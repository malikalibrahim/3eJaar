<?php
class DB {
    private $dbh;
    protected $stmt;

    public function __construct($db, $host = "localhost", $user = "root", $pass = "") {
        try {
            $this->dbh = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection error: " . $e->getMessage());
        }
    }

    public function execute($sql, $placeholders = []) {
        try {
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute($placeholders);
            return $stmt;
        } catch (PDOException $e) {
            die("Query execution error: " . $e->getMessage());
        }
    }

    public function query($sql, $placeholders = []) {
        $stmt = $this->execute($sql, $placeholders);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>