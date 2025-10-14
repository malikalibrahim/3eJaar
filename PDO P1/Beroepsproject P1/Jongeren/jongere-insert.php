<?php
// jongeren/jongere-insert.php
include '../db.php';
include '../header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naam = $_POST['naam'] ?? '';
    $geboortedatum = $_POST['geboortedatum'] ?? null;
    $adres = $_POST['adres'] ?? '';
    $telefoon = $_POST['telefoon'] ?? '';
    $email = $_POST['email'] ?? '';
    $status = $_POST['status'] ?? 'ingeschreven';

    $myDb->execute("INSERT INTO jongeren (naam, geboortedatum, adres, telefoon, email, status) VALUES (?, ?, ?, ?, ?, ?)",
        [$naam, $geboortedatum, $adres, $telefoon, $email, $status]);

    header("Location: jongere-view.php");
    exit;
}
?>

<h2>Jongere toevoegen</h2>
<form method="post">
    <label>Naam:</label><br><input type="text" name="naam" required><br><br>
    <label>Geboortedatum:</label><input type="date" name="geboortedatum">
    <label>Adres:</label><input type="text" name="adres">
    <label>Telefoon:</label><input type="text" name="telefoon">
    <label>Email:</label><input type="email" name="email">
    <label>Status:</label>
    <select name="status">
        <option value="ingeschreven">Ingeschreven</option>
        <option value="uitgeplaatst">Uitgeplaatst</option>
    </select>
    <input type="submit" value="Opslaan">
</form>

<?php include '../footer.php'; ?>
