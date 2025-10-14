<?php
include '../db.php';

$id = $_GET['id'];
$myDb->execute("DELETE FROM medewerkers WHERE id=?", [$id]);

header("Location: user-view.php");
exit;
