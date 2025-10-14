<?php
include_once __DIR__ . '/../db.php';

class UserModel {
    private $db;
    public function __construct() {
        global $myDb;
        $this->db = $myDb;
    }

    public function findByUsername(string $username): ?array {
        $row = $this->db->execute("SELECT * FROM users WHERE username = ?", [$username])->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function isAdminSession(): bool {
        return isset($_SESSION['boom_user']) && (($_SESSION['boom_user']['rol'] ?? null) === 'admin');
    }

    public function isStudentSession(): bool {
        return isset($_SESSION['boom_user']) && (($_SESSION['boom_user']['rol'] ?? null) === 'leerling');
    }
}


