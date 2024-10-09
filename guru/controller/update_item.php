<?php
include "../../config/conn.php";

$id = $_POST['id'];
$item_code = $_POST['item_code'];
$item_name = $_POST['name'];
$amount = $_POST['item_stock'];

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $imageTmpPath = $_FILES['image']['tmp_name'];
    $imageName = $_FILES['image']['name'];
    $imageSize = $_FILES['image']['size'];
    $imageType = $_FILES['image']['type'];

    // Tentukan lokasi untuk menyimpan gambar
    $uploadFileDir = '../assets/images/';
    $destPath = $uploadFileDir . $imageName;

    // Pindahkan file gambar ke lokasi yang diinginkan
    if (move_uploaded_file($imageTmpPath, $destPath)) {
        // Gambar berhasil di-upload, lakukan tindakan update pada database
        // Misalnya, perbarui informasi gambar di database
        $id = $_POST['id'];
        $item_code = $_POST['item_code'];
        $name = $_POST['name'];
        $item_stock = $_POST['item_stock'];

        // Update query ke database
        $query = "UPDATE barang SET item_code='$item_code', name='$name', item_stock='$item_stock', image='$imageName' WHERE id='$id'";
        mysqli_query($conn, $query);
        header("Location: ../inputtools.php");
    } else {
        // Gagal upload gambar
        echo "Gagal mengupload gambar.";
        header("Location: ../inputtools.php");
    }
} else {
    // Jika tidak ada gambar yang di-upload, cukup update informasi lain
    $id = $_POST['id'];
    $item_code = $_POST['item_code'];
    $name = $_POST['name'];
    $item_stock = $_POST['item_stock'];

    // Update query ke database tanpa mengubah gambar
    $query = "UPDATE barang SET item_code='$item_code', name='$name', item_stock='$item_stock' WHERE id='$id'";
    mysqli_query($conn, $query);
    header("Location: ../inputtools.php");
}
