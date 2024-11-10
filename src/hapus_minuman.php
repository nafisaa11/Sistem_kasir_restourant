<?php

session_start();

require 'function.php';

if(!isset($_SESSION["login"])) {
    header("Location: loginadmin.php");
    exit;
}

$nama = $_GET['nama'];

$select = "SELECT * FROM minuman WHERE nama = '$nama'";
$sql_select = mysqli_query($conn, $select);

$detail = mysqli_fetch_assoc($sql_select);

if(isset($_POST["submit"])) {

    $id = $_POST["id"];

    if(isset($_POST["checkbox"])) {
        mysqli_query($conn, "DELETE FROM minuman WHERE id_minuman = $id");
        header("Location: dashboard_admin.php");
        exit;
    } else {    
        $error = 'checklist terlebih dahulu jika anda ingin menghapus menu <?= $detail["nama"] ?>';
}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="hapus_makanan.css">
    <title>Hapus Minumas</title>
</head>

<body>
    <div class="container">
        <img class="logo" src="asset/logotrizaria.svg">
        <div class="container1">
            <div class="imagecon">
                <img class="gambarmakanan" src="../asset_database/minuman/<?= $detail["gambar"]; ?>">
            </div>
            <div class="detailcon">
                <h2><?= $detail["nama"] ?></h2>
                <p><?= $detail["detail"] ?></p>
                <h2><?= $detail["harga"] ?></h2>
                <h2><?= $detail["stok"] ?></h2>
            </div>
        </div>
        <div class="container2">
            <form method="post" action="">
                <div class="concheck">
                    <input name="id" type="hidden" value="<?= $detail["id_minuman"] ?>">
                    <input class="checkbox" name="checkbox" type="checkbox">
                    <p>Apakah anda yakin menghapus menu <?= $detail["nama"] ?> ?</p>
                </div>
                <div class="buttonkembali">
                    <button name="submit" type="submit">
                        <h2>Hapus</h2>
                    </button>
                </div>
            </form>
        </div>
        <a href="dashboard_admin.php">
            <div class="buttonkembali">
                <h2 class="textbutton">Kembali</h2>
            </div>
        </a>
    </div>
</body>

</html>