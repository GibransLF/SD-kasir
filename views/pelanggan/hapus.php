<?php 
require "../../koneksi.php";

//cari data dari ID pada url
$id_pelanggan = $_GET["id"];
$sql= "DELETE FROM pelanggan WHERE id_pelanggan = $id_pelanggan;";
$result = $conn->query($sql);
if ($conn->query($sql) === TRUE) {
    header("location: index.php");
  } else {
    echo "Error deleting record: " . $conn->error;
  }