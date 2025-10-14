<?php
include_once __DIR__ . '/../db.php';
include_once __DIR__ . '/../header.php';
if (!isset($_SESSION['boom_user']) || ($_SESSION['boom_user']['rol'] ?? null) !== 'admin') { header('Location: ../User/login.php'); exit; }

$id = $_GET['id'] ?? null;
if (!$id) { header('Location: docent-view.php'); exit; }
include_once __DIR__ . '/docent.php';
$docentModel = new Docent();
$d = $docentModel->find((int)$id);
if (!$d) { header('Location: docent-view.php'); exit; }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naam = trim($_POST['naam'] ?? '');
    $password = trim($_POST['password'] ?? '');
    if ($naam === '') { $errors[] = 'Naam is verplicht.'; }
    if (!$errors) {
        $docentModel->update((int)$id, $naam, $password);
        header('Location: docent-view.php');
        exit;
    }
}
?>
<h2>Docent wijzigen</h2>
<?php if ($errors): ?><div class="error"><?php foreach ($errors as $e) { echo '<p>' . htmlspecialchars($e) . '</p>'; } ?></div><?php endif; ?>
<form method="post" class="stack">
  <label>Naam</label>
  <input type="text" name="naam" value="<?= htmlspecialchars($_POST['naam'] ?? $d['naam']) ?>" required>
  <label>Nieuw wachtwoord (optioneel)</label>
  <input type="password" name="password">
  <input type="submit" value="Opslaan">
</form>
<?php include_once __DIR__ . '/../footer.php'; ?>
