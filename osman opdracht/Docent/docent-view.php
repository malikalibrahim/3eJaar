<?php
include_once __DIR__ . '/../db.php';
include_once __DIR__ . '/../header.php';
if (!isset($_SESSION['boom_user']) || ($_SESSION['boom_user']['rol'] ?? null) !== 'admin') { header('Location: ../User/login.php'); exit; }

include_once __DIR__ . '/docent.php';
$docentModel = new Docent();
$docenten = $docentModel->all();
?>
<h2>Overzicht Docenten</h2>
<p><a class="button" href="../User/users-insert.php?rol=docent">+ Docent toevoegen</a></p>
<table class="table">
<thead><tr><th>ID</th><th>Naam</th><th>Gebruikersnaam</th><th>Acties</th></tr></thead>
  <tbody>
    <?php foreach ($docenten as $d): ?>
      <tr>
        <td><?= htmlspecialchars($d['id']) ?></td>
        <td><?= htmlspecialchars($d['naam']) ?></td>
        <td><?= htmlspecialchars($d['username']) ?></td>
        <td>
          <a href="docent-edit.php?id=<?= urlencode($d['id']) ?>">Wijzigen</a> |
          <a href="docent-delete.php?id=<?= urlencode($d['id']) ?>" onclick="return confirm('Verwijderen?');">Verwijderen</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php include_once __DIR__ . '/../footer.php'; ?>
