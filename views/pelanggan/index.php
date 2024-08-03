<?php 
require "../../koneksi.php";
require "../../function.php";

$sql = "SELECT * FROM pelanggan";

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
    <title>Kasir | Pelanggan</title>
</head>
<body>
    <header>
        <a href="../../">HomePage</a> / Pelanggan
    </header>
        
    <!-- content -->
    <h1 style="text-align:center">Kasir</h1>
    <section>
        <a href="tambah.php">
            <button style="float:right; margin:10px; padding: 12px;">Tambah Pelanggan +</button>
        </a>
        <table>
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>No Telepon</th>
                <th>Action</th>
            </tr>

            <?php
            $no = 1;
            if (mysqli_num_rows($result) > 0) {
                foreach($result as $pelanggan) {
                    ?>
                    <tr>
                        <td style="text-align: center">
                            <?= $no ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($pelanggan["nama"]) ?>
                        </td>
                        <td>
                            <?=$pelanggan["no_hp"] ?>
                        </td>
                        <td style="text-align: center">
                            <a href="ubah.php?id= <?= $pelanggan['id_pelanggan'] ?>">Ubah</a>
                            &nbsp; | &nbsp;
                            <a href="hapus.php?id= <?= $pelanggan["id_pelanggan"] ?>" onclick="return confirm('apakah anda yakin ingin menghapusnya?')">Hapus</a>
                        </td>
                    </tr>

                    <?php
                    $no++;
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
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>No Telepon</th>
                <th>Action</th>
            </tr>
        </table>
    </section>
    <!-- end content -->
    <br><br>
    <a href="../produk/index.php">Produk</a>
    <br>
    <a href="../penjualan/index.php">Penjualan</a>
</body>
</html>