<?php
require_once 'connection.php';
session_start();

if (!isset($_SESSION['korisnici_id']) || $_SESSION['prijava_id'] != 1) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['dodajAutomobil'])) {
    $marka = $_POST['marka'];
    $model = $_POST['model'];
    $godina = $_POST['godina'];
    $cena = $_POST['cena'];

    $q = "INSERT INTO automobili (marka, model, godina, cena) VALUES ('$marka', '$model', '$godina', '$cena')";
    if (mysqli_query($conn, $q)) {
        $poruka = "Automobil je uspešno dodat!";
    } else {
        $poruka = "Greška: " . mysqli_error($conn);
    }
}

$automobili = "SELECT * FROM automobili";
$zaPrikaz = mysqli_query($conn, $automobili);
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Kontrolna tabla</title>
    <link rel="stylesheet" href="css/admin.css?v=<?php echo time(); ?>">
</head>
<body>

    <div class="container">
        <h1>Admin - Kontrolna tabla</h1>
        
        <div class="div">
            <nav>
                <ul>
                    <li><a href="admin.php" class="active">Početna</a></li>
                    <li><a href="upravljanjeKorisnicima.php">Upravljanje korisnicima</a></li>
                    <li><a href="pregledRez.php">Pregled rezervacija</a></li>
                    <li><a href="index.php?logout=true" class="logoutBtn">Odjavi se</a></li>
                </ul>
            </nav>
        </div>

        <section>
            <h2>Dodaj novi automobil</h2>
            <?php if (isset($poruka)): ?>
                <p class="obavestenje"><?php echo $poruka; ?></p>
            <?php endif; ?>

            <form action="admin.php" method="post">
                <div class="inputGrupa">
                    <label for="marka">Marka automobila:</label>
                    <input type="text" id="marka" name="marka" required placeholder="Npr. BMW">
                </div>

                <div class="inputGrupa">
                    <label for="model">Model automobila:</label>
                    <input type="text" id="model" name="model" required placeholder="Npr. X6">
                </div>

                <div class="inputGrupa">
                    <label for="godina">Godina proizvodnje:</label>
                    <input type="number" id="godina" name="godina" min="1900" max="<?php echo date('Y'); ?>" required placeholder="Npr. 2024">
                </div>

                <div class="inputGrupa">
                    <label for="cena">Cena automobila (€/dan):</label>
                    <input type="text" id="cena" name="cena" required placeholder="Npr. 150.00">
                </div>

                <input type="submit" name="dodajAutomobil" value="Dodaj automobil" class="submitBtn">
            </form>
        </section>

        <section>
            <h2>Lista automobila</h2>
            <div class="tabelaKontejner">
                <table class="adminTabela">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Marka</th>
                            <th>Model</th>
                            <th>Godina</th>
                            <th>Cena</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($automobil = mysqli_fetch_assoc($zaPrikaz)): ?>
                        <tr>
                            <td><?php echo $automobil['id']; ?></td>
                            <td><?php echo $automobil['marka']; ?></td>
                            <td><?php echo $automobil['model']; ?></td>
                            <td><?php echo $automobil['godina']; ?></td>
                            <td class="cenaCol"><?php echo number_format($automobil['cena'], 2); ?> €</td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>

</body>
</html>
