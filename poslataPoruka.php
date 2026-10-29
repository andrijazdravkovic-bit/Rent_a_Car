<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poruka Poslata | Rent a Car</title>
    <link rel="stylesheet" href="css/poslataPoruka.css?v=<?php echo time(); ?>">
</head>
<body>

    <div class="porukaKontejner">
        <?php
        if (isset($_GET['email'])) {
            $email = htmlspecialchars($_GET['email']);
            echo "<div class='porukaIkonica'>✉️</div>";
            echo "<h1>Poruka je poslata.</h1>";
            echo "<p>Očekujte odgovor uskoro na emailu: <strong>$email</strong></p>";
        } else {
            echo "<div class='porukaIkonica greskaIkonica'>❌</div>";
            echo "<h1>Greška</h1>";
            echo "<p>Email adresa nije pronađena. Molimo pokušajte ponovo.</p>";
        }
        ?>

        <a href="javascript:history.back()" class="nazad">Nazad</a>
    </div>

</body>
</html>
