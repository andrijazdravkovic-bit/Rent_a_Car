<?php
require_once 'connection.php';
session_start();

$poruka = "";
$auto = null;
$korisnik = null;
$datumPocetka = "";
$datumKraja = "";
$ukupnaCena = 0;
$status = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['korisnici_id'])) {
        echo "<script>alert('Morate biti prijavljeni za pravljenje rezervacije'); window.location.href='login.php';</script>";
        exit;
    }

    $auto_id = $_POST['auto_id'];
    $datumPocetka = $_POST['datumPocetka'];
    $datumKraja = $_POST['datumKraja'];
    $korisnik_id = $_SESSION['korisnici_id'];

    $sql = "SELECT cena, marka, model FROM automobili WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $auto_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $auto = $res->fetch_assoc();

    if ($auto) {
        $cenaDan = $auto['cena'];
        $pocetak = new DateTime($datumPocetka);
        $kraj = new DateTime($datumKraja);
        $vreme = $pocetak->diff($kraj);
        $dan = $vreme->days + 1;
        $ukupnaCena = $dan * $cenaDan;
        $status = "Potvrdjeno";

        $sql = "INSERT INTO rezervacije (automobil_id, korisnik_id, datumPocetka, datumKraja, ukupnaCena, status) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iissds", $auto_id, $korisnik_id, $datumPocetka, $datumKraja, $ukupnaCena, $status);

        if ($stmt->execute()) {
            $sql = "SELECT ime, prezime FROM korisnici WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $korisnik_id);
            $stmt->execute();
            $res = $stmt->get_result();
            $korisnik = $res->fetch_assoc();

            $poruka = "Rezervacija uspešno kreirana.";
        } else {
            $poruka = "Greška pri kreiranju rezervacije: " . $conn->error;
        }
    } else {
        $poruka = "Automobil nije pronađen.";
    }

    $stmt->close();
}

if (!isset($_SESSION['korisnici_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Potvrda rezervacije | Rent a Car</title>
    <link rel="stylesheet" href="css/index.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/rezervacije.css?v=<?php echo time(); ?>">
</head>
<body>

    <header>
        <h1>Rent a Car</h1>
        <nav>
            <ul>
                <li><a href="index.php">Početna</a></li>
                <li><a href="rezervacije.php">Rezervacija</a></li>
                <li><a href="onama.php">O nama</a></li>
                <li><a href="kontakt.php">Kontakt</a></li>
                <li><a href="upisRezervacije.php?logout=true">Odjavi se</a></li>
            </ul>
        </nav>
    </header>

    <main class="rezervacijaSekcija">
        <div class="rezervacijaKontejner">
            <h2>Potvrda rezervacije</h2>

            <?php if ($poruka): ?>
                <p style="color: <?php echo ($poruka == 'Rezervacija uspešno kreirana.') ? '#27ae60' : '#e74c3c'; ?>; font-weight: bold; font-size: 18px; margin-bottom: 20px;">
                    <?php echo $poruka; ?>
                </p>
            <?php endif; ?>

            <?php if ($poruka == "Rezervacija uspešno kreirana." && !empty($auto)): ?>
                <div style="background-color: #181818; padding: 25px; border-radius: 10px; border: 1px solid #333333; margin-bottom: 25px; text-align: left;">
                    <h3 style="color: #27ae60; margin-bottom: 15px; font-size: 20px;">Detalji rezervacije</h3>
                    <p style="color: #ffffff; margin-bottom: 8px;"><strong>Automobil:</strong> <?php echo $auto['marka'] . " " . $auto['model']; ?></p>
                    <p style="color: #ffffff; margin-bottom: 8px;"><strong>Korisnik:</strong> <?php echo $korisnik['ime'] . " " . $korisnik['prezime']; ?></p>
                    <p style="color: #cccccc; margin-bottom: 8px;"><strong>Datum početka:</strong> <?php echo date("d.m.Y.", strtotime($datumPocetka)); ?></p>
                    <p style="color: #cccccc; margin-bottom: 8px;"><strong>Datum kraja:</strong> <?php echo date("d.m.Y.", strtotime($datumKraja)); ?></p>
                    <p style="color: #27ae60; font-size: 18px; font-weight: bold; margin-top: 15px;"><strong>Ukupna cena:</strong> <?php echo number_format($ukupnaCena, 2); ?> €</p>
                    <p style="color: #cccccc; margin-top: 5px;"><strong>Status:</strong> <span style="color: #27ae60; font-weight: bold;"><?php echo $status; ?></span></p>
                </div>
            <?php endif; ?>

            <a href="index.php" class="submitDugme" style="display: inline-block; text-decoration: none;">Nazad na početnu</a>
        </div>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Rent a Car</p>
    </footer>

</body>
</html>
