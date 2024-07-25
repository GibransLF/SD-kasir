<?php 
require "../../koneksi.php";

$sql = "SELECT * FROM penjualan LEFT JOIN produk ON penjualan.produk_id = produk.id_produk";

//search
//jika button cari di klik
if(isset($_GET['cari'])){
    //cek tanggal
    if($_GET['tgl_awal'] > $_GET['tgl_akhir']){
        echo "<script>alert('tanggal Akhir tidak bisa lebih kecil dari tanggal Awal');</script>";

        $_GET['tgl_awal']= '';
        $_GET['tgl_akhir'] = '';
    }

    $produk = $_GET['produk'];
    $tgl_awal = $_GET['tgl_awal'];
    $tgl_akhir = $_GET['tgl_akhir'];
    
    if($produk == ""){
        $sql .= " WHERE NOT nama_produk = ''";
    }
    else{
        $sql .= " WHERE nama_produk LIKE '%$produk%'";
    }

    if($tgl_awal){
        if(!$tgl_akhir){
            $now = date('Y-m-d');
            $sql .= " AND tanggal BETWEEN '$tgl_awal' AND '$now'"; 
        }
        else{
            $sql .= " AND tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'"; 
        }
    }
}

try {
    $result = $conn->query($sql);
} 
catch (mysqli_sql_exception $e) {
    echo "Tabel tidak ditemukan <br>";
    echo "<a href='../../table.php'>buat Tabel</a>";
    die();
}
?>

<style>
body{
    padding: 30px; 
}

table, td, th {
    border: 1px solid black;
    padding: 4px;
}

table {
    border-collapse: collapse;
    width: 100%;
}
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir | Penjualan</title>
</head>
<body>
    <header>
        <a href="../../">HomePage</a> / Penjualan
    </header>
        
    <!-- content -->
    <h1 style="text-align:center">Kasir</h1>
    <section>
        <div style="display: flex; justify-content: space-between;  margin:10px;">
            <!-- search -->
            <form action="" method="get" style="margin: 10px;">
                <input style="width: 60vh;" type="text" name="produk" placeholder="Cari Nama Produk..." value="<?= isset($_GET['produk']) ? $_GET['produk'] : ''; ?>">
                <input style="width: 20vh;" type="date" name="tgl_awal" value="<?= isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : ''; ?>">
                &nbsp;~&nbsp;
                <input style="width: 20vh;" type="date" name="tgl_akhir" value="<?= isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : ''; ?>">
                <button type="submit" name="cari">Cari</button>
            </form>
            <a href="tambah.php">
                <button style="float:right; padding: 12px;">Tambah Produk +</button>
            </a>
        </div>
        <table>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Produk</th>
                <th>Qty Terjual</th>
                <th>Total Harga Jual</th>
            </tr>

            <?php
            $no = 1;
            $sum_harga_jual = 0;
            if (mysqli_num_rows($result) > 0) {
                foreach($result as $data) {
                    ?>
                    <tr>
                        <td style="text-align: center">
                            <b><?= $no ?></b>
                        </td>
                        <td style="text-align: center">
                            <?= $data["tanggal"] ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($data["nama_produk"]) ?>
                        </td>
                        <td>
                            Rp.<?= $data["total_harga_dasar"] ?>
                        </td>
                        <td>
                            Rp.<?= $data["total_harga_jual"] ?>
                        </td>
                    </tr>

                    <?php
                    $no++;
                    $sum_harga_jual += $data["total_harga_jual"];
                }
            }
            else{
                echo "<tr>";
                    echo "<td colspan=5 style='text-align: center'>";
                        echo "0 result";
                    echo "</td>";
                echo "</tr>";
                
            }
            ?>
            <tr>
                <th colspan="4">Total Harga Jual</th>
                <th>Rp.<?= $sum_harga_jual ?></th>
            </tr>
        </table>
    </section>
    <!-- end content -->
    <br><br>
    <a href="../produk/index.php">Produk</a>
</body>
</html>