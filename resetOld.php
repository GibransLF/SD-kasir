<?php
require "koneksi.php";

//cek tabel penjualan
$query = "SHOW TABLES LIKE 'penjualan'";
$result = mysqli_query($conn, $query);
$tableExists = mysqli_num_rows($result) > 0;

if($tableExists){
    $sql = "DROP TABLE penjualan";

    if (mysqli_query($conn, $sql)) {
        echo "Table Penjualan berhasil di hapus <br>";
    } 
    else {
        echo "Error menghapus tabel Penjualan <br>";
    }
}
else{
    echo "Tabel Penjualan tidak ada. <br>";
}
//end penjualan

//cek tabel produk
$query = "SHOW TABLES LIKE 'produk'";
$result = mysqli_query($conn, $query);
$tableExists = mysqli_num_rows($result) > 0;

if($tableExists){
    $sql = "DROP TABLE produk";
    
    if (mysqli_query($conn, $sql)) {
        echo "Table Produk berhasil di hapus <br>";
    } 
    else {
        echo "Error menghapus tabel Produk <br>";
    }
}
else{
    echo "Tabel Produk tidak ada. <br>";
}
//end produk

echo "<br> reset selesai <br> <br>";
mysqli_close($conn);

?>
<a href="table.php">buat tabel</a>
<br>
<a href="index.html">pergi ke home page</a>
