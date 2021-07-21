<?php
session_start();
include_once __DIR__ . '/util.php';
include_once __DIR__ . '/User.php';

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header('Location: https://localhost/biblioteca/login.php');
    exit;
}

$loggedInUser = \DataHandle\User::loginUser($_POST);

$_SESSION['username'] = $loggedInUser['username'];
$_SESSION['userId'] = $loggedInUser['id'];
header('Location: https://localhost/biblioteca');
exit; 
