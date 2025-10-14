<?php
include_once __DIR__ . '/../db.php';
if (!isset($_SESSION)) { session_start(); }
if (!isset($_SESSION['boom_user']) || (($_SESSION['boom_user']['rol'] ?? null) !== 'admin')) { header('Location: login.php'); exit; }

$id = $_GET['id'] ?? null;
if ($id) {
    $myDb->execute("DELETE FROM users WHERE id=?", [$id]);
}
header('Location: users-view.php');
exit;


