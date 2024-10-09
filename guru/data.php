<?php
// Melanjutkan dari kode yang sudah ada
session_start();
include "../config/conn.php";
if (empty($_SESSION['username']) or empty($_SESSION['role'])) {
    echo "<script>alert('To open this page, please log in first!');document.location='../login.php'</script>";
}
$sql = 'SELECT * FROM barang';
$exe = mysqli_query($conn, $sql);

require_once '../vendor/autoload.php';

use Dompdf\Dompdf;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $firstdate = $_POST['input1'] ?? '';
    $seconddate = $_POST['input2'] ?? '';

    // Pengecekan apakah ada input tanggal
    if (!empty($firstdate) && !empty($seconddate)) {
        // Kueri untuk mengambil data berdasarkan tanggal
        $sql = "SELECT peminjaman.*, barang.name FROM peminjaman
                INNER JOIN barang ON peminjaman.tools_id = barang.id
                WHERE STR_TO_DATE(loan_date, '%e %M, %Y')
                BETWEEN '$firstdate' AND '$seconddate'";
    } else {
        // Jika tidak ada input tanggal, ambil semua data
        $sql = "SELECT peminjaman.*, barang.name FROM peminjaman
                INNER JOIN barang ON peminjaman.tools_id = barang.id";
    }
    $exe = mysqli_query($conn, $sql);

    // Jika button "View PDF" ditekan
    if (isset($_POST['view_pdf'])) {
        $dompdf = new Dompdf();

        $html = '<style>
            body {
                font-family: Arial, sans-serif;
            }
            .table {
                width: 100%;
                border-collapse: collapse;
            }
            .table th, .table td {
                border: 1px solid #ddd;
                padding: 8px;
            }
            .table th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: center;
                background-color: #9b5de5;
                color: white;
            }
            .table td {
                text-align: center;
            }
            h1 {
                text-align: center;
                color: #333;
            }
        </style>';

        // Konten HTML untuk PDF
        $html .= '<h1>Loan Data</h1>';
        $html .= '<table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Borrower</th>
                    <th>Tools</th>
                    <th>Loan Amount</th>
                    <th>Loan Date</th>
                    <th>Return Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>';

        $no = 1;
        while ($data = mysqli_fetch_array($exe)) {
            $html .= '<tr>
                            <td>' . $no++ . '</td>
                            <td>' . $data['borrower_name'] . '</td>
                            <td>' . $data['name'] . '</td>
                            <td>' . $data['number_tools'] . ' Items</td>
                            <td>' . $data['loan_date'] . '</td>
                            <td>' . $data['return_date'] . '</td>
                            <td>' . $data['status'] . '</td>
                        </tr>';
        }

        $html .= '</tbody></table>';

        // Memuat HTML ke Dompdf
        $dompdf->loadHtml($html);

        // Set ukuran dan orientasi halaman
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF
        $dompdf->render();

        // Menampilkan PDF di browser (tidak langsung download)
        $dompdf->stream('loan_data.pdf', array("Attachment" => 0));
        exit; // Menghentikan eksekusi agar tidak mengoutput konten HTML
    }
}
?>
<!doctype html>
<html lang="en">

<!--HTML di bagian bawah-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home | Guru</title>
    <script src="https://kit.fontawesome.com/f8a09ade68.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styleguru.css">
</head>

<style>
    body {
        background-color: #f3f0f7;
        font-family: 'Poppins', sans-serif;
    }

    .navbar {
        background-color: #6f42c1;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .navbar .nav-link,
    .navbar-brand,
    .logout p {
        color: #fff;
    }

    .navbar .nav-link:hover {
        color: #d1c4e9;
    }

    .navbar .logout a {
        color: #ffcccb;
    }

    .card {
        box-shadow: 0 4px 12px rgba(108, 92, 231, 0.2);
        transition: transform 0.3s ease-in-out;
        border: none;
        border-radius: 12px;
    }

    .card:hover {
        transform: translateY(-8px);
    }

    .card-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #6f42c1;
    }

    .table thead {
        background-color: #6f42c1;
        color: #fff;
    }

    .btn-primary {
        background-color: #6f42c1;
        border: none;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #533997;
    }

    .btn-dark {
        background-color: #4a148c;
        transition: background-color 0.3s ease;
    }

    .btn-dark:hover {
        background-color: #6f42c1;
    }

    .back-to-top {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: #6f42c1;
        border-radius: 50%;
        padding: 12px;
        color: #fff;
        box-shadow: 0 4px 12px rgba(108, 92, 231, 0.4);
        transition: background-color 0.3s ease;
    }

    .back-to-top:hover {
        background-color: #4a148c;
    }

    /* Custom card design */
    .custom-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .custom-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .card-title {
        font-weight: 700;
        color: #4b0082;
        /* Warna ungu untuk judul kartu */
    }

    .btn-custom {
        background-color: #6a0dad;
        /* Ungu gelap untuk tombol */
        border: none;
        color: white;
        font-weight: bold;
    }

    .btn-custom:hover {
        background-color: #7b2cbf;
        /* Ungu yang lebih terang saat hover */
    }

    .custom-badge {
        background-color: #9b5de5;
        /* Warna ungu untuk badge */
        font-size: 0.9rem;
        font-weight: bold;
    }

    .table-striped tbody tr:hover {
        background-color: #f1f1f1;
    }

    /* Custom modal style */
    .modal-content {
        border-radius: 20px;
        padding: 20px;
    }

    .modal-header {
        border-bottom: none;
    }

    /* Back to top button styling */
    .back-to-top {
        position: fixed;
        bottom: 20px;
        right: 20px;
        display: none;
        z-index: 1000;
    }

    .back-to-top.show {
        display: block;
    }

    .btn-warning {
        background-color: #9b5de5;
        /* Warna ungu pada tombol */
    }

    .btn-warning:hover {
        background-color: #7b2cbf;
        /* Warna ungu saat hover */
    }
