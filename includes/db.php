<?php

$mysqli = new mysqli('localhost', 'root', '', 'biblioteca');

if ($mysqli->connect_errno) {
    echo 'Connessione al database fallita: ' . $mysqli->connect_error;
    exit();
}
