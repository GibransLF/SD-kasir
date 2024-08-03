<?php 
require "../../koneksi.php";
require "../../function.php";

$sql = "SELECT * FROM penjualan 
        LEFT JOIN produk ON penjualan.produk_id = produk.id_produk
        LEFT JOIN pelanggan ON penjualan.pelanggan_id = pelanggan.id_pelanggan";

$terlaris = "SELECT * FROM penjualan 
LEFT JOIN produk ON penjualan.produk_id = produk.id_produk
LEFT JOIN pelanggan ON penjualan.pelanggan_id
ORDER BY qty_terjual DESC LIMIT 1";

//search
//jika button cari di klik
if(isset($_GET['cari'])){
    //cek tanggal
    if($_GET['tgl_awal'] > $_GET['tgl_akhir']){
        echo "<script>alert('tanggal Akhir tidak bisa lebih kecil dari tanggal Awal');</script>";

        $_GET['tgl_awal']= '';
        $_GET['tgl_akhir'] = '';
    }

    $pelanggan = $_GET['pelanggan'];
    $produk = $_GET['produk'];
    $tgl_awal = $_GET['tgl_awal'];
    $tgl_akhir = $_GET['tgl_akhir'];
    
    if($pelanggan == ""){
        $sql .= " WHERE NOT nama = ''";
    }
    else{
        $sql .= " WHERE nama LIKE '%$pelanggan%'";
    }

    if($produk == ""){
        $sql .= " AND NOT nama_produk = ''";
    }
    else{
        $sql .= " AND nama_produk LIKE '%$produk%'";
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
    $laris = $conn->query($terlaris);
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
            <form action="exportXlsx.php" method="post">
                <button type="submit" name="export" style="padding: 12px;">Export to Excel</button>
            </form>
            <!-- search -->
            <form action="" method="get" style="margin: 10px;">
                <input style="width: 30vh;" type="text" name="pelanggan" placeholder="Cari Nama Pelanggan..." value="<?= isset($_GET['pelanggan']) ? $_GET['pelanggan'] : ''; ?>">
                <input style="width: 30vh;" type="text" name="produk" placeholder="Cari Nama Produk..." value="<?= isset($_GET['produk']) ? $_GET['produk'] : ''; ?>">
                <input style="width: 20vh;" type="date" name="tgl_awal" value="<?= isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : ''; ?>">
                &nbsp;~&nbsp;
                <input style="width: 20vh;" type="date" name="tgl_akhir" value="<?= isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : ''; ?>">
                <button type="submit" name="cari">Cari</button>
            </form>
            <a href="tambah.php">
                <button style="float:right; padding: 12px;">Tambah Penjualan +</button>
            </a>
        </div>
        <table>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Pelanggan</th>
                <th>Nama Produk</th>
                <th>Qty Terjual</th>
                <th>Total Harga Dasar</th>
                <th>Total Harga Jual</th>
                <th>Action</th>
            </tr>

            <?php
            $no = 1;
            $sum_harga_dasar = 0;
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
                            <?= htmlspecialchars($data["nama"]) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($data["nama_produk"]) ?>
                        </td>
                        <td>
                            <?= $data['qty_terjual'] ?>
                        </td>
                        <td>
                            <?= formatRupiah($data["total_harga_dasar"]) ?>
                        </td>
                        <td>
                            <?= formatRupiah($data["total_harga_jual"]) ?>
                        </td>
                        <td style="text-align: center">
                            <a href="ubah.php?id= <?= $data['id_penjualan'] ?>">Ubah</a>
                            &nbsp; | &nbsp;
                            <a href="hapus.php?id= <?= $data["id_penjualan"] ?>&id_produk=<?= $data['produk_id'] ?>&qty=<?= $data['qty_terjual'] ?>" onclick="return confirm('apakah anda yakin ingin menghapusnya?')">Hapus</a>
                        </td>
                    </tr>

                    <?php
                    $no++;
                    $sum_harga_dasar += $data["total_harga_dasar"];
                    $sum_harga_jual += $data["total_harga_jual"];
                }
            }
            else{
                echo "<tr>";
                    echo "<td colspan=7 style='text-align: center'>";
                        echo "0 result";
                    echo "</td>";
                echo "</tr>";
                
            }
            ?>
            <tr>
                <th colspan="5">Total Penjualan</th>
                <th><?= formatRupiah($sum_harga_dasar) ?></th>
                <th><?= formatRupiah($sum_harga_jual) ?></th>
                <th>&nbsp;</th>
            </tr>
            <tr>
                <th colspan="5">Total Laba</th>
                <th colspan="2"><?= formatRupiah($sum_harga_jual - $sum_harga_dasar) ?></th>
                <th>Action</th>
            </tr>
        </table>
    </section>
    <br>
    <br>
    Terlaris
    <br>
    <section>
        <table>
            <tr>
                <th>No</th>
                <th>nama Produk</th>
                <th>Harga Dasar</th>
                <th>Harga Jual</th>
                <th>Qty Terjual</th>
                <th>Total Harga Dasar</th>
                <th>Total Harga Jual</th>
            </tr>
            <?php
            $no = 1;
            if (mysqli_num_rows($result) > 0) {
                foreach($laris as $data) {
                    ?>
                    <tr>
                        <td style="text-align: center">
                            <b><?= $no ?></b>
                        </td>
                        <td>
                            <?= htmlspecialchars($data["nama_produk"]) ?>
                        </td>
                        <td>
                            <?= formatRupiah($data["harga_awal"]) ?>
                        </td>
                        <td>
                            <?= formatRupiah($data["harga_jual"]) ?>
                        </td>
                        <td>
                            <?= $data['qty_terjual'] ?>
                        </td>
                        <td>
                            <?= formatRupiah($data["total_harga_dasar"]) ?>
                        </td>
                        <td>
                            <?= formatRupiah($data["total_harga_jual"]) ?>
                        </td>
                    </tr>

                    <?php
                    $no++;
                    $sum_harga_dasar += $data["total_harga_dasar"];
                    $sum_harga_jual += $data["total_harga_jual"];
                }
            }
            else{
                echo "<tr>";
                    echo "<td colspan=8 style='text-align: center'>";
                        echo "0 result";
                    echo "</td>";
                echo "</tr>";
                
            }
            ?>
            <tr>
                <th>No</th>
                <th>nama Produk</th>
                <th>Harga Dasar</th>
                <th>Harga Jual</th>
                <th>Qty Terjual</th>
                <th>Total Harga Dasar</th>
                <th>Total Harga Jual</th>
            </tr>
        </table>
    </section>
    <!-- end content -->
    <br>
    <a href="../laporan/index.php">Laporan Penjualan Bulanan</a>
    <br><br>
    <a href="../produk/index.php">Produk</a>
    <br>
    <a href="../pelanggan/index.php">Pelanggan</a>
</body>
</html>