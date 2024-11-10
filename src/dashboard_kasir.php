<?php

session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: loginkasir.php");
    exit;
}
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: loginkasir.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard_kasir.css">
    <title>DASHBOARD KASIR</title>
</head>

<body>
    <div class="container">
        <img src="asset/logotrizaria.svg">
        <div id="tagline">Slice into happiness your perfect pizza experience</div>
        <button id="neworder" onclick="window.location = 'inputnama_kasir.php'">New Order</button>
        <br>
        <form method="POST">
            <button type="submit" id="neworder" name="logout">LOGOUT</button>
        </form>
    </div>
</body>

</html>