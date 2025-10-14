<?php
include_once __DIR__ . '/../db.php';
include_once __DIR__ . '/../header.php';
if (!isset($_SESSION['boom_user']) || ($_SESSION['boom_user']['rol'] ?? null) !== 'admin') { header('Location: ../User/login.php'); exit; }

include_once __DIR__ . '/klas.php';
$klasModel = new Klas();
$klassen = $klasModel->all();
?>
<h2>Overzicht Klassen</h2>
<p><a class="button" href="klas-insert.php">+ Klas toevoegen</a></p>
<table class="table">
  <thead><tr><th>ID</th><th>Naam</th><th>Jaar</th><th>Acties</th></tr></thead>
  <tbody>
    <?php foreach ($klassen as $k): ?>
      <tr>
        <td><?= htmlspecialchars($k['id']) ?></td>
        <td><?= htmlspecialchars($k['naam']) ?></td>
        <td><?= htmlspecialchars($k['jaar']) ?></td>
        <td>
          <a href="klas-edit.php?id=<?= urlencode($k['id']) ?>">Wijzigen</a> |
          <a href="klas-delete.php?id=<?= urlencode($k['id']) ?>" onclick="return confirm('Verwijderen?');">Verwijderen</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php include_once __DIR__ . '/../footer.php'; ?>
