<?php

session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: loginkasir.php");
    exit;
}

if (isset($_SESSION['nama_pembeli'])) {
    header("Location: menu.php");
    exit;
}

if (isset($_POST['submit'])) {
    $_SESSION['nama_pembeli'] = trim($_POST['nama_pembeli']);
    header("Location: menu.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="inputnama_kasir.css">
    <title>Input Nama Pembeli</title>
</head>

<body>
    <div class="container">
        <img src="asset/logotrizaria.svg" class="img">
        <div id="welcome">Welcome to our restoran</div>
        <form action="" method="post">
            <input type="text" name="nama_pembeli" placeholder="Nama pembeli" require>
            <button type="submit" name="submit" class="submit">Submit</button>
        </form>
    </div>
</body>

</html>