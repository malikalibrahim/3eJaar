<?php
session_start();
require_once __DIR__ . '/../db_connectie.php';
if (!isset($_SESSION['user'])) { header('Location: /user/login.php'); exit; }
$db = new DB('rooster_de_boom');
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id) {
    $db->execute('DELETE FROM classes WHERE id=?', [$id]);
}
header('Location: classes.php');
exit;
