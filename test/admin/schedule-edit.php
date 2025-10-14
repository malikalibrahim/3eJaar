<?php
session_start();
require_once __DIR__ . '/../db_connectie.php';
require_once __DIR__ . '/../Rooster/rooster.php';
if (!isset($_SESSION['user'])) { header('Location: /user/login.php'); exit; }
$db = new DB('rooster_de_boom');
$rooster = new Rooster($db);
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_id = $_POST['class_id'];
    $teacher_id = $_POST['teacher_id'] ?: null;
    $subject = $_POST['subject'];
    $day = $_POST['day'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $room = $_POST['room'];
    $rooster->update($id, $class_id, $teacher_id, $subject, $day, $start_time, $end_time, $room);
    header('Location: schedules.php');
    exit;
}

$classes = $db->query('SELECT * FROM classes ORDER BY name');
$teachers = $db->query('SELECT * FROM teachers ORDER BY last_name, first_name');
$row = $db->query('SELECT * FROM schedules WHERE id=?', [$id]);
$row = $row ? $row[0] : null;
include __DIR__ . '/../includes/header.php';
?>
<h2>Rooster bewerken</h2>
<?php if(!$row) echo '<p>Niet gevonden.</p>'; else: ?>
<form method="post">
  <label>Klas <select name="class_id" required><?php foreach($classes as $c): $sel = $c['id']==$row['class_id']? 'selected':''; ?><option value="<?= $c['id'] ?>" <?= $sel ?>><?= htmlspecialchars($c['name']) ?></option><?php endforeach; ?></select></label><br>
  <label>Docent <select name="teacher_id"><option value="">-- geen --</option><?php foreach($teachers as $t): $sel = $t['id']==$row['teacher_id']? 'selected':''; ?><option value="<?= $t['id'] ?>" <?= $sel ?>><?= htmlspecialchars($t['first_name'].' '.$t['last_name']) ?></option><?php endforeach; ?></select></label><br>
  <label>Vak <input name="subject" value="<?= htmlspecialchars($row['subject']) ?>" required></label><br>
  <label>Dag <select name="day" required><option <?= $row['day']=='Maandag'?'selected':'' ?>>Maandag</option><option <?= $row['day']=='Dinsdag'?'selected':'' ?>>Dinsdag</option><option <?= $row['day']=='Woensdag'?'selected':'' ?>>Woensdag</option><option <?= $row['day']=='Donderdag'?'selected':'' ?>>Donderdag</option><option <?= $row['day']=='Vrijdag'?'selected':'' ?>>Vrijdag</option></select></label><br>
  <label>Start tijd <input type="time" name="start_time" value="<?= htmlspecialchars($row['start_time']) ?>" required></label><br>
  <label>Eind tijd <input type="time" name="end_time" value="<?= htmlspecialchars($row['end_time']) ?>" required></label><br>
  <label>Lokaal <input name="room" value="<?= htmlspecialchars($row['room']) ?>"></label><br>
  <button type="submit">Opslaan</button>
</form>
<?php endif; ?>
<?php include __DIR__ . '/../includes/footer.php'; ?>