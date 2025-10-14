<?php
session_start();
require_once __DIR__ . '/../db_connectie.php';
if (!isset($_SESSION['user'])) { header('Location: /user/login.php'); exit; }
$db = new DB('rooster_de_boom');
$classes = $db->query('SELECT * FROM classes ORDER BY name');
include __DIR__ . '/../includes/header.php';
?>
<h2>Klassen</h2>
<a href="class-add.php">Nieuwe klas toevoegen</a>
<table>
<tr><th>ID</th><th>Naam</th><th>Acties</th></tr>
<?php foreach($classes as $c): ?>
<tr>
  <td><?= htmlspecialchars($c['id']) ?></td>
  <td><?= htmlspecialchars($c['name']) ?></td>
  <td>
    <a href="class-edit.php?id=<?= $c['id'] ?>">Bewerk</a> |
    <a href="class-delete.php?id=<?= $c['id'] ?>" onclick="return confirm('Weet je het zeker?')">Verwijder</a>
  </td>
</tr>
<?php endforeach; ?>
</table>
<?php include __DIR__ . '/../includes/footer.php'; ?>