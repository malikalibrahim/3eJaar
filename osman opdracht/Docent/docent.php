<?php
include_once __DIR__ . '/../db.php';

class Docent {
    private $db;
    public function __construct() {
        global $myDb;
        $this->db = $myDb;
    }

    public function all(): array {
        return $this->db->execute("SELECT id, naam, username FROM users WHERE rol='docent' ORDER BY naam ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array {
        $row = $this->db->execute("SELECT id, naam, username FROM users WHERE id=? AND rol='docent'", [$id])->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function create(string $naam, string $username, string $password): void {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $this->db->execute("INSERT INTO users (naam, username, password, rol, klas_id) VALUES (?,?,?,?,NULL)", [$naam, $username, $hashed, 'docent']);
    }

    public function update(int $id, string $naam, ?string $password): void {
        if ($password !== null && $password !== '') {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $this->db->execute("UPDATE users SET naam=?, password=? WHERE id=? AND rol='docent'", [$naam, $hashed, $id]);
        } else {
            $this->db->execute("UPDATE users SET naam=? WHERE id=? AND rol='docent'", [$naam, $id]);
        }
    }

    public function delete(int $id): void {
        $this->db->execute("DELETE FROM users WHERE id=? AND rol='docent'", [$id]);
    }
}


