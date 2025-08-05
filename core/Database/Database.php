<?php
namespace Core\Database;

use PDOException;
use PDO;
use Exception;
use Core\Loader;

class Database{
    private $settings = null;

    private $db = null;

    public function __construct(){
        $this->settings = Loader::config('Database');
        if(!$this->settings || !is_array($this->settings)){
            throw new Exception('Database config is invalid or missing.');
        }
        register_shutdown_function(function() {
            $this->close();
        });

    }

    public function connect(){
        if($this->db !== null){
            return $this;
        }
        $database = $this->settings['DATABASE'] ?? 'mysql';
        $host = $this->settings['DB_HOST'] ?? 'localhost';
        $username = $this->settings['DB_USERNAME'] ?? '';
        $password = $this->settings['DB_PASSWORD'] ?? '';
        $name = $this->settings['DB_NAME'] ?? '';
        $charset = $this->settings['DB_CHARSET'] ?? 'utf8mb4';

        try {
            $this->db = new PDO($database . ':host=' . $host . ';dbname=' . $name . ';charset=' . $charset ,$username, $password);
        } catch (PDOException $e) {
            throw new Exception("Database connection failed: " . $e->getMessage());
        }
        // Set attributes for the PDO instance
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        return $this;
    }

    public function begin_transaction(){
        $this->connect();
        $this->db->beginTransaction();
        return $this;
    }

    public function transaction(callable $func){
        $this->connect();

        try {
            $this->begin_transaction();
            $result = $func($this->db);
            $this->commit();
            return($result);
        } catch (\Throwable $th) {
            $this->rollback();
            return $th->getMessage();
        }
    }

    public function commit(){
        if($this->db && $this->db->inTransaction()){
            $this->db->commit();
        }
        return $this;
    }
    public function rollback(){
        if($this->db && $this->db->inTransaction()){
            $this->db->rollBack();
        }
        return $this;
    }

    public function close(){
        if($this->db && $this->db->inTransaction()){
            $this->rollback();
        }
        $this->db = null;
        return $this;
    }

    public function get_db(){
        $this->connect();
        return $this->db;
    }

}