<?php
require 'function.php';
require 'cek.php';

// Mendapatkan nama file PHP yang sedang diakses
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Barang Masuk</title>

    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <style>
        .nav-link {
            display: flex;
            align-items: center;
            transition: all 0.3s ease; /* Menambahkan transisi untuk animasi */
        }
        
        .nav-link:hover {
            color: #fff !important;
            background-color: #343a40 !important;
        }
        
        /* Gaya untuk menu yang sedang aktif */
        .nav-link.active {
            font-weight: bold;
            background-color:  rgba(79, 98, 118, 1) !important; /* Warna latar belakang untuk menu aktif */
            color: #fff !important; /* Warna teks untuk menu aktif */
            border-left: 5px solid #ffc107; /* Garis kuning di sisi kiri */
            padding-left: 1rem; /* Menyesuaikan padding agar konten tidak terpotong */
        }

        .sb-nav-link-icon {
            margin-right: 0.5rem;
            width: 1.5rem; /* Memberikan lebar tetap agar semua ikon sejajar */
            display: flex;
            align-items: center;
            justify-content: center; /* Memastikan ikon selalu di tengah */
        }
    </style>
    </head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="index.php">Barang Masuk</a>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link <?= ($currentPage == 'index.php') ? 'active' : ''; ?>" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                            Stok Barang
                        </a>
                        <a class="nav-link <?= ($currentPage == 'masuk.php') ? 'active' : ''; ?>" href="masuk.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-import"></i></div>
                            Barang Masuk
                        </a>
                        <a class="nav-link <?= ($currentPage == 'keluar.php') ? 'active' : ''; ?>" href="keluar.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-export"></i></div>
                            Barang Keluar
                        </a>
                        <a class="nav-link" href="logout.php">
                            Log Out
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?php echo isset($_SESSION['email']) ? $_SESSION['email'] : 'Guest'; ?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1>Barang Masuk</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                Tambah Barang Masuk
                            </button>
                            <a href="export_masuk.php" class="btn btn-success">Cetak ke Excel</a>
                        </div>
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Mengambil semua data dari tabel 'masuk' dan 'stock'
                                    $ambilsemuadatastock = mysqli_query($conn, "SELECT * FROM masuk m, stock s WHERE m.idbarang = s.idbarang");
                                    if ($ambilsemuadatastock) {
                                        $i = 1;
                                        while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                                            $idm = $data['idmasuk']; // Ambil ID unik untuk operasi edit/hapus
                                            $idb = $data['idbarang'];
                                            $tanggal = $data['tanggal'];
                                            $namabarang = $data['namabarang'];
                                            $qty = $data['qty'];
                                            $keterangan = $data['keterangan'];
                                    ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $tanggal; ?></td>
                                        <td><?= $namabarang; ?></td>
                                        <td><?= $qty; ?></td>
                                        <td><?= $keterangan; ?></td>
                                        <td>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $idm; ?>">Edit</button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $idm; ?>">Hapus</button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="edit<?= $idm; ?>" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editLabel">Edit Data Barang Masuk</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="post">
                                                    <div class="modal-body">
                                                        <label for="new_idb">Nama Barang:</label>
                                                        <select name="new_idb" class="form-control mb-2" id="new_idb">
                                                            <?php
                                                                $ambilsemuastock_edit = mysqli_query($conn, "SELECT * FROM stock");
                                                                while ($data_edit = mysqli_fetch_array($ambilsemuastock_edit)) {
                                                                    $idbarang_edit = $data_edit['idbarang'];
                                                                    $namabarang_edit = $data_edit['namabarang'];
                                                                    $selected = ($idbarang_edit == $idb) ? 'selected' : '';
                                                            ?>
                                                                <option value="<?= $idbarang_edit; ?>" <?= $selected; ?>><?= $namabarang_edit; ?></option>
                                                            <?php
                                                                }
                                                            ?>
                                                        </select>
                                                        <br>
                                                        <label for="keterangan">Keterangan:</label>
                                                        <input type="text" name="keterangan" id="keterangan" value="<?= $keterangan; ?>" class="form-control mb-2" placeholder="Keterangan" required>
                                                        <br>
                                                        <label for="qty">Jumlah:</label>
                                                        <input type="number" name="qty" id="qty" value="<?= $qty; ?>" class="form-control mb-2" placeholder="Jumlah" required>
                                                        <br>
                                                        <input type="hidden" name="idm" value="<?= $idm; ?>">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-warning" name="updatebarangmasuk">Simpan Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="delete<?= $idm; ?>" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteLabel">Hapus Data Barang Masuk</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="post">
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus data **<?= $namabarang; ?>** dengan jumlah **<?= $qty; ?>**?
                                                        <input type="hidden" name="idb" value="<?= $idb; ?>">
                                                        <input type="hidden" name="idm" value="<?= $idm; ?>">
                                                        <input type="hidden" name="qty" value="<?= $qty; ?>">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-danger" name="hapusbarangmasuk">Hapus</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                        }
                                    } else {
                                        echo '<tr><td colspan="6">Error: ' . mysqli_error($conn) . '</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
            <script src="js/scripts.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
            <script src="js/datatables-simple-demo.js"></script>
            <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel">Tambah Barang Masuk</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post">
                            <div class="modal-body">
                                <label for="barangnya">Pilih Barang:</label>
                                <select name="barangnya" class="form-control" id="barangnya" required>
                                    <?php
                                    $ambilsemuadatastock_modal = mysqli_query($conn, "SELECT * FROM stock");
                                    if ($ambilsemuadatastock_modal) {
                                        while ($fetcharray = mysqli_fetch_array($ambilsemuadatastock_modal)) {
                                            $namabarangnya = $fetcharray['namabarang'];
                                            $idbarangnya = $fetcharray['idbarang'];
                                    ?>
                                    <option value="<?= $idbarangnya; ?>"><?= $namabarangnya; ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <br>
                                <label for="qty_masuk">Jumlah:</label>
                                <input type="number" id="qty_masuk" name="qty" placeholder="Jumlah barang yang masuk" class="form-control mb-2" required>
                                <br>
                                <label for="keterangan_masuk">Keterangan:</label>
                                <input type="text" id="keterangan_masuk" name="keterangan" class="form-control" placeholder="Keterangan (misal: 'Supplier A' atau 'Retur')" required>
                                <br>
                                <button type="submit" class="btn btn-primary" name="barangmasuk">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>