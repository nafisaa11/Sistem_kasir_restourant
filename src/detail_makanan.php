<?php

session_start();

require 'connection.php';

if(!isset($_SESSION["login"])) {
    header("Location: loginadmin.php");
    exit;
}

$nama = $_GET['nama'];

$select = "SELECT * FROM makanan WHERE nama = '$nama'";
$sql_select = mysqli_query($conn, $select);

$detail = mysqli_fetch_assoc($sql_select);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="detail_makanan.css">
    <title>Detail Makanan</title>
</head>

<body>
    <div class="container">
        <img class="logo" src="asset/logotrizaria.svg">
        <div class="container1">
            <div class="imagecon">
                <img class="gambarmakanan" src="../asset_database/makanan/<?= $detail["gambar"]; ?>">
            </div>
            <div class="detailcon">
                <h2><?= $detail["nama"] ?></h2>
                <p><?= $detail["detail"] ?></p>
                <h2><?= $detail["harga"] ?></h2>
                <h2><?= $detail["stok"] ?></h2>
            </div>
        </div>
        <a href="dashboard_admin.php">
            <div class="buttonkembali">
                <h2 class="textbutton">Kembali</h2>
            </div>
        </a>
    </div>
    </div>
</body>


</html>