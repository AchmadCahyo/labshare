<?php
include '../config/conn.php';

$id = $_POST['id'] ?? '';
$borrower = $_POST['borrower_name'] ?? '';
$idalat = $_POST['tools_id'] ?? '';
$jumlah = $_POST['number_tools'] ?? '';
$tgl_pinjam = $_POST['tgl_pinjam'] ?? '';
$tgl_kembali = $_POST['tgl_kembali'] ?? '';
$status = $_POST['status'] ?? 'check';
$actual_return_date = null; // Inisialisasi nilai default

// Mulai transaksi
mysqli_begin_transaction($conn);

try {
   // Query 1: Insert ke tabel peminjaman
   $sqlInsert = "INSERT INTO peminjaman (borrower_name, tools_id, number_tools, loan_date, return_date, status, actual_return_date) 
                  VALUES ('$borrower', '$idalat', '$jumlah', '$tgl_pinjam', '$tgl_kembali', '$status', '$actual_return_date')";
   $exeInsert = mysqli_query($conn, $sqlInsert);

   if (!$exeInsert) {
      throw new Exception("Error saat memasukkan data peminjaman.");
   }

   // Query 2: Update stok di tabel barang
   $sqlUpdate = "UPDATE barang SET item_stock = item_stock - $jumlah WHERE id = '$idalat'";
   $exeUpdate = mysqli_query($conn, $sqlUpdate);

   if (!$exeUpdate) {
      throw new Exception("Error saat mengupdate stok barang.");
   }

   // Jika kedua query berhasil, commit transaksi
   mysqli_commit($conn);
   echo "Data Berhasil Disimpan";
   header("Location: peminjamansiswa.php");
   exit;
} catch (Exception $e) {
   // Jika terjadi error, rollback transaksi
   mysqli_rollback($conn);
   echo "Gagal Disimpan: " . $e->getMessage();
}
