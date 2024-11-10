<?php

// Koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pizza";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Fungsi untuk menampilkan nama admin
function tampilNamaAdmin($data) {
    global $conn;
    $username_kasir = $data;

    $queryNama = "SELECT * FROM admin_pizza WHERE username_admin = ?";
    $stmt = $conn->prepare($queryNama);
    $stmt->bind_param("s", $username_kasir);
    $stmt->execute();
    $resultNama = $stmt->get_result();

    if ($resultNama->num_rows > 0) {
        $row = $resultNama->fetch_assoc();
        return htmlspecialchars($row["nama_admin"]);
    }
    return null;
}

// Fungsi untuk menambahkan makanan
function tambahMakanan($data) {
    global $conn;

    $role_menu = htmlspecialchars($data["role_menu"]);
    $nama = htmlspecialchars($data["nama"]);
    $detail = htmlspecialchars($data["detail"]);
    $harga = htmlspecialchars($data["harga"]);
    $stok = htmlspecialchars($data["stok"]);

    // Upload gambar 
    $gambar = uploadMakanan();
    if (!$gambar) {
        return false;
    }

    // Query untuk melakukan insert data makanan
    $query = "INSERT INTO makanan (role_menu, gambar, nama, detail, harga, stok) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isssds", $role_menu, $gambar, $nama, $detail, $harga, $stok);
    $stmt->execute();

    return $stmt->affected_rows;
}

function tambahMinuman($data) {
    global $conn;

    $role_menu = htmlspecialchars($data["role"]); // Mengganti $data["role"] menjadi $data["role_menu"]
    $nama = htmlspecialchars($data["nama"]);
    $detail = htmlspecialchars($data["detail"]);
    $harga = htmlspecialchars($data["harga"]);
    $stok = htmlspecialchars($data["stok"]);

    // Upload gambar 
    $gambar = uploadMinuman();
    if (!$gambar) {
        return false;
    }

    // Query untuk melakukan insert data minuman
    $query = "INSERT INTO minuman (role_menu, gambar, nama, detail, harga, stok) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isssds", $role_menu, $gambar, $nama, $detail, $harga, $stok);
    $stmt->execute();

    return $stmt->affected_rows;
}

function editMakanan($data) {
    // Implementasi untuk fungsi editMakanan
}

function uploadMakanan() {
    $namafile = $_FILES['gambar']['name'];
    $ukuranfile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    if ($error === 4) {
        echo "<script>alert('Masukkan gambar terlebih dahulu');</script>";
        return false;
    }

    $ekstensiGambarValid = ['svg', 'png'];
    $ekstensiGambar = explode('.', $namafile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>alert('gunakan format gambar yang benar');</script>";
        return false;
    }

    if ($ukuranfile > 15728640) {
        echo "<script>alert('ukuran gambar terlalu besar');</script>";
        return false;
    }

    $targetDir = '../asset_database/makanan/';
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    move_uploaded_file($tmpName, $targetDir . $namafile);
    return $namafile;
}

function uploadMinuman() {
    $namafile = $_FILES['gambar']['name'];
    $ukuranfile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    if ($error === 4) {
        echo "<script>alert('Masukkan gambar terlebih dahulu');</script>";
        return false;
    }

    $ekstensiGambarValid = ['svg', 'png'];
    $ekstensiGambar = explode('.', $namafile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>alert('gunakan format gambar yang benar');</script>";
        return false;
    }

    if ($ukuranfile > 15728640) {
        echo "<script>alert('ukuran gambar terlalu besar');</script>";
        return false;
    }

    $targetDir = '../asset_database/minuman/';
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    move_uploaded_file($tmpName, $targetDir . $namafile);
    return $namafile;
}

?>
