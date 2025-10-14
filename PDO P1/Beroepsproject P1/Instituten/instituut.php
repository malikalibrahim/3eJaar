<?php
// instituten/instituut.php
include_once __DIR__ . '/../db.php';

class Instituut {
    private $db;
    public function __construct() {
        global $myDb;
        $this->db = $myDb;
    }

    public function getAll() {
        $stmt = $this->db->execute("SELECT * FROM instituten ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->execute("SELECT * FROM instituten WHERE id = ?", [$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($naam, $adres, $contactpersoon, $telefoon, $email) {
        $this->db->execute("INSERT INTO instituten (naam, adres, contactpersoon, telefoon, email) VALUES (?, ?, ?, ?, ?)",
            [$naam, $adres, $contactpersoon, $telefoon, $email]);
    }

    public function update($id, $naam, $adres, $contactpersoon, $telefoon, $email) {
        $this->db->execute("UPDATE instituten SET naam=?, adres=?, contactpersoon=?, telefoon=?, email=? WHERE id=?",
            [$naam, $adres, $contactpersoon, $telefoon, $email, $id]);
    }

    public function delete($id) {
        $this->db->execute("DELETE FROM instituten WHERE id = ?", [$id]);
    }
}
