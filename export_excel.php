<?php
require 'function.php';
require 'cek.php';

// Atur header agar browser mengunduh file sebagai Excel
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan-stok-barang.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Ambil data dari tabel stock
$sql = "SELECT * FROM stock";
$result = mysqli_query($conn, $sql);

// Tampilkan header kolom tabel di Excel
echo "No\tNama Barang\tDeskripsi\tStok\n";

$i = 1;
// Loop data dan tampilkan di Excel
while($data = mysqli_fetch_array($result)){
    echo $i++ . "\t" . $data['namabarang'] . "\t" . $data['deskripsi'] . "\t" . $data['stock'] . "\n";
}
?>