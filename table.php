<?php
require "koneksi.php";

//membbuat tabel produk
//cek tabel produk
$query = "SHOW TABLES LIKE 'produk'";
$result = mysqli_query($conn, $query);
$tableExists = mysqli_num_rows($result) > 0;

//membuat tabel produk
if(!$tableExists){
    $sql = "CREATE TABLE produk (
        id_produk INT PRIMARY KEY AUTO_INCREMENT,
        nama_produk VARCHAR(255),
        qty_awal INT(11),
        harga_awal INT(11),
        harga_jual INT(11),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if (mysqli_query($conn, $sql)) {
    echo "Table Produk berhasil di buat <br>";
    } else {
    echo "Error membuat tabel Produk <br>" . mysqli_error($conn);
    }
}
//end produk

//membbuat tabel pelanggan
//cek tabel pelanggan
$query = "SHOW TABLES LIKE 'pelanggan'";
$result = mysqli_query($conn, $query);
$tableExists = mysqli_num_rows($result) > 0;

//membuat tabel pelanggan
if(!$tableExists){
    $sql = "CREATE TABLE pelanggan (
        id_pelanggan INT PRIMARY KEY AUTO_INCREMENT,
        nama VARCHAR(255),
        no_hp VARCHAR(20),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if (mysqli_query($conn, $sql)) {
    echo "Table Pelanggan berhasil di buat <br>";
    } else {
    echo "Error membuat tabel Pelanggan <br>" . mysqli_error($conn);
    }
}
//end pelanggan

//membuat tabel Penjualan
//cek tabel Penjualan
$query = "SHOW TABLES LIKE 'penjualan'";
$result = mysqli_query($conn, $query);
$tableExists = mysqli_num_rows($result) > 0;

//membuat tabel penjualan
if(!$tableExists){
    $sql = "CREATE TABLE penjualan (
        id_penjualan INT(11) AUTO_INCREMENT PRIMARY KEY,
        tanggal DATE,
        produk_id INT(11),
        pelanggan_id INT(11),
        qty_terjual INT(11),
        total_harga_dasar INT(11),
        total_harga_jual INT(11),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        
        FOREIGN KEY (produk_id) REFERENCES produk(id_produk),
        FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(id_pelanggan)
    )";

if (mysqli_query($conn, $sql)) {
    echo "Table Penjualan berhasil di buat <br>";
} else {
    echo "Error membuat tabel Penjualan <br>" . mysqli_error($conn);
}
}
//end penjualan

echo "<br>membuat tabel selesai <br>";
mysqli_close($conn);

?>
<a href="index.html">pergi ke home page</a>