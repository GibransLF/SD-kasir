<?php 
require "../../koneksi.php";
require "../../function.php";

$monthNow = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');

$bulan = $monthNow;
$sql = "SELECT * FROM penjualan 
        LEFT JOIN produk ON penjualan.produk_id = produk.id_produk
        LEFT JOIN pelanggan ON penjualan.pelanggan_id
        WHERE MONTH(tanggal) = $bulan";

$terlaris = "SELECT * FROM penjualan 
            LEFT JOIN produk ON penjualan.produk_id = produk.id_produk
            LEFT JOIN pelanggan ON penjualan.pelanggan_id
            WHERE MONTH(tanggal) = $bulan
            ORDER BY qty_terjual DESC LIMIT 5";

//bulanutton cari di klik
if(isset($_GET['cari'])){
    //cek bulan

    $bulan = $_GET['bulan'];
    
    $sql = "SELECT * FROM penjualan 
        LEFT JOIN produk ON penjualan.produk_id = produk.id_produk
        LEFT JOIN pelanggan ON penjualan.pelanggan_id
        WHERE MONTH(tanggal) = $bulan";
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
        <a href="../../">HomePage</a> / <a href="../penjualan/index.php">Penjualan</a> / Laporan Penjualan Bulanan
    </header>
        
    <!-- content -->
    <h1 style="text-align:center">Kasir</h1>
    <section>
        <div style="display: flex; justify-content: space-between;  margin:10px;">
            <form action="exportXlsx.php?bulan=<?= $bulan ?>" method="post">
                <button type="submit" name="export" style="padding: 12px;">Export to Excel</button>
            </form>
            <!-- search -->
            <form action="" method="get" style="margin: 10px;">
            <select name="bulan" id="bulan" style="width:20vh">
                <option value="<?= $monthNow ?>" hidden><?= $monthNow ?></option>
                <?php for($numBulan = 1; $numBulan <13; $numBulan++) {?>

                <option value="<?= $numBulan ?>"><?= $numBulan ?></option>

                <?php
                } 
                ?>
            </select>
                <button type="submit" name="cari">Cari Bulan</button>
            </form>
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
                <th>Laba</th>
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
                        <td>
                            <?= formatRupiah($data["total_harga_jual"] - $data["total_harga_dasar"]) ?>
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
                <th colspan="5">Total Penjualan</th>
                <th><?= formatRupiah($sum_harga_dasar) ?></th>
                <th><?= formatRupiah($sum_harga_jual) ?></th>
                <th><?= formatRupiah($sum_harga_jual - $sum_harga_dasar) ?></th>
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
            if (mysqli_num_rows($laris) > 0) {
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
    <br><br>
    <a href="../produk/index.php">Produk</a>
    <br>
    <a href="../pelanggan/index.php">Pelanggan</a>
</body>
</html>