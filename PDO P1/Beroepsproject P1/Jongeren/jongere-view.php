<?php
// jongeren/jongere-view.php
include '../db.php';
include '../header.php';

$stmt = $myDb->execute("SELECT j.id, j.naam, j.status, j.geboortedatum, i.naam AS instituut_naam
    FROM jongeren j
    LEFT JOIN jongeren_instituten ji ON ji.jongere_id = j.id
    LEFT JOIN instituten i ON i.id = ji.instituut_id
    ORDER BY j.id DESC");
$jongeren = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Overzicht jongeren</h2>
<a href="jongere-insert.php" class="btn btn-add">+ Jongere toevoegen</a>
<table>
<tr><th>ID</th><th>Naam</th><th>Geboortedatum</th><th>Status</th><th>Instituut</th><th>Acties</th></tr>
<?php foreach ($jongeren as $j): ?>
<tr>
    <td><?= $j['id'] ?></td>
    <td><?= htmlspecialchars($j['naam']) ?></td>
    <td><?= $j['geboortedatum'] ?></td>
    <td><?= $j['status'] ?></td>
    <td><?= $j['instituut_naam'] ?? 'Leeg' ?></td>
    <td>
        <a href="jongere-edit.php?id=<?= $j['id'] ?>">Wijzigen</a> |
        <a href="jongere-delete.php?id=<?= $j['id'] ?>" onclick="return confirm('Verwijderen?')">Verwijderen</a> |
        <a href="jongere-activiteiten.php?id=<?= $j['id'] ?>">Activiteiten</a> |
        <a href="jongere-instituut.php?id=<?= $j['id'] ?>">Instituut</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<?php include '../footer.php'; ?>
