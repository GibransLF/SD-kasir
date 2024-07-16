<?php 
require "../../koneksi.php";

//jika tombol tambah di tekan
if(isset($_POST["tambah"])){
    $nama_produk = $_POST["nama"];
    $qty_awal = $_POST["qty"];
    $harga_jual = $_POST["harga"];

    if(!$nama_produk || !$qty_awal || !$harga_jual){
        echo "<script>alert('Data Harus diIsi!')</script>";
    }
    else{
        $sql = "INSERT INTO produk (nama_produk, qty_awal, harga_jual) VALUES ('$nama_produk', '$qty_awal', '$harga_jual')";
    
        mysqli_query($conn, $sql);
    
        header("location: index.php");
    }
}
?>
<style>
body{
    padding: 30px; 
}

form{
    background-color: whitesmoke;
    position: relative;
    margin: auto;
    width: 50%;
    height: 50%;
    border: 3px solid black;
    padding: 24px;
    text-align: center;
}

label, input, button{
    margin: 6px;
}
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir | Tambah Produk</title>
</head>
<body>
    <header>
        <a href="../../">HomePage</a> / <a href="index.php">Produk</a> / Tambah
    </header>

    <h1 style="text-align:center">Tambah Produk</h1>
    <form action="" method="post">
        <br><br>
        <label for="nama">Nama Produk:</label><br>
        <input type="text" id="nama" name="nama"><br>
        <label for="qty">Quantity:</label><br>
        <input type="number" min="0" id="qty" name="qty"><br>
        <label for="harga">Harga Jual:</label><br>
        <input type="number" min="1" id="harga" name="harga">
        <div style="position: flex">
            <a href="index.php"><button type="button">Kembali</button></a>
            <button type="submit" name="tambah">Tambah</button>
        </div>
    </form>
</body>
</html>