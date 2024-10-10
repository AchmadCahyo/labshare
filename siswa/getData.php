<?php
session_start();
include '../config/conn.php';

$id = $_GET['id'] ?? 0;
$user_id = $_SESSION['id'];
$sql = "SELECT peminjaman.*, barang.name AS tool_name, users.name AS user_name FROM peminjaman
INNER JOIN barang ON peminjaman.tools_id = barang.id
INNER JOIN users ON peminjaman.borrower_id = users.id
WHERE borrower_id = '$user_id'";
$result = mysqli_query($conn, $sql);

if ($result) {
    $data = mysqli_fetch_assoc($result);
    // Tampilkan data dengan menggunakan Bootstrap div
    echo '
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Borrower</label>
        <div class="col-sm-9">
            <p class="form-control-plaintext fw-bold">' . $data['user_name'] . '</p>
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Tools</label>
        <div class="col-sm-9">
            <p class="form-control-plaintext fw-bold">' . $data['tool_name'] . '</p>
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Amount</label>
        <div class="col-sm-9">
            <p class="form-control-plaintext fw-bold">' . $data['number_tools'] . ' Items </p>
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Loan Date</label>
        <div class="col-sm-9">
            <p class="form-control-plaintext fw-bold">' . $data['loan_date'] . '</p>
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Return Date</label>
        <div class="col-sm-9">
            <p class="form-control-plaintext fw-bold">' . $data['return_date'] . '</p>
        </div>
    </div>
    <div class="alert alert-info fw-bold" role="alert" style="text-align: center; margin-top: 20px;">
        Show this message to the admin so that your loan can be approved.
    </div>';
} else {
    echo "Data tidak ditemukan.";
}
