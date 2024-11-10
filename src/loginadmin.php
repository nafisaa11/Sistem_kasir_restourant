<?php

session_start();

require 'connection.php';

if (isset($_POST["login"])) {
    $username_kasir = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM admin_pizza WHERE username_admin = '$username_kasir'");

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password_admin"])) {
            $_SESSION["login"] = true;
            $_SESSION["user"] = $username_kasir;
            header("Location: dashboard_admin.php");
            exit;
        }
    }
    $error = true;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login_admin.css">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <img src="asset/logotrizaria.svg" class="img">
        <h1>LOGIN</h1>

        <?php if (isset($error)) : ?>
            <p>username / password salah!!</p>
        <?php endif; ?>

        <form action="" method="post">
            <ul>
                <li>
                    <input type="text" name="username" placeholder="username">
                </li>
                <li>
                    <input type="password" name="password" placeholder="password">
                </li>
                <button type="submit" name="login" class="submit">Login</button>
            </ul>
        </form>
    </div>
</body>

</html>