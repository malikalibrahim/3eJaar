<?php
// instituten/instituut-insert.php
include '../db.php';
include '../header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naam = $_POST['naam'] ?? '';
    $adres = $_POST['adres'] ?? '';
    $contactpersoon = $_POST['contactpersoon'] ?? '';
    $telefoon = $_POST['telefoon'] ?? '';
    $email = $_POST['email'] ?? '';

    $myDb->execute("INSERT INTO instituten (naam, adres, contactpersoon, telefoon, email) VALUES (?, ?, ?, ?, ?)",
        [$naam, $adres, $contactpersoon, $telefoon, $email]);

    header("Location: instituut-view.php");
    exit;
}
?>

<h2>Instituut toevoegen</h2>
<form method="post">
    <label>Naam:</label><br><input type="text" name="naam" required><br><br>
    <label>Adres:</label><input type="text" name="adres">
    <label>Contactpersoon:</label><input type="text" name="contactpersoon">
    <label>Telefoon:</label><input type="text" name="telefoon">
    <label>Email:</label><input type="email" name="email">
    <input type="submit" value="Opslaan">
</form>

<?php include '../footer.php'; ?>
