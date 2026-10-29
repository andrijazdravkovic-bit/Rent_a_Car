<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['korisnici_id']) || $_SESSION['prijava_id'] != 1) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: upravljanjeKorisnicima.php");
    exit;
}

$korisnici_id = $_GET['id'];

$sql = "SELECT ime, prezime, email, lozinka FROM korisnici WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $korisnici_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Korisnik nije pronađen.";
    exit;
}

$korisnik = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $email = $_POST['email'];
    $lozinka = password_hash($_POST['lozinka'], PASSWORD_DEFAULT);

    $sql = "UPDATE korisnici SET ime = ?, prezime = ?, email = ?, lozinka = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $ime, $prezime, $email, $lozinka, $korisnici_id);

    if ($stmt->execute()) {
        header("Location: upravljanjeKorisnicima.php");
        exit;
    } else {
        $greska = "Greška pri ažuriranju podataka.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uredi korisnika</title>
    <link rel="stylesheet" href="css/urediKorisnika.css?v=<?php echo time(); ?>">
</head>
<body>

    <div class="container">
        <h1>Uredi korisnika</h1>

        <?php if (isset($greska)): ?>
            <p class="greska"><?php echo $greska; ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="inputGrupa">
                <label for="ime">Novo ime:</label>
                <input type="text" id="ime" name="ime" value="<?php echo htmlspecialchars($korisnik['ime']); ?>" required>
            </div>

            <div class="inputGrupa">
                <label for="prezime">Novo prezime:</label>
                <input type="text" id="prezime" name="prezime" value="<?php echo htmlspecialchars($korisnik['prezime']); ?>" required>
            </div>

            <div class="inputGrupa">
                <label for="email">Novi email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($korisnik['email']); ?>" required>
            </div>

            <div class="inputGrupa">
                <label for="lozinka">Nova lozinka:</label>
                <input type="password" id="lozinka" name="lozinka" required placeholder="Unesite novu lozinku">
            </div>

            <input type="submit" value="Ažuriraj" class="submitBtn">
        </form>

        <div class="nazadWrapper">
            <a href="upravljanjeKorisnicima.php" class="nazadBtn">Nazad na Upravljanje Korisnicima</a>
        </div>
    </div>

</body>
</html>