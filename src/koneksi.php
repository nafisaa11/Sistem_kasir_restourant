<?php
$koneksi = mysqli_connect("localhost", "root", "", "pizza");
if (mysqli_connect_errno()) {
	echo "Koneksi Gagal " . mysqli_connect_error();
}
?>