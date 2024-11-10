<?php
require 'koneksi.php';
session_start();
$error = false;
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: dashboard_kasir.php");
    exit;
}

if (isset($_POST['login'])) {
    $valid_username = trim($_POST["username"]);
    $valid_password = trim($_POST["password"]);

    if (!empty($valid_username) && !empty($valid_password)) {
        $result = mysqli_query($koneksi, "SELECT * FROM kasir WHERE username_kasir = '$valid_username'");
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($valid_password === $row["password_kasir"]) {
                $_SESSION['logged_in'] = true;
                $_SESSION['nama_kasir'] = $row['nama_kasir'];
                $_SESSION['id_kasir'] = $row['id_kasir'];
                header("Location: dashboard_kasir.php");
                exit;
            }
        }
        $error = true;
    } else {
        $error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="loginkasir.css">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <img src="asset/logotrizaria.svg" class="img" />
        <h1>LOGIN</h1>

        <?php if ($error) : ?>
            <p>Username atau password salah!</p>
        <?php endif; ?>

        <form action="" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login" class="submit">Login</button>
        </form>
    </div>
</body>

</html>