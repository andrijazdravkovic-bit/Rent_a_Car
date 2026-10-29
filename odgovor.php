<?php
require_once 'connection.php';
session_start();

if (!isset($_SESSION['korisnici_id']) || $_SESSION['prijava_id'] != 2) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $q = "SELECT * FROM poruke WHERE id = $id";
    $result = mysqli_query($conn, $q);
    $poruka = mysqli_fetch_assoc($result);
} else {
    header("Location: manager.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $odgovor = $_POST['odgovor'];
    $email = $poruka['email'];
    $to = $email;
    $subject = "Odgovor na vašu poruku";
    $porukaTekst = "Poštovani,\n\n" . $odgovor;
    $manager = "From: manager@rentzafirovic.com";

    $azurirajPoruku = "UPDATE poruke SET odgovoren = 1 WHERE id = $id";
    if (mysqli_query($conn, $azurirajPoruku)) {
        header("Location: manager.php");
        exit;
    } else {
        echo "Greška pri ažuriranju poruke.";
    }
}
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Odgovor na poruku | Rent a Car</title>
    <link rel="stylesheet" href="css/odgovor.css?v=<?php echo time(); ?>">
</head>
<body>

    <div class="container">
        <h1>Odgovorite na poruku</h1>

        <?php if ($poruka): ?>
            <div class="porukaInfo">
                <p class="porukaKorisnik"><strong>Korisnik:</strong> <?php echo htmlspecialchars($poruka['ime']); ?> (<?php echo htmlspecialchars($poruka['email']); ?>)</p>
                <p class="porukaTekst"><strong>Poruka:</strong> "<?php echo htmlspecialchars($poruka['poruka']); ?>"</p>
            </div>
        <?php endif; ?>

        <form action="odgovor.php?id=<?php echo $id; ?>" method="post">
            <div class="inputGrupa">
                <label for="odgovor">Vaš odgovor:</label>
                <textarea id="odgovor" name="odgovor" rows="5" required placeholder="Napišite vaš odgovor ovde..."></textarea>
            </div>

            <input type="submit" value="Pošaljite odgovor" class="submitBtn">
        </form>

        <div class="nazadWrapper">
            <a href="manager.php" class="nazadBtn">Nazad na kontrolnu tablu</a>
        </div>
    </div>

</body>
</html>

