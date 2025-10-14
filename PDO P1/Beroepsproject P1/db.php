<?php
class DB {
    private $host = "localhost";
    private $dbname = "jongerenkansrijker";
    private $user = "root";       // pas aan naar jouw MySQL gebruiker
    private $pass = "";           // pas aan naar jouw MySQL wachtwoord
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->dbname,
                $this->user,
                $this->pass
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connectie mislukt: " . $e->getMessage());
        }
    }

    // query uitvoeren
    public function execute($query, $args = []) {
        try {
            if (!$args) {
                return $this->pdo->query($query);
            }
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($args);
            return $stmt;
        } catch (PDOException $e) {
            echo "Fout bij query: " . $e->getMessage();
            return false;
        }
    }
}

// instantie van DB
$myDb = new DB();
?>
