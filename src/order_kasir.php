<?php
require 'koneksi.php';
session_start();

if (empty($_SESSION['total'])) {
    header("Location: menu.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="order_kasir.css">
    <title>Your Order</title>
</head>

<body>
    <h1 class="title"><?php echo $_SESSION['nama_pembeli'] ?> order</h1>
    <form>
        <?php foreach ($_SESSION['menu'] as $key => $value) : ?>
            <?php
            $menus = mysqli_query($koneksi, "SELECT * FROM makanan WHERE nama = '$key' UNION SELECT * FROM minuman WHERE nama = '$key'");
            $menu = mysqli_fetch_assoc($menus);
            
            ?>
            <div class="container1">
                <div class="leftcon">
                    <div class="left">
                        <h2 class="titleproduct"><?php echo implode(' ', explode('_', $menu['nama'])) ?></h2>
                        <P><?php echo $menu['detail'] ?></P>
                        <h2 class="price"><?php echo $menu['harga'] ?></h2>
                    </div>
                    <div class="right">
                        <?php if (!empty($menu['gambar'])) : ?>
                            <?php
                            $image_path = file_exists("../asset_database/makanan/" . $menu["gambar"]) ?
                                "../asset_database/makanan/" . $menu["gambar"] :
                                "../asset_database/minuman/" . $menu["gambar"];
                            ?>
                            <img src="<?= $image_path; ?>">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="rightcon">
                    <h1><?php echo $value ?> PCS</h1>
                    <h2><?php echo $value * $menu['harga'] ?></h2>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="container2">
            TOTAL PEMBAYARAN : <?php echo $_SESSION['total'] ?>
        </div>
    </form>
    <button class="container3" onclick="window.location = 'pembayaran_kasir.php'">
        SUBMIT
    </button>
</body>

</html>