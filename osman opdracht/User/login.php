<?php
include_once __DIR__ . '/../db.php';
include_once __DIR__ . '/user.php';

$__session_started = (session_status() === PHP_SESSION_ACTIVE);
if (!$__session_started) {
    session_start();
}

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = $_POST['username'] ?? '';
    $p = $_POST['password'] ?? '';
    $userModel = new UserModel();
    $user = $userModel->findByUsername($u);
    if ($user && password_verify($p, $user['password'])) {
        $_SESSION['boom_user'] = [
            'id' => $user['id'],
            'naam' => $user['naam'],
            'username' => $user['username'],
            'rol' => $user['rol'],
            'klas_id' => $user['klas_id']
        ];
        if ($user['rol'] === 'admin') {
            header('Location: ../index.php');
        } elseif ($user['rol'] === 'docent') {
            header('Location: ../Rooster/rooster-view.php');
        } else {
            header('Location: ../mijn-rooster.php');
        }
        exit;
    } else {
        $error = 'Onjuiste inloggegevens';
    }
}

include_once __DIR__ . '/../header.php';
?>

<h2>Inloggen</h2>
<?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post" class="stack">
  <label>Gebruikersnaam</label>
  <input type="text" name="username" required>
  <label>Wachtwoord</label>
  <input type="password" name="password" required>
  <input type="submit" value="Inloggen">
  <p><a class="btn button--ghost" href="<?= BOOM_BASE_URL ?>/public-rooster.php">Rooster zonder inloggen</a></p>
</form>

<?php include_once __DIR__ . '/../footer.php'; ?>
