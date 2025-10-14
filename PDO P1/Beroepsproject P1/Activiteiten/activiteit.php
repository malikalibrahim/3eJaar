<?php
// activiteiten/activiteit.php
include_once __DIR__ . '/../db.php';

class Activiteit {
    private $db;
    public function __construct() {
        global $myDb;
        $this->db = $myDb;
    }

    public function getAll() {
        $stmt = $this->db->execute("SELECT * FROM activiteiten ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->execute("SELECT * FROM activiteiten WHERE id = ?", [$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($naam, $omschrijving, $startdatum, $einddatum) {
        $this->db->execute("INSERT INTO activiteiten (naam, omschrijving, startdatum, einddatum) VALUES (?, ?, ?, ?)",
            [$naam, $omschrijving, $startdatum, $einddatum]);
    }

    public function update($id, $naam, $omschrijving, $startdatum, $einddatum) {
        $this->db->execute("UPDATE activiteiten SET naam=?, omschrijving=?, startdatum=?, einddatum=? WHERE id=?",
            [$naam, $omschrijving, $startdatum, $einddatum, $id]);
    }

    public function delete($id) {
        $this->db->execute("DELETE FROM activiteiten WHERE id = ?", [$id]);
    }

    public function countParticipants($id) {
        $stmt = $this->db->execute("SELECT COUNT(*) AS cnt FROM jongeren_activiteiten WHERE activiteit_id = ?", [$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['cnt'] ?? 0;
    }
}
