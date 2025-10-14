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
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <a href="<?= BASE_URL ?>/index.php">
                    <!-- <img src="<?= BASE_URL ?>/assets/images/logo.png" alt="Logo Jongeren Kansrijker"> -->
                    <h1>Jongeren Kansrijker</h1>
                </a>
            </div>
            <nav>
                <ul>
                    <?php if ($isLoggedIn): ?>
                        <li><a href="<?= BASE_URL ?>/jongeren/jongere-view.php">Jongeren</a></li>
                        <li><a href="<?= BASE_URL ?>/activiteiten/activiteit-view.php">Activiteiten</a></li>
                        <li><a href="<?= BASE_URL ?>/instituten/instituut-view.php">Instituten</a></li>
                        <li class="dropdown">
                            <a href="#">Rapportages</a>
                            <ul class="dropdown-content">
                                <li><a href="<?= BASE_URL ?>/rapportages/overzicht-jongeren.php">Overzicht Jongeren</a></li>
                                <li><a href="<?= BASE_URL ?>/rapportages/overzicht-activiteiten.php">Overzicht Activiteiten</a></li>
                                <li><a href="<?= BASE_URL ?>/rapportages/overzicht-instituten.php">Overzicht Instituten</a></li>
                                <li><a href="<?= BASE_URL ?>/rapportages/overzicht-uitplaatsingen.php">Overzicht Uitplaatsingen</a></li>
                            </ul>
                        </li>
                        <?php if ($isAdmin): ?>
                            <li><a href="<?= BASE_URL ?>/user/user-view.php">Medewerkers</a></li>
                        <?php endif; ?>
                        <li><a href="<?= BASE_URL ?>/user/user-logout.php">Uitloggen (<?= htmlspecialchars($_SESSION['username']) ?>)</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container">