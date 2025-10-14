<?php
session_start();
require_once __DIR__ . '/../db_connectie.php';
if (!isset($_SESSION['user'])) { header('Location: /user/login.php'); exit; }
$db = new DB('rooster_de_boom');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $db->execute('INSERT INTO classes (name, description) VALUES (?,?)', [$name, $description]);
    header('Location: classes.php');
    exit;
}
include __DIR__ . '/../includes/header.php';
?>
<h2>Nieuwe klas toevoegen</h2>
<form method="post">
  <label>Naam <input name="name" required></label><br>
  <label>Beschrijving <textarea name="description"></textarea></label><br>
  <button type="submit">Opslaan</button>
</form>
<?php include __DIR__ . '/../includes/footer.php'; ?>