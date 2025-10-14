<?php
session_start();
require_once __DIR__ . '/../db_connectie.php';
require_once __DIR__ . '/../Rooster/rooster.php';
if (!isset($_SESSION['user'])) { header('Location: /user/login.php'); exit; }
$db = new DB('rooster_de_boom');
$rooster = new Rooster($db);
$rows = $rooster->getAll();
include __DIR__ . '/../includes/header.php';
?>
<h2>Rooster overzicht</h2>
<a href="schedule-add.php">Lesblok toevoegen</a>
<table>
<tr><th>Dag</th><th>Tijd</th><th>Klas</th><th>Vak</th><th>Docent</th><th>Acties</th></tr>
<?php foreach($rows as $r): ?>
<tr>
  <td><?= htmlspecialchars($r['day']) ?></td>
  <td><?= htmlspecialchars(substr($r['start_time'],0,5)).' - '.htmlspecialchars(substr($r['end_time'],0,5)) ?></td>
  <td><?= htmlspecialchars($r['class_name']) ?></td>
  <td><?= htmlspecialchars($r['subject']) ?></td>
  <td><?= htmlspecialchars($r['teacher_name']) ?></td>
  <td><a href="schedule-edit.php?id=<?= $r['id'] ?>">Bewerk</a> | <a href="schedule-delete.php?id=<?= $r['id'] ?>" onclick="return confirm('Verwijderen?')">Verwijder</a></td>
</tr>
<?php endforeach; ?>
</table>
<?php include __DIR__ . '/../includes/footer.php'; ?>