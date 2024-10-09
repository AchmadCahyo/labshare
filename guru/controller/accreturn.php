<?php
session_start();
include "../../config/conn.php";

if (isset($_POST['accr'])) {
    $id = $_POST['id'];

    $sql = "UPDATE peminjaman SET status = 'returned' WHERE id = '$id'";
    // echo $sql;
    $exe = mysqli_query($conn, $sql);

    if ($exe) {
        echo "<script>alert('You have just agreed to a return!'); document.location.href='../homeguru.php'</script>";
    } else {
        echo "<script>alert('Something Error Just Happened!'); document.location.href='../homeguru.php'</script>";
    }
}
