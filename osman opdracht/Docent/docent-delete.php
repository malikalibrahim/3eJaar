<?php
include_once __DIR__ . '/../db.php';
if (!isset($_SESSION)) { session_start(); }
if (!isset($_SESSION['boom_user']) || ($_SESSION['boom_user']['rol'] ?? null) !== 'admin') { header('Location: ../User/login.php'); exit; }

$id = $_GET['id'] ?? null;
if ($id) {
    include_once __DIR__ . '/docent.php';
    $docentModel = new Docent();
    $docentModel->delete((int)$id);
}
header('Location: docent-view.php');
exit;
