<?php
require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $email = $_POST['email'];
    $lozinka = password_hash($_POST['lozinka'], PASSWORD_DEFAULT);
    $prijava_id = 3;

    $q = "INSERT INTO korisnici (ime, prezime, email, lozinka, prijava_id) VALUES ('$ime', '$prezime', '$email', '$lozinka', '$prijava_id')";

    if (mysqli_query($conn, $q)) {
        header("Location: login.php");
        exit;
    } else {
        $greska = "Greška: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registracija | Rent a Car</title>
    <link rel="stylesheet" href="css/register.css?v=<?php echo time(); ?>">
</head>
<body class="registerBody">

    <div class="registerOverlay"></div>

    <div class="registerKontejner">
        <form action="register.php" method="post">
            <h2>Registracija</h2>

            <?php if (isset($greska)): ?>
                <p class="greska"><?php echo $greska; ?></p>
            <?php endif; ?>

            <div class="inputGrupa">
                <label for="ime">Ime:</label>
                <input type="text" id="ime" name="ime" required placeholder="Unesite ime">
            </div>

            <div class="inputGrupa">
                <label for="prezime">Prezime:</label>
                <input type="text" id="prezime" name="prezime" required placeholder="Unesite prezime">
            </div>

            <div class="inputGrupa">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required placeholder="Unesite email">
            </div>

            <div class="inputGrupa">
                <label for="lozinka">Lozinka:</label>
                <input type="password" id="lozinka" name="lozinka" required placeholder="Unesite lozinku">
            </div>

            <input type="submit" value="Registruj se" class="submitDugme">

            <div class="prijava">
                <p>Imate kreiran nalog? <a href="login.php">Prijavite se</a></p>
            </div>
        </form>
    </div>

</body>
</html>
