<?php
include('data.php');

// Verwerk popups voor succesmeldingen
$actionMessage = "";
$popupClass = ""; // Standaard klasse voor popup

if (isset($_GET['action']) && $_GET['action'] == 'success') {
    if (isset($_GET['type']) && $_GET['type'] == 'edit') {
        $actionMessage = "E-mail succesvol bijgewerkt!";
    } elseif (isset($_GET['type']) && $_GET['type'] == 'delete') {
        $actionMessage = "E-mail succesvol verwijderd!";
        $popupClass = "error"; // Maak de popup rood bij verwijderen
    }
}

// Haal e-mails op uit de database
$sql = "SELECT id, email FROM emails"; 
$result = $mysqli->query($sql);

if (!$result) {
    die("Query mislukt: " . $mysqli->error);
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overzicht van E-mails</title>
    <link rel="stylesheet" href="../css/styles.css"> <!-- Externe CSS voor consistent ontwerp -->

    <style>
        /* Interne CSS voor de navigatiebalk, tabel, knoppen en popups */

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #333;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .btn {
            padding: 5px 10px;
            margin: 5px;
            border: none;
            cursor: pointer;
        }
        .edit-btn {
            background-color: #4CAF50;
            color: white;
        }
        .delete-btn {
            background-color: #f44336;
            color: white;
        }
        .backup-btn {
            background-color: #333;
            color: white;
        }

        /* CSS voor popup berichten */
        .popup-message {
            display: none;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.5s ease, top 0.5s ease;
        }

        .popup-message.show {
            display: block;
            opacity: 1;
            top: 40px;
        }

        .popup-message.error {
            background-color: #f44336; /* Rode achtergrond voor verwijderingen */
        }
    </style>
</head>
<body>

<header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="tabel.php">Overzicht</a></li>
            </ul>
        </nav>
    </header>
    <!-- Popup bericht voor feedback bij succes -->
    <div id="popupMessage" class="popup-message <?php echo $popupClass; ?>">
        <?php echo $actionMessage; ?>
    </div>

    <h2 style="text-align:center">Overzicht van E-mails</h2>

    <?php if ($result->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>E-mail</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td>
                        <button class="btn edit-btn" onclick="editEmail('<?php echo $row['id']; ?>', '<?php echo $row['email']; ?>')">Bewerk</button>
                        <button class="btn delete-btn" onclick="window.location.href='process.php?action=delete&id=<?php echo $row['id']; ?>'">Verwijder</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p style="text-align:center">Geen gegevens gevonden</p>
    <?php endif; ?>

    <!-- Backup knop -->
    <div style="text-align: center; margin-top: 20px;">
        <button class="btn backup-btn" onclick="window.location.href='process.php?action=backup'">Backup gegevens</button>
    </div>

    <!-- Exportknoppen -->
    <div style="text-align: center; margin-top: 20px;">
        <form action="export_pdf.php" method="post" style="display:inline;">
            <button class="btn backup-btn">Exporteer naar PDF</button>
        </form>
        <form action="export_excel.php" method="post" style="display:inline;">
            <button class="btn backup-btn">Exporteer naar Excel</button>
        </form>
    </div>

    <!-- JavaScript voor het bewerken van e-mail en het weergeven van popups -->
    <script>
        function editEmail(id, currentEmail) {
            var newEmail = prompt("Voer de nieuwe e-mail in:", currentEmail);
            if (newEmail) {
                window.location.href = 'process.php?action=edit&id=' + id + '&email=' + newEmail;
            }
        }

        // Functie om de popup weer te geven
        function showPopup() {
            var popup = document.getElementById("popupMessage");
            if (popup.textContent.trim() !== "") {
                popup.classList.add("show");
                setTimeout(function() {
                    popup.classList.remove("show");
                }, 3000); // Verberg de popup na 3 seconden
            }
        }

        // Roep de showPopup functie aan als er een bericht is
        window.onload = showPopup;
    </script>

</body>
</html>
