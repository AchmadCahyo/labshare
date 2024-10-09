<?php
session_start();
include "../../config/conn.php"; // Menggunakan null coalescing untuk menghindari error jika tidak ada data

$resultData  = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $firstdate = $_POST['formatted_input1'] ?? '';
    $seconddate = $_POST['formatted_input2'] ?? '';

    // Kueri untuk mengambil data berdasarkan tanggal
    $sql = "SELECT * FROM peminjaman WHERE loan_date BETWEEN ? AND ?";
    // echo $sql;
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Prepare failed: ' . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("ss", $firstdate, $seconddate);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        // Simpan hasil ke variabel $resultData
        while ($row = $result->fetch_assoc()) {
            $resultData[] = $row;
        }
    } else {
        die('Execute failed: ' . $stmt->error);
    }

    $stmt->close();
}
