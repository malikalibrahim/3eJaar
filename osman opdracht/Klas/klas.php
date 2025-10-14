<?php
include_once __DIR__ . '/../db.php';

class Klas {
    private $db;
    public function __construct() {
        global $myDb;
        $this->db = $myDb;
    }

    public function all(): array {
        return $this->db->execute("SELECT * FROM klassen ORDER BY jaar DESC, naam ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array {
        $row = $this->db->execute("SELECT * FROM klassen WHERE id=?", [$id])->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function create(string $naam, int $jaar): void {
        $this->db->execute("INSERT INTO klassen (naam, jaar) VALUES (?, ?)", [$naam, $jaar]);
    }

    public function update(int $id, string $naam, int $jaar): void {
        $this->db->execute("UPDATE klassen SET naam=?, jaar=? WHERE id=?", [$naam, $jaar, $id]);
    }

    public function delete(int $id): void {
        $this->db->execute("DELETE FROM klassen WHERE id=?", [$id]);
    }
}


