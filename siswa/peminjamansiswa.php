<?php
session_start();
include "../config/conn.php";
if (empty($_SESSION['username']) || empty($_SESSION['role'])) {
    echo "<script>alert('Untuk Membuka Halaman Ini, Silahkan Login Terlebih Dahulu!');document.location='login.php'</script>";
    exit();
}
$query = "SELECT id, name FROM barang WHERE item_stock > 0"; // Hanya menampilkan alat yang masih tersedia
$result = mysqli_query($conn, $query);

$user_id = $_SESSION['id'];
$query2 = "SELECT peminjaman.*, barang.name AS tool_name, users.name AS user_name FROM peminjaman 
INNER JOIN barang ON peminjaman.tools_id = barang.id 
INNER JOIN users ON peminjaman.borrower_id = users.id 
WHERE borrower_id = '$user_id' AND (status = 'check' OR status = 'borrowed')";
$exe = mysqli_query($conn, $query2);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Peminjaman</title>
    <script src="https://kit.fontawesome.com/f8a09ade68.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/classic.css">
    <link rel="stylesheet" href="css/classic.date.css">
    <link rel="stylesheet" href="homestyle.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<style>
    body {

        background-color: #f3f0f7;
        font-family: 'Poppins', sans-serif;
    }

    /* Pastikan modal dan backdrop berada di atas elemen lain */
    .modal-backdrop {
        z-index: 1040 !important;
        /* Nilai yang tinggi untuk backdrop */
    }

    .modal {
        z-index: 1050 !important;
        /* Pastikan modal di atas backdrop */
    }

    /* Tambahkan properti untuk menghindari kedipan modal saat di-hover */
    .modal.fade .modal-dialog {
        transition: none;
        /* Nonaktifkan transisi jika tidak diperlukan */
    }

    /* Untuk modal yang mungkin terpengaruh overflow */
    body.modal-open {
        overflow: hidden;
        font-family: 'Poppins', sans-serif;
        /* Mencegah scrollbar muncul saat modal terbuka */
    }

    /* Navbar styling */
    .navbar {
        background-color: #8967B3;
    }

    /* .navbar-brand img {
        height: 50px;
    } */

    .navbar .nav-link,
    .navbar-brand,
    .logout p {
        color: #fff;
    }

    .navbar .nav-link:hover {
        color: #d1c4e9;
    }

    /* Card styling */
    .card {
        border: none;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease-in-out;
    }

    .card:hover {
        transform: translateY(-10px);
    }

    .card-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #8967B3;
    }

    /* Scroll section styling */
    .scroll-section {
        max-height: 240px;
        min-height: 100px;
        overflow-y: auto;
    }

    /* Button styling */
    .btn-primary {
        background-color: #8967B3;
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

    .btn-dark:hover {
        background-color: #23272b;
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

    /* Back to top button */
    .back-to-top {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: #ffc107;
        border-radius: 50%;
        padding: 10px;
    }

    .back-to-top i {
        font-size: 24px;
        color: #fff;
    }

    .back-to-top:hover {
        background-color: #e0a800;
    }
</style>

<body>
    <!--Navbar START-->
    <nav class="navbar navbar-expand-lg fw-bold">
        <div class="container">
            <a class="navbar-brand" href="../home.php"><img class="logo" src="../assets/image/logolab.png" alt="Logo" style="height: 40px;"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="homesiswa.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="peminjamansiswa.php">Go To Loan Page</a>
                    </li>
                </ul>
                <form class="logout d-flex mt-3" role="submit">
                    <p class="me-2"><i class="fa-solid fa-user-graduate"></i> Hello, <?= $_SESSION['name'] ?></p>
                    <p class="me-2">|</p>
                    <a href="../controller/logout.php" role="button"><i class="fa-solid fa-right-from-bracket"> Log
                            out</i></a>
                </form>
            </div>
        </div>
    </nav>
    <!--Navbar END-->

    <!--Container START-->
    <div class="container my-5">
        <div class="row mb-5">
            <div class="col-lg-12 text-center">
                <div class="card bg-light text-dark p-4">
                    <h3 class="card-title">WELCOME TO THE LABORATORY</h3>
                    <p class="card-text">Rekayasa Perangkat Lunak - You can enjoy our online service <i
                            class="fa-solid fa-clock"></i></p>
                </div>
            </div>
        </div>

        <!--Data START-->
        <div class="row justify-content-evenly align-items-center text-center">
            <div class="col-lg-8 mb-4 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body">
                        <div style="max-height: 240px; overflow-y: auto;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Tools</th>
                                        <th>Loan Amount</th>
                                        <th>Loan Date</th>
                                        <th>Return Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    while ($data = mysqli_fetch_array($exe)) {
                                        // Mengonversi tanggal loan_date dan return_date menjadi format d-m-Y
                                        $loan_date = date('d, M Y', strtotime($data['loan_date']));
                                        $return_date = date('d, M Y', strtotime($data['return_date']));
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $data['user_name'] ?></td>
                                            <td><?= $data['tool_name'] ?></td>
                                            <td><?= $data['number_tools'] ?> Items</td>
                                            <td><?= $loan_date ?></td>
                                            <td><?= $return_date ?></td>
                                            <td>
                                                <?php if ($data['status'] === 'borrowed'): ?>
                                                    Borrowed
                                                <?php elseif ($data['status'] === 'returned'): ?>
                                                    Returned
                                                <?php elseif ($data['status'] === 'check'): ?>
                                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#show" onclick="loadData(<?= $data['id'] ?>)">
                                                        Check
                                                    </button>
                                                <?php else: ?>
                                                    <?= $data['status'] ?>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>

                            </table>
                        </div>
                        <span
                            class="position-absolute top-0 start-30 translate-middle badge rounded-pill text-white btn btn-primary"><i
                                class="fa-solid fa-desktop"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <!--Data END-->
    </div>
    <!--Container END-->

    <div class="text-center">
        <p class="fw-bold fs-4 card-title">List Of Tools</p>
    </div>
    <div class="container mt-5 mb-5">
        <div class="row g-4">
            <?php
            $query = "SELECT * FROM barang";
            $exe = mysqli_query($conn, $query);

            if (mysqli_num_rows($exe) > 0) {
                // Mulai perulangan untuk setiap baris data
                while ($row = mysqli_fetch_assoc($exe)) {
            ?>
                    <div class="col-md-3">
                        <div class="card h-100 shadow-lg p-3 mb-5 bg-body-tertiary rounded border border-light-subtle">
                            <img src="../guru/assets/images/<?php echo $row['image']; ?>" class="card-img-top" alt="<?php echo $row['name']; ?>" style="max-height: 200px; object-fit: cover;">

                            <div class="card-body text-center">
                                <h5 class="card-title mb-2"><?php echo $row['name']; ?></h5>
                                <p class="card-text text-muted">Stock: <?php echo $row['item_stock']; ?></p>
                            </div>

                            <div class="card-footer text-center">
                                <?php if ($row['item_stock'] > 0) { ?>
                                    <button type="button" class="btn btn-primary view-detail" data-bs-toggle="modal" data-bs-target="#add" data-id="<?php echo $row['id']; ?>">
                                        Borrow
                                    </button>
                                <?php } else { ?>
                                    <p class="text-danger mb-0 fw-bold">All Borrowed</p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<p>Tidak ada data yang ditemukan.</p>';
            }
            ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Tangkap event klik pada tombol "Lihat Detail"
            $('.view-detail').on('click', function() {
                var toolId = $(this).data('id'); // Ambil ID dari barang yang dipilih
                $('#id').val(toolId); // Isi input hidden dengan ID barang
            });
        });
    </script>
    <!-- Modal Add Data-->
    <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Loan Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="saveloan.php" method="post">
                        <div class="form-row">
                            <div class="form-group">
                                <input type="hidden" name="tools_id" class="form-control" id="id_borrow" required value="">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <!-- <label>Borrower Name</label> -->
                                <input type="text" name="borrower_id" class="form-control" id="nim" required
                                    value="<?php echo $_SESSION['id'] ?>" hidden>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="form-group">
                                <label>Number of Tools</label>
                                <input type="text" name="number_tools" class="form-control" id="jumlah" required
                                    placeholder="Enter The Number of Tools">
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="form-group">
                                <label for="input_from"><i class="fa-solid fa-calendar-days"></i> Loan Date</label>
                                <input type="text" name="tgl_pinjam" class="form-control" id="input_from"
                                    placeholder="Start Date" style="width: 180px;" required>
                            </div>
                            <div class="form-group mt-2">
                                <label for="input_to"><i class="fa-solid fa-calendar-days"></i> Return Date</label>
                                <input type="text" name="tgl_kembali" class="form-control" id="input_to"
                                    placeholder="End Date" style="width: 180px;" required>
                            </div>
                        </div>
                        <input type="hidden" value="check" name="status">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Tangkap event klik pada tombol "Lihat Detail"
            $('.view-detail').on('click', function() {
                var toolId = $(this).data('id'); // Ambil ID dari barang yang dipilih
                $('#id_borrow').val(toolId); // Isi input hidden dengan ID barang yang dipilih
            });
        });
    </script>
    <script>
        function loadData(id) {
            // Lakukan AJAX untuk mengambil data berdasarkan id
            fetch(`getData.php ? id = $ {
                    id
                }`)
                .then(response => response.text())
                .then(data => {
                    // Masukkan data yang diterima ke dalam modal
                    document.getElementById('modalContent').innerHTML = data;
                })
                .catch(error => console.error('Error fetching data:', error));
        }
    </script>
    <!-- Modal Show Data -->
    <div class="modal fade" id="show" tabindex="-1" aria-labelledby="checkModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkModalLabel">Loan Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Data akan dimuat di sini -->
                    <div id="modalContent">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!--Footer START-->
    <!--Footer END-->

    <!-- <a id="back-to-top" href="#" class="btn-primary btn-md back-to-top" role="button"><i
            class="fas fa-chevron-up"></i></a> -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/picker.js"></script>
    <script src="js/picker.date.js"></script>
    <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
    <script src="home.js"></script>

</body>

</html>