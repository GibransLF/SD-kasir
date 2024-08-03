<?php
require '../../vendor/autoload.php';
require '../../koneksi.php';
require '../../function.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$bulan = $_GET['bulan'];
// Query untuk mengambil data dari tabel
$sql = "SELECT * FROM penjualan LEFT JOIN produk ON penjualan.produk_id = produk.id_produk
LEFT JOIN pelanggan ON penjualan.pelanggan_id = pelanggan.id_pelanggan WHERE MONTH(tanggal) = '$bulan'";
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
$activeWorksheet->setCellValue('B1', 'Nama Pelanggan');
$activeWorksheet->setCellValue('C1', 'Nama Produk');
$activeWorksheet->setCellValue('D1', 'Harga Awal');
$activeWorksheet->setCellValue('E1', 'Harga Jual');
$activeWorksheet->setCellValue('F1', 'Qty Terjual');
$activeWorksheet->setCellValue('G1', 'Total Harga Dasar');
$activeWorksheet->setCellValue('H1', 'Total Harga Jual');
$activeWorksheet->setCellValue('I1', 'Laba');

// Tambahkan data dari database ke spreadsheet
$rowNumber = 2; // Baris dimulai dari 2 karena baris pertama untuk header
$total_harga_dasar = 0;
$total_harga_jual = 0;

foreach($result as $data) {
    $activeWorksheet->setCellValue('A' . $rowNumber, $data['tanggal']);
    $activeWorksheet->setCellValue('B' . $rowNumber, $data['nama']);
    $activeWorksheet->setCellValue('C' . $rowNumber, $data['nama_produk']);
    $activeWorksheet->setCellValue('D' . $rowNumber, $data['harga_awal']);
    $activeWorksheet->setCellValue('E' . $rowNumber, $data['harga_jual']);
    $activeWorksheet->setCellValue('F' . $rowNumber, $data['qty_terjual']);
    $activeWorksheet->setCellValue('G' . $rowNumber, $data['total_harga_dasar']);
    $activeWorksheet->setCellValue('H' . $rowNumber, $data['total_harga_jual']);
    $activeWorksheet->setCellValue('I' . $rowNumber, $data['total_harga_jual'] - $data['total_harga_dasar']);
    $rowNumber++;

    $total_harga_dasar =+ $data['total_harga_dasar'];
    $total_harga_jual =+ $data['total_harga_jual'];
}

// Tambahkan footer
$activeWorksheet->setCellValue('G' . $rowNumber, 'Total');
$activeWorksheet->setCellValue('G' . $rowNumber, $total_harga_dasar);
$activeWorksheet->setCellValue('H' . $rowNumber, $total_harga_jual);
$activeWorksheet->setCellValue('I' . $rowNumber, $total_harga_jual - $total_harga_dasar);

// Format nama file
$date = date('Y-m-d_H-i-s');
$filename = $bulan . "Laporan_Penjualan_Bulanan_$date";

// Menulis file ke output standar untuk diunduh
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
header('Cache-Control: max-age=0');

// Menulis file ke output standar
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;

