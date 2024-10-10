<?php
session_start();
include "../../config/conn.php";

if (isset($_POST['accr'])) {
    $id = $_POST['id'];

    // Ambil jumlah item yang dipinjam serta ID barang (tools_id)
    $query = "SELECT tools_id, number_tools FROM peminjaman WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $tools_id = $data['tools_id'];
        $number_tools = $data['number_tools'];

        // Update status peminjaman menjadi 'returned'
        $sql = "UPDATE peminjaman SET status = 'returned' WHERE id = '$id'";
        $exe = mysqli_query($conn, $sql);

        if ($exe) {
            // Tambahkan jumlah yang dipinjam kembali ke stok barang
            $update_stock_query = "UPDATE barang SET item_stock = item_stock + $number_tools WHERE id = '$tools_id'";
            $update_stock_result = mysqli_query($conn, $update_stock_query);

            if ($update_stock_result) {
                echo "<script>alert('You have just agreed to a return!'); document.location.href='../homeguru.php'</script>";
            } else {
                echo "<script>alert('Failed to update item stock!'); document.location.href='../homeguru.php'</script>";
            }
        } else {
            echo "<script>alert('Something Error Just Happened!'); document.location.href='../homeguru.php'</script>";
        }
    } else {
        echo "<script>alert('No matching loan record found!'); document.location.href='../homeguru.php'</script>";
    }
}
