<?php

//De connectie met de database via PDO
$db = "mysql:host=localhost;dbname=lasergamebox;port=3307";
$user = "laser";
$pass = "Lgf33695";
$pdo = new PDO($db, $user, $pass);

//Session starten automatisch op elke webpagina
session_start();

//toegang controleren
$access = new toegang();

//cms systeem laden
$pagina = new cms();
