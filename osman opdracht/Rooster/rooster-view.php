<?php
include_once __DIR__ . '/../db.php';
include_once __DIR__ . '/../header.php';
if (!isset($_SESSION['boom_user']) || ($_SESSION['boom_user']['rol'] ?? null) !== 'admin') { header('Location: ../User/login.php'); exit; }

include_once __DIR__ . '/rooster.php';
$roosterModel = new RoosterModel();
$week = isset($_GET['week']) ? max(1, min(53, (int)$_GET['week'])) : (int)date('W');
$rows = $roosterModel->overview($week);
?>
<h2>Overzicht Roosters (Week <?= htmlspecialchars($week) ?>)</h2>
<form method="get" class="row" style="margin-bottom:12px">
  <label>Week</label>
  <input type="number" name="week" value="<?= htmlspecialchars($week) ?>" min="1" max="53" style="width:90px">
  <button class="button">Toon</button>
  <a class="button button--ghost" href="?week=<?= (int)date('W') ?>">Huidige week</a>
  <?php if (isset($_SESSION['boom_user']) && (($_SESSION['boom_user']['rol'] ?? null) === 'admin')): ?>
    <a class="button" href="rooster-insert.php?week=<?= htmlspecialchars($week) ?>">+ Les toevoegen</a>
  <?php endif; ?>
</form>
<table class="table">
  <thead><tr><th>Week</th><th>Klas</th><th>Dag</th><th>Van</th><th>Tot</th><th>Vak</th><th>Docent</th><?php if (isset($_SESSION['boom_user']) && (($_SESSION['boom_user']['rol'] ?? null) === 'admin')): ?><th>Acties</th><?php endif; ?></tr></thead>
  <tbody>
  <?php foreach ($rows as $r): ?>
    <tr>
      <td><?= htmlspecialchars($r['week']) ?></td>
      <td><?= htmlspecialchars($r['klas']) ?></td>
      <td><?= htmlspecialchars($r['dag']) ?></td>
      <td><?= htmlspecialchars($r['les_van']) ?></td>
      <td><?= htmlspecialchars($r['les_tot']) ?></td>
      <td><?= htmlspecialchars($r['vak']) ?></td>
      <td><?= htmlspecialchars($r['docent'] ?? '-') ?></td>
      <?php if (isset($_SESSION['boom_user']) && (($_SESSION['boom_user']['rol'] ?? null) === 'admin')): ?>
      <td>
        <a href="rooster-edit.php?id=<?= urlencode($r['id']) ?>&week=<?= htmlspecialchars($week) ?>">Wijzigen</a> |
        <a href="rooster-delete.php?id=<?= urlencode($r['id']) ?>&week=<?= htmlspecialchars($week) ?>" onclick="return confirm('Verwijderen?');">Verwijderen</a>
      </td>
      <?php endif; ?>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<?php include_once __DIR__ . '/../footer.php'; ?>
