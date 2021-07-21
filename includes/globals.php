<?php
include_once __DIR__ . '/header.php';
include_once __DIR__ . '/util.php';
include_once __DIR__.'/FormHandle.php';
include_once __DIR__.'/Books.php';

 
 if (!isset($_SESSION['username'])) {
    header('Location: https://localhost/biblioteca/login.php');
} 
