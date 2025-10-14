<?php
include_once __DIR__ . '/../db.php';
include_once __DIR__ . '/../header.php';
if (!isset($_SESSION['boom_user']) || ($_SESSION['boom_user']['rol'] ?? null) !== 'admin') { header('Location: ../User/login.php'); exit; }

$klassen = $myDb->execute("SELECT id, naam FROM klassen ORDER BY naam")->fetchAll(PDO::FETCH_ASSOC);
$vakken = $myDb->execute("SELECT v.id, v.naam AS vak, u.naam AS docent FROM vakken v JOIN users u ON u.id = v.docent_id WHERE u.rol='docent' ORDER BY v.naam, u.naam")->fetchAll(PDO::FETCH_ASSOC);

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $week = $_POST['week'] ?? '';
    $klas_id = $_POST['klas_id'] ?? '';
    $dag = $_POST['dag'] ?? '';
    $les_van = $_POST['les_van'] ?? '';
    $les_tot = $_POST['les_tot'] ?? '';
    $vak_id = $_POST['vak_id'] ?? '';

    if ($week === '' || !preg_match('/^\d+$/', $week) || (int)$week < 1 || (int)$week > 53) { $errors[] = 'Week moet tussen 1 en 53 zijn.'; }
    if ($klas_id === '') { $errors[] = 'Klas is verplicht.'; }
    if (!in_array($dag, ['maandag','dinsdag','woensdag','donderdag','vrijdag'])) { $errors[] = 'Dag is ongeldig.'; }
    if ($les_van === '' || $les_tot === '') { $errors[] = 'Tijden zijn verplicht.'; }
    if ($vak_id === '') { $errors[] = 'Vak is verplicht.'; }

    if (!$errors) {
        include_once __DIR__ . '/rooster.php';
        $roosterModel = new RoosterModel();
        $roosterModel->create((int)$klas_id, (int)$week, $dag, $les_van, $les_tot, (int)$vak_id);
        $goWeek = (int)$week;
        header('Location: rooster-view.php?week=' . $goWeek);
        exit;
    }
}
?>
<h2>Les toevoegen</h2>
<?php if ($errors): ?><div class="error"><?php foreach ($errors as $e) { echo '<p>' . htmlspecialchars($e) . '</p>'; } ?></div><?php endif; ?>
<form method="post" class="stack">
  <label>Week (1-53)</label>
  <input type="number" name="week" min="1" max="53" value="<?= htmlspecialchars($_GET['week'] ?? $_POST['week'] ?? (int)date('W')) ?>" required>
  <label>Klas</label>
  <select name="klas_id" required>
    <option value="">-- kies klas --</option>
    <?php foreach ($klassen as $k): ?>
      <option value="<?= $k['id'] ?>" <?= (($_POST['klas_id'] ?? '') == $k['id']) ? 'selected' : '' ?>><?= htmlspecialchars($k['naam']) ?></option>
    <?php endforeach; ?>
  </select>

  <label>Dag</label>
  <select name="dag" required>
    <?php $dagen = ['maandag','dinsdag','woensdag','donderdag','vrijdag']; foreach ($dagen as $d) { $sel = (($_POST['dag'] ?? '') === $d) ? 'selected' : ''; echo '<option ' . $sel . ' value="' . $d . '">' . ucfirst($d) . '</option>'; } ?>
  </select>

  <label>Van</label>
  <input class="time-input" type="time" name="les_van" step="300" value="<?= htmlspecialchars($_POST['les_van'] ?? '') ?>" required>

  <label>Tot</label>
  <input class="time-input" type="time" name="les_tot" step="300" value="<?= htmlspecialchars($_POST['les_tot'] ?? '') ?>" required>

  <label>Vak (met docent)</label>
  <select name="vak_id" required>
    <option value="">-- kies vak --</option>
    <?php foreach ($vakken as $v): ?>
      <option value="<?= $v['id'] ?>" <?= (($_POST['vak_id'] ?? '') == $v['id']) ? 'selected' : '' ?>><?= htmlspecialchars($v['vak']) ?> — <?= htmlspecialchars($v['docent']) ?></option>
    <?php endforeach; ?>
  </select>
  <p class="muted">Mis je een vak? <a href="../Vakken/vakken.php">Voeg vak(ken) toe</a>.</p>
  <style>
    .time-input {
      font-size: 18px;
      padding: 10px 12px;
      border: 2px solid var(--color-border);
      border-radius: 10px;
      background: #0b1220;
      color: #fff;
      width: 220px;
    }
    .time-input::-webkit-datetime-edit-hour-field,
    .time-input::-webkit-datetime-edit-minute-field,
    .time-input::-webkit-datetime-edit-ampm-field,
    .time-input::-webkit-datetime-edit-text {
      padding: 0 2px;
    }
    .time-input:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.25); }
  </style>

  <input type="submit" value="Opslaan">
</form>
<?php include_once __DIR__ . '/../footer.php'; ?>
