<?php
session_start();
require_once __DIR__ . '/../db_connectie.php';
if (!isset($_SESSION['user'])) { header('Location: /user/login.php'); exit; }
$db = new DB('rooster_de_boom');
$teachers = $db->query('SELECT * FROM teachers ORDER BY last_name, first_name');
include __DIR__ . '/../includes/header.php';
?>
<h2>Docenten</h2>
<a href="teacher-add.php">Nieuwe docent</a>
<table>
<tr><th>ID</th><th>Naam</th><th>Email</th><th>Acties</th></tr>
<?php foreach($teachers as $t): ?>
<tr>
  <td><?= htmlspecialchars($t['id']) ?></td>
  <td><?= htmlspecialchars($t['first_name'].' '.$t['last_name']) ?></td>
  <td><?= htmlspecialchars($t['email']) ?></td>
  <td><a href="teacher-edit.php?id=<?= $t['id'] ?>">Bewerk</a> | <a href="teacher-delete.php?id=<?= $t['id'] ?>" onclick="return confirm('Verwijder?')">Verwijder</a></td>
</tr>
<?php endforeach; ?>
</table>
<?php include __DIR__ . '/../includes/footer.php'; ?>