<?php
$melding = "";

$mnr = "";
if (isset($_GET["mnr"])) {
    $mnr = $_GET["mnr"];
}

$naam = "";
if (isset($_GET["naam"])) {
    $naam = $_GET["naam"];
}

$achternaam = "";
if (isset($_GET["achternaam"])) {
    $achternaam = $_GET["achternaam"];
}

$functie = "";
if (isset($_GET["functie"])) {
    $functie = $_GET["functie"];
}

$rechten = "";
if (isset($_GET["rechten"])) {
    $rechten = $_GET["rechten"];
}
$medewerker = array();

try {
    if (isset($_GET["toevoegen"])) {
        if ($mnr != "") {
            $stmt = $pdo->prepare("INSERT INTO medewerker (mnr, naam, achternaam,functie,rechten) VALUES(?,?,?,?,?)");
            $stmt->execute(array($_GET["mnr"], $_GET["naam"], $_GET["achternaam"], $_GET["functie"], $_GET["rechten"]));
            if ($stmt->rowCount() == 1) {
                // als de medewerker is toegevoegd worden de ingevoerde waarden niet opnieuw getoond
                $mnr = "";
                $naam = "";
                $achternaam = "";
                $functie = "";
                $rechten = "";
                $melding = "De medewerker is toegevoegd";
            } else {
                $melding = "Het toevoegen is mislukt";
            }
        } else {
            $melding = "Nummer is een verplicht veld";
        }
    }
    $stmt = $pdo->prepare("SELECT * FROM medewerker");
    $stmt->execute();
    $medewerkers = $stmt->fetchAll();
} catch (PDOException $e) {
    $melding = "Er is iets misgegaan";
}
$pdo = NULL;
?>