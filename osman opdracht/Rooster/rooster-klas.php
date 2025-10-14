<?php
include_once __DIR__ . '/../db.php';
include_once __DIR__ . '/../header.php';

$klas_id = $_GET['klas_id'] ?? '';
if ($klas_id === '') { echo '<div class="error">Geen klas gekozen.</div>'; include_once __DIR__ . '/../footer.php'; exit; }

$klas = $myDb->execute("SELECT * FROM klassen WHERE id=?", [$klas_id])->fetch(PDO::FETCH_ASSOC);
if (!$klas) { echo '<div class="error">Klas niet gevonden.</div>'; include_once __DIR__ . '/../footer.php'; exit; }

include_once __DIR__ . '/rooster.php';
$roosterModel = new RoosterModel();
$week = isset($_GET['week']) ? max(1, min(53, (int)$_GET['week'])) : (int)date('W');
$rows = $roosterModel->byKlas((int)$klas_id, $week);

$dagen = ['maandag','dinsdag','woensdag','donderdag','vrijdag'];
$perDag = array_fill_keys($dagen, []);
foreach ($rows as $r) { $perDag[$r['dag']][] = $r; }
?>
<h2>Rooster: <?= htmlspecialchars($klas['naam']) ?> (Week <?= htmlspecialchars($week) ?>)</h2>
<form method="get" class="row" style="margin-bottom:12px">
  <input type="hidden" name="klas_id" value="<?= htmlspecialchars($klas_id) ?>">
  <label>Week</label>
  <input type="number" name="week" value="<?= htmlspecialchars($week) ?>" min="1" max="53" style="width:90px">
  <button class="button">Toon</button>
  <a class="button button--ghost" href="?klas_id=<?= urlencode($klas_id) ?>&week=<?= (int)date('W') ?>">Huidige week</a>
  <?php if (isset($_SESSION['boom_user']) && (($_SESSION['boom_user']['rol'] ?? null) === 'admin')): ?>
    <a class="button" href="rooster-insert.php?week=<?= htmlspecialchars($week) ?>">+ Les toevoegen</a>
  <?php endif; ?>
</form>
<div class="week-grid-wrap">
<div class="week-grid">
  <div class="week-grid__header"></div>
  <?php foreach ($dagen as $d): ?>
    <div class="week-grid__header"><strong><?= ucfirst($d) ?></strong></div>
  <?php endforeach; ?>

  <?php
    // Bouw consistente tijdsloten (08:00 - 18:00 per uur) en merge met grenzen uit data
    $baseline = [];
    for ($h = 8; $h <= 18; $h++) { $baseline[] = sprintf('%02d:00:00', $h); }
    $times = $baseline;
    foreach ($rows as $r) { $times[] = $r['les_van']; $times[] = $r['les_tot']; }
    $times = array_values(array_unique($times));
    sort($times);
    if (count($times) < 2) { $times = ['08:00:00','09:00:00','10:00:00','11:00:00','12:00:00','13:00:00','14:00:00','15:00:00','16:00:00']; }
    for ($i = 0; $i < count($times) - 1; $i++):
      $slotStart = $times[$i];
      $slotEnd = $times[$i+1];
  ?>
    <div class="week-grid__time"><?= htmlspecialchars(substr($slotStart,0,5)) ?></div>
    <?php foreach ($dagen as $d): ?>
      <?php
        $cell = array_values(array_filter($perDag[$d], function($r) use ($slotStart, $slotEnd) {
          return $r['les_van'] <= $slotStart && $r['les_tot'] >= $slotEnd;
        }));
      ?>
      <div class="week-grid__cell">
        <?php if ($cell): $c = $cell[0]; ?>
          <div class="lesson">
            <div class="lesson__vak"><?= htmlspecialchars($c['vak']) ?></div>
            <div class="lesson__meta"><?= htmlspecialchars(substr($c['les_van'],0,5)) ?> - <?= htmlspecialchars(substr($c['les_tot'],0,5)) ?> · <?= htmlspecialchars($c['docent'] ?? '-') ?></div>
            <?php if (isset($_SESSION['boom_user']) && (($_SESSION['boom_user']['rol'] ?? null) === 'admin')): ?>
              <div class="lesson__actions">
                <a class="btn btn--sm" href="rooster-edit.php?id=<?= urlencode($c['id']) ?>">Wijzigen</a>
                <a class="btn btn--sm button--danger" href="rooster-delete.php?id=<?= urlencode($c['id']) ?>&week=<?= htmlspecialchars($week) ?>" onclick="return confirm('Verwijderen?');">Verwijderen</a>
              </div>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  <?php endfor; ?>
</div>
</div>
<style>
.week-grid-wrap { overflow-x: auto; padding-bottom: 8px; }
.week-grid {
  display: grid;
  grid-template-columns: 120px repeat(5, 1fr);
  gap: 8px;
}
.week-grid__header { padding: 6px 8px; color: #e5e7eb; }
.week-grid__time { padding: 6px 8px; color: var(--color-muted); }
.week-grid__cell { background: rgba(255,255,255,0.02); border: 1px solid var(--color-border); border-radius: 10px; padding: 6px; min-height: 54px; }
.lesson { background: rgba(59,130,246,0.12); border: 1px solid rgba(59,130,246,0.35); border-radius: 8px; padding: 6px 8px; }
.lesson__vak { font-weight: 700; }
.lesson__meta { font-size: 12px; color: var(--color-muted); }
.lesson__actions { margin-top: 6px; display: flex; gap: 6px; }
.btn--sm { padding: 4px 8px; font-size: 12px; border-radius: 8px; }
@media (max-width: 900px) { .week-grid { grid-template-columns: 80px repeat(5, 1fr); } }
</style>
<?php include_once __DIR__ . '/../footer.php'; ?>
