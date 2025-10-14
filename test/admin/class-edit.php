<?php
session_start();
require_once __DIR__ . '/../db_connectie.php';
if (!isset($_SESSION['user'])) { header('Location: /user/login.php'); exit; }
$db = new DB('rooster_de_boom');
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $db->execute('UPDATE classes SET name=?, description=? WHERE id=?', [$name, $description, $id]);
    header('Location: classes.php');
    exit;
}

$class = $db->query('SELECT * FROM classes WHERE id=?', [$id]);
$class = $class ? $class[0] : null;
include __DIR__ . '/../includes/header.php';
?>
<h2>Klas bewerken</h2>
<?php if(!$class) echo '<p>Klas niet gevonden.</p>'; else: ?>
<form method="post">
  <label>Naam <input name="name" value="<?= htmlspecialchars($class['name']) ?>" required></label><br>
  <label>Beschrijving <textarea name="description"><?= htmlspecialchars($class['description']) ?></textarea></label><br>
  <button type="submit">Opslaan</button>
</form>
<?php endif; ?>
<?php include __DIR__ . '/../includes/footer.php'; ?>