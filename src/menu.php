<?php
require 'koneksi.php';
session_start();

if (empty($_SESSION['nama_pembeli'])) {
    header("Location: inputnama_kasir.php");
    exit;
}

$makanan_table_row = mysqli_query($koneksi, "SELECT * FROM makanan");
$minuman_table_row = mysqli_query($koneksi, "SELECT * FROM minuman");

if (isset($_POST['submit'])) {
    $_SESSION['menu'] = [];

    foreach ($_POST as $key => $value) {
        if ($value > 0 && $value < 50) {
            $_SESSION['menu'][implode(' ', explode('_', $key))] = $value;
        }
    }

    $_SESSION['total'] = 0;
    $_SESSION['kembalian'] = 0;

    foreach ($_SESSION['menu'] as $key => $value) {
        $menus = mysqli_query($koneksi, "SELECT * FROM makanan WHERE nama = '$key' UNION SELECT * FROM minuman WHERE nama = '$key'");
        $menu = mysqli_fetch_assoc($menus);
        $_SESSION['total'] += $value * $menu['harga'];

        // Update stok makanan atau minuman
        if ($menu['stok'] >= $value) {
            if (isset($menu['id_makanan'])) {
                $update_stok = mysqli_query($koneksi, "UPDATE makanan SET stok = stok - $value WHERE id_makanan = {$menu['id_makanan']}");
            } elseif (isset($menu['id_minuman'])) {
                $update_stok = mysqli_query($koneksi, "UPDATE minuman SET stok = stok - $value WHERE id_minuman = {$menu['id_minuman']}");
            }
        } else {
            echo "Stok untuk $key tidak mencukupi!";
            exit;
        }
    }

    header("Location: order_kasir.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, Initial-scale=1.0">
    <link href="menu.css" rel="stylesheet">
    <title>Menu</title>
</head>
<body>
    <div id="header">
        <img src="asset/LogoPizzaria.svg" width="290px" height="137" />
        <div id="ourmenuheader">OUR MENU</div>
        <div id="switchmenu">
            <div id="switchmakanan" onclick="tampilmakan()">Pizza</div>
            <div>|</div>
            <div id="switchminuman" onclick="tampilminum()">Drink</div>
        </div>
    </div>
    <div id="welcome">WELCOME <?php echo htmlspecialchars($_SESSION['nama_pembeli']); ?></div>
    <form id="boxmenu" action="" method="POST">
        <div id="sub_boxmenu_makan">
            <div id="row_card">
                <?php if ($makanan_table_row) : ?>
                    <?php while ($row = mysqli_fetch_assoc($makanan_table_row)) : ?>
                        <div id="card_menu">
                            <img src="../asset_database/makanan/<?= $row["gambar"]; ?>">
                            <div id="judul"><?= htmlspecialchars($row['nama']); ?></div>
                            <div id="deskripsi"><?= htmlspecialchars($row['detail']); ?></div>
                            <div id="box_harga"><?= htmlspecialchars($row['harga']); ?></div><br>
                            <input type="number" id="inputItem" name="<?= htmlspecialchars($row['nama']); ?>" min="0" max="<?= htmlspecialchars($row['stok']); ?>" placeholder="0">
                            <div id="infostok">Stok <?php if ($row['stok'] != 0) {
                                                        echo htmlspecialchars($row['stok']);
                                                    } else {
                                                        echo "Habis";
                                                    } ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <div>Gagal mengambil data dari tabel makanan.</div>
                <?php endif; ?>
            </div>
            <div id="row_card" style="justify-content: center;">
                <button type="submit" id="submit" name="submit">Submit</button>
            </div>
        </div>
        <div id="sub_boxmenu_minum">
            <div id="row_card">
                <?php if ($minuman_table_row) : ?>
                    <?php while ($row = mysqli_fetch_assoc($minuman_table_row)) : ?>
                        <div id="card_menu">
                            <img src="../asset_database/minuman/<?= $row["gambar"]; ?>">
                            <div id="judul"><?= htmlspecialchars($row['nama']); ?></div>
                            <div id="deskripsi"><?= htmlspecialchars($row['detail']); ?></div>
                            <div id="box_harga"><?= htmlspecialchars($row['harga']); ?></div><br>
                            <input type="number" id="inputItem" name="<?= htmlspecialchars($row['nama']); ?>" min="0" max="<?= htmlspecialchars($row['stok']); ?>" placeholder="0">
                            <div id="infostok">Stok <?php if ($row['stok'] != 0) {
                                                        echo htmlspecialchars($row['stok']);
                                                    } else {
                                                        echo "Habis";
                                                    } ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <div>Gagal mengambil data dari tabel minuman.</div>
                <?php endif; ?>
            </div>
            <div id="row_card" style="justify-content: center;">
                <button type="submit" id="submit" name="submit">Submit</button>
            </div>
        </div>
    </form>
    <script>
        function tampilmakan() {
            sub_boxmenu_makan.style.display = "flex";
            sub_boxmenu_minum.style.display = "none";
            switchmakanan.style.color = "#FF9C3D";
            switchminuman.style.color = "white";
        }

        function tampilminum() {
            sub_boxmenu_makan.style.display = "none";
            sub_boxmenu_minum.style.display = "flex";
            switchmakanan.style.color = "white";
            switchminuman.style.color = "#FF9C3D";
        }
    </script>
</body>
</html>
