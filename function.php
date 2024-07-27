<?php
// menambahkan foramt rupiah 
function formatRupiah($angka) {
    return 'Rp ' . number_format($angka, 2, ',', '.');
}