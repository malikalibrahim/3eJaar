<?php
// activiteiten/activiteit-edit.php
include '../db.php';
include '../header.php';

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: activiteit-view.php"); exit; }

$stmt = $myDb->execute("SELECT * FROM activiteiten WHERE id = ?", [$id]);
$act = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naam = $_POST['naam'] ?? '';
    $omschrijving = $_POST['omschrijving'] ?? '';
    $startdatum = $_POST['startdatum'] ?: null;
    $einddatum = $_POST['einddatum'] ?: null;

    $myDb->execute("UPDATE activiteiten SET naam=?, omschrijving=?, startdatum=?, einddatum=? WHERE id=?",
        [$naam, $omschrijving, $startdatum, $einddatum, $id]);

    header("Location: activiteit-view.php");
    exit;
}
?>

<h2>Activiteit wijzigen</h2>
<form method="post">
    <label>Naam:</label><br><input type="text" name="naam" value="<?= htmlspecialchars($act['naam']) ?>" required><br><br>
    <label>Omschrijving:</label><textarea name="omschrijving"><?= htmlspecialchars($act['omschrijving']) ?></textarea>
    <label>Startdatum:</label><input type="date" name="startdatum" value="<?= $act['startdatum'] ?>">
    <label>Einddatum:</label><input type="date" name="einddatum" value="<?= $act['einddatum'] ?>">
    <input type="submit" value="Opslaan">
</form>

<?php include '../footer.php'; ?>
