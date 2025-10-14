<?php
session_start();
require_once __DIR__ . '/../db_connectie.php';
require_once __DIR__ . '/../Rooster/rooster.php';
if (!isset($_SESSION['user'])) { header('Location: /user/login.php'); exit; }
$db = new DB('rooster_de_boom');
$rooster = new Rooster($db);
$classes = $db->query('SELECT * FROM classes ORDER BY name');
$teachers = $db->query('SELECT * FROM teachers ORDER BY last_name, first_name');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_id = $_POST['class_id'];
    $teacher_id = $_POST['teacher_id'] ?: null;
    $subject = $_POST['subject'];
    $day = $_POST['day'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $room = $_POST['room'];
    $rooster->create($class_id, $teacher_id, $subject, $day, $start_time, $end_time, $room);
    header('Location: schedules.php');
    exit;
}
include __DIR__ . '/../includes/header.php';
?>
<h2>Roosterblok toevoegen</h2>
<form method="post">
  <label>Klas <select name="class_id" required>
    <?php foreach($classes as $c): ?><option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option><?php endforeach; ?>
  </select></label><br>
  <label>Docent <select name="teacher_id"><option value="">-- geen --</option><?php foreach($teachers as $t): ?><option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['first_name'].' '.$t['last_name']) ?></option><?php endforeach; ?></select></label><br>
  <label>Vak <input name="subject" required></label><br>
  <label>Dag <select name="day" required><option>Maandag</option><option>Dinsdag</option><option>Woensdag</option><option>Donderdag</option><option>Vrijdag</option></select></label><br>
  <label>Start tijd <input type="time" name="start_time" required></label><br>
  <label>Eind tijd <input type="time" name="end_time" required></label><br>
  <label>Lokaal <input name="room"></label><br>
  <button type="submit">Opslaan</button>
</form>
<?php include __DIR__ . '/../includes/footer.php'; ?>