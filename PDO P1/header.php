<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Roosterwebsite - Basisschool De Boom</title>
    <link rel="stylesheet" href="Assets/css/style.css">
</head>
<body>
<header>
    <h1>Basisschool De Boom</h1>
    <nav>
        <a href="/index.php">Home</a> |
        <a href="/Klassen/klas.php">Klassen</a> |
        <a href="/Docenten/docent.php">Docenten</a> |
        <a href="/Roosters/rooster-overzicht.php">Roosters</a> |
        <?php if(isset($_SESSION['user'])): ?>
            <span>Welkom, <?= htmlspecialchars($_SESSION['user']) ?></span> |
            <a href="/User/user-logout.php">Uitloggen</a>
        <?php else: ?>
            <a href="/Rapportages/inloggen.php">Inloggen</a>
        <?php endif; ?>
    </nav>
</header>
<main>
