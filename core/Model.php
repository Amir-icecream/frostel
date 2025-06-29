<?php
namespace Core;
use Config\Database;
class Model extends Database{
    private $table = null;
    private $sql = null;
    private $parameters = [];
    private $param_count = 0;
    private $allowed_operations = ['=', '!=', '<', '>', '<=', '>=', 'LIKE', 'IS NULL', 'IS NOT NULL'];
    private $safe = true; 
    protected $sanitized = [];
    protected $output = [];
    public function __construct() {
        $model_path = get_called_class();
        $pathes = explode('\\',$model_path);
        $model = $pathes[array_key_last($pathes)];
        $this->table = strtolower($model) . 's';
    }
    public static function query(){
        return new static;
    }
    private function add_parameter($param){  
        $param_name = 'param' . '_' . $this->param_count++;
        $this->parameters[$param_name] = $param;
        return $param_name;
    }
    public function set_query_type($type){
        switch (strtoupper($type)) {
            case 'READ':
                $this->sql = 'SELECT * FROM ' . $this->table . $this->sql;
                break;
            case 'CREATE':
                $this->sql = 'INSERT INTO ' . $this->table;
                break;
            case 'UPDATE':
                $this->sql = 'UPDATE ' . $this->table . ' SET ' . $this->sql;
                break;
            case 'DELETE':
                $this->sql = 'DELETE FROM ' . $this->table . $this->sql;
                break;
            default:
                throw new \Exception("Invalid query type: $type");
        }
        return;
    }
    public function select(array $coulmns){
        if(!is_array($coulmns) or count($coulmns) === 0 or empty($this->sql)){
            return;
        }
        $coulmns = implode(',', array_map(function($col) {
            return preg_replace('/[^a-zA-Z0-9()_.*]/', '', $col);
        }, $coulmns));
        $this->sql = preg_replace('/SELECT\s+\*\s+FROM/i',"SELECT $coulmns FROM",$this->sql);
        return $this;
    }
    //conditions
    public function where($col,$operation,$param){
        if(in_array($operation , $this->allowed_operations) === false){
            throw new \Exception("Invalid operation: $operation. Allowed operations are: " . implode(', ', $this->allowed_operations));
        }
        $param_name = $this->add_parameter($param);
        $this->sql .= " WHERE $col $operation :$param_name ";
        return $this;
    }
    public function orwhere($col,$operation,$param){
        if(in_array($operation , $this->allowed_operations) === false){
            throw new \Exception("Invalid operation: $operation. Allowed operations are: " . implode(', ', $this->allowed_operations));
        }
        $param_name = $this->add_parameter($param);
        $this->sql .= " OR $col $operation :$param_name ";
        return $this;
    }
    public function andwhere($col,$operation,$param){
        if(in_array($operation , $this->allowed_operations) === false){
            throw new \Exception("Invalid operation: $operation. Allowed operations are: " . implode(', ', $this->allowed_operations));
        }
        $param_name = $this->add_parameter($param);
        $this->sql .= " AND $col $operation :$param_name ";
        return $this;
    }
    //read
    public function find($id){
        $param_name = $this->add_parameter($id);
        $this->sql .= ' WHERE ID = :' . $param_name;
        $this->set_query_type('READ');
        return $this->execute();
    }
    public function count(array $col = ['*']){
        $col = array_map(function($c){
            return 'COUNT(' . $c . ')';
        },$col);
        $this->select($col);
        return $this;
    }
    public function all(){
        $this->set_query_type('READ');
        return $this->execute();
    }
    //create update delete
    public function update(array $data = [] , $safe = true){
        $this->safe = $safe;
        if(!count($data))
        {
            throw new \Exception("No data provided for update.");
        }
        $this->set_query_type('UPDATE');
        foreach ($data as $key => $value) {
            $param_name = $this->add_parameter($value);
            $this->sql .= $key . '= :' . $param_name .',';
        }
        $this->sql = rtrim($this->sql, ',');
        return $this;
    }
    public function create(array $data = [] , $safe = true){
        $this->safe = $safe;
        if(!count($data))
        {
            throw new \Exception("No data provided for insert.");
        }
        $this->set_query_type('CREATE');
        $keys = implode(',',array_keys($data));
        $param = '';
        $this->sql .= ' (' . $keys . ') VALUES (';
        foreach ($data as $key => $value) {
            $param_name = $this->add_parameter($value);
            $param .= ':' . $param_name . ',';
        }
        $param = rtrim($param, ',') . ')';
        $this->sql .= $param;
        return $this;
    }  
    public function delete($safe = true){
        $this->safe = $safe;
        $this->set_query_type('DELETE');
        return $this;
    }
    //ordering
    public function orderby(string $col){
        $this->sql .= ' ORDER BY ' . $col;
        return $this;
    }
    public function reverse(){
        $this->sql .= ' DESC ';
        return $this;
    }
    public function limit(int $limit){
        $this->sql .= ' LIMIT ' . (int)$limit;
        return $this;
    }
    public function offset(int $offset){
        $this->sql .= ' OFFSET ' . (int)$offset;
        return $this;
    }
    //run the query
    public function get(){
        $this->set_query_type('read');
        return $this->execute();
    }
    public function run(){
        return $this->execute();
    }
    private function execute(){
        if($this->safe and !str_contains(strtoupper($this->sql),'WHERE')){
            throw new \Exception("Unsafe operation detected. Please use 'where' method to specify conditions before executing the query.");
        }
        $db = new Database;
        $db->transaction(function($db){
            $statement = $db->prepare($this->sql);
            foreach ($this->parameters as $key => $value) {
                $statement->bindValue($key,$value);
            }
            $statement->execute();
            $result = $statement->fetchAll();
            foreach ($result as $row) {
                
                foreach ($row as $key => $value) {
                    $this->sanitized[$key] = htmlspecialchars($value ?? '' ,ENT_QUOTES,'UTF-8');                    
                }
                $this->output[] = $this->sanitized;
            }
        });
        $this->table = null;
        $this->sql = null;
        $this->parameters = [];
        $this->param_count = 0;
        return json_encode($this->output , true);
        
    }
}
