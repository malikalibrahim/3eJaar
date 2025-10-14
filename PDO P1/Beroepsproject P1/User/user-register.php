<?php
// user/user-register.php
include '../db.php';
include '../header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naam = $_POST['naam'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $rol = $_POST['rol'] ?? 'medewerker';

    // eenvoudige check: username uniek
    $stmt = $myDb->execute("SELECT id FROM medewerkers WHERE username = ?", [$username]);
    if ($stmt->rowCount() > 0) {
        $error = "Gebruikersnaam bestaat al.";
    } else {
        $myDb->execute("INSERT INTO medewerkers (naam, username, password, rol) VALUES (?, ?, ?, ?)",
            [$naam, $username, md5($password), $rol]);
        header("Location: user-view.php");
        exit;
    }
}
?>

<h2>Medewerker registreren</h2>
<?php if (isset($error)): ?><p class="error"><?= $error ?></p><?php endif; ?>

<form method="post">
    <label>Naam:</label>
    <input type="text" name="naam" required>

    <label>Gebruikersnaam:</label>
    <input type="text" name="username" required>

    <label>Wachtwoord:</label>
    <input type="password" name="password" required>

    <label>Rol:</label>
    <select name="rol">
        <option value="admin">Admin</option>
        <option value="medewerker" selected>Medewerker</option>
    </select>

    <input type="submit" value="Registreren">
</form>

<?php include '../footer.php'; ?>
