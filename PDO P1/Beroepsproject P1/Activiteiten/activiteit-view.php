<?php
// activiteiten/activiteit-view.php
include '../db.php';
include '../header.php';

$stmt = $myDb->execute("SELECT * FROM activiteiten ORDER BY id DESC");
$activiteiten = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Overzicht activiteiten</h2>
<a href="activiteit-insert.php" class="btn btn-add">+ Activiteit toevoegen</a>
<table>
<tr><th>ID</th><th>Naam</th><th>Start</th><th>Eind</th><th>Deelnemers</th><th>Acties</th></tr>
<?php foreach ($activiteiten as $a): ?>
<tr>
    <td><?= $a['id'] ?></td>
    <td><?= htmlspecialchars($a['naam']) ?></td>
    <td><?= $a['startdatum'] ?></td>
    <td><?= $a['einddatum'] ?></td>
    <td>
        <?php 
        $cnt = $myDb->execute("SELECT COUNT(*) AS c FROM jongeren_activiteiten WHERE activiteit_id = ?", [$a['id']])->fetch(PDO::FETCH_ASSOC);
        echo $cnt['c'] ?? 0;
        ?>
    </td>
    <td>
        <a href="activiteit-edit.php?id=<?= $a['id'] ?>">Wijzigen</a> |
        <a href="activiteit-delete.php?id=<?= $a['id'] ?>" onclick="return confirm('Verwijderen?')">Verwijderen</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<?php include '../footer.php'; ?>
