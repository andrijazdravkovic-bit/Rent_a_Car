<?php

require_once 'connection.php';


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

foreach ($cars as $car) {
    $marka = $car[0];
    $model = $car[1];
    $godina = $car[2];
    $cena = $car[3];
    
    $sql = "INSERT IGNORE INTO automobili (marka, model, godina, cena) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssid", $marka, $model, $godina, $cena);
    $stmt->execute();
}

 $conn->close();
?>