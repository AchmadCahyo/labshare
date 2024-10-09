<?php
// Pastikan session dan koneksi ke database telah dimulai
session_start();
include '../../config/conn.php'; // Sambungkan dengan file konfigurasi koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form modal
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Buat query dasar untuk update data (tanpa password terlebih dahulu)
    $sql = "UPDATE users SET username='$username', name='$name', email='$email'";

    // Cek apakah password juga diupdate
    if (!empty($password)) {
        // Gunakan SHA-256 untuk enkripsi password
        $hashed_password = hash('sha256', $password);
        $sql .= ", password='$hashed_password'";
    }

    $sql .= " WHERE id='$id'";

    // Eksekusi query
    if (mysqli_query($conn, $sql)) {
        // Set success message ke session
        $_SESSION['success_message'] = "Data berhasil diupdate";
    } else {
        // Set error message ke session jika ada kesalahan
        $_SESSION['error_message'] = "Error: " . mysqli_error($conn);
    }

    // Redirect kembali ke halaman yang menampilkan data atau tempat modal berada
    header("Location: ../addguru.php"); // Sesuaikan dengan halaman yang sesuai
    exit();
}
