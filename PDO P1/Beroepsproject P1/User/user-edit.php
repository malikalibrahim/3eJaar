<?php
include '../db.php';
include '../header.php';

$id = $_GET['id'];
$stmt = $myDb->execute("SELECT * FROM medewerkers WHERE id = ?", [$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naam = $_POST['naam'];
    $username = $_POST['username'];
    $rol = $_POST['rol'];

    if (!empty($_POST['password'])) {
        $password = md5($_POST['password']);
        $myDb->execute("UPDATE medewerkers SET naam=?, username=?, password=?, rol=? WHERE id=?", 
            [$naam, $username, $password, $rol, $id]);
    } else {
        $myDb->execute("UPDATE medewerkers SET naam=?, username=?, rol=? WHERE id=?", 
            [$naam, $username, $rol, $id]);
    }

    header("Location: user-view.php");
    exit;
}
?>

<h2>Medewerker wijzigen</h2>
<form method="post">
    <label>Naam:</label><br>
    <input type="text" name="naam" value="<?= htmlspecialchars($user['naam']) ?>" required><br><br>

    <label>Gebruikersnaam:</label><br>
    <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required><br><br>

    <label>Wachtwoord (leeg laten = niet wijzigen):</label><br>
    <input type="password" name="password"><br><br>

    <label>Rol:</label>
    <select name="rol">
        <option value="admin" <?= $user['rol']=="admin"?"selected":"" ?>>Admin</option>
        <option value="medewerker" <?= $user['rol']=="medewerker"?"selected":"" ?>>Medewerker</option>
    </select>

    <input type="submit" value="Opslaan">
</form>

<?php include '../footer.php'; ?>
