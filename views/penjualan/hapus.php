<?php 
require "../../koneksi.php";

//cari data dari ID pada url
$id_penjualan = $_GET["id"];
$idProdukUbah = $_GET["id_produk"];
$qtyUbah = $_GET["qty"];

//mengembalikan qty produk
  $rePorduk = "UPDATE produk SET qty_awal = qty_awal + '$qtyUbah' WHERE id_produk = '$idProdukUbah';";
  mysqli_query($conn, $rePorduk);

//delete
$sql= "DELETE FROM penjualan WHERE id_penjualan = $id_penjualan;";
$result = $conn->query($sql);
if ($conn->query($sql) === TRUE) {
    header("location: index.php");
  } else {
    echo "Error deleting record: " . $conn->error;
  }