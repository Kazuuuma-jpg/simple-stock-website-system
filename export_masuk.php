<?php
require 'function.php';
require 'cek.php';

// Atur header agar browser mengunduh file sebagai Excel
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan-barang-masuk.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Ambil data dari tabel masuk (join dengan tabel stock)
$sql = "SELECT m.tanggal, s.namabarang, m.qty, m.keterangan FROM masuk m, stock s WHERE m.idbarang = s.idbarang";
$result = mysqli_query($conn, $sql);

// Tampilkan header kolom tabel di Excel
echo "No\tTanggal\tNama Barang\tJumlah\tKeterangan\n";

$i = 1;
// Loop data dan tampilkan di Excel
while($data = mysqli_fetch_array($result)){
    echo $i++ . "\t" . $data['tanggal'] . "\t" . $data['namabarang'] . "\t" . $data['qty'] . "\t" . $data['keterangan'] . "\n";
}
?>