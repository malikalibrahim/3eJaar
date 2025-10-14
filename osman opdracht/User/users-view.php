<?php
include_once __DIR__ . '/../db.php';
include_once __DIR__ . '/../header.php';
if (!isset($_SESSION['boom_user']) || (($_SESSION['boom_user']['rol'] ?? null) !== 'admin')) { header('Location: login.php'); exit; }

$rows = $myDb->execute("SELECT u.*, k.naam AS klas_naam FROM users u LEFT JOIN klassen k ON k.id = u.klas_id ORDER BY u.rol ASC, u.naam ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>Gebruikers</h2>
<p><a class="button" href="users-insert.php">+ Gebruiker toevoegen</a></p>
<table class="table">
  <thead><tr><th>ID</th><th>Naam</th><th>Gebruikersnaam</th><th>Rol</th><th>Klas</th><th>Acties</th></tr></thead>
  <tbody>
  <?php foreach ($rows as $u): ?>
    <tr>
      <td><?= htmlspecialchars($u['id']) ?></td>
      <td><?= htmlspecialchars($u['naam']) ?></td>
      <td><?= htmlspecialchars($u['username']) ?></td>
      <td><?= htmlspecialchars($u['rol']) ?></td>
      <td><?= htmlspecialchars($u['klas_naam'] ?? '-') ?></td>
      <td>
        <a href="users-edit.php?id=<?= urlencode($u['id']) ?>">Wijzigen</a> |
        <a href="users-delete.php?id=<?= urlencode($u['id']) ?>" onclick="return confirm('Verwijderen?');">Verwijderen</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<?php include_once __DIR__ . '/../footer.php'; ?>


