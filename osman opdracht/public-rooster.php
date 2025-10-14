<?php
include_once __DIR__ . '/db.php';
include_once __DIR__ . '/header.php';

include_once __DIR__ . '/Klas/klas.php';
$klasModel = new Klas();
$klassen = $klasModel->all();
?>
<h2>Rooster per klas</h2>
<?php if (count($klassen) === 0): ?>
  <p class="muted">Er zijn nog geen klassen aangemaakt.</p>
<?php else: ?>
  <div class="grid grid-2">
    <?php foreach ($klassen as $k): ?>
      <a class="card" href="<?= BOOM_BASE_URL ?>/Rooster/rooster-klas.php?klas_id=<?= urlencode($k['id']) ?>">
        <h3><?= htmlspecialchars($k['naam']) ?></h3>
        <p class="muted">Jaar <?= htmlspecialchars($k['jaar']) ?></p>
      </a>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
<?php include_once __DIR__ . '/footer.php'; ?>
