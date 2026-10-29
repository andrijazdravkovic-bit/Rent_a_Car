<?php
require_once 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ime = $_POST['ime'];
    $email = $_POST['email'];
    $poruka = $_POST['poruka'];

    $q = "INSERT INTO poruke (ime, email, poruka) VALUES ('$ime', '$email', '$poruka')";
    if (mysqli_query($conn, $q)) {
        header("Location: poslataporuka.php?email=" . urlencode($email));
        exit;
    } else {
        echo "Greška: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent a Car | Kontakt</title>
    <link rel="stylesheet" href="css/index.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/kontakt.css?v=<?php echo time(); ?>">
</head>
<body>

    <header>
        <h1>Rent a Car</h1>
        <nav>
            <ul>
                <li><a href="indexGost.php">Početna</a></li>
                <li><a href="rezervacijeGost.php">Rezervacija</a></li>
                <li><a href="onamaGost.php">O nama</a></li>
                <li><a href="kontaktGost.php">Kontakt</a></li>
                <li><a href="login.php">Prijavi se</a></li>
            </ul>
        </nav>
    </header>

    <div class="heroSection">
        <img src="slike/slika.png" alt="Kontakt Banner" class="heroSlika">
        <div class="heroOverlay">
            <h1>Kontaktirajte Nas</h1>
            <p>Tu smo da odgovorimo na sva vaša pitanja i pružimo podršku 24/7.</p>
        </div>
    </div>

    <section class="kontaktSekcija">
        <div class="kontaktKontejner">
            
            <div class="kontaktInfo">
                <h2>Informacije</h2>
                <p class="podnaslov">Za sve informacije o iznajmljivanju automobila, slobodno nas kontaktirajte. Bićemo vam na raspolaganju za sve dodatne informacije i pomoć!</p>

                <div class="infoKartica">
                    <span class="infoIkonica">📍</span>
                    <div>
                        <h3>Naša adresa</h3>
                        <p>Pirot, Srbija</p>
                    </div>
                </div>

                <div class="infoKartica">
                    <span class="infoIkonica">📞</span>
                    <div>
                        <h3>Telefon</h3>
                        <p>010 123 456</p>
                    </div>
                </div>

                <div class="infoKartica">
                    <span class="infoIkonica">✉️</span>
                    <div>
                        <h3>Email</h3>
                        <p>kontakt@rentacar.rs</p>
                    </div>
                </div>
            </div>

            <div class="kontaktFormaBox">
                <h2>Pošaljite nam poruku</h2>
                <form action="" method="post">
                    <div class="inputGrupa">
                        <label for="ime">Ime:</label>
                        <input type="text" id="ime" name="ime" required placeholder="Vaše ime i prezime">
                    </div>

                    <div class="inputGrupa">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required placeholder="vas@email.com">
                    </div>

                    <div class="inputGrupa">
                        <label for="poruka">Poruka:</label>
                        <textarea id="poruka" name="poruka" rows="5" required placeholder="Napišite vašu poruku ovde..."></textarea>
                    </div>

                    <input type="submit" value="Pošalji poruku" class="submitDugme">
                </form>
            </div>

        </div>
    </section>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Rent a Car</p>
    </footer>

</body>
</html>