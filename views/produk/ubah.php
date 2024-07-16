<?php 
require "../../koneksi.php";

//cari data dari ID pada url
$id_produk = $_GET["id"];
$sql= "SELECT * FROm produk WHERE id_produk='$id_produk';";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
} else {
    echo "Data produk tidak ditemukan";
    die();
}

//jika tombol ubah di tekan
if(isset($_POST["ubah"])){
    $nama_produk = $_POST["nama"];
    $qty_awal = $_POST["qty"];
    $harga_jual = $_POST["harga"];

    if($qty_awal < 0 || !$nama_produk || !$harga_jual){
        echo "<script>alert('Data Harus diIsi!')</script>";
    }
    else{
        $sql = "UPDATE produk SET nama_produk = '$nama_produk', qty_awal = '$qty_awal', harga_jual = '$harga_jual' WHERE id_produk = $id_produk;";
    
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
        <a href="../../">HomePage</a> / <a href="index.php">Produk</a> / Ubah
    </header>

    <h1 style="text-align:center">Ubah Produk</h1>
    <form action="" method="post">
        <br><br>
        <label for="nama">Nama Produk:</label><br>
        <input type="text" id="nama" name="nama" value="<?= $data['nama_produk'] ?>" placeholder="<?= $data['nama_produk'] ?>"><br>
        <label for="qty">Quantity:</label><br>
        <input type="number" min="0" id="qty" name="qty" value="<?= $data['qty_awal'] ?>" placeholder="<?= $data['qty_awal'] ?>"><br>
        <label for="harga">Harga Jual:</label><br>
        <input type="number" min="1" id="harga" name="harga" value="<?= $data['harga_jual'] ?>" placeholder="<?= $data['harga_jual'] ?>">
        <div style="position: flex">
            <a href="index.php"><button type="button">Kembali</button></a>
            <button type="submit" name="ubah">Ubah</button>
        </div>
    </form>
</body>
</html>