<?php
class DB {
    private $dbh;
    protected $stmt;

    public function __construct($db, $host = "localhost", $user = "root", $pass = "", $charset = "utf8mb4") {
        try {
            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            $this->dbh = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            die("Connection error: " . $e->getMessage());
        }
    }

    public function execute($query, $args = null) {
        $this->stmt = $this->dbh->prepare($query);
        $this->stmt->execute($args);
        return $this->stmt;
    }

    public function lastId() {
        return $this->dbh->lastInsertId();
    }
}


$myDb = new DB('basisschool_boom');
?>
