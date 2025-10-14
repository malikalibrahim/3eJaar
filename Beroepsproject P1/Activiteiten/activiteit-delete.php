<?php
// activiteiten/activiteit-delete.php
include '../db.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $myDb->execute("DELETE FROM activiteiten WHERE id = ?", [$id]);
}
header("Location: activiteit-view.php");
exit;
