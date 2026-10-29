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

$sql = "SELECT * FROM automobili";
$res = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent a Car | Rezervacija</title>
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
                <li><a href="index.php?logout=true">Odjavi se</a></li>
            </ul>
        </nav>
    </header>

    <main class="rezervacijaSekcija">
        <div class="rezervacijaKontejner">
            <h2>Izaberite automobil za rezervaciju</h2>

            <form action="upisRezervacije.php" method="post">
                <div class="inputGrupa">
                    <label for="auto">Izaberite automobil:</label>
                    <select id="auto" name="auto_id" required>
                        <option value="">Izaberite automobil</option>
                        <?php
                        if ($res && $res->num_rows > 0) {
                            while($row = $res->fetch_assoc()) {
                                echo "<option value='" . $row['id'] . "'>" . $row['marka'] . " " . $row['model'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>Nema dostupnih automobila</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="inputGrupa">
                    <label for="datumPocetka">Datum početka:</label>
                    <input type="date" id="datumPocetka" name="datumPocetka" required min="<?php echo date('Y-m-d'); ?>">
                </div>

                <div class="inputGrupa">
                    <label for="datumKraja">Datum kraja:</label>
                    <input type="date" id="datumKraja" name="datumKraja" required min="<?php echo date('Y-m-d'); ?>">
                </div>

                <input type="submit" value="Rezerviši" class="submitDugme">
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Rent a Car</p>
    </footer>

</body>
</html>