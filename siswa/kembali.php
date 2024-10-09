<?php
session_start();
include "../config/conn.php";

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $today = date("Y-m-d"); // Tanggal hari ini

    // Ambil data peminjaman berdasarkan ID
    $query = "SELECT return_date FROM peminjaman WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    $return_date = $data['return_date'];

    // Logika untuk peringatan jika melewati tanggal kembali
    if ($today > $return_date) {
        echo "<script>alert('Peringatan, Kembalikan Barang Tepat Waktu. Jika tidak maka akan ada sanksi. Mohon Bertanggung Jawab dengan barang yang dipinjam.');</script>";
    }

    // Update status dan tanggal kembali
    $sql = "UPDATE peminjaman SET status = 'wait', actual_return_date = '$today' WHERE id = '$id'";
    $exe = mysqli_query($conn, $sql);

    if ($exe) {
        echo "<script>alert('Wait Until The Admin Approve Your Returned Request!'); document.location.href='homesiswa.php'</script>";
    } else {
        echo "<script>alert('Your Loan Data Not Updated!'); document.location.href='homesiswa.php'</script>";
    }
}
