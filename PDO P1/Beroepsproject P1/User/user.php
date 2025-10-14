<?php
// user/user.php
include_once __DIR__ . '/../db.php';

class User {
    private $db;
    public function __construct() {
        global $myDb;
        $this->db = $myDb;
    }

    public function getAll() {
        $stmt = $this->db->execute("SELECT * FROM medewerkers ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->execute("SELECT * FROM medewerkers WHERE id = ?", [$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($naam, $username, $password, $rol) {
        $pwd = md5($password);
        $this->db->execute("INSERT INTO medewerkers (naam, username, password, rol) VALUES (?, ?, ?, ?)", 
            [$naam, $username, $pwd, $rol]);
    }

    public function update($id, $naam, $username, $rol, $password = null) {
        if ($password !== null && $password !== '') {
            $pwd = md5($password);
            $this->db->execute("UPDATE medewerkers SET naam=?, username=?, password=?, rol=? WHERE id=?", 
                [$naam, $username, $pwd, $rol, $id]);
        } else {
            $this->db->execute("UPDATE medewerkers SET naam=?, username=?, rol=? WHERE id=?", 
                [$naam, $username, $rol, $id]);
        }
    }

    public function delete($id) {
        $this->db->execute("DELETE FROM medewerkers WHERE id = ?", [$id]);
    }

    public function authenticate($username, $password) {
        $stmt = $this->db->execute("SELECT * FROM medewerkers WHERE username = ?", [$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && $user['password'] === md5($password)) {
            return $user;
        }
        return false;
    }
}
