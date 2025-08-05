<?php
namespace Core\Database;

class BluePrint{
    private $name;
    private $columns = [];
    private $build;

    public function __construct($name) {
        $this->name = $name;
    }

    public function id(){
        $this->build = 'id INT PRIMARY KEY AUTO_INCREMENT';
        array_push($this->columns,$this->build);
        $this->build = null;
    }
    
    // string types
    public function string(string $name , int $length = 255){
        if($this->build !== null){
            array_push($this->columns,$this->build);
            $this->build = null;
        }
        $this->build = "{$name} VARCHAR({$length}) ";
        return $this;
    }
    public function text(string $name){
        if($this->build !== null){
            array_push($this->columns,$this->build);
            $this->build = null;
        }
        $this->build = "{$name} TEXT ";
        return $this;
    }
    public function char(string $name){
        if($this->build !== null){
            array_push($this->columns,$this->build);
            $this->build = null;
        }
        $this->build = "{$name} CHAR ";
        return $this;
    }
    public function binary(string $name){
        if($this->build !== null){
            array_push($this->columns,$this->build);
            $this->build = null;
        }
        $this->build = "{$name} BINARY ";
        return $this;
    }
    public function json(string $name){
        if($this->build !== null){
            array_push($this->columns,$this->build);
            $this->build = null;
        }
        $this->build = "{$name} JSON ";
        return $this;
    }
    // numeric types
    public function int(string $name){
        if($this->build !== null){
            array_push($this->columns,$this->build);
            $this->build = null;
        }
        $this->build = "{$name} INT ";
        return $this;
    }
    public function flout(string $name){
        if($this->build !== null){
            array_push($this->columns,$this->build);
            $this->build = null;
        }
        $this->build = "{$name} FLOAT ";
        return $this;
    }
    public function double(string $name){
        if($this->build !== null){
            array_push($this->columns,$this->build);
            $this->build = null;
        }
        $this->build = "{$name} DOUBLE ";
        return $this;
    }
    public function boolean(string $name){
        if($this->build !== null){
            array_push($this->columns,$this->build);
            $this->build = null;
        }
        $this->build = "{$name} BOOLEAN ";
        return $this;
    }
    // date types
    public function date(string $name){
        if($this->build !== null){
            array_push($this->columns,$this->build);
            $this->build = null;
        }
        $this->build = "{$name} DATE ";
        return $this;
    }
    public function time(string $name){
        if($this->build !== null){
            array_push($this->columns,$this->build);
            $this->build = null;
        }
        $this->build = "{$name} TIME ";
        return $this;
    }
    public function datetime(string $name){
        if($this->build !== null){
            array_push($this->columns,$this->build);
            $this->build = null;
        }
        $this->build = "{$name} DATETIME ";
        return $this;
    }



    public function nullable(){
        $this->build .= 'NULL ';
        return $this;
    }
    public function notNull(){
        $this->build .= 'NOT NULL ';
        return $this;
    }
    public function unique(){
        $this->build .= 'UNIQUE ';
        return $this;
    }
    public function unsigned(){
        $this->build .= 'UNSIGNED ';
        return $this;
    }
    public function default($value){
        $this->build .= "DEFAULT '" . $value .  "'";
        return $this;
    }
    public function ai($value){
        $this->build .= 'AUTO_INCREMENT ';
        return $this;
    }
    


    public function timestamps(){
        if($this->build !== null){
            array_push($this->columns,$this->build);
            $this->build = null;
        }
        $this->build = "`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";
        array_push($this->columns,$this->build);
        $this->build = "`modified_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";
        array_push($this->columns,$this->build);
        $this->build = null;
    }

    public function sql(){
        if($this->build !== null){
            array_push($this->columns,$this->build);
            $this->build = null;
        }

        $query = 'CREATE TABLE IF NOT EXISTS ' . $this->name . '(';
        $query .= implode(',',$this->columns);
        $query .= ');';

        return $query;
    }
}