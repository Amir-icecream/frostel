<?php
namespace Core;

use PDOException;
use PDO;
use Exception;

class Database{
    private $settings;

    private $db = null;
    private $in_transaction = false;

    public function __construct(){
        $this->settings = Loader::config('Database');

        register_shutdown_function(function() {
            $this->close();
        });

    }

    public function connect(){
        $database =$this->settings['DATABASE'] ?? 'mysql';
        $host = $this->settings['DB_HOST'] ?? 'localhost';
        $username = $this->settings['DB_USERNAME'] ?? 'root';
        $password = $this->settings['DB_PASSWORD'] ?? '';
        $name = $this->settings['DB_NAME'] ?? 'Dtoy.ir';
        $charset = $this->settings['DB_CHARSET'] ?? 'utf8mb4';

        if($this->db === null){
            try {
                $this->db = new PDO($database . ':host=' . $host . ';dbname=' . $name . ';charset=' . $charset ,$username, $password);
            } catch (PDOException $e) {
                throw new Exception("Database connection failed: " . $e->getMessage());
            }
            // Set attributes for the PDO instance
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }

        return $this;
    }

    public function begin_transaction(){
        $this->db->beginTransaction();
        $this->in_transaction = true;
        return $this;
    }

    public function transaction(callable $func){
        if($this->db === null){
            $this->connect();
        }
        try {
            $this->begin_transaction();
            $result = $func($this->db);
            $this->commit();
            return($result);
        } catch (\Throwable $th) {
            $this->rollback();
            throw $th;
        }
    }

    public function commit(){
        if($this->in_transaction){
            $this->db->commit();
            $this->in_transaction = false;
        } else {
            throw new Exception("No transaction in progress.");
        }
        return $this;
    }
    public function rollback(){
        if($this->in_transaction){
            $this->db->rollBack();
            $this->in_transaction = false;
        } else {
            throw new Exception("No transaction in progress.");
        }
        return $this;
    }

    public function close(){
        if($this->in_transaction){
            $this->rollback();
        }
        $this->db = null;
        $this->in_transaction = false;
        return $this;
    }

    public function get_db(){
        if($this->db === null){
            $this->connect();
        }
        return $this->db;
    }

}