<?php

session_start();

require 'function.php';

if (!isset($_SESSION["login"])) {
    header("Location: loginadmin.php");
    exit;
}

if (isset($_POST["submit"])) {
    //melakukan pengecekan data berhasil di tambahkan atau tidak
    if (tambahMakanan($_POST) > 0) {
        echo "<script>
            alert('data berhasil ditambahkan');
            document.location.href = 'dashboard_admin.php';
        </script>";
    } else {
        echo "<script>
            alert('data gagal ditambahkan!');
            document.location.href = 'dashboard_admin.php';
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="tambah_makanan.css">
    <title>Tambah Menu Makanan</title>
</head>

<body>
    <div class="container">
        <div class="containerimage">
            <img src="asset/logotrizaria.svg">
        </div>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="container1">
                <h2>Tambah Makanan</h2>
                <input type="hidden" name="role_menu" value="0">
                <div class="inputgambar">
                    <label for="file-upload" class="custom-file-label">Pilih Gambar</label>
                    <input class="file-input" name="gambar" type="file" id="file-upload" required>
                    <span id="file-name" class="file-name"></span>
                </div>
                <input class="inputother" name="nama" type="text" placeholder="nama" required>
                <input class="inputother" name="detail" type="text" placeholder="detail" required>
                <input class="inputother" name="harga" type="number" placeholder="harga" required>
                <input class="inputother" name="stok" type="number" placeholder="stok" required>
                <button name="submit" type="submit">
                    <h2>Submit</h2>
                </button>
            </div>
        </form>
    </div>
</body>

</html>
