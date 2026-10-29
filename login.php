<?php
require_once 'connection.php';
session_start();

$adminIme = 'admin';
$adminPass = 'admin';

$menadzerIme = 'manager';
$menadzerPass = 'manager';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ime = $_POST['ime'];
    $lozinka = $_POST['lozinka'];

    if ($ime === $adminIme && $lozinka === $adminPass) {
        $_SESSION['korisnici_id'] = 1;
        $_SESSION['prijava_id'] = 1;
        header("Location: admin.php");
        exit;
    }

    if ($ime === $menadzerIme && $lozinka === $menadzerPass) {
        $_SESSION['korisnici_id'] = 2;
        $_SESSION['prijava_id'] = 2;
        header("Location: manager.php");
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM korisnici WHERE ime = ?");
    $stmt->bind_param("s", $ime);
    $stmt->execute();
    $res = $stmt->get_result();
    $korisnik = $res->fetch_assoc();

    if ($korisnik && password_verify($lozinka, $korisnik['lozinka'])) {
        $_SESSION['korisnici_id'] = $korisnik['id'];
        $_SESSION['prijava_id'] = $korisnik['prijava_id'];

        switch ($korisnik['prijava_id']) {
            case 1:
                header("Location: admin.php");
                break;
            case 2:
                header("Location: manager.php");
                break;
            case 3:
                header("Location: index.php");
                break;
        }
        exit;
    } else {
        $greska = "Neispravna lozinka ili korisničko ime.";
    }
}
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prijava | Rent a Car</title>
    <link rel="stylesheet" href="css/login.css?v=<?php echo time(); ?>">
    <script>
        function gost() {
            window.location.href = 'indexGost.php';
        }
    </script>
</head>
<body class="loginBody">

    <div class="loginOverlay"></div>

    <div class="loginKontejner">
        <form action="login.php" method="post">
            <h2>Prijava</h2>

            <div class="inputGrupa">
                <label for="ime">Ime:</label>
                <input type="text" id="ime" name="ime" required placeholder="Unesite korisničko ime">
            </div>

            <div class="inputGrupa">
                <label for="lozinka">Lozinka:</label>
                <input type="password" id="lozinka" name="lozinka" required placeholder="Unesite lozinku">
            </div>

            <input type="submit" value="Prijavi se" class="submitDugme">

            <?php if (!empty($greska)): ?>
                <p class="greska"><?php echo $greska; ?></p>
            <?php endif; ?>

            <button type="button" onclick="gost()" class="gostDugme">Nastavi kao gost</button>

            <div class="registracija">
                <p>Nemate kreiran nalog? <a href="register.php">Registrujte se</a></p>
            </div>
        </form>
    </div>

</body>
</html>
