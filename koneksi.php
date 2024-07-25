<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kasir";

// membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// // Cek koneksi
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
// echo "Connected successfully";

//fumnction
function formatRupiah($angka) {
    return 'Rp ' . number_format($angka, 2, ',', '.');
}