<?php
// rapportages/overzicht-uitplaatsingen.php
include '../db.php';
include '../header.php';

$stmt = $myDb->execute("SELECT j.naam AS jongere, i.naam AS instituut, ji.plaatsingsdatum
    FROM jongeren_instituten ji
    JOIN jongeren j ON j.id = ji.jongere_id
    JOIN instituten i ON i.id = ji.instituut_id
    ORDER BY ji.plaatsingsdatum DESC");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Rapportage: Geplaatste jongeren</h2>
<table>
<tr><th>Jongere</th><th>Instituut</th><th>Plaatsingsdatum</th></tr>
<?php foreach ($rows as $r): ?>
<tr>
    <td><?= htmlspecialchars($r['jongere']) ?></td>
    <td><?= htmlspecialchars($r['instituut']) ?></td>
    <td><?= $r['plaatsingsdatum'] ?></td>
</tr>
<?php endforeach; ?>
</table>

<?php include '../footer.php'; ?>
