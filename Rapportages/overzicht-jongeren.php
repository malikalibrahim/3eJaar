<?php
// rapportages/overzicht-jongeren.php
include '../db.php';
include '../header.php';

$stmt = $myDb->execute("SELECT j.*, i.naam AS instituut_naam FROM jongeren j
    LEFT JOIN jongeren_instituten ji ON ji.jongere_id = j.id
    LEFT JOIN instituten i ON i.id = ji.instituut_id
    ORDER BY j.naam ASC");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Rapportage: Overzicht jongeren</h2>
<table>
<tr><th>Naam</th><th>Geboortedatum</th><th>Status</th><th>Instituut</th></tr>
<?php foreach ($rows as $r): ?>
<tr>
    <td><?= htmlspecialchars($r['naam']) ?></td>
    <td><?= $r['geboortedatum'] ?></td>
    <td><?= $r['status'] ?></td>
    <td><?= $r['instituut_naam'] ?? '-' ?></td>
</tr>
<?php endforeach; ?>
</table>

<?php include '../footer.php'; ?>
