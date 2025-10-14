<?php
// user/user-view.php
include '../db.php';
include '../header.php';

$stmt = $myDb->execute("SELECT * FROM medewerkers ORDER BY id DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Overzicht medewerkers</h2>
<a href="user-register.php" class="btn btn-add">+ Medewerker toevoegen</a>
<table>
    <tr><th>ID</th><th>Naam</th><th>Gebruikersnaam</th><th>Rol</th><th>Acties</th></tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= $user['id'] ?></td>
        <td><?= htmlspecialchars($user['naam']) ?></td>
        <td><?= htmlspecialchars($user['username']) ?></td>
        <td><?= $user['rol'] ?></td>
        <td>
            <a href="user-edit.php?id=<?= $user['id'] ?>">Wijzigen</a> |
            <a href="user-delete.php?id=<?= $user['id'] ?>" onclick="return confirm('Weet je het zeker?')">Verwijderen</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include '../footer.php'; ?>
