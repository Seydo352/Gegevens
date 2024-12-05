<?php
require_once 'data.php';
require_once 'vendor/autoload.php'; 

use TCPDF;

// Maak een nieuw PDF-object
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Website Export');
$pdf->SetTitle('Geëxporteerde gegevens');
$pdf->SetHeaderData('', '', 'Gegevens Export', '');
$pdf->AddPage();

// Haal gegevens op uit de database
$sql = "SELECT id, email FROM emails";
$result = $mysqli->query($sql);

// Voeg gegevens toe aan de PDF
$html = '<h1>Geëxporteerde Gegevens</h1><table border="1" cellpadding="5"><thead><tr><th>ID</th><th>Email</th></tr></thead><tbody>';
while ($row = $result->fetch_assoc()) {
    $html .= '<tr><td>' . htmlspecialchars($row['id']) . '</td><td>' . htmlspecialchars($row['email']) . '</td></tr>';
}
$html .= '</tbody></table>';
$pdf->writeHTML($html);

// Genereer de PDF
$pdf->Output('export.pdf', 'D');
?>
