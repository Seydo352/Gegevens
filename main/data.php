<?php

// Database configuratie
$db_host = 'localhost'; // Database hostnaam
$db_user = 'root'; // Database gebruikersnaam
$db_pass = 'root'; // Database wachtwoord
$db_name = 'website'; // Database naam

// Maak verbinding met de database
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Controleer de verbinding
if ($mysqli->connect_error) {
    die("Verbinding mislukt: " . $mysqli->connect_error);
}

?>
