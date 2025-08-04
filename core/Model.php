<?php
namespace Core;

use Core\Database;

class Model extends Database{
    private $table = null;
    private $sql = null;
    private $parameters = [];
    private $param_count = 0;
    private $allowed_operations = ['=', '!=', '<', '>', '<=', '>=', 'LIKE', 'IS NULL', 'IS NOT NULL'];
    private $query_type = null;
    private $safe = true; 
    protected $result = null;


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
                $this->query_type = 'READ';
                $this->sql = 'SELECT * FROM ' . $this->table . $this->sql;
                break;
            case 'CREATE':
                $this->query_type = 'CREATE';
                $this->sql = 'INSERT INTO ' . $this->table;
                break;
            case 'UPDATE':
                $this->query_type = 'UPDATE';
                $this->sql = 'UPDATE ' . $this->table . ' SET ' . $this->sql;
                break;
            case 'DELETE':
                $this->query_type = 'DELETE';
                $this->sql = 'DELETE FROM ' . $this->table . $this->sql;
                break;
            default:
                throw new \Exception("Invalid query type: $type");
        }
        return;
    }
    public function select(array $coulmns){
        $this->set_query_type('READ');
        if(!is_array($coulmns) or count($coulmns) === 0 or empty($this->sql)){
            return;
        }
        if(count($coulmns) > 0)
        {
            $coulmns = implode(',', array_map(function($col) {
                return preg_replace('/[^a-zA-Z0-9()_.*]/', '', $col);
            }, $coulmns));
            $this->sql = preg_replace('/SELECT\s+\*\s+FROM/i',"SELECT $coulmns FROM",$this->sql);
        }
        return $this;
    }
    
    //conditions
    public function where($col,$operation,$param = null){
        if(in_array($operation , $this->allowed_operations) === false){
            throw new \Exception("Invalid operation: $operation. Allowed operations are: " . implode(', ', $this->allowed_operations));
        }
        if($param !== null){
            $param_name = $this->add_parameter($param);
            $this->sql .= " WHERE $col $operation :$param_name ";
        }else{
            $this->sql .= " WHERE $col $operation ";
        }
        return $this;
    }
    public function orwhere($col,$operation,$param = null){
        if(in_array($operation , $this->allowed_operations) === false){
            throw new \Exception("Invalid operation: $operation. Allowed operations are: " . implode(', ', $this->allowed_operations));
        }
        if($param !== null){
            $param_name = $this->add_parameter($param);
            $this->sql .= " OR $col $operation :$param_name ";
        }else{
            $this->sql .= " OR $col $operation ";
        }
        return $this;
    }
    public function andwhere($col,$operation,$param = null){
        if(in_array($operation , $this->allowed_operations) === false){
            throw new \Exception("Invalid operation: $operation. Allowed operations are: " . implode(', ', $this->allowed_operations));
        }
        if($param !== null){
            $param_name = $this->add_parameter($param);
            $this->sql .= " AND $col $operation :$param_name ";
        }else{
            $this->sql .= " AND $col $operation ";
        }
        return $this;
    }

    //read
    public function find($id){
        $param_name = $this->add_parameter($id);
        $this->sql .= ' WHERE id = :' . $param_name;
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
        return $this;
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
    public function create(array $data = [] , $safe = false){
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
    public function groupBy(array $field , $aggregate = 'MAX'){
        if(preg_match('/^SELECT\s*\*\s*FROM/i',$this->sql)){
            $result = $this->querybuilder('SHOW COLUMNS FROM ' . $this->table);
            $coulmns = array();
            foreach ($result as $key => $value) {
                array_push($coulmns , $value->Field);
            }
            foreach ($coulmns as $key => $value) {
                if(!in_array($value, $field)){
                    $coulmns[$key] = strtoupper($aggregate) . '(' . $value . ') AS ' . $value;
                }
            }

            $this->sql = preg_replace_callback('/\*/',function() use ($coulmns) {
                return implode(',', $coulmns);
            },$this->sql);

            $this->sql .= ' GROUP BY ' . implode(',', $field);
        }
        else{
            preg_match('/^SELECT\s([A-Za-z0-9_.,]*)\sFROM/i', $this->sql, $matches);
            array_shift($matches);
            $coulmns = explode(',', $matches[0]);

            foreach ($coulmns as $key => $value) {
                if(!in_array($value, $field)){
                    $coulmns[$key] = strtoupper($aggregate) . '(' . $value . ') AS ' . $value;
                }
            }

            $this->sql = preg_replace_callback('/'. $matches[0] .'/',function() use ($coulmns) {
                return implode(',', $coulmns);
            },$this->sql);
            $this->sql .= ' GROUP BY ' . implode(',', $field);
        }
        return $this; 
    }

    /**
     * This method is used to join two tables.
     * @param string $table The name of the table to join.
     * @param string $primary_key_field The primary key field of the current table.
     * @param string $Foreign_key_field The foreign key field of the table to join.
     * @param string $type The type of join (default is 'LEFT').
     * @warning tables most have relation before using this method.
     */
    public function join(string $table,string $primary_key_field,string $Foreign_key_field,string $type = 'LEFT'){
        $type = strtoupper($type);
        $this->sql .= " $type JOIN $table ON $table.$Foreign_key_field" . " = $this->table.$primary_key_field";
        return $this;
    }


    /**
     * you can create and run custom query with this method.
     * connection method is PDO. 
     * @warning This method is not safe be carefull while using it.
     */
    public function querybuilder($query , $parameters = []){
        $this->result = null;

        preg_match_all('/:([a-zA-Z0-9_.]+)/i', $query, $matches);
        $matches = $matches[0];
        $db = new Database;
        $db->transaction(function($db) use ($query, $parameters, $matches){
            $statement = $db->prepare($query);
            foreach ($matches as $key => $value) {
                if(isset($parameters[$key])){
                    $statement->bindValue($value, $parameters[$key]);
                } else {
                    throw new \Exception("Missing parameter for placeholder: $value");
                }
            }
            $statement->execute();
            $result = $statement->fetchAll();
            if(empty($result)){
                return false;
            }elseif(count($result) > 1){
                $this->result = $result;
            }else{
                $this->result = $result[0];
            }
            $this->result = $result;
        });
        return $this->result;
    }

    /**
    * this mthod run the query. 
    */
    public function run(){
        return $this->execute();
    }
    private function execute(){
        $this->result = null;

        if($this->safe and !str_contains(strtoupper($this->sql),'WHERE') and ($this->query_type !== 'READ' and $this->query_type !== 'DELETE') ){
            throw new \Exception("Unsafe operation detected. Please use 'where' method to specify conditions before executing the query.");
        }
        $db = new Database;
        $db->transaction(function($db){
            try {
                $statement = $db->prepare($this->sql);
            } catch (\Throwable $th) {
                throw new \Exception("Syntax error in SQL query: " . $th->getMessage() . ' SQL: ' . $this->sql);
            }
            foreach ($this->parameters as $key => $value) {
                $statement->bindValue($key,$value);
            }
            $statement->execute();
            $result = $statement->fetchAll();
            if(empty($result)){
                return false;
            }elseif(count($result) > 1){
                $this->result = $result;
            }else{
                $this->result = $result[0];
            }
        });
        $this->table = null;
        $this->sql = null;
        $this->parameters = [];
        $this->param_count = 0;
        return $this->result;
        
    }

    public function getResult(){
        return $this->result ?? false;
    }

}
