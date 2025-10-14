<?php
include_once __DIR__ . '/db.php';
include_once __DIR__ . '/header.php';

if (!isset($_SESSION['boom_user']) || ($_SESSION['boom_user']['rol'] ?? null) !== 'admin') {
    header('Location: User/login.php');
    exit;
}
?>

<h2>Dashboard</h2>
<div class="grid grid-3">
  <a class="card" href="Klas/klas-view.php"><h3>Klassen</h3><p class="muted">Beheer klassen</p></a>
  <a class="card" href="Docent/docent-view.php"><h3>Docenten</h3><p class="muted">Beheer docenten</p></a>
  <a class="card" href="Rooster/rooster-view.php"><h3>Roosters</h3><p class="muted">Beheer roosters</p></a>
</div>

<?php include_once __DIR__ . '/footer.php'; ?>
