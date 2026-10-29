<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['korisnici_id']) || $_SESSION['prijava_id'] != 1) {
    echo "Niste admin.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['obrisi'])) {
    $rezervacija_id = $_POST['obrisi'];

    $sql = "DELETE FROM rezervacije WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $rezervacija_id);

    if ($stmt->execute()) {
        $_SESSION['poruka'] = "Rezervacija uspešno obrisana.";
    } else {
        $_SESSION['poruka'] = "Greška pri brisanju rezervacije.";
    }

    $stmt->close();

    header("Location: pregledRez.php");
    exit;
}

$sql = "SELECT r.id, k.ime, k.prezime, a.marka, a.model, r.datumPocetka, r.datumKraja, r.ukupnaCena 
        FROM rezervacije r
        JOIN korisnici k ON r.korisnik_id = k.id
        JOIN automobili a ON r.automobil_id = a.id";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pregled rezervacija</title>
    <link rel="stylesheet" href="css/pregledRez.css?v=<?php echo time(); ?>">
</head>
<body>

    <div class="container">
        <h1>Pregled rezervacija</h1>

        <?php if (isset($_SESSION['poruka'])): ?>
            <p class="obavestenje"><?php echo $_SESSION['poruka']; unset($_SESSION['poruka']); ?></p>
        <?php endif; ?>

        <?php if ($result && $result->num_rows > 0): ?>
            <div class="tabelaKontejner">
                <table>
                    <thead>
                        <tr>
                            <th>Ime</th>
                            <th>Prezime</th>
                            <th>Marka</th>
                            <th>Model</th>
                            <th>Datum početka rezervacije</th>
                            <th>Datum kraja rezervacije</th>
                            <th>Cena</th>
                            <th class="dugme"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['ime'] ?></td>
                            <td><?= $row['prezime'] ?></td>
                            <td><?= $row['marka'] ?></td>
                            <td><?= $row['model'] ?></td>
                            <td><?= date("d.m.Y.", strtotime($row['datumPocetka'])) ?></td>
                            <td><?= date("d.m.Y.", strtotime($row['datumKraja'])) ?></td>
                            <td class="cenaCol"><?= number_format($row['ukupnaCena'], 2) ?> €</td>
                            <td class="dugme">
                                <form method="POST" action="">
                                    <input type="hidden" name="obrisi" value="<?= $row['id'] ?>">
                                    <input type="submit" class="obrisiDugme" value="Obriši" onclick="return confirm('Da li ste sigurni da želite da obrišete ovu rezervaciju?');">
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="nemaRezervacija">Nema rezervacija.</p>
        <?php endif; ?>

        <div class="nazadWrapper">
            <a href="admin.php" class="nazadBtn">Nazad na kontrolnu tablu</a>
        </div>
    </div>

</body>
</html>
