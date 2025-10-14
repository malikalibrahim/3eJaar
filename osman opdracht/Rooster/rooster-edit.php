<?php
include_once __DIR__ . '/../db.php';
include_once __DIR__ . '/../header.php';
if (!isset($_SESSION['boom_user']) || (($_SESSION['boom_user']['rol'] ?? null) !== 'admin')) { header('Location: ../User/login.php'); exit; }

include_once __DIR__ . '/rooster.php';
$roosterModel = new RoosterModel();

$id = $_GET['id'] ?? null;
if (!$id) { header('Location: rooster-view.php'); exit; }

$klassen = $myDb->execute("SELECT id, naam FROM klassen ORDER BY naam")->fetchAll(PDO::FETCH_ASSOC);
$vakken = $myDb->execute("SELECT v.id, v.naam AS vak, u.naam AS docent FROM vakken v JOIN users u ON u.id = v.docent_id WHERE u.rol='docent' ORDER BY v.naam, u.naam")->fetchAll(PDO::FETCH_ASSOC);

$row = $myDb->execute("SELECT * FROM roosters WHERE id=?", [$id])->fetch(PDO::FETCH_ASSOC);
if (!$row) { header('Location: rooster-view.php'); exit; }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $klas_id = $_POST['klas_id'] ?? '';
    $dag = $_POST['dag'] ?? '';
    $les_van = $_POST['les_van'] ?? '';
    $les_tot = $_POST['les_tot'] ?? '';
    $vak_id = $_POST['vak_id'] ?? '';

    if ($klas_id === '') { $errors[] = 'Klas is verplicht.'; }
    if (!in_array($dag, ['maandag','dinsdag','woensdag','donderdag','vrijdag'])) { $errors[] = 'Dag is ongeldig.'; }
    if ($les_van === '' || $les_tot === '') { $errors[] = 'Tijden zijn verplicht.'; }
    if ($vak_id === '') { $errors[] = 'Vak is verplicht.'; }

    if (!$errors) {
        $roosterModel->update((int)$id, (int)$klas_id, (int)$row['week'], $dag, $les_van, $les_tot, (int)$vak_id);
        header('Location: rooster-view.php?week=' . (int)$row['week']);
        exit;
    }
}
?>
<h2>Les wijzigen</h2>
<?php if ($errors): ?><div class="error"><?php foreach ($errors as $e) { echo '<p>' . htmlspecialchars($e) . '</p>'; } ?></div><?php endif; ?>
<form method="post" class="stack">
  <label>Klas</label>
  <select name="klas_id" required>
    <?php foreach ($klassen as $k): ?>
      <option value="<?= $k['id'] ?>" <?= ($row['klas_id'] == $k['id']) ? 'selected' : '' ?>><?= htmlspecialchars($k['naam']) ?></option>
    <?php endforeach; ?>
  </select>

  <label>Dag</label>
  <?php $dagen = ['maandag','dinsdag','woensdag','donderdag','vrijdag']; ?>
  <select name="dag" required>
    <?php foreach ($dagen as $d) { $sel = ($row['dag'] === $d) ? 'selected' : ''; echo '<option ' . $sel . ' value="' . $d . '">' . ucfirst($d) . '</option>'; } ?>
  </select>

  <label>Van</label>
  <input class="time-input" type="time" name="les_van" step="300" value="<?= htmlspecialchars($row['les_van']) ?>" required>

  <label>Tot</label>
  <input class="time-input" type="time" name="les_tot" step="300" value="<?= htmlspecialchars($row['les_tot']) ?>" required>

  <label>Vak (met docent)</label>
  <select name="vak_id" required>
    <?php foreach ($vakken as $v): ?>
      <option value="<?= $v['id'] ?>" <?= (($row['vak_id'] ?? null) == $v['id']) ? 'selected' : '' ?>><?= htmlspecialchars($v['vak']) ?> — <?= htmlspecialchars($v['docent']) ?></option>
    <?php endforeach; ?>
  </select>

  <input type="submit" value="Opslaan">
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
</form>
<?php include_once __DIR__ . '/../footer.php'; ?>
