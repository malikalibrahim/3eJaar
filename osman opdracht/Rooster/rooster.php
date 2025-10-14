<?php
include_once __DIR__ . '/../db.php';

class RoosterModel {
    private $db;
    public function __construct() {
        global $myDb;
        $this->db = $myDb;
    }

    public function overview(int $week): array {
        $sql = "SELECT r.id, r.week, k.naam AS klas, r.dag, r.les_van, r.les_tot, v.naam AS vak, u.naam AS docent
                FROM roosters r
                JOIN klassen k ON k.id = r.klas_id
                JOIN vakken v ON v.id = r.vak_id
                JOIN users u ON u.id = v.docent_id AND u.rol = 'docent'
                WHERE r.week = ?
                ORDER BY k.naam, FIELD(r.dag,'maandag','dinsdag','woensdag','donderdag','vrijdag'), r.les_van";
        return $this->db->execute($sql, [$week])->fetchAll(PDO::FETCH_ASSOC);
    }

    public function byKlas(int $klas_id, int $week): array {
        $sql = "SELECT r.id, r.klas_id, r.week, r.dag, r.les_van, r.les_tot, v.naam AS vak, u.naam AS docent
                FROM roosters r
                JOIN vakken v ON v.id = r.vak_id
                JOIN users u ON u.id = v.docent_id AND u.rol = 'docent'
                WHERE r.klas_id = ? AND r.week = ?
                ORDER BY FIELD(r.dag,'maandag','dinsdag','woensdag','donderdag','vrijdag'), r.les_van";
        return $this->db->execute($sql, [$klas_id, $week])->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(int $klas_id, int $week, string $dag, string $les_van, string $les_tot, int $vak_id): void {
        $this->db->execute("INSERT INTO roosters (klas_id, week, dag, les_van, les_tot, vak_id) VALUES (?,?,?,?,?,?)",
            [$klas_id, $week, $dag, $les_van, $les_tot, $vak_id]);
    }

    public function find(int $id): ?array {
        $row = $this->db->execute("SELECT * FROM roosters WHERE id=?", [$id])->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function update(int $id, int $klas_id, int $week, string $dag, string $les_van, string $les_tot, int $vak_id): void {
        $this->db->execute("UPDATE roosters SET klas_id=?, week=?, dag=?, les_van=?, les_tot=?, vak_id=? WHERE id=?",
            [$klas_id, $week, $dag, $les_van, $les_tot, $vak_id, $id]);
    }

    public function delete(int $id): void {
        $this->db->execute("DELETE FROM roosters WHERE id=?", [$id]);
    }
}
