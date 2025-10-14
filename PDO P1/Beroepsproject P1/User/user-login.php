<?php
// user/user-login.php
include '../db.php';
include '../header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        $stmt = $myDb->execute("SELECT * FROM medewerkers WHERE username = ?", [$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $user['password'] === md5($password)) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['rol'] = $user['rol'];
            header("Location: ../jongeren/jongere-view.php");
            exit;
        } else {
            $error = "Ongeldige gebruikersnaam of wachtwoord.";
        }
    } catch (Exception $e) {
        $error = "Er is een fout opgetreden: " . $e->getMessage();
    }
}
?>

<h2>Inloggen medewerkers</h2>
<?php if (isset($error)): ?><p class="error"><?= $error ?></p><?php endif; ?>

<form method="post" action="user-login.php">
    <label>Gebruikersnaam:</label>
    <input type="text" name="username" required>

    <label>Wachtwoord:</label>
    <input type="password" name="password" required>

    <input type="submit" value="Inloggen">
</form>
<?php include '../footer.php'; ?>
