<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$loggedIn = isset($_SESSION['boom_user']) && ($_SESSION['boom_user']['rol'] ?? null) === 'admin';
$studentIn = isset($_SESSION['boom_user']) && ($_SESSION['boom_user']['rol'] ?? null) === 'leerling';
$docentIn = isset($_SESSION['boom_user']) && ($_SESSION['boom_user']['rol'] ?? null) === 'docent';


define('PROJECT_BASE', '/SCHOOL 2025/osman opdracht');
define('BOOM_BASE_URL', PROJECT_BASE);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basisschool De Boom</title>
    <link rel="stylesheet" href="<?= BOOM_BASE_URL ?>/Assets/css/style.css">
</head>
<body>
<header>
  <div class="container">
    <div class="logo"><h1>Basisschool De Boom</h1></div>
    <nav>
      <ul>
        <li><a href="<?= BOOM_BASE_URL ?>/public-rooster.php">Rooster bekijken</a></li>
        <?php if ($loggedIn): ?>
          <li><a href="<?= BOOM_BASE_URL ?>/index.php">Dashboard</a></li>
          <li><a href="<?= BOOM_BASE_URL ?>/Klas/klas-view.php">Klassen</a></li>
          <li><a href="<?= BOOM_BASE_URL ?>/Docent/docent-view.php">Docenten</a></li>
          <li><a href="<?= BOOM_BASE_URL ?>/User/users-view.php">Gebruikers</a></li>
          <li><a href="<?= BOOM_BASE_URL ?>/Vakken/vakken.php">Vakken</a></li>
          <li><a href="<?= BOOM_BASE_URL ?>/Rooster/rooster-view.php">Roosters</a></li>
         
          <li><a href="<?= BOOM_BASE_URL ?>/User/logout.php">Uitloggen (<?= htmlspecialchars($_SESSION['boom_user']['naam']) ?>)</a></li>
        <?php elseif ($docentIn): ?>
          <li><a href="<?= BOOM_BASE_URL ?>/Rooster/rooster-view.php">Roosters</a></li>
          <li><a href="<?= BOOM_BASE_URL ?>/User/logout.php">Uitloggen (<?= htmlspecialchars($_SESSION['boom_user']['naam']) ?>)</a></li>
        <?php elseif ($studentIn): ?>
          <li><a href="<?= BOOM_BASE_URL ?>/mijn-rooster.php">Mijn Rooster</a></li>
          <li><a href="<?= BOOM_BASE_URL ?>/User/logout.php">Uitloggen (<?= htmlspecialchars($_SESSION['boom_user']['naam']) ?>)</a></li>
        <?php else: ?>
          <li><a href="<?= BOOM_BASE_URL ?>/User/login.php">Inloggen</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>
</header>
<main class="container">
