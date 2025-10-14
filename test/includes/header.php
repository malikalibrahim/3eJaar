<?php
if (session_status() == PHP_SESSION_NONE) session_start();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rooster De Boom</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<header>
    <h1>Basisschool De Boom - Beheer</h1>
    <?php if(isset($_SESSION['user'])): ?>
        <p>Ingelogd als <?= htmlspecialchars($_SESSION['user']) ?> | <a href="/user/logout.php">Uitloggen</a></p>
    <?php endif; ?>
    <nav>
        <a href="/admin/index.php">Dashboard</a> |
        <a href="/admin/classes.php">Klassen</a> |
        <a href="/admin/teachers.php">Docenten</a> |
        <a href="/admin/schedules.php">Roosters</a>
    </nav>
</header>
<main>
