<?php
// rapportages/overzicht-activiteiten.php
include '../db.php';
include '../header.php';

$stmt = $myDb->execute("SELECT a.*, (SELECT COUNT(*) FROM jongeren_activiteiten ja WHERE ja.activiteit_id = a.id) AS deelnemers FROM activiteiten a ORDER BY a.naam ASC");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Rapportage: Overzicht activiteiten</h2>
<table>
<tr><th>Naam</th><th>Omschrijving</th><th>Start</th><th>Eind</th><th>Aantal deelnemers</th></tr>
<?php foreach ($rows as $r): ?>
<tr>
    <td><?= htmlspecialchars($r['naam']) ?></td>
    <td><?= htmlspecialchars($r['omschrijving']) ?></td>
    <td><?= $r['startdatum'] ?></td>
    <td><?= $r['einddatum'] ?></td>
    <td><?= $r['deelnemers'] ?></td>
</tr>
<?php endforeach; ?>
</table>

<?php include '../footer.php'; ?>
