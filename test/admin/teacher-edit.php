<?php
session_start();
require_once __DIR__ . '/../db_connectie.php';
if (!isset($_SESSION['user'])) { header('Location: /user/login.php'); exit; }
$db = new DB('rooster_de_boom');
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first = $_POST['first_name'] ?? '';
    $last = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $db->execute('UPDATE teachers SET first_name=?, last_name=?, email=? WHERE id=?', [$first,$last,$email,$id]);
    header('Location: teachers.php');
    exit;
}

$teacher = $db->query('SELECT * FROM teachers WHERE id=?', [$id]);
$teacher = $teacher ? $teacher[0] : null;
include __DIR__ . '/../includes/header.php';
?>
<h2>Docent bewerken</h2>
<?php if(!$teacher) echo '<p>Docent niet gevonden.</p>'; else: ?>
<form method="post">
  <label>Voornaam <input name="first_name" value="<?= htmlspecialchars($teacher['first_name']) ?>" required></label><br>
  <label>Achternaam <input name="last_name" value="<?= htmlspecialchars($teacher['last_name']) ?>" required></label><br>
  <label>Email <input name="email" type="email" value="<?= htmlspecialchars($teacher['email']) ?>"></label><br>
  <button type="submit">Opslaan</button>
</form>
<?php endif; ?>
<?php include __DIR__ . '/../includes/footer.php'; ?>