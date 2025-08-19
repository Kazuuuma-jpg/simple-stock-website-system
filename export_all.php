<?php
require 'function.php';
require 'cek.php';

// Atur header agar browser mengunduh file sebagai Excel
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan-seluruh-data.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<h2>Laporan Seluruh Data Inventaris</h2>";

// ==========================================================
// Bagian 1: Tabel Stok Barang
// ==========================================================
echo "<h3>Tabel Stok Barang</h3>";
echo "<table border='1'>";
echo "<thead><tr><th>No</th><th>Nama Barang</th><th>Deskripsi</th><th>Stok</th></tr></thead>";
echo "<tbody>";

$ambilsemuadatastock = mysqli_query($conn, "SELECT * FROM stock");
$i = 1;
while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
    echo "<tr>";
    echo "<td>" . $i++ . "</td>";
    echo "<td>" . $data['namabarang'] . "</td>";
    echo "<td>" . $data['deskripsi'] . "</td>";
    echo "<td>" . $data['stock'] . "</td>";
    echo "</tr>";
}

echo "</tbody></table>";

echo "<br><br>";

// ==========================================================
// Bagian 2: Tabel Barang Masuk
// ==========================================================
echo "<h3>Tabel Barang Masuk</h3>";
echo "<table border='1'>";
echo "<thead><tr><th>No</th><th>Tanggal</th><th>Nama Barang</th><th>Jumlah</th><th>Keterangan</th></tr></thead>";
echo "<tbody>";

$ambilsemuadatamasuk = mysqli_query($conn, "SELECT m.tanggal, s.namabarang, m.qty, m.keterangan FROM masuk m, stock s WHERE m.idbarang = s.idbarang");
$i = 1;
while ($data = mysqli_fetch_array($ambilsemuadatamasuk)) {
    echo "<tr>";
    echo "<td>" . $i++ . "</td>";
    echo "<td>" . $data['tanggal'] . "</td>";
    echo "<td>" . $data['namabarang'] . "</td>";
    echo "<td>" . $data['qty'] . "</td>";
    echo "<td>" . $data['keterangan'] . "</td>";
    echo "</tr>";
}

echo "</tbody></table>";

echo "<br><br>";

// ==========================================================
// Bagian 3: Tabel Barang Keluar
// ==========================================================
echo "<h3>Tabel Barang Keluar</h3>";
echo "<table border='1'>";
echo "<thead><tr><th>No</th><th>Tanggal</th><th>Nama Barang</th><th>Jumlah</th><th>Penerima</th></tr></thead>";
echo "<tbody>";

$ambilsemuadatakuar = mysqli_query($conn, "SELECT k.tanggal, s.namabarang, k.qty, k.penerima FROM keluar k, stock s WHERE k.idbarang = s.idbarang");
$i = 1;
while ($data = mysqli_fetch_array($ambilsemuadatakuar)) {
    echo "<tr>";
    echo "<td>" . $i++ . "</td>";
    echo "<td>" . $data['tanggal'] . "</td>";
    echo "<td>" . $data['namabarang'] . "</td>";
    echo "<td>" . $data['qty'] . "</td>";
    echo "<td>" . $data['penerima'] . "</td>";
    echo "</tr>";
}

echo "</tbody></table>";
?>