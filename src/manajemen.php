<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            background: url('asset/bg.svg') no-repeat center center fixed;
            background-size: cover;
        }

        .logo {
            display: flex;
            justify-content: center;
            margin-top: 50px;
        }

        .header h1 {
            color: white;
            margin-left: 100px;
            margin-top: 80px;
        }

        table th {
            background-color: #FF9C3D;

        }

        table {
            width: 90%;
            border-collapse: collapse;
            margin: auto;
        }

        th,
        td {
            /* background-color: #FF9C3D; */
            padding: 15px;
            color: white;
            text-align: center;
        }

        th.gambar {
            width: 20%;
            border-top-left-radius: 10px;
        }

        th:nth-child(2),
        td:nth-child(2) {
            width: 17%;
            /* Lebar kolom Nama */
        }

        th:nth-child(3),
        td:nth-child(3) {
            width: 18%;
            /* Lebar kolom Detail */
        }

        th:nth-child(4),
        td:nth-child(4) {
            width: 15%;
            /* Lebar kolom Harga */
        }

        th:nth-child(5),
        td:nth-child(5) {
            width: 10%;
            /* Lebar kolom Stok */
        }

        th.aksi {
            width: 20%;
            border-top-right-radius: 10px;
        }

        td a {
            color: white;
            justify-content: center;
        }

        tr:nth-child(odd) {
            background-color: #FF9C3D;
        }

        tr:nth-child(even) {
            background-color: #FFBA78;
        }

        a.plus {
            display: block;
            /* Mengubah anchor menjadi elemen block */
            width: 89%;
            /* Lebar elemen */
            border-radius: 10px;
            background-color: #FF9C3D;
            text-align: center;
            /* Pusatkan teks */
            padding: 10px;
            /* Berikan ruang di sekitar teks */
            color: black;
            /* Warna teks */
            text-decoration: none;
            /* Hapus dekorasi link */
            margin: auto;
            /* Gunakan margin auto untuk posisi horizontal, berikan margin atas dan bawah yang sesuai */
        }
    </style>
    </style>
</head>

<body>
    <div class="logo"><img src="asset/logoo.svg" alt=""></div>
    <div class="header">
        <h1>Menejemen Makanan</h1>
    </div>
    <div class="mm">
        <table>
            <tr>
                <th class="gambar">Gambar</th>
                <th>Nama</th>
                <th>Detail</th>
                <th>Harga</th>
                <th>Stok</th>
                <th class="aksi">Action</th>
            </tr>
            <?php
            include "koneksi.php";
            $data = mysqli_query($koneksi, "SELECT * FROM makanan order by id_makanan DESC");
            while ($row = mysqli_fetch_array($data)) {
            ?>
                <tr>
                    <td><img src="file/<?php echo $row['gambar']; ?>" style="width: 100%;"></td>
                    <td><?= $row['nama'] ?></td>
                    <td><?= $row['detail'] ?></td>
                    <td><?= $row['harga'] ?></td>
                    <td><?= $row['stok'] ?></td>
                    <td>
                        <a href="edit.php?hal=edit&id=<?= $row['id_makanan'] ?>">Edit</a>
                        <a href="manajemen.php?hal=hapus&id=<?= $row['id_makanan'] ?>" onclick="return confirm('Yakin ingin menghapus data ini?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <br>
        <div class="tambah">
            <a href="add.php" class="plus">Tambah Makanan</a>

        </div>
    </div>

    <div class="header">
        <h1>Menejemen Makanan</h1>
    </div>
    <div class="mm">
        <table>
            <tr>
                <th class="gambar">Gambar</th>
                <th>Nama</th>
                <th>Detail</th>
                <th>Harga</th>
                <th>Stok</th>
                <th class="aksi">Action</th>
            </tr>
            <?php
            include "koneksi.php";
            $data = mysqli_query($koneksi, "SELECT * FROM minuman order by id_minuman DESC");
            while ($row = mysqli_fetch_array($data)) {
            ?>
                <tr>
                    <td><img src="file/<?php echo $row['gambar']; ?>" style="width: 100%;"></td>
                    <td><?= $row['nama'] ?></td>
                    <td><?= $row['detail'] ?></td>
                    <td><?= $row['harga'] ?></td>
                    <td><?= $row['stok'] ?></td>
                    <td>
                        <a href="drink.php?hal=edit&id=<?= $row['id_minuman'] ?>">Edit</a>
                        <a href="manajemen.php?hal=hapus&id=<?= $row['id_minuman'] ?>" onclick="return confirm('Yakin ingin menghapus data ini?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <br>
        <div class="tambah">
            <a href="drink.php" class="plus">Tambah Minuman</a>
            <br><br>
        </div>
</body>

</html>