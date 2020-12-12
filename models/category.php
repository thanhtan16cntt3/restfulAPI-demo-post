<?php
    class Category 
    {
        public $conn;
        public $table = 'categories';

        public $id;
        public $name;
        public $created_at;

        public function __construct($db){
            $this->conn = $db;
        }

        public function getAll(){
            $query = "SELECT * FROM $this->table";

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        public function getCategoryById(){
            $query = "SELECT * FROM $this->table WHERE id = :id LIMIT 0,1";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id',$this->id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->created_at = $row['created_at'];
        }

        public function create(){
            $query = "INSERT INTO $this->table SET name = :name";

            $stmt = $this->conn->prepare($query);

            $this->name = htmlspecialchars(strip_tags($this->name));

            $stmt->bindParam(':name', $this->name);

            if($stmt->execute()){
                return true;
            }

            return false;
        }

        public function update(){
            $query = "UPDATE $this->table SET name = :name WHERE id = :id";

            $stmt = $this->conn->prepare($query);

            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->name = htmlspecialchars(strip_tags($this->name));

            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':name', $this->name);

            if($stmt->execute()){
                return true;
            }

            return false;
        }

        public function delete(){
            $query = "DELETE FROM $this->table WHERE id = :id";
            $stmt = $this->conn->prepare($query);

            $this->id = htmlspecialchars(strip_tags($this->id));

            $stmt->bindParam(':id', $this->id);

            if($stmt->execute()){
                return true;
            }
            
			printf("Error: %s\n", $stmt->error);
            return false;

        }
    }
    