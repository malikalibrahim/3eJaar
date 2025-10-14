<?php
// activiteiten/activiteit-insert.php
include '../db.php';
include '../header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naam = $_POST['naam'] ?? '';
    $omschrijving = $_POST['omschrijving'] ?? '';
    $startdatum = $_POST['startdatum'] ?: null;
    $einddatum = $_POST['einddatum'] ?: null;

    $myDb->execute("INSERT INTO activiteiten (naam, omschrijving, startdatum, einddatum) VALUES (?, ?, ?, ?)",
        [$naam, $omschrijving, $startdatum, $einddatum]);

    header("Location: activiteit-view.php");
    exit;
}
?>

<h2>Activiteit toevoegen</h2>
<form method="post">
    <label>Naam:</label><br><input type="text" name="naam" required><br><br>
    <label>Omschrijving:</label><textarea name="omschrijving"></textarea>
    <label>Startdatum:</label><input type="date" name="startdatum">
    <label>Einddatum:</label><input type="date" name="einddatum">
    <input type="submit" value="Opslaan">
</form>

<?php include '../footer.php'; ?>
