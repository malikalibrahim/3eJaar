<?php
require_once __DIR__ . "/../db_connectie.php";

class Rooster {
    private $db;

    public function __construct($dbInstance) {
        $this->db = $dbInstance;
    }

    public function create($class_id, $teacher_id, $subject, $day, $start_time, $end_time, $room) {
        $sql = "INSERT INTO schedules (class_id, teacher_id, subject, day, start_time, end_time, room) VALUES (?,?,?,?,?,?,?)";
        return $this->db->execute($sql, [$class_id, $teacher_id, $subject, $day, $start_time, $end_time, $room]);
    }

    public function getByClass($class_id) {
        $sql = "SELECT s.*, c.name as class_name, CONCAT(t.first_name,' ',t.last_name) as teacher_name
                FROM schedules s
                LEFT JOIN classes c ON s.class_id = c.id
                LEFT JOIN teachers t ON s.teacher_id = t.id
                WHERE s.class_id = ?
                ORDER BY FIELD(s.day,'Maandag','Dinsdag','Woensdag','Donderdag','Vrijdag'), s.start_time";
        return $this->db->query($sql, [$class_id]);
    }

    public function getAll() {
        $sql = "SELECT s.*, c.name as class_name, CONCAT(t.first_name,' ',t.last_name) as teacher_name
                FROM schedules s
                LEFT JOIN classes c ON s.class_id = c.id
                LEFT JOIN teachers t ON s.teacher_id = t.id
                ORDER BY FIELD(s.day,'Maandag','Dinsdag','Woensdag','Donderdag','Vrijdag'), s.start_time";
        return $this->db->query($sql);
    }

    public function update($id, $class_id, $teacher_id, $subject, $day, $start_time, $end_time, $room) {
        $sql = "UPDATE schedules SET class_id=?, teacher_id=?, subject=?, day=?, start_time=?, end_time=?, room=? WHERE id=?";
        return $this->db->execute($sql, [$class_id, $teacher_id, $subject, $day, $start_time, $end_time, $room, $id]);
    }

    public function delete($id) {
        $sql = "DELETE FROM schedules WHERE id=?";
        return $this->db->execute($sql, [$id]);
    }
}
?>