<?php
session_start();
include "../config/conn.php";
if (empty($_SESSION['username']) or empty($_SESSION['role'])) {
    echo "<script>alert('To open this page, please log in first!');document.location='../login.php'</script>";
}
$name = mysqli_real_escape_string($conn, $_SESSION['name']);
$sql =  "SELECT * FROM barang";
$sql3 = "SELECT * FROM peminjaman";
$sql2 = "SELECT peminjaman.*, barang.name FROM peminjaman INNER JOIN barang ON peminjaman.tools_id = barang.id WHERE status = 'check'";
$sql3 = "SELECT peminjaman.*, barang.name FROM peminjaman INNER JOIN barang ON peminjaman.tools_id = barang.id WHERE status = 'wait'";
$exe = mysqli_query($conn, $sql);
$exe2 = mysqli_query($conn, $sql2);
$exe3 = mysqli_query($conn, $sql3);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home | Guru</title>
    <link rel="stylesheet" href="https://kit.fontawesome.com/f8a09ade68.js" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/f8a09ade68.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styleguru.css">

</head>

<body>
    <!--Navbar START-->
    <nav class="navbar navbar-expand-lg fw-bold">
        <div class="container">
            <a class="navbar-brand" href="../home.php"><img class="logo" src="../assets/image/logolab.png" style="height: 40px;"
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
        <!-- Welcome Section -->
        <div class="row mb-5">
            <div class="col-lg-12 text-center">
                <div class="card bg-light text-dark p-4">
                    <h3 class="card-title">WELCOME TO THE LABORATORY</h3>
                    <p class="card-text">Rekayasa Perangkat Lunak - You can enjoy our online service <i
                            class="fa-solid fa-clock"></i></p>
                </div>
            </div>
        </div>

        <!-- Loan Requests and Return Data -->
        <div class="row d-flex">
            <!-- Loan Request Card -->
            <div class="col-lg-6 mb-4 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body">
                        <h5 class="card-title text-center">Loan Request</h5>
                        <div style="max-height: 240px; min-height: 100px; overflow-y: scroll;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Tools</th>
                                        <th>Loan Amount</th>
                                        <th>Loan Date</th>
                                        <th>Return Date</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- PHP loop untuk menampilkan data -->
                                    <?php
                                    $no = 1;
                                    while ($data = mysqli_fetch_array($exe2)) { ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $data['borrower_name'] ?></td>
                                            <td><?= $data['name'] ?></td>
                                            <td><?= $data['number_tools'] ?> Items</td>
                                            <td><?= $data['loan_date'] ?></td>
                                            <td><?= $data['return_date'] ?></td>
                                            <td>
                                                <form action="controller/acc.php" method="post">
                                                    <input type="hidden" name="id" value="<?= $data['id'] ?>">
                                                    <button class="btn btn-primary" name="acc">Approve</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <a href="lend.php" class="btn btn-dark d-block mt-3">Go To Loan Page</a>
                    </div>
                </div>
            </div>

            <!-- Return Data Card -->
            <div class="col-lg-6 mb-4 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body">
                        <h5 class="card-title text-center">Return Data</h5>
                        <div style="max-height: 240px; min-height: 100px; overflow-y: scroll;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Tools</th>
                                        <th>Loan Amount</th>
                                        <th>Loan Date</th>
                                        <th>Return Date</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    while ($data = mysqli_fetch_array($exe3)) { ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $data['borrower_name'] ?></td>
                                            <td><?= $data['name'] ?></td>
                                            <td><?= $data['number_tools'] ?> Items</td>
                                            <td><?= $data['loan_date'] ?></td>
                                            <td><?= $data['return_date'] ?></td>
                                            <td>
                                                <form action="controller/accreturn.php" method="post">
                                                    <input type="hidden" name="id" value="<?= $data['id'] ?>">
                                                    <button class="btn btn-primary" name="accr">Approve</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <a href="inputtools.php" class="btn btn-dark d-block mt-3">Go To Input Tools Page</a>
                    </div>
                </div>
            </div>
        </div>




        <!-- Back to top button -->
        <a href="#" class="back-to-top"><i class="fas fa-arrow-up"></i></a>
    </div>
    <!--Container END-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>