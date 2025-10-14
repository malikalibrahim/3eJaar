<?php
include_once __DIR__ . '/../db.php';
include_once __DIR__ . '/../header.php';
if (!isset($_SESSION['boom_user']) || (($_SESSION['boom_user']['rol'] ?? null) !== 'admin')) { header('Location: login.php'); exit; }

$id = $_GET['id'] ?? null;
if (!$id) { header('Location: users-view.php'); exit; }

$u = $myDb->execute("SELECT * FROM users WHERE id=?", [$id])->fetch(PDO::FETCH_ASSOC);
if (!$u) { header('Location: users-view.php'); exit; }

$klassen = $myDb->execute("SELECT id, naam FROM klassen ORDER BY naam")->fetchAll(PDO::FETCH_ASSOC);

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naam = trim($_POST['naam'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $rol = $_POST['rol'] ?? 'leerling';
    $klas_id = $_POST['klas_id'] ?? '';

    if ($naam === '') { $errors[] = 'Naam is verplicht.'; }
    if ($username === '') { $errors[] = 'Gebruikersnaam is verplicht.'; }
    if (!in_array($rol, ['admin','leerling','docent'])) { $errors[] = 'Rol is ongeldig.'; }
    if ($rol === 'leerling' && $klas_id === '') { $errors[] = 'Klas is verplicht voor leerlingen.'; }

    if (!$errors) {
        if ($password !== '') {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $myDb->execute("UPDATE users SET naam=?, username=?, password=?, rol=?, klas_id=? WHERE id=?", [$naam, $username, $hashed_password, $rol, $rol === 'leerling' ? $klas_id : null, $id]);
        } else {
            $myDb->execute("UPDATE users SET naam=?, username=?, rol=?, klas_id=? WHERE id=?",
                [$naam, $username, $rol, $rol === 'leerling' ? $klas_id : null, $id]);
        }
        header('Location: users-view.php');
        exit;
    }
}
?>
<h2>Gebruiker wijzigen</h2>
<?php if ($errors): ?><div class="error"><?php foreach ($errors as $e) { echo '<p>' . htmlspecialchars($e) . '</p>'; } ?></div><?php endif; ?>
<form method="post" class="stack">
  <label>Naam</label>
  <input type="text" name="naam" value="<?= htmlspecialchars($_POST['naam'] ?? $u['naam']) ?>" required>
  <label>Gebruikersnaam</label>
  <input type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? $u['username']) ?>" required>
  <label>Nieuw wachtwoord (leeg laten = ongewijzigd)</label>
  <input type="password" name="password">
  <label>Rol</label>
  <select name="rol" required>
    <?php $rolSel = $_POST['rol'] ?? $u['rol']; ?>
    <option value="leerling" <?= ($rolSel === 'leerling') ? 'selected' : '' ?>>Leerling</option>
    <option value="docent" <?= ($rolSel === 'docent') ? 'selected' : '' ?>>Docent</option>
    <option value="admin" <?= ($rolSel === 'admin') ? 'selected' : '' ?>>Admin</option>
  </select>
  <label>Klas (alleen voor leerling)</label>
  <select name="klas_id">
    <option value="">-- optioneel --</option>
    <?php foreach ($klassen as $k): ?>
      <?php $sel = ((($_POST['klas_id'] ?? $u['klas_id']) == $k['id']) ? 'selected' : ''); ?>
      <option value="<?= $k['id'] ?>" <?= $sel ?>><?= htmlspecialchars($k['naam']) ?></option>
    <?php endforeach; ?>
  </select>
  <input type="submit" value="Opslaan">
</form>
<?php include_once __DIR__ . '/../footer.php'; ?>
