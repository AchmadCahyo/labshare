<?php
session_start();
include "../../config/conn.php";

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM barang WHERE id = $id";
    $exe = mysqli_query($conn, $sql);

    if ($exe) {
        // Set pesan sukses dalam sesi
        $_SESSION['message'] = 'Data berhasil dihapus!';
    } else {
        // Set pesan error jika penghapusan gagal
        $_SESSION['message'] = 'Terjadi kesalahan saat menghapus data.';
    }

    // Arahkan kembali ke halaman yang diinginkan
    header("Location: ../inputtools.php");
    exit();
}
?>
