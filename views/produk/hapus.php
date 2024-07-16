<?php 
require "../../koneksi.php";

//cari data dari ID pada url
$id_produk = $_GET["id"];
$sql= "DELETE FROM produk WHERE id_produk = $id_produk;";
$result = $conn->query($sql);
if ($conn->query($sql) === TRUE) {
    header("location: index.php");
  } else {
    echo "Error deleting record: " . $conn->error;
  }