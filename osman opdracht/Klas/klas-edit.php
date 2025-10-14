<?php
include_once __DIR__ . '/../db.php';
include_once __DIR__ . '/../header.php';
if (!isset($_SESSION['boom_user']) || ($_SESSION['boom_user']['rol'] ?? null) !== 'admin') { header('Location: ../User/login.php'); exit; }

$id = $_GET['id'] ?? null;
if (!$id) { header('Location: klas-view.php'); exit; }
include_once __DIR__ . '/klas.php';
$klasModel = new Klas();
$klas = $klasModel->find((int)$id);
if (!$klas) { header('Location: klas-view.php'); exit; }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naam = trim($_POST['naam'] ?? '');
    $jaar = trim($_POST['jaar'] ?? '');
    if ($naam === '') { $errors[] = 'Naam is verplicht.'; }
    if ($jaar === '' || !preg_match('/^\d{4}$/', $jaar)) { $errors[] = 'Jaar moet 4 cijfers zijn.'; }
    if (!$errors) {
        $klasModel->update((int)$id, $naam, (int)$jaar);
        header('Location: klas-view.php');
        exit;
    }
}
?>
<h2>Klas wijzigen</h2>
<?php if ($errors): ?><div class="error"><?php foreach ($errors as $e) { echo '<p>' . htmlspecialchars($e) . '</p>'; } ?></div><?php endif; ?>
<form method="post" class="stack">
  <label>Naam</label>
  <input type="text" name="naam" value="<?= htmlspecialchars($_POST['naam'] ?? $klas['naam']) ?>" required>
  <label>Jaar</label>
  <input type="text" name="jaar" value="<?= htmlspecialchars($_POST['jaar'] ?? $klas['jaar']) ?>" required>
  <input type="submit" value="Opslaan">
</form>
<?php include_once __DIR__ . '/../footer.php'; ?>
