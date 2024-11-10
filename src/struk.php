<?php
session_start();
require 'koneksi.php';

if (empty($_SESSION['nama_pembeli'])) {
    header("Location: inputnama_kasir.php");
    exit;
}

// Mengambil data tanggal transaksi terbaru dari tabel transaksi
$tanggal_transaksi = mysqli_query($koneksi, "SELECT tanggal_transaksi FROM transaksi ORDER BY id_transaksi DESC LIMIT 1");
$tanggal_transaksi = mysqli_fetch_assoc($tanggal_transaksi);
$tanggal_transaksi = $tanggal_transaksi['tanggal_transaksi'];

// Mengambil nomor transaksi terbaru dari tabel transaksi
$nomor_transaksi = mysqli_query($koneksi, "SELECT no_transaksi FROM transaksi ORDER BY id_transaksi DESC LIMIT 1");
$nomor_transaksi = mysqli_fetch_assoc($nomor_transaksi);
$nomor_transaksi = $nomor_transaksi['no_transaksi'];

// Insert ke tabel detail transaksi
foreach ($_SESSION['menu'] as $key => $value) {
    // Mengecek apakah menu yang dipesan ada di tabel makanan atau minuman dengan query exist
    $cek_menu_makanan = mysqli_query($koneksi, "SELECT EXISTS(SELECT * FROM makanan WHERE nama = '$key') AS exist");
    $cek_menu_makanan = mysqli_fetch_assoc($cek_menu_makanan)['exist'];
    
    if ($cek_menu_makanan == 1) {
        $menus_makanan = mysqli_query($koneksi, "SELECT * FROM makanan WHERE nama = '$key'");
        $menus_makanan = mysqli_fetch_assoc($menus_makanan);
        $total = $value * $menus_makanan['harga']; // Menghitung total harga untuk item makanan
        $query_menu_makanan = "INSERT INTO detail_transaksi (id_transaksi, id_pembayaran, id_makanan, id_minuman, kuantitas, harga_pesanan, total_harga) VALUES ('{$_SESSION['id_transaksi']}', '{$_SESSION['id_pembayaran']}', '{$menus_makanan['id_makanan']}', NULL, '$value', '{$menus_makanan['harga']}', '$total')";
        mysqli_query($koneksi, $query_menu_makanan);
    }

    $cek_menu_minuman = mysqli_query($koneksi, "SELECT EXISTS(SELECT * FROM minuman WHERE nama = '$key') AS exist");
    $cek_menu_minuman = mysqli_fetch_assoc($cek_menu_minuman)['exist'];
    
    if ($cek_menu_minuman == 1) {
        $menus_minuman = mysqli_query($koneksi, "SELECT * FROM minuman WHERE nama = '$key'");
        $menus_minuman = mysqli_fetch_assoc($menus_minuman);
        $total = $value * $menus_minuman['harga']; // Menghitung total harga untuk item minuman
        $query_menu_minuman = "INSERT INTO detail_transaksi (id_transaksi, id_pembayaran, id_makanan, id_minuman, kuantitas, harga_pesanan, total_harga) VALUES ('{$_SESSION['id_transaksi']}', '{$_SESSION['id_pembayaran']}', NULL, '{$menus_minuman['id_minuman']}', '$value', '{$menus_minuman['harga']}', '$total')";
        mysqli_query($koneksi, $query_menu_minuman);
    }
}

if (isset($_POST['logout'])) {
    // Menghapus session setelah data disimpan
    unset($_SESSION['nama_pembeli']);
    unset($_SESSION['menu']);
    unset($_SESSION['total']);
    unset($_SESSION['uangditerima']);
    unset($_SESSION['kembalian']);

    // Redirect ke dashboard_kasir.php
    header("Location: dashboard_kasir.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="struk.css">
</head>
<body>
    <div class="container">
        <div class="content">
            <div class="logo">
                <img src="asset/logoo.svg">
            </div>
            <div class="header">
                <h2>The Best Authentic Pizza</h2>
            </div>
            <div class="alamat">
                <p>Gedung AKA, Jl. Bangka Raya No.27C RT 004/007 Kelurahan Pela Mampang, Kecamatan Mampang Prapatan,</p>
                <p>Kota Administrasi Jakarta Selatan, DKI Jakarta.</p>
            </div>
            <div class="dashed-line"></div>
        </div>
        <div class="table">
            <div class="row">
                <div class="cell label">No. Bill</div>
                <div class="cell separator">:</div>
                <div class="cell"><?php echo $nomor_transaksi; ?></div>
            </div>
            <div class="row">
                <div class="cell label">Date</div>
                <div class="cell separator">:</div>
                <div class="cell"><?php echo $tanggal_transaksi . " WIB"; ?></div>
            </div>
            <div class="row">
                <div class="cell label">Cashier</div>
                <div class="cell separator">:</div>
                <div class="cell"><?php echo $_SESSION['nama_kasir']; ?></div>
            </div>
            <div class="row">
                <div class="cell label">Customer</div>
                <div class="cell separator">:</div>
                <div class="cell"><?php echo $_SESSION['nama_pembeli'] ?></div>
            </div>
        </div>
        <div class="dashed-line"></div>
        <?php foreach ($_SESSION['menu'] as $key => $value) : ?>
            <div class="menu">
                <div class="order">
                    <div class="pesanan"><?php echo $key ?></div>
                    <div class="jumlah"><?php echo $value ?></div>
                    <?php
                    $menus = mysqli_query($koneksi, "SELECT * FROM makanan WHERE nama = '$key' UNION SELECT * FROM minuman WHERE nama = '$key'");
                    $menu = mysqli_fetch_assoc($menus);
                    ?>
                    <div class="satuan"><?php echo $menu['harga'] ?></div>
                    <div class="harga"><?php echo $value * $menu['harga'] ?></div>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="dashed-line"></div>
        <div class="total">
            <div class="all">
                <div class="col price">Total Harga</div>
                <div class="col"><?php echo $_SESSION['total'] ?></div>
            </div>
            <div class="row">
                <div class="col price">Bayar</div>
                <div class="col"><?php echo $_SESSION['uangditerima'] ?></div>
            </div>
            <div class="row">
                <div class="col price">Kembali</div>
                <div class="col"><?php echo $_SESSION['kembalian'] ?></div>
            </div>
        </div>
        <form method="POST">
            <button class="submit-button" name="logout">Submit</button>
        </form>
    </div>
</body>
</html>
