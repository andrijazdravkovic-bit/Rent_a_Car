<?php
require_once 'connection.php';
session_start();

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
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent a Car | O Nama</title>
    <link rel="stylesheet" href="css/index.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/onama.css?v=<?php echo time(); ?>">
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
                <li><a href="index.php?logout=true">Odjavi se</a></li>
            </ul>
        </nav>
    </header>

    <div class="heroSection">
        <img src="slike/slika.png" alt="O Nama Banner" class="heroSlika">
        <div class="heroOverlay">
            <h1>O Nama</h1>
            <p>Vaša pouzdana agencija za udobno, sigurno i bezbrižno putovanje.</p>
        </div>
    </div>

    <section class="opisSekcija">
        <div class="opisSadrzaj">
            <h2>Dobrodošli na Rent a Car</h2>
            <p>Dobrodošli na Rent a Car, vašu pouzdanu agenciju za iznajmljivanje vozila! Naša misija je da vam omogućimo udobno, sigurno i bezbrižno putovanje, bilo da se radi o poslovnim obavezama ili odmoru.</p>
            
            <div class="oNamaMreza">
                <div class="oNamaKartica">
                    <h3>🚘 Ko smo mi?</h3>
                    <p>Rent a Car je specijalizovana agencija za iznajmljivanje automobila sa dugogodišnjim iskustvom u industriji. Posvećeni smo pružanju vrhunskih usluga, konkurentnih cena i širokog asortimana vozila kako bismo zadovoljili različite potrebe naših klijenata. Bilo da vam je potreban luksuzni automobil, ekološki prihvatljivo vozilo, ili porodični SUV, mi imamo pravo vozilo za vas.</p>
                </div>
                
                <div class="oNamaKartica">
                    <h3>🎯 Naša misija</h3>
                    <p>Naša misija je da svakom klijentu pružimo vrhunsko iskustvo iznajmljivanja automobila, bilo da putujete na kratko ili dugoročno. Razumemo važnost vremena i udobnosti, zbog čega se trudimo da svaki proces bude brz, jednostavan i transparentan.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="zaposleniSekcija">
        <h2 class="sekcijaNaslov">Rukovodstvo</h2>
        <div class="zaposleniMreza">
            <div class="zaposlenKartica">
                <div class="zaposlenIkonica">👨‍💼</div>
                <h3>Andrija Zdravkovic</h3>
                <p class="pozicija">Vlasnik i direktor</p>
                <a href="https://www.linkedin.com/in/andrija-zdravkovi%C4%87-11aa75447/" target="_blank" class="instagramDugme">LinkedIn 🔗</a>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Rent a Car</p>
    </footer>

</body>
</html>
