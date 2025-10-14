<?php
// instituten/instituut-view.php
include '../db.php';
include '../header.php';

$stmt = $myDb->execute("SELECT * FROM instituten ORDER BY id DESC");
$instituten = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Overzicht instituten</h2>
<a href="instituut-insert.php" class="btn btn-add">+ Instituut toevoegen</a>
<table>
<tr><th>ID</th><th>Naam</th><th>Contactpersoon</th><th>Telefoon</th><th>Acties</th></tr>
<?php foreach ($instituten as $i): ?>
<tr>
    <td><?= $i['id'] ?></td>
    <td><?= htmlspecialchars($i['naam']) ?></td>
    <td><?= htmlspecialchars($i['contactpersoon']) ?></td>
    <td><?= htmlspecialchars($i['telefoon']) ?></td>
    <td>
        <a href="instituut-edit.php?id=<?= $i['id'] ?>">Wijzigen</a> |
        <a href="instituut-delete.php?id=<?= $i['id'] ?>" onclick="return confirm('Verwijderen?')">Verwijderen</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<?php include '../footer.php'; ?>
