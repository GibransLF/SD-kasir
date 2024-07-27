<?php
require '../../vendor/autoload.php';
require '../../koneksi.php';
require '../../function.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Query untuk mengambil data dari tabel
$sql = "SELECT * FROM penjualan LEFT JOIN produk ON penjualan.produk_id = produk.id_produk";
try {
    $result = $conn->query($sql);
} 
catch (mysqli_sql_exception $e) {
    echo "Tabel tidak ditemukan <br>";
    echo "<a href='../../table.php'>buat Tabel</a>";
    die();
}

$spreadsheet = new Spreadsheet();
$activeWorksheet = $spreadsheet->getActiveSheet();

// Tambahkan header
$activeWorksheet->setCellValue('A1', 'Tanggal');
$activeWorksheet->setCellValue('B1', 'Nama Produk');
$activeWorksheet->setCellValue('C1', 'Qty Terjual');
$activeWorksheet->setCellValue('D1', 'Total Harga Dasar');
$activeWorksheet->setCellValue('E1', 'Total Harga Jual');

// Tambahkan data dari database ke spreadsheet
$rowNumber = 2; // Baris dimulai dari 2 karena baris pertama untuk header
foreach($result as $data) {
    $activeWorksheet->setCellValue('A' . $rowNumber, $data['tanggal']);
    $activeWorksheet->setCellValue('B' . $rowNumber, $data['nama_produk']);
    $activeWorksheet->setCellValue('C' . $rowNumber, $data['qty_terjual']);
    $activeWorksheet->setCellValue('D' . $rowNumber, $data['total_harga_dasar']);
    $activeWorksheet->setCellValue('E' . $rowNumber, $data['total_harga_jual']);
    $rowNumber++;
}

// Format nama file
$date = date('Y-m-d_H-i-s');
$filename = "Penjualan_$date";

// Menulis file ke output standar untuk diunduh
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
header('Cache-Control: max-age=0');

// Menulis file ke output standar
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;

