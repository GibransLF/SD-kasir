<?php 
require "../../koneksi.php";
require "../../function.php";

// cari data ubah awals
$id_penjualan = $_GET["id"];
$sqlPenjualan= "SELECT * FROM penjualan 
        LEFT JOIN produk ON penjualan.produk_id = produk.id_produk
        LEFT JOIN pelanggan ON penjualan.pelanggan_id = pelanggan.id_pelanggan
        WHERE id_penjualan='$id_penjualan';";
// cari data produk untuk pilih produk
$sqlProduk = "SELECT * FROM produk";
$sqlPelanggan = "SELECT * FROM pelanggan";

try {
    $penjualan = $conn->query($sqlPenjualan);
    if ($penjualan->num_rows > 0) {
        $jualan = $penjualan->fetch_assoc();
    } else {
        echo "Data produk tidak ditemukan";
        die();
    }
    $produk = $conn->query($sqlProduk);
    $pelanggan = $conn->query($sqlPelanggan);
} 
catch (mysqli_sql_exception $e) {
    echo "Tabel tidak ditemukan <br>";
    echo "<a href='../../table.php'>buat Tabel</a>";
    die();
}

//jika tombol tambah di tekan
if(isset($_POST["ubah"])){
    $id_pelanggan = $_POST["id_pelanggan"];
    $id_produk = $_POST["id_produk"];
    $qty_terjual = $_POST["qty_terjual"];
    $qtyUbah = $_POST["qtyUbah"];
    $idProdukUbah = $_POST["idProdukUbah"];

    if(!$id_pelanggan || !$id_produk || !$qty_terjual){
        echo "<script>alert('Data Harus diIsi!')</script>";
    }
    else{
        //mengembalikan qty ke produk
        $rePorduk = "UPDATE produk SET qty_awal = qty_awal + '$qtyUbah' WHERE id_produk = '$idProdukUbah';";
        mysqli_query($conn, $rePorduk);

        //cari pelanggan berdasarkan  produk id yang di pilih
        $findIdProduk = "SELECT * FROM produk WHERE id_produk = '$id_produk'";
        $result = $conn->query($findIdProduk);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $harga_awal = $row['harga_awal'];
                $harga_jual = $row['harga_jual'];
            }
        } 
        else {
            echo "Produk tidak ditemukan";
        }

        //cari produk berdasarkan  produk id yang di pilih
        $findIdProduk = "SELECT * FROM produk WHERE id_produk = '$id_produk'";
        $result = $conn->query($findIdProduk);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $harga_awal = $row['harga_awal'];
                $harga_jual = $row['harga_jual'];
            }
        } 
        else {
            echo "Produk tidak ditemukan";
        }

        //count
        $total_harga_dasar = $qty_terjual * $harga_awal; 
        $total_harga_jual = $qty_terjual * $harga_jual;
        $tgl = date('Y-m-d');

        $sql = "UPDATE penjualan SET tanggal = '$tgl', produk_id = '$id_produk', pelanggan_id = '$id_pelanggan', qty_terjual = '$qty_terjual', total_harga_dasar = '$total_harga_dasar', total_harga_jual = '$total_harga_jual' WHERE id_penjualan = '$id_penjualan'";
    
        mysqli_query($conn, $sql);
        
        //mengurangi qty produk yang terjual
        $minCount = "UPDATE produk SET qty_awal = qty_awal - '$qty_terjual' WHERE id_produk = '$id_produk';";
        mysqli_query($conn, $minCount);

    
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
        <a href="../../">HomePage</a> / <a href="index.php">Penjualan</a> / Tambah
    </header>

    <h1 style="text-align:center">Tambah Penjualan</h1>
    <form action="" method="post">
        <input type="hidden" name="idProdukUbah" value="<?= $jualan['id_produk'] ?>">
        <input type="hidden" name="qtyUbah" value="<?= $jualan['qty_terjual'] ?>">
        <br><br>
        <select name="id_pelanggan" id="pilih_pelanggan">
            <option value="<?= $jualan['id_pelanggan'] ?>" hidden><?= $jualan['nama'] ?></option>
            <?php foreach($pelanggan as $data) {?>

            <option value="<?= $data['id_pelanggan'] ?>"><?= $data['nama']?></option>

            <?php } ?>
        </select>
        <br><br>
        <select name="id_produk" id="pilih_roduk">
            <option value="<?= $jualan['id_produk'] ?>" hidden><?= $jualan['nama_produk'] .' - '. formatRupiah($jualan['harga_jual']) . ' Buy: '. $jualan['qty_terjual'] ?></option>
            <?php foreach($produk as $data) {?>

            <option value="<?= $data['id_produk'] ?>"><?= $data['nama_produk'] .' - '. formatRupiah($data['harga_jual']).' - Qty: '. $data['qty_awal'] ?></option>

            <?php } ?>
        </select>
        <br><br>
        <label for="qty_terjual">Quantity Terjual:</label><br>
        <input type="number" min="0" id="qty_terjual" name="qty_terjual" value="<?= $jualan['qty_terjual'] ?>" placeholder="<?= $jualan['qty_terjual'] ?>"><br>
        <div style="position: flex">
            <a href="index.php"><button type="button">Kembali</button></a>
            <button type="submit" name="ubah">Ubah</button>
        </div>
    </form>
</body>
</html>