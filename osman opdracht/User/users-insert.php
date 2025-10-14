<?php
include_once __DIR__ . '/../db.php';
include_once __DIR__ . '/../header.php';
if (!isset($_SESSION['boom_user']) || (($_SESSION['boom_user']['rol'] ?? null) !== 'admin')) { header('Location: login.php'); exit; }

$klassen = $myDb->execute("SELECT id, naam FROM klassen ORDER BY naam")->fetchAll(PDO::FETCH_ASSOC);

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naam = trim($_POST['naam'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
$rol = $_POST['rol'] ?? ($_GET['rol'] ?? 'leerling');
    $klas_id = $_POST['klas_id'] ?? '';

    if ($naam === '') { $errors[] = 'Naam is verplicht.'; }
    if ($username === '') { $errors[] = 'Gebruikersnaam is verplicht.'; }
    if ($password === '') { $errors[] = 'Wachtwoord is verplicht.'; }
    if (!in_array($rol, ['admin','leerling','docent'])) { $errors[] = 'Rol is ongeldig.'; }
    if ($rol === 'leerling' && $klas_id === '') { $errors[] = 'Klas is verplicht voor leerlingen.'; }

    if (!$errors) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $myDb->execute("INSERT INTO users (naam, username, password, rol, klas_id) VALUES (?,?,?,?,?)",
            [$naam, $username, $hashed_password, $rol, $rol === 'leerling' ? $klas_id : null]);
        header('Location: users-view.php');
        exit;
    }
}
?>
<h2>Gebruiker toevoegen</h2>
<?php if ($errors): ?><div class="error"><?php foreach ($errors as $e) { echo '<p>' . htmlspecialchars($e) . '</p>'; } ?></div><?php endif; ?>
<?php $prefRole = $_POST['rol'] ?? ($_GET['rol'] ?? 'leerling'); ?>
<form method="post" class="stack">
  <label>Naam</label>
  <input type="text" name="naam" value="<?= htmlspecialchars($_POST['naam'] ?? '') ?>" required>
  <label>Gebruikersnaam</label>
  <input type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
  <label>Wachtwoord</label>
  <input type="password" name="password" required>
  <label>Rol</label>
  <select name="rol" required>
    <option value="leerling" <?= ($prefRole === 'leerling') ? 'selected' : '' ?>>Leerling</option>
    <option value="docent" <?= ($prefRole === 'docent') ? 'selected' : '' ?>>Docent</option>
    <option value="admin" <?= ($prefRole === 'admin') ? 'selected' : '' ?>>Admin</option>
  </select>
  <label>Klas (alleen voor leerling)</label>
  <select name="klas_id">
    <option value="">-- optioneel --</option>
    <?php foreach ($klassen as $k): ?>
      <option value="<?= $k['id'] ?>" <?= (($_POST['klas_id'] ?? '') == $k['id']) ? 'selected' : '' ?>><?= htmlspecialchars($k['naam']) ?></option>
    <?php endforeach; ?>
  </select>
  <input type="submit" value="Opslaan">
</form>
<?php include_once __DIR__ . '/../footer.php'; ?>
