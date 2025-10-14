<?php
include '../db.php';
include '../header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naam = $_POST['naam'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $rol = $_POST['rol'];

    $myDb->execute("INSERT INTO medewerkers (naam, username, password, rol) VALUES (?, ?, ?, ?)", 
        [$naam, $username, $password, $rol]);

    header("Location: user-view.php");
    exit;
}
?>

<h2>Medewerker toevoegen</h2>
<form method="post">
    <label>Naam:</label><br>
    <input type="text" name="naam" required><br><br>

    <label>Gebruikersnaam:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Wachtwoord:</label><br>
    <input type="password" name="password" required><br><br>

    <label>Rol:</label><br>
    <select name="rol">
        <option value="admin">Admin</option>
        <option value="medewerker">Medewerker</option>
    </select><br><br>

    <input type="submit" value="Opslaan">
</form>

<?php include '../footer.php'; ?>
