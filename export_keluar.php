<?php
require 'function.php';
require 'cek.php';

// Atur header agar browser mengunduh file sebagai Excel
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan-barang-keluar.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Ambil data dari tabel keluar (join dengan tabel stock)
$sql = "SELECT k.tanggal, s.namabarang, k.qty, k.penerima FROM keluar k, stock s WHERE k.idbarang = s.idbarang";
$result = mysqli_query($conn, $sql);

// Tampilkan header kolom tabel di Excel
echo "No\tTanggal\tNama Barang\tJumlah\tPenerima\n";

$i = 1;
// Loop data dan tampilkan di Excel
while($data = mysqli_fetch_array($result)){
    echo $i++ . "\t" . $data['tanggal'] . "\t" . $data['namabarang'] . "\t" . $data['qty'] . "\t" . $data['penerima'] . "\n";
}
?>