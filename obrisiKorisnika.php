<?php
    session_start();
    require_once 'connection.php';

    if (!isset($_SESSION['korisnici_id']) || $_SESSION['prijava_id'] != 1) {
        echo "Niste admin.";
        exit;
    }

    if (isset($_GET['id'])) {
        $korisnik = $_GET['id'];
        $sql = "DELETE FROM korisnici WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $korisnik);
        $stmt->execute();
        $stmt->close();
    } else {
        $_SESSION['poruka'] = "ID korisnika nije prosleđen.";
    }
    $conn->close();
    
    header("Location: upravljanjeKorisnicima.php");
    exit;
?>
