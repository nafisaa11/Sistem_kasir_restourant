<?php 
session_start(); 
require 'function.php' ; 
if(!isset($_SESSION["login"])) { 
    header("Location: loginadmin.php");
    exit; 
} 
$resultMakanan=mysqli_query($conn, "SELECT * FROM makanan" );
$resultMinuman=mysqli_query($conn, "SELECT * FROM minuman" ); 

if (isset($_POST["logout"])) {
    unset($_SESSION['login']);
    unset($_SESSION['user']);
    header("Location: loginadmin.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard_admin.css">
    <title>Dashboard Admin</title>
</head>

<body>
    <div class="container">
        <img class="logo" src="asset/logotrizaria.svg">
        <h1>Selamat datang, <?= tampilNamaAdmin($_SESSION["user"]); ?></h1>
        <div class="container1">
            <h2>Menejemen Makanan</h2>
            <div class="buttontambah">
                <a href="tambah_makanan.php">Tambah Menu Makanan</a>
            </div>
            <table>
                <div class="table_head">
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </div>
                <div class="table_body">

                    <?php $i = 1; ?>
                    <?php while($row = mysqli_fetch_assoc($resultMakanan)) : ?>

                    <tr>
                        <td><?= $i; ?></td>
                        <td>
                            <img class="gambarmakanan" src="../asset_database/makanan/<?= $row["gambar"]; ?>">
                        </td>
                        <td><?= $row["nama"]; ?></td>
                        <td><?= $row["harga"]; ?></td>
                        <td><?= $row["stok"]; ?></td>
                        <td>
                            <form method="get" action="detail_makanan.php">
                                <input type="hidden" name="nama" value="<?= $row['nama']; ?>">
                                <button class="crud" type="submit">Detail</button>
                            </form>
                            <form method="get" action="edit_makanan.php">
                                <input type="hidden" name="nama" value="<?= $row['nama']; ?>">
                                <button class="crud" type="submit">Edit</button>
                            </form>
                            <form method="get" action="hapus_makanan.php">
                                <input type="hidden" name="nama" value="<?= $row['nama']; ?>">
                                <button class="crud" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <?php $i++; ?>
                    <?php endwhile; ?>

                </div>
            </table>
        </div>
        <div class="container2">
            <h2>Menejemen Minuman</h2>
            <div class="buttontambah">
                <a href="tambah_minuman.php">Tambah Menu Minuman</a>
            </div>
            <table>
                <div class="table_head">
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </div>
                <div class="table_body">

                    <?php $i = 1; ?>
                    <?php while($row = mysqli_fetch_assoc($resultMinuman)) : ?>

                    <tr>
                        <td><?= $i; ?></td>
                        <td>
                            <img class="gambarminuman" src="../asset_database/minuman/<?= $row["gambar"]; ?>">
                        </td>
                        <td><?= $row["nama"]; ?></td>
                        <td><?= $row["harga"]; ?></td>
                        <td><?= $row["stok"]; ?></td>
                        <td>
                            <form method="get" action="detail_minuman.php">
                                <input type="hidden" name="nama" value="<?= $row['nama']; ?>">
                                <button class="crud" type="submit">Detail</button>
                            </form>
                            <form method="get" action="edit_minuman.php">
                                <input type="hidden" name="nama" value="<?= $row['nama']; ?>">
                                <button class="crud" type="submit">Edit</button>
                            </form>
                            <form method="get" action="hapus_minuman.php">
                                <input type="hidden" name="nama" value="<?= $row['nama']; ?>">
                                <button class="crud" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <?php $i++; ?>
                    <?php endwhile; ?>
            </table>
        </div>
        <a class="linkbutton">
            <form action="" method="POST">
                <button name="logout" class="textbutton">Log Out</button>
            </form>
        </a>
        <br>
    </div>
    </div>
</body>

</html>