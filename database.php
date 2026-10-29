<?php

require_once 'connection.php';


 $prijavljivanje = "CREATE TABLE IF NOT EXISTS prijavljivanje (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    naziv VARCHAR(50) NOT NULL
) ENGINE=INNODB;";

 $conn->query($prijavljivanje);

 $automobili = "CREATE TABLE IF NOT EXISTS automobili (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    marka VARCHAR(50) NOT NULL,
    model VARCHAR(50) NOT NULL,
    godina YEAR NOT NULL,
    cena DECIMAL(10,2) NOT NULL
) ENGINE=INNODB;";

 $conn->query($automobili);

 $korisnici = "CREATE TABLE IF NOT EXISTS korisnici (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ime VARCHAR(50) NOT NULL,
    prezime VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    lozinka VARCHAR(255) NOT NULL,
    prijava_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (prijava_id) REFERENCES prijavljivanje(id)
) ENGINE=INNODB;";

 $conn->query($korisnici);

 $rezervacije = "CREATE TABLE IF NOT EXISTS rezervacije (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    automobil_id INT UNSIGNED,
    korisnik_id INT UNSIGNED,
    datumPocetka DATE NOT NULL,
    datumKraja DATE NOT NULL,
    ukupnaCena DECIMAL(10,2) NOT NULL,
    status ENUM('rezervisano', 'odbijeno', 'potvrdjeno') NOT NULL,
    FOREIGN KEY (automobil_id) REFERENCES automobili(id) ON DELETE CASCADE,
    FOREIGN KEY (korisnik_id) REFERENCES korisnici(id) ON DELETE CASCADE
) ENGINE=INNODB;";

 $conn->query($rezervacije);

 $poruke = "CREATE TABLE IF NOT EXISTS poruke (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ime VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    poruka TEXT NOT NULL,
    odgovoren BOOLEAN DEFAULT 0
) ENGINE=INNODB;";

 $conn->query($poruke);




 $insertPrijavljivanje = "INSERT IGNORE INTO prijavljivanje (naziv) VALUES ('admin'), ('manager'), ('korisnik')";
 $conn->query($insertPrijavljivanje);


 $cars = [
    ["BMW", "X6", 2024, 150.00],
    ["Porsche", "911 Carrera", 2023, 250.00],
    ["Ferrari", "Roma", 2023, 400.00],
    ["Ford", "Mustang GT", 2022, 180.00],
    ["Mercedes", "C-Class", 2021, 70.00],
    ["Audi", "A7", 2022, 110.00],
    ["Volkswagen", "Golf", 2021, 45.00],
    ["Tesla", "Model 3", 2023, 90.00]
];

 $stmt = $conn->prepare("INSERT IGNORE INTO automobili (marka, model, godina, cena) VALUES (?, ?, ?, ?)");
if ($stmt) {
    foreach ($cars as $car) {
        $stmt->bind_param("ssid", $car[0], $car[1], $car[2], $car[3]);
        $stmt->execute();
    }

    $stmt->close();
}

 $conn->close();



?>