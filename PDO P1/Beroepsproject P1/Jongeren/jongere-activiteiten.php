<?php
// jongeren/jongere-activiteiten.php
include '../db.php';
include '../header.php';

$jongere_id = $_GET['id'] ?? null;
if (!$jongere_id) { header("Location: jongere-view.php"); exit; }

// huidige activiteiten
$actStmt = $myDb->execute("SELECT a.* FROM activiteiten a
    JOIN jongeren_activiteiten ja ON ja.activiteit_id = a.id
    WHERE ja.jongere_id = ?", [$jongere_id]);
$current = $actStmt->fetchAll(PDO::FETCH_ASSOC);

// alle activiteiten (voor toevoegen)
$allStmt = $myDb->execute("SELECT * FROM activiteiten ORDER BY naam ASC");
$all = $allStmt->fetchAll(PDO::FETCH_ASSOC);

// toevoegen
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['activiteit_id'])) {
    $activiteit_id = $_POST['activiteit_id'];
    $myDb->execute("INSERT INTO jongeren_activiteiten (jongere_id, activiteit_id) VALUES (?, ?)", [$jongere_id, $activiteit_id]);
    header("Location: jongere-activiteiten.php?id=".$jongere_id);
    exit;
}

// verwijderen via GET remove
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    $myDb->execute("DELETE FROM jongeren_activiteiten WHERE jongere_id = ? AND activiteit_id = ?", [$jongere_id, $remove_id]);
    header("Location: jongere-activiteiten.php?id=".$jongere_id);
    exit;
}
?>

<h2>Activiteiten koppelen voor jongere #<?= $jongere_id ?></h2>

<h3>Huidige activiteiten</h3>
<ul>
<?php foreach ($current as $c): ?>
    <li><?= htmlspecialchars($c['naam']) ?> - <a href="jongere-activiteiten.php?id=<?= $jongere_id ?>&remove=<?= $c['id'] ?>" onclick="return confirm('Verwijderen?')">Verwijderen</a></li>
<?php endforeach; ?>
</ul>

<h3>Activiteit toevoegen</h3>
<form method="post">
    <select name="activiteit_id">
        <option value="">-- Selecteer een activiteit --</option>
        <?php foreach ($all as $a): ?>
            <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['naam']) ?></option>
        <?php endforeach; ?>
    </select>
    <input type="submit" value="Koppel activiteit">
</form>
<p><a href="jongere-view.php">Terug naar overzicht jongeren</a></p>

<?php include '../footer.php'; ?>
