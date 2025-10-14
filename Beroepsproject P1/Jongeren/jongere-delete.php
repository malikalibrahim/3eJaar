<?php
// jongeren/jongere-delete.php
include '../db.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $myDb->execute("DELETE FROM jongeren WHERE id = ?", [$id]);
}
header("Location: jongere-view.php");
exit;
