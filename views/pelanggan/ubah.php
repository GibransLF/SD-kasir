<?php 
require "../../koneksi.php";

//cari data dari ID pada url
$id_pelanggan = $_GET["id"];
$sql= "SELECT * FROm pelanggan WHERE id_pelanggan='$id_pelanggan';";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
} else {
    echo "Data produk tidak ditemukan";
    die();
}

//jika tombol ubah di tekan
if(isset($_POST["ubah"])){
    $nama = $_POST["nama"];
    $no_hp = $_POST["no_hp"];

    if(!$nama || !$no_hp){
        echo "<script>alert('Data Harus diIsi!')</script>";
    }
    else{
        $sql = "UPDATE pelanggan SET nama = '$nama', no_hp = '$no_hp' WHERE id_pelanggan = $id_pelanggan;";
    
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
        <input type="text" id="nama" name="nama" value="<?= $data['nama'] ?>" placeholder="<?= $data['nama'] ?>"><br>
        <label for="no_hp">No Telepon:</label><br>
        <input type="number" min="0" id="no_hp" name="no_hp" value="<?= $data['no_hp'] ?>" placeholder="<?= $data['no_hp'] ?>"><br>
        <div style="position: flex">
            <a href="index.php"><button type="button">Kembali</button></a>
            <button type="submit" name="ubah">Ubah</button>
        </div>
    </form>
</body>
</html>