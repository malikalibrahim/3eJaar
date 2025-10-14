<?php
// jongeren/jongere-instituut.php
include '../db.php';
include '../header.php';

$jongere_id = $_GET['id'] ?? null;
if (!$jongere_id) { header("Location: jongere-view.php"); exit; }

// instellingen
$instStmt = $myDb->execute("SELECT * FROM instituten ORDER BY naam ASC");
$instituten = $instStmt->fetchAll(PDO::FETCH_ASSOC);

// huidige plaatsing
$plaStmt = $myDb->execute("SELECT ji.*, i.naam FROM jongeren_instituten ji JOIN instituten i ON i.id = ji.instituut_id WHERE ji.jongere_id = ?", [$jongere_id]);
$plaatsing = $plaStmt->fetch(PDO::FETCH_ASSOC);

// plaatsen / wijzigen
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['instituut_id'])) {
    $instituut_id = $_POST['instituut_id'];
    $plaatsingsdatum = $_POST['plaatsingsdatum'] ?: null;

    // vervangen of invoegen
    $exists = $myDb->execute("SELECT id FROM jongeren_instituten WHERE jongere_id = ?", [$jongere_id])->rowCount();
    if ($exists) {
        $myDb->execute("UPDATE jongeren_instituten SET instituut_id=?, plaatsingsdatum=? WHERE jongere_id=?", [$instituut_id, $plaatsingsdatum, $jongere_id]);
    } else {
        $myDb->execute("INSERT INTO jongeren_instituten (jongere_id, instituut_id, plaatsingsdatum) VALUES (?, ?, ?)", [$jongere_id, $instituut_id, $plaatsingsdatum]);
    }
    $myDb->execute("UPDATE jongeren SET status = 'uitgeplaatst' WHERE id = ?", [$jongere_id]);
    header("Location: jongere-instituut.php?id=".$jongere_id);
    exit;
}

// verwijderen
if (isset($_GET['remove'])) {
    $myDb->execute("DELETE FROM jongeren_instituten WHERE jongere_id = ?", [$jongere_id]);
    $myDb->execute("UPDATE jongeren SET status = 'ingeschreven' WHERE id = ?", [$jongere_id]);
    header("Location: jongere-instituut.php?id=".$jongere_id);
    exit;
}
?>

<h2>Instituut koppelen voor jongere #<?= $jongere_id ?></h2>

<?php if ($plaatsing): ?>
    <p>Huidig instituut: <strong><?= htmlspecialchars($plaatsing['naam']) ?></strong> (geplaatst op <?= $plaatsing['plaatsingsdatum'] ?>) 
    - <a href="jongere-instituut.php?id=<?= $jongere_id ?>&remove=1" onclick="return confirm('Ontkoppelen?')">Ontkoppelen</a></p>
<?php else: ?>
    <p>Geen plaatsing aanwezig.</p>
<?php endif; ?>

<form method="post">
    <label>Instelling:</label>
    <select name="instituut_id">
        <option value="">-- Selecteer een instituut --</option>
        <?php foreach ($instituten as $i): ?>
            <option value="<?= $i['id'] ?>"><?= htmlspecialchars($i['naam']) ?></option>
        <?php endforeach; ?>
    </select>

    <label>Plaatsingsdatum:</label>
    <input type="date" name="plaatsingsdatum">

    <input type="submit" value="Plaatsen">
</form>
<p><a href="jongere-view.php">Terug naar overzicht jongeren</a></p>

<?php include '../footer.php'; ?>
