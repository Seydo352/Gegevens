<?php
require_once 'data.php';
require_once 'vendor/autoload.php'; 


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Maak een nieuwe spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Geëxporteerde Gegevens');

// Voeg kolomtitels toe
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Email');

// Haal gegevens op uit de database
$sql = "SELECT id, email FROM emails";
$result = $mysqli->query($sql);

// Voeg gegevens toe aan de spreadsheet
$rowIndex = 2; // Begin vanaf de tweede rij
while ($row = $result->fetch_assoc()) {
    $sheet->setCellValue('A' . $rowIndex, $row['id']);
    $sheet->setCellValue('B' . $rowIndex, $row['email']);
    $rowIndex++;
}

// Exporteer naar een Excel-bestand
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="export.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
?>
