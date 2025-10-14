<?php
// instituten/instituut-delete.php
include '../db.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $myDb->execute("DELETE FROM instituten WHERE id = ?", [$id]);
}
header("Location: instituut-view.php");
exit;