</style>

<body>
    <nav class="navbar navbar-expand-lg fw-bold">
        <div class="container">
            <a class="navbar-brand" href="#"><img class="logo" src="../assets/image/logolab.png" style="height: 40px;"
                    alt=""></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="homeguru.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Actions
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="inputtools.php">Data Tools</a></li>
                            <li><a class="dropdown-item" href="data.php">Borrowed Data in Month</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="addguru.php">Add Admin</a>
                    </li>
                </ul>
                <form class="logout d-flex mt-3" role="submit">
                    <p class="me-2"><i class="fa-solid fa-user-graduate"></i> Hello, <?= $_SESSION['name'] ?></p>
                    <p class="me-2">|</p>
                    <a href="../controller/logout.php" role="button" style="text-decoration:none"><i class="fa-solid fa-right-from-bracket nav-link"> Log
                            out</i></a>
                </form>
            </div>
        </div>
    </nav>
    <!--Navbar END-->
    <!--Container START-->
    <div class="container my-5">
        <div class="col-lg-12 text-center">
            <div class="card bg-light text-dark p-4">
                <h3 class="card-title">WELCOME TO THE LABORATORY</h3>
                <p class="card-text">Rekayasa Perangkat Lunak - You can enjoy our online service <i
                        class="fa-solid fa-clock"></i></p>
            </div>
        </div>
    </div>

    <!-- Form Section START -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title text-center">Displays Loan Data</h5>
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <label>First Date</label>
                                <input type="date" name="input1" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Last Date</label>
                                <input type="date" name="input2" class="form-control">
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary col-md-12">Show</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Data Table START -->
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $firstdate = $_POST['input1'];
        $seconddate = $_POST['input2'];
        if ($firstdate && $seconddate) {
            $sql = "SELECT peminjaman.*, barang.name FROM peminjaman INNER JOIN barang ON peminjaman.tools_id = barang.id WHERE STR_TO_DATE(loan_date, '%e %M, %Y') BETWEEN '$firstdate' AND '$seconddate'";
            $exe = mysqli_query($conn, $sql);
        } else {
            $sql = "SELECT peminjaman.*, barang.name FROM peminjaman INNER JOIN barang ON peminjaman.tools_id = barang.id";
            $exe = mysqli_query($conn, $sql);
        }

        if (mysqli_num_rows($exe) > 0) {
    ?>
            <div class="container">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped align-middle">
                        <thead class="bg-primary text-white text-center">
                            <tr>
                                <th>No</th>
                                <th>Borrower</th>
                                <th>Tools</th>
                                <th>Loan Amount</th>
                                <th>Loan Date</th>
                                <th>Return Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php
                            $no = 1;
                            while ($data = mysqli_fetch_array($exe)) {
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $data['borrower_name'] ?></td>
                                    <td><?= $data['name'] ?></td>
                                    <td><?= $data['number_tools'] ?> Items</td>
                                    <td><?= $data['loan_date'] ?></td>
                                    <td><?= $data['return_date'] ?></td>
                                    <td>
                                        <?php
                                        if ($data['status'] == 'Returned') {
                                            echo '<span class="badge bg-success">Returned</span>';
                                        } else {
                                            echo '<span class="badge bg-warning">Not Returned</span>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <!-- Hidden input untuk mengirim tanggal ke PDF -->
                    <form action="" method="post" target="_blank">
                        <input type="hidden" name="input1" value="<?= $firstdate ?>">
                        <input type="hidden" name="input2" value="<?= $seconddate ?>">
                        <div class="d-grid gap-2 col-6 mx-auto">
                            <button type="submit" name="view_pdf" class="btn btn-primary mb-4">View PDF</button>
                        </div>
                    </form>
                </div>
            </div>
    <?php
        } else {
            echo "<p class='text-center mt-4'>No data found for the selected dates.</p>";
        }
    }
    ?>
</body>

</html>