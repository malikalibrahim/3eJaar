<?php
// rapportages/overzicht-instituten.php
include '../db.php';
include '../header.php';

$stmt = $myDb->execute("SELECT i.*, (SELECT COUNT(*) FROM jongeren_instituten ji WHERE ji.instituut_id = i.id) AS geplaatst FROM instituten i ORDER BY i.naam ASC");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Rapportage: Overzicht instituten</h2>
<table>
<tr><th>Naam</th><th>Adres</th><th>Contactpersoon</th><th>Geplaatst</th></tr>
<?php foreach ($rows as $r): ?>
<tr>
    <td><?= htmlspecialchars($r['naam']) ?></td>
    <td><?= htmlspecialchars($r['adres']) ?></td>
    <td><?= htmlspecialchars($r['contactpersoon']) ?></td>
    <td><?= $r['geplaatst'] ?></td>
</tr>
<?php endforeach; ?>
</table>

<?php include '../footer.php'; ?>
