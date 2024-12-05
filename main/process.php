<?php
include('data.php');

// Verwerk het formulier ingediend vanuit index.php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    // Haal het e-mailadres op uit het formulier
    $email = $_POST['email'];

    // Voeg het e-mailadres toe aan de database
    $sql = "INSERT INTO emails (email) VALUES ('$email')";

    // Voer de query uit en controleer of het succesvol is
    if ($mysqli->query($sql) === TRUE) {
        // Redirect naar tabel.php na succesvolle toevoeging
        header("Location: tabel.php?action=success&type=add");
    } else {
        echo "<p>Fout: " . $sql . "<br>" . $mysqli->error . "</p>";
    }

    // Sluit de databaseverbinding
    $mysqli->close();
    exit;
}

// Verwerk andere acties vanuit tabel.php (bewerken, verwijderen, back-up maken)
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    // E-mailadres bewerken
    if ($action == 'edit' && isset($_GET['id']) && isset($_GET['email'])) {
        $id = $_GET['id'];
        $email = $_GET['email'];
        $sql = "UPDATE emails SET email='$email' WHERE id=$id";
        $mysqli->query($sql);
        header("Location: tabel.php?action=success&type=edit");
        exit;
    }

    // E-mailadres verwijderen
    if ($action == 'delete' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "DELETE FROM emails WHERE id=$id";
        $mysqli->query($sql);
        header("Location: tabel.php?action=success&type=delete");
        exit;
    }

    // Back-up van e-mails maken als CSV-bestand
    if ($action == 'backup') {
        $sql = "SELECT id, email FROM emails";
        $result = $mysqli->query($sql);

        // Maak een CSV-bestand
        $backupFile = 'backup_' . date('Y-m-d-H-i-s') . '.csv';
        $output = fopen($backupFile, 'w');
        fputcsv($output, ['ID', 'Email']);

        // Haal de rijen op en schrijf naar CSV
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, $row);
        }
        fclose($output);

        // Bied het bestand aan voor download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename="' . $backupFile . '"');
        readfile($backupFile);
        exit;
    }
}
?>
