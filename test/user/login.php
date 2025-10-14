<?php
session_start();
require_once __DIR__ . '/../db_connectie.php';
$db = new DB('rooster_de_boom');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $db->execute('SELECT id, username, password_hash FROM users WHERE username = ?', [$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user'] = $user['username'];
        $_SESSION['user_id'] = $user['id'];
        header('Location: /admin/index.php');
        exit;
    } else {
        $error = 'Onjuiste gebruikersnaam of wachtwoord.';
    }
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<h2>Inloggen</h2>
<?php if(!empty($error)) echo '<p style="color:red;">'.htmlspecialchars($error).'</p>'; ?>
<form method="post">
  <label>Gebruikersnaam <input name="username" required></label><br>
  <label>Wachtwoord <input type="password" name="password" required></label><br>
  <button type="submit">Log in</button>
</form>
<?php include __DIR__ . '/../includes/footer.php'; ?>