<?php
require_once __DIR__ . '/session_init.php';
require_once __DIR__ . '/config/data.php';
require_once __DIR__ . '/db/dbconn.php';
require_admin();

require_once __DIR__ . '/libs/PhpSpreadsheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

// ================= DATA =================

$stmt = $conn->prepare("
    SELECT 
        Cislo,
        Alias,
        CASE WHEN Prijmeni LIKE '% %' THEN CONCAT(SUBSTRING_INDEX(Prijmeni, ' ', 1), ' ', Jmeno, ' ', SUBSTRING_INDEX(Prijmeni, ' ', -1)) ELSE CONCAT(Prijmeni, ' ', Jmeno) END AS PrijmeniJmeno,
        TRIM(CONCAT(ObcanskyPrukaz,' ',IF(ZbrojniOpravneni = 1, '(zo)', ''))) AS `Občanský průkaz`,
        CisloZbrane,
        Squad,
        Kategorie,
        CONCAT(Divize,'',IF(Faktor = 'MAJ', '+', '')) AS `Division`
    FROM $table
    WHERE Vyrazeno IS NULL
    ORDER BY Squad, PrijmeniJmeno
");
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$result_match = $conn->query("SELECT Zavod FROM $table_matches WHERE Zavod_id='$table' LIMIT 1");
$match_data = $result_match->fetch_array();

// ================= EXCEL =================

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// ---------- PAGE SETUP (TISK) ----------

$sheet->getPageSetup()
    ->setPaperSize(PageSetup::PAPERSIZE_A4)
    ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE)
    ->setFitToWidth(null)
    ->setFitToHeight(null);
    

// opakování hlavičky (řádky 1–3)
$sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 3);

// okraje
$sheet->getPageMargins()
    ->setTop(0.75)
    ->setBottom(0.75)
    ->setLeft(0.5)
    ->setRight(0.5);

// ================= HLAVIČKA =================

// řádek 1
$sheet->setCellValue('A1', $match_data['Zavod'] . ' - ' . date('d.m.Y') . ' - Podpisový arch účastníků');
$sheet->mergeCells('A1:H1');
$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(20);
$sheet->getRowDimension(1)->setRowHeight(30);
$sheet->getStyle('A1')->getAlignment()
    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
    ->setVertical(Alignment::VERTICAL_TOP);

// řádek 2
$sheet->setCellValue('A2', 'Svým podpisem stvrzuji, že jsem se seznámil(a) s Provozním řádem střelnice');
$sheet->mergeCells('A2:H2');
$sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(14);
$sheet->getRowDimension(2)->setRowHeight(30);
$sheet->getStyle('A2')->getAlignment()
    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
    ->setVertical(Alignment::VERTICAL_TOP);

// řádek 3 – hlavička tabulky
$sheet->fromArray(
    ['#', 'Alias', 'Příjmení, Jméno', 'OP / EZP', 'Číslo zbraně', 'Squad', 'Kategorie', 'Divize', 'Podpis'],
    null,
    'A3'
);

// ================= DATA =================

$row = 4;
//$counter = 1;
foreach ($data as $line) {
    $sheet->fromArray(
        [
            $line['Cislo'],
            $line['Alias'],
            $line['PrijmeniJmeno'],
            $line['Občanský průkaz'],
            $line['CisloZbrane'],
            $line['Squad'],
            $line['Kategorie'],
            $line['Division'],
            $line['Poznamka']
        ],
        null,
        "A$row"
    );
    $row++;
    //$counter++;
}

$highestRow = $sheet->getHighestRow();

// ================= STYLY =================

$headerStyle = [
    'font' => ['bold' => true, 'size' => 14],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical'   => Alignment::VERTICAL_CENTER
    ],
    'borders' => [
        'allBorders' => ['borderStyle' => Border::BORDER_THIN]
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'DDDDDD']
    ],
];

$bodyStyle = [
    'font' => ['size' => 13],
    'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
    'borders' => [
        'allBorders' => ['borderStyle' => Border::BORDER_THIN]
    ],
];

// hlavička tabulky
$sheet->getStyle("A3:I3")->applyFromArray($headerStyle);
$sheet->getRowDimension(3)->setRowHeight(30);

// tělo tabulky
$sheet->getStyle("A4:I$highestRow")->applyFromArray($bodyStyle);
// tučné jméno
$sheet->getStyle("B4:B$highestRow")->getFont()->setBold(true)->setSize(14);

// centrování
$sheet->getStyle("D4:I$highestRow")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// výšky řádků
for ($i = 4; $i <= $highestRow; $i++) {
    $sheet->getRowDimension($i)->setRowHeight(27);
}

// ================= ŠÍŘKY SLOUPCŮ =================

$sheet->getColumnDimension('A')->setWidth(5);   // číslo
$sheet->getColumnDimension('B')->setWidth(20);  // alias
$sheet->getColumnDimension('C')->setWidth(25);  // příjmení, jméno
$sheet->getColumnDimension('D')->setWidth(20);  // OP
$sheet->getColumnDimension('E')->setWidth(17);  // číslo zbraně
$sheet->getColumnDimension('F')->setWidth(12);  // squad
$sheet->getColumnDimension('G')->setWidth(15);  // kategorie
$sheet->getColumnDimension('H')->setWidth(12);  // divize
$sheet->getColumnDimension('I')->setWidth(35);  // podpis


// ================= VÝSTUP =================

$filename = 'Podpisovy_arch_' . $table . '.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
ob_clean();
$writer->save('php://output');
exit;
