<?php
require "koneksi.php";
require_once 'vendor/autoload.php';

// use the factory to create a Faker\Generator instance


$faker = Faker\Factory::create("id_ID");
$sql = NULL;

for ($i = 0; $i < 5; $i++) {
    $nama_produk = $faker->word;
    $qty_awal = $faker->randomNumber(2,true);
    $harga_awal = $faker->randomFloat(0, 500, 100000);
    $harga_jual = $harga_awal + 500;

    $sql .= "INSERT INTO produk(nama_produk, qty_awal, harga_awal, harga_jual) VALUES ('$nama_produk', '$qty_awal', '$harga_awal', '$harga_jual');";

    echo "INSERT INTO produk(nama_produk, qty_awal, harga_jual) VALUES ('$nama_produk', '$qty_awal', '$harga_awal', '$harga_jual'); <br>";
}

if ($conn->multi_query($sql) === TRUE) {
    echo "<br>";
    echo "Data fake Produk berhasil di tambahkan!";
    echo "<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
<a href="index.html">pergi ke home page</a>