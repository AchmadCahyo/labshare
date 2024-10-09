<?php
session_start();
include "../config/conn.php";

// Menerima dan mengamankan data input username dan password
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = hash('sha256', $_POST['password']);
$pass = mysqli_real_escape_string($conn, $password);

// Memeriksa apakah username ada di database
$users_check = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
$validated_users = mysqli_fetch_array($users_check);

if ($validated_users) {
    // Memeriksa kecocokan password
    if ($pass == $validated_users['password']) {
        // Regenerate session ID untuk memastikan session unik
        session_regenerate_id(true);

        // Menyimpan informasi ke session
        $_SESSION['username'] = $validated_users['username'];
        $_SESSION['name'] = $validated_users['name'];
        $_SESSION['role'] = $validated_users['role']; // Mengambil role dari database

        // Set cookie session yang berbeda berdasarkan role
        if ($validated_users['role'] == "guru") {
            setcookie('role', 'guru', 0, '/');
            header('location:../guru/homeguru.php');
        } elseif ($validated_users['role'] == "siswa") {
            setcookie('role', 'siswa', 0, '/');
            header('location:../siswa/homesiswa.php');
        } else {
            echo "<script>alert('Role tidak dikenali!'); document.location='../login.php'</script>";
        }
    } else {
        echo "<script>alert('Login gagal. Password salah!'); document.location='../login.php'</script>";
    }
} else {
    echo "<script>alert('Login gagal. Username tidak terdaftar!'); document.location='../login.php'</script>";
}
