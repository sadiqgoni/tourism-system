<?php
if (!class_exists('Database')) {
    class Database
    {
        private $host = "localhost";
        private $user = "root";
        private $password = "";
        private $dbname = "tourism";
        private $conn;

        public function __construct()
        {
            try {
                $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];
                $this->conn = new PDO($dsn, $this->user, $this->password, $options);
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
                exit;
            }
        }

        public function escapeString($string)
        {
            return $string;
        }

        public function create($table, $data)
        {
            try {
                $keys = implode(", ", array_keys($data));
                $values = ":" . implode(", :", array_keys($data));
                $sql = "INSERT INTO $table ($keys) VALUES ($values)";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute($data);
                return $this->conn->lastInsertId();
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
        }

        public function read($table, $condition = "")
        {
            try {
                $sql = "SELECT * FROM $table $condition";
                $stmt = $this->conn->query($sql);
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
        }

        public function readAll($table, $condition = "")
        {
            try {
                $sql = "SELECT * FROM $table $condition";
                $stmt = $this->conn->query($sql);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
        }

        public function readAllCondition($table, $condition = "")
        {
            try {
                $sql = "$condition";
                $stmt = $this->conn->query($sql);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
        }

        public function readWithJoin($table1, $table2, $joinCondition, $condition = "")
        {
            try {
                // Dynamically prefix column names with table names
                $columns1 = $this->getColumns($table1, $table1 . ".");
                $columns2 = $this->getColumns($table2, $table2 . ".");
                $columns = implode(", ", array_merge($columns1, $columns2));
    
                $sql = "SELECT $columns FROM $table1 
                        INNER JOIN $table2 
                        ON $joinCondition $condition";
    
                $stmt = $this->conn->query($sql);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
        }
        
        private function getColumns($table, $prefix = "")
        {
            try {
                $sql = "DESCRIBE $table";
                $stmt = $this->conn->query($sql);
                $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
                return array_map(fn($column) => $prefix . $column, $columns);
            } catch (PDOException $e) {
                die("Error fetching columns for $table: " . $e->getMessage());
            }
        }
        

        public function update($table, $data, $condition)
        {
            try {
                $set = [];
                foreach ($data as $key => $value) {
                    $set[] = "$key = :$key";
                }
                $set = implode(", ", $set);
                $sql = "UPDATE $table SET $set WHERE $condition";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute($data);
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
        }

        public function delete($table, $condition)
        {
            try {
                $sql = "DELETE FROM $table WHERE $condition";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
        }

        public function readF($table1, $table2,  $key1, $fields = "*", $key2 = "id")
        {
            try {
                $query = "SELECT $fields FROM $table1 INNER JOIN $table2 ON $table1.$key1 = $table2.$key2";
                $stmt = $this->conn->prepare($query);

                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
        }
    }
}
