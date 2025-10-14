<?php
session_start();
if (!isset($_SESSION['user'])) { header('Location: /user/login.php'); exit; }
include __DIR__ . '/../includes/header.php';
?>
<h2>Dashboard</h2>
<p>Welkom, <?= htmlspecialchars($_SESSION['user']) ?>. Kies een onderdeel uit het menu.</p>
<?php include __DIR__ . '/../includes/footer.php'; ?>