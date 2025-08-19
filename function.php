<?php
session_start(); // Memulai session
$conn = mysqli_connect("localhost", "root", "", "barang"); // Koneksi ke database

// -------------------------------
// Menambah barang baru ke tabel stock
// -------------------------------
if (isset($_POST['addnewbarang'])) {
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    // Stok awal diset 0, karena penambahan stok hanya dilakukan di "Barang Masuk"
    $stock = 0;

    // Query untuk menyimpan barang baru ke database
    $addtotable = mysqli_query($conn, "INSERT INTO stock (namabarang, deskripsi, stock) VALUES('$namabarang','$deskripsi','$stock')");

    // Redirect ke index.php setelah proses
    if ($addtotable) {
        header('Location: index.php');
        exit(); // Tambahkan exit() untuk menghentikan eksekusi
    } else {
        echo 'Gagal';
        header('Location: index.php');
        exit(); // Tambahkan exit() untuk menghentikan eksekusi
    }
}

// -------------------------------
// Menambahkan data barang masuk
// -------------------------------
if (isset($_POST['barangmasuk'])) {
    $barangnya = $_POST['barangnya'];
    $keterangan = $_POST['keterangan'];
    $qty = $_POST['qty'];

    // Mengambil data stok saat ini dari tabel stock
    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);
    $stocksekarang = $ambildatanya['stock'];

    // Menambahkan jumlah stok saat ini dengan qty yang masuk
    $tambahkanstocksekarangdenganquantity = $stocksekarang + $qty;

    // Simpan ke tabel masuk dan update jumlah stok
    $addtomasuk = mysqli_query($conn, "INSERT INTO masuk (idbarang, keterangan, qty) VALUES('$barangnya','$keterangan','$qty')");
    $updatestockmasuk = mysqli_query($conn, "UPDATE stock SET stock='$tambahkanstocksekarangdenganquantity' WHERE idbarang='$barangnya'");

    // Redirect ke halaman masuk.php setelah proses
    if ($addtomasuk && $updatestockmasuk) {
        header('Location: masuk.php');
        exit(); // Tambahkan exit() untuk menghentikan eksekusi
    } else {
        echo 'Gagal';
        header('Location: masuk.php');
        exit(); // Tambahkan exit() untuk menghentikan eksekusi
    }
}

// -------------------------------
// Menambahkan data barang keluar
// -------------------------------
if (isset($_POST['barangkeluar'])) {
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    // Mengambil data stok saat ini
    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);
    $stocksekarang = $ambildatanya['stock'];

    // Validasi stok: pastikan stok mencukupi
    if ($stocksekarang >= $qty) {
        // Kurangi stok dengan qty yang keluar
        $kurangkanstocksekarangdenganquantity = $stocksekarang - $qty;

        // Simpan ke tabel keluar dan update stok di tabel stock
        $addtokeluar = mysqli_query($conn, "INSERT INTO keluar (idbarang, penerima, qty) VALUES('$barangnya','$penerima','$qty')");
        $updatestockkeluar = mysqli_query($conn, "UPDATE stock SET stock='$kurangkanstocksekarangdenganquantity' WHERE idbarang='$barangnya'");

        // Redirect ke halaman keluar.php
        if ($addtokeluar && $updatestockkeluar) {
            header('Location: keluar.php');
            exit(); // Tambahkan exit() untuk menghentikan eksekusi
        } else {
            echo 'Gagal';
            header('Location: keluar.php');
            exit(); // Tambahkan exit() untuk menghentikan eksekusi
        }
    } else {
        // Jika stok tidak cukup, tampilkan alert dan tetap redirect ke keluar.php
        echo '
        <script>
            alert("Stok saat ini tidak mencukupi");
            window.location.href="keluar.php";
        </script>
        ';
    }
}

// -------------------------------
// Update info barang
// -------------------------------
if(isset($_POST['updatebarang'])){
    $idbarang = $_POST['idb']; // Menggunakan idb yang dikirim dari form
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];

    // Perbaikan: mysqli_wuery menjadi mysqli_query
    // Perbaikan: Menghilangkan koma setelah deskripsi dan menggunakan WHERE idbarang='$idbarang'
    $update = mysqli_query($conn, "UPDATE stock SET namabarang='$namabarang', deskripsi='$deskripsi' WHERE idbarang='$idbarang'");
    
    if($update){
        header('Location: index.php');
        exit(); // Tambahkan exit() untuk menghentikan eksekusi
    } else {
        echo 'Gagal';
        header('Location: index.php'); // Perbaikan: diarahkan kembali ke index.php
        exit(); // Tambahkan exit() untuk menghentikan eksekusi
    }
}

// -------------------------------
// Menghapus barang dari tabel stock
// -------------------------------
if(isset($_POST['hapusbarang'])){
    $idb = $_POST['idb']; // Mengambil idbarang dari form

    $hapus = mysqli_query($conn, "DELETE FROM stock WHERE idbarang='$idb'");

    if($hapus){
        header('Location: index.php');
        exit();
    } else {
        echo 'Gagal';
        header('Location: index.php');
        exit();
    }
}

// -------------------------------
// EDIT dan HAPUS data Barang Masuk
// -------------------------------

// Update (Edit) data barang masuk
if(isset($_POST['updatebarangmasuk'])){
    $idm = $_POST['idm'];
    $new_qty = $_POST['qty'];
    $new_keterangan = $_POST['keterangan'];
    $new_idb = $_POST['new_idb'];

    // Ambil data lama dari database
    $get_old_data = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk = '$idm'");
    $old_data = mysqli_fetch_array($get_old_data);
    $old_qty = $old_data['qty'];
    $old_idb = $old_data['idbarang'];
    
    // Periksa apakah ID barang berubah
    if ($old_idb != $new_idb) {
        // Kasus: Nama barang DIUBAH
        // Kurangi stok barang lama
        $get_old_stock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang = '$old_idb'");
        $old_stock_data = mysqli_fetch_array($get_old_stock);
        $old_stock = $old_stock_data['stock'];
        $new_old_stock = $old_stock - $old_qty;

        $update_old_stock = mysqli_query($conn, "UPDATE stock SET stock = '$new_old_stock' WHERE idbarang = '$old_idb'");

        // Tambah stok barang baru
        $get_new_stock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang = '$new_idb'");
        $new_stock_data = mysqli_fetch_array($get_new_stock);
        $new_stock = $new_stock_data['stock'];
        $final_new_stock = $new_stock + $new_qty;

        $update_new_stock = mysqli_query($conn, "UPDATE stock SET stock = '$final_new_stock' WHERE idbarang = '$new_idb'");

        // Update data di tabel 'masuk'
        $update_masuk = mysqli_query($conn, "UPDATE masuk SET qty = '$new_qty', keterangan = '$new_keterangan', idbarang = '$new_idb' WHERE idmasuk = '$idm'");

        if($update_old_stock && $update_new_stock && $update_masuk){
            header('Location: masuk.php');
            exit();
        } else {
            echo 'Gagal';
            header('Location: masuk.php');
            exit();
        }

    } else {
        // Kasus: Nama barang TIDAK DIUBAH
        $selisih = $new_qty - $old_qty;
        
        // Ambil stok sekarang
        $get_stock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang = '$old_idb'");
        $stock_data = mysqli_fetch_array($get_stock);
        $current_stock = $stock_data['stock'];
        $final_stock = $current_stock + $selisih;

        // Update stok barang di tabel 'stock'
        $update_stock = mysqli_query($conn, "UPDATE stock SET stock = '$final_stock' WHERE idbarang = '$old_idb'");
        
        // Update data di tabel 'masuk'
        $update_masuk = mysqli_query($conn, "UPDATE masuk SET qty = '$new_qty', keterangan = '$new_keterangan' WHERE idmasuk = '$idm'");
        
        if($update_stock && $update_masuk){
            header('Location: masuk.php');
            exit();
        } else {
            echo 'Gagal';
            header('Location: masuk.php');
            exit();
        }
    }
}


// Hapus data barang masuk
if(isset($_POST['hapusbarangmasuk'])){
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $qty = $_POST['qty'];

    // Ambil data stok sekarang dari tabel 'stock'
    $ambilsemuastock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang = '$idb'");
    $data = mysqli_fetch_array($ambilsemuastock);
    $stok = $data['stock'];

    // Kurangi stok barang
    $newstok = $stok - $qty;

    // Hapus data dari tabel 'masuk'
    $hapusmasuk = mysqli_query($conn, "DELETE FROM masuk WHERE idmasuk = '$idm'");

    // Update stok barang di tabel 'stock'
    $updatestok = mysqli_query($conn, "UPDATE stock SET stock = '$newstok' WHERE idbarang = '$idb'");

    if($hapusmasuk && $updatestok){
        header('Location: masuk.php');
        exit();
    } else {
        echo 'Gagal';
        header('Location: masuk.php');
        exit();
    }
}
?>