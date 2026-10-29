<?php
require_once 'connection.php';
session_start();

if (!isset($_SESSION['korisnici_id']) || $_SESSION['prijava_id'] != 2) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['odgovor_id'])) {
    $odgovor_id = $_POST['odgovor_id'];
    $odgovor = $_POST['odgovor'];

    $sql = "UPDATE poruke SET odgovor_id = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $odgovor, $odgovor_id);

    if ($stmt->execute()) {
        $_SESSION['poruka'] = "Odgovor uspešno poslat.";
    } else {
        $_SESSION['poruka'] = "Greška pri slanju odgovora.";
    }

    $stmt->close();
}

$sql = "SELECT * FROM poruke";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager - Kontrolna tabla</title>
    <link rel="stylesheet" href="css/manager.css?v=<?php echo time(); ?>">
</head>
<body>

    <div class="container">
        <h1>Manager - Kontrolna tabla</h1>

        <div class="sadrzajBox">
            <h2>Primljene poruke</h2>

            <?php if (isset($_SESSION['poruka'])): ?>
                <p class="obavestenje"><?php echo $_SESSION['poruka']; unset($_SESSION['poruka']); ?></p>
            <?php endif; ?>

            <div class="tabelaKontejner">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ime</th>
                            <th>Email</th>
                            <th>Poruka</th>
                            <th class="dugme"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($poruka = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $poruka['id']; ?></td>
                            <td><?php echo $poruka['ime']; ?></td>
                            <td><?php echo $poruka['email']; ?></td>
                            <td class="porukaTekst"><?php echo $poruka['poruka']; ?></td>
                            <td class="dugme">
                                <a href="odgovor.php?id=<?php echo $poruka['id']; ?>" class="odgovoriDugme">Odgovori</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="odjaviWrapper">
                <a href="manager.php?logout=true" class="odjaviSeDugme">Odjavi se</a>
            </div>
        </div>
    </div>

</body>
</html>