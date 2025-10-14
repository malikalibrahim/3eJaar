<?php
require_once __DIR__ . '/../db_connectie.php';
$db = new DB('rooster_de_boom');
$class_id = isset($_GET['class_id']) ? (int)$_GET['class_id'] : 0;
if ($class_id <= 0) { echo 'Kies een klas.'; exit; }
$class = $db->query('SELECT * FROM classes WHERE id=?', [$class_id]);
$class = $class ? $class[0] : null;
if (!$class) { echo 'Klas niet gevonden.'; exit; }
$rows = $db->query("SELECT s.*, CONCAT(t.first_name,' ',t.last_name) as teacher_name FROM schedules s LEFT JOIN teachers t ON s.teacher_id = t.id WHERE s.class_id = ? ORDER BY FIELD(s.day,'Maandag','Dinsdag','Woensdag','Donderdag','Vrijdag'), s.start_time", [$class_id]);
include __DIR__ . '/../includes/header.php';
?>
<h2>Rooster <?= htmlspecialchars($class['name']) ?></h2>
<table>
<tr><th>Dag</th><th>Tijd</th><th>Vak</th><th>Docent</th></tr>
<?php foreach($rows as $r): ?>
<tr>
  <td><?= htmlspecialchars($r['day']) ?></td>
  <td><?= htmlspecialchars(substr($r['start_time'],0,5)).' - '.htmlspecialchars(substr($r['end_time'],0,5)) ?></td>
  <td><?= htmlspecialchars($r['subject']) ?></td>
  <td><?= htmlspecialchars($r['teacher_name']) ?></td>
</tr>
<?php endforeach; ?>
</table>
<?php include __DIR__ . '/../includes/footer.php'; ?>