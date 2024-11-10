<?php
session_start();
require 'koneksi.php';

if (empty($_SESSION['total'])) {
    header("Location: menu.php");
    exit;
}

//membuat nomor transaksi
date_default_timezone_set('Asia/Jakarta');
$nomor_transaksi = "PSN" . date('dmYHis');

if (isset($_POST['button_kembalian'])) {
    //mengambil uang diterima dan menjadikan sebagai session
    $uang_diterima = $_POST['uang_diterima'];
    $_SESSION['uangditerima'] = $uang_diterima;

    //menghitung kembalian
    $total = $_SESSION['total'];
    $kembalian = $uang_diterima - $total;
    $_SESSION['kembalian'] = $kembalian;

    //insert ke tabel pembayaran
    $query_pembayaran = mysqli_query($koneksi, "INSERT INTO pembayaran (jumlah_pembayaran, uang_diterima, uang_kembalian) VALUES ('$total', '$uang_diterima', '$kembalian')");

    //mengambil id pembayaran dan menjadikan sebagai session
    $res = mysqli_query($koneksi, "SELECT id_pembayaran FROM pembayaran ORDER BY id_pembayaran DESC LIMIT 1");
    $res = mysqli_fetch_assoc($res);
    $_SESSION['id_pembayaran'] = $res['id_pembayaran'];
}

if (isset($_POST['cetak'])) {
    //insert ke tabel transaksi
    $query_transaksi = mysqli_query($koneksi, "INSERT INTO transaksi (id_kasir, no_transaksi, nama_pelanggan) VALUES ('{$_SESSION['id_kasir']}', '$nomor_transaksi', '{$_SESSION['nama_pembeli']}')");

    //mengambil id transaksi dan menjadikan sebagai session
    $res = mysqli_query($koneksi, "SELECT id_transaksi FROM transaksi ORDER BY id_transaksi DESC LIMIT 1");
    $res = mysqli_fetch_assoc($res);
    $_SESSION['id_transaksi'] = $res['id_transaksi'];

    //redirect ke struk.php
    header("Location: struk.php");
}
// var_dump($_SESSION);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="pembayaran_kasir.css">
    <title>Pembayaran</title>
</head>

<body>
    <h1 class="title">Pembayaran</h1>
    <div class="container">
        <form class="container1" action="" method="POST">
            <h2 class="text">Total Pembayaran : <?php echo $_SESSION['total'] ?></h2>
            <input type="number" name="uang_diterima" placeholder="<?php echo isset($_SESSION['uangditerima']) ? $_SESSION['uangditerima'] : 0; ?>" required>
            <button type="submit" name="button_kembalian">Submit</button>
        </form>
        <form class="container2" action="" method="POST">
            <h2 class="text">Uang Kembali : <?php echo isset($_SESSION['kembalian']) ? $_SESSION['kembalian'] : 0; ?></h2>
            <button type="submit" name="cetak">Cetak Struk Transaksi</button>
        </form>
    </div>
</body>

</html>