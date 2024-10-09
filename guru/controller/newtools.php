<?php
include '../../config/conn.php';

// Periksa apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $item_code = $_POST['item_code'] ?? '';
    $item_name = $_POST['name'] ?? '';
    $amount = $_POST['item_stock'] ?? '';
    $image = $_POST['image'];

    // Periksa apakah ada file yang diupload
    $rand = rand();
    $ekstensi = array('png', 'jpg', 'jpeg');
    $filename = $_FILES['image']['name']; // Nama file asli
    $ukuran = $_FILES['image']['size']; // Ukuran file
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION)); // Ekstensi file dalam lowercase
    // echo '<pre>';
    // print_r($_FILES);
    // print_r($_POST);
    // echo '</pre>';
    // Cek apakah ekstensi file diizinkan
    if (in_array($ext, $ekstensi)) {
        // Cek ukuran file (maksimal 1MB)
        if ($ukuran < 2000000) {
            // Membuat nama file baru
            $xx = $rand . "_" . $filename;

            // Path untuk menyimpan file
            $targetDir = '../assets/images/'; // Ubah direktori ke 'assets/images/'
            $targetFile = $targetDir . $xx;

            // Cek panjang path
            if (strlen($targetFile) > 100) {
                echo "<script>alert('Panjang path gambar melebihi batas maksimum.'); document.location.href='../inputtools.php'</script>";
                exit;
            }

            // Coba upload file
            $upload = move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
            if ($upload) {
                // Masukkan data ke dalam database
                $exe = mysqli_query($conn, "INSERT INTO barang VALUES ('', '$item_code', '$item_name', '$amount', '$xx')");

                if ($exe) {
                    echo "<script>alert('Data Has Been Added!'); document.location.href='../inputtools.php'</script>";
                } else {
                    echo "<script>alert('Datas Has Not Been Added, Try Again!'); document.location.href='../inputtools.php'</script>";
                }
            } else {
                echo "<script>alert('Datas Has Not Been Added, Try Again!'); document.location.href='../inputtools.php'</script>";
            }
        } else {
            header("location:inputtools.php?alert=gagal_ukuran");
        }
    } else {
        header("location:../inputtools.php.php?alert=gagal_mengupload");
    }
} else {
    echo "Form belum disubmit.";
}
