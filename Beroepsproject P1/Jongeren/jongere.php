<?php
// jongeren/jongere.php
include_once __DIR__ . '/../db.php';

class Jongere {
    private $db;
    public function __construct() {
        global $myDb;
        $this->db = $myDb;
    }

    public function getAll() {
        $stmt = $this->db->execute("SELECT j.*, ji.instituut_id, ji.plaatsingsdatum, i.naam AS instituut_naam
            FROM jongeren j
            LEFT JOIN jongeren_instituten ji ON ji.jongere_id = j.id
            LEFT JOIN instituten i ON i.id = ji.instituut_id
            ORDER BY j.id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->execute("SELECT * FROM jongeren WHERE id = ?", [$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($naam, $geboortedatum, $adres, $telefoon, $email, $status = 'ingeschreven') {
        $this->db->execute("INSERT INTO jongeren (naam, geboortedatum, adres, telefoon, email, status) VALUES (?, ?, ?, ?, ?, ?)",
            [$naam, $geboortedatum, $adres, $telefoon, $email, $status]);
    }

    public function update($id, $naam, $geboortedatum, $adres, $telefoon, $email, $status) {
        $this->db->execute("UPDATE jongeren SET naam=?, geboortedatum=?, adres=?, telefoon=?, email=?, status=? WHERE id=?",
            [$naam, $geboortedatum, $adres, $telefoon, $email, $status, $id]);
    }

    public function delete($id) {
        $this->db->execute("DELETE FROM jongeren WHERE id = ?", [$id]);
    }

    // activiteiten koppelingen
    public function getActivities($jongere_id) {
        $stmt = $this->db->execute("SELECT a.* FROM activiteiten a
            JOIN jongeren_activiteiten ja ON ja.activiteit_id = a.id
            WHERE ja.jongere_id = ?", [$jongere_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addActivity($jongere_id, $activiteit_id) {
        $this->db->execute("INSERT INTO jongeren_activiteiten (jongere_id, activiteit_id) VALUES (?, ?)",
            [$jongere_id, $activiteit_id]);
    }

    public function removeActivity($jongere_id, $activiteit_id) {
        $this->db->execute("DELETE FROM jongeren_activiteiten WHERE jongere_id = ? AND activiteit_id = ?",
            [$jongere_id, $activiteit_id]);
    }

    // instituut plaatsen (één instituut per jongere)
    public function getInstituut($jongere_id) {
        $stmt = $this->db->execute("SELECT ji.*, i.naam FROM jongeren_instituten ji JOIN instituten i ON i.id = ji.instituut_id WHERE ji.jongere_id = ?", [$jongere_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function placeInstituut($jongere_id, $instituut_id, $plaatsingsdatum = null) {
        // als er al bestaat -> update, anders insert
        $exists = $this->db->execute("SELECT id FROM jongeren_instituten WHERE jongere_id = ?", [$jongere_id])->rowCount();
        if ($exists) {
            $this->db->execute("UPDATE jongeren_instituten SET instituut_id = ?, plaatsingsdatum = ? WHERE jongere_id = ?", [$instituut_id, $plaatsingsdatum, $jongere_id]);
            $this->db->execute("UPDATE jongeren SET status = 'uitgeplaatst' WHERE id = ?", [$jongere_id]);
        } else {
            $this->db->execute("INSERT INTO jongeren_instituten (jongere_id, instituut_id, plaatsingsdatum) VALUES (?, ?, ?)", [$jongere_id, $instituut_id, $plaatsingsdatum]);
            $this->db->execute("UPDATE jongeren SET status = 'uitgeplaatst' WHERE id = ?", [$jongere_id]);
        }
    }

    public function removeInstituut($jongere_id) {
        $this->db->execute("DELETE FROM jongeren_instituten WHERE jongere_id = ?", [$jongere_id]);
        $this->db->execute("UPDATE jongeren SET status = 'ingeschreven' WHERE id = ?", [$jongere_id]);
    }
}
