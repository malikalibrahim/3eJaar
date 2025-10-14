<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['username']);
$isAdmin = isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';

// Definieer de basis URL van je project. Pas dit aan indien nodig.
define('BASE_URL', '/SCHOOL 2025/Beroepsproject P1');
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jongeren Kansrijker</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/Assets/css/stylee.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <a href="<?= BASE_URL ?>/index.php">
                    <!-- <img src="<?= BASE_URL ?>/Assets/images/logo.png" alt="Logo Jongeren Kansrijker"> -->
                    <h1>Jongeren Kansrijker</h1>
                </a>
            </div>
            <nav>
                <?php if ($isLoggedIn): ?>
                <ul>
                    <li><a href="<?= BASE_URL ?>/Jongeren/jongere-view.php">Jongeren</a></li>
                    <li><a href="<?= BASE_URL ?>/Activiteiten/activiteit-view.php">Activiteiten</a></li>
                    <li><a href="<?= BASE_URL ?>/Instituten/instituut-view.php">Instituten</a></li>
                    <li class="dropdown">
                        <a href="#">Rapportages</a>
                        <ul class="dropdown-menu">
                            <li><a href="<?= BASE_URL ?>/Rapportages/overzicht-jongeren.php">Overzicht Jongeren</a></li>
                            <li><a href="<?= BASE_URL ?>/Rapportages/overzicht-activiteiten.php">Overzicht Activiteiten</a></li>
                            <li><a href="<?= BASE_URL ?>/Rapportages/overzicht-instituten.php">Overzicht Instituten</a></li>
                            <li><a href="<?= BASE_URL ?>/Rapportages/overzicht-uitplaatsingen.php">Overzicht Uitplaatsingen</a></li>
                        </ul>
                    </li>
                    <?php if ($isAdmin): ?>
                    <li><a href="<?= BASE_URL ?>/User/user-view.php">Medewerkers</a></li>
                    <?php endif; ?>
                    <li><a href="<?= BASE_URL ?>/User/user-logout.php">Uitloggen (<?= htmlspecialchars($_SESSION['username']) ?>)</a></li>
                </ul>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <main class="container">