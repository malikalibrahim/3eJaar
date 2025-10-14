<?php
session_start();
require_once __DIR__ . '/../db_connectie.php';
if (!isset($_SESSION['user'])) { header('Location: /user/login.php'); exit; }
$db = new DB('rooster_de_boom');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first = $_POST['first_name'] ?? '';
    $last = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $db->execute('INSERT INTO teachers (first_name, last_name, email) VALUES (?,?,?)', [$first,$last,$email]);
    header('Location: teachers.php');
    exit;
}
include __DIR__ . '/../includes/header.php';
?>
<h2>Docent toevoegen</h2>
<form method="post">
  <label>Voornaam <input name="first_name" required></label><br>
  <label>Achternaam <input name="last_name" required></label><br>
  <label>Email <input name="email" type="email"></label><br>
  <button type="submit">Opslaan</button>
</form>
<?php include __DIR__ . '/../includes/footer.php'; ?>