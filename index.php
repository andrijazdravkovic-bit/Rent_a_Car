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
    <title>Rent a Car</title>
    <link rel="stylesheet" href="css/index.css?v=<?php echo time(); ?>">
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
        <img src="slike/slika.png" alt="Rent a Car Banner" class="heroSlika">
        <div class="heroOverlay">
            <h1>Iznajmite vozilo iz snova</h1>
            <p>Brza, sigurna i jednostavna rezervacija luksuznih i ekonomičnih automobila.</p>
            <a href="#ponuda" class="heroDugme">Pogledaj ponudu</a>
        </div>
    </div>

    <section class="opisSekcija">
        <div class="opisSadrzaj">
            <h2>Vaš pouzdan partner na putu</h2>
            <p>Nudimo vam vrhunska vozila za sve prilike — od ekonomičnih gradskih automobila do ekskluzivnih modela. Bez skrivenih troškova, uz potpunu sigurnost i brz proces rezervacije.</p>
            <div class="opisMreza">
                <div class="opisKartica">
                    <h3>⚡ Brza rezervacija</h3>
                    <p>Izaberite željeno vozilo i završite rezervaciju u samo par jednostavnih koraka.</p>
                </div>
                <div class="opisKartica">
                    <h3>🛡️ Sigurnost i osiguranje</h3>
                    <p>Sva naša vozila su redovno servisirana, kasko osigurana i spremna za put.</p>
                </div>
                <div class="opisKartica">
                    <h3>💰 Povoljne cene</h3>
                    <p>Zagarantovano najbolji odnos cene i kvaliteta usluge na tržištu.</p>
                </div>
            </div>
        </div>
    </section>

    <h2 class="sekcijaNaslov" id="ponuda">Najpopularnije u ponudi</h2>

    <section class="ponuda">
        <div class="ponudaDiv">
            <?php
            $sql = "SELECT * FROM automobili LIMIT 8";
            $res = $conn->query($sql);

            if ($res && $res->num_rows > 0) {
                while($row = $res->fetch_assoc()) {
                    echo "<div class='ponudaKvadrat'>";
                    echo "<img src='slike/" . $row['id'] . ".jpg' alt='" . $row['marka'] . "' class='autoSlika'>";
                    echo "<a href='rezervacije.php?id=" . $row['id'] . "' style='color:white; text-decoration:none;'>";
                    echo "<h3>" . $row['marka'] . " " . $row['model'] . "</h3>";
                    echo "<p>Godina: " . $row['godina'] . "</p>";
                    echo "<p>Cena: " . $row['cena'] . " € / DAN</p>";
                    echo "</a>";
                    echo "</div>";
                }
            } else {
                echo "<p>Nema dostupnih automobila.</p>";
            }
            $conn->close();
            ?>
        </div>
    </section>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Rent a Car</p>
    </footer>

</body>
</html>