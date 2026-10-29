<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['korisnici_id']) || $_SESSION['prijava_id'] != 1) {
    header("Location: login.php");
    exit;
}

$sql = "SELECT id, ime, prezime, email, lozinka FROM korisnici";
$result = $conn->query($sql);

$conn->close();
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upravljanje korisnicima</title>
    <link rel="stylesheet" href="css/upravljanjeKorisnicima.css?v=<?php echo time(); ?>">
</head>
<body>

    <div class="container">
        <h1>Upravljanje korisnicima</h1>

        <div class="tabelaKontejner">
            <table class="adminTabela">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ime</th>
                        <th>Prezime</th>
                        <th>Email</th>
                        <th>Lozinka</th>
                        <th>Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['ime']; ?></td>
                        <td><?php echo $row['prezime']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td class="lozinka"><?php echo $row['lozinka']; ?></td>
                        <td class="dugme">
                            <a href="urediKorisnika.php?id=<?php echo $row['id']; ?>" class="urediBtn">Uredi</a>
                            <a href="obrisiKorisnika.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Da li ste sigurni da želite da obrišete ovog korisnika?')" class="obrisiBtn">Obriši</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="nazadWrapper">
            <a href="admin.php" class="nazadBtn">Nazad na kontrolnu tablu</a>
        </div>
    </div>

</body>
</html>
