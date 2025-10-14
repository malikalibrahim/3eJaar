<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
unset($_SESSION['boom_user']);
unset($_SESSION['boom_admin']);
unset($_SESSION['boom_student']);
header('Location: ../public-rooster.php');
exit;

