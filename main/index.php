<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Gegevensverzameling</title>
    <link rel="stylesheet" href="../css/styles.css">
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

    <div class="content">
        <h1>Welkom bij Gegevensverzameling</h1> 
        <div class="logo-container">
            <img src="../images/logo.png" alt="Logo" class="rotating-logo">
        </div>
        <p>Registreer je e-mail hieronder:</p>

        <form action="process.php" method="POST">
            <input type="email" name="email" placeholder="E-mail" required>
            <button type="submit">Verzenden</button>
        </form>
    </div>

    <script src="../js/script.js"></script>
</body>
</html>