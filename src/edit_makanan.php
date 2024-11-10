<?php

session_start();

require 'function.php';

if(!isset($_SESSION["login"])) {
    header("Location: loginadmin.php");
    exit;
}

$nama = $_GET['nama'];

$select = "SELECT * FROM makanan WHERE nama = '$nama'";
$sql_select = mysqli_query($conn, $select);
$detail = mysqli_fetch_assoc($sql_select);

$namafilekosong = $detail['gambar'];

if(isset($_POST["submit"])) {

    $namafile = $_FILES['gambar']['name'];

    if($namafile == NULL) {
        $namafile = $namafilekosong;
    }

    $id_makanan = $_POST["id"];
    $nama = $_POST["nama"];
    $detail = $_POST["detail"];
    $harga = $_POST["harga"];
    $stok = $_POST["stok"];

    $gambar = uploadMakanan();
    if(!$gambar) {
        return false;
    }

    $query = "UPDATE makanan SET gambar = '$namafile', nama = '$nama', detail = '$detail', harga = '$harga', stok = '$stok' WHERE id_makanan = '$id_makanan'";

    mysqli_query($conn, $query);

    header("Location: dashboard_admin.php");
    exit;
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="edit_makanan.css">
    <title>Edit</title>
</head>

<body>
    <div class="container">
        <img class="logo" src="asset/logotrizaria.svg">
        <div class="container1">
            <div class="imagecon">
                <img class="gambarmakanan" src="../asset_database/makanan/<?= $detail["gambar"]; ?>">
            </div>
            <div class="detailcon">
                <h2><?= $detail["nama"]; ?></h2>
                <p><?= $detail["detail"]; ?></p>
                <h2><?= $detail["harga"]; ?></h2>
                <h2><?= $detail["stok"]; ?></h2>
            </div>
        </div>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="container2">
                <input name="id" type="hidden" value="<?= $detail["id_makanan"]; ?>">
                <div class="inputgambar">
                    <img class="gambarmakananinput" src="../asset_database/makanan/<?= $detail["gambar"]; ?>">
                    <label for="file-upload" class="custom-file-label">Choose File</label>
                    <input class="file-input" name="gambar" type="file" id="file-upload">
                    <span id="file-name" class="file-name"></span>
                </div>
                <input class="inputother" name="nama" type="text" placeholder="nama" value="<?= $detail["nama"]; ?>">
                <input class="inputother" name="detail" type="text" placeholder="detail"
                    value="<?= $detail["detail"]; ?>">
                <input class="inputother" name="harga" type="number" placeholder="harga"
                    value="<?= $detail["harga"]; ?>">
                <input class="inputother" name="stok" type="number" placeholder="stok" value="<?= $detail["stok"]; ?>">
                <button name="submit" type="submit">
                    <h2 class="textbutton">Submit</h2>
                </button>
            </div>
        </form>
    </div>
</body>

</html>