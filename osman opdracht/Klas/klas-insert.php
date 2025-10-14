<?php
include_once __DIR__ . '/../db.php';
include_once __DIR__ . '/../header.php';
if (!isset($_SESSION['boom_user']) || ($_SESSION['boom_user']['rol'] ?? null) !== 'admin') { header('Location: ../User/login.php'); exit; }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naam = trim($_POST['naam'] ?? '');
    $jaar = trim($_POST['jaar'] ?? '');
    if ($naam === '') { $errors[] = 'Naam is verplicht.'; }
    if ($jaar === '' || !preg_match('/^\d{4}$/', $jaar)) { $errors[] = 'Jaar moet 4 cijfers zijn.'; }
    if (!$errors) {
        include_once __DIR__ . '/klas.php';
        $klasModel = new Klas();
        $klasModel->create($naam, (int)$jaar);
        header('Location: klas-view.php');
        exit;
    }
}
?>
<h2>Klas toevoegen</h2>
<?php if ($errors): ?><div class="error"><?php foreach ($errors as $e) { echo '<p>' . htmlspecialchars($e) . '</p>'; } ?></div><?php endif; ?>
<form method="post" class="stack">
  <label>Naam</label>
  <input type="text" name="naam" value="<?= htmlspecialchars($_POST['naam'] ?? '') ?>" required>
  <label>Jaar (bijv. 2025)</label>
  <input type="text" name="jaar" value="<?= htmlspecialchars($_POST['jaar'] ?? '') ?>" required>
  <input type="submit" value="Opslaan">
</form>
<?php include_once __DIR__ . '/../footer.php'; ?>
