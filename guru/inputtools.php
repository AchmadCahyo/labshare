<?php
session_start();
include "../config/conn.php";
if (empty($_SESSION['username']) or empty($_SESSION['role'])) {
    echo "<script>alert('To open this page, please log in first!');document.location='../login.php'</script>";
}
if (isset($_SESSION['message'])) {
    echo "<script>alert('" . $_SESSION['message'] . "');</script>";
    // Hapus pesan dari sesi setelah ditampilkan
    unset($_SESSION['message']);
}

$sql =  'SELECT * FROM barang';
$sql2 =  "SELECT * FROM users WHERE role ='siswa'";
$exe = mysqli_query($conn, $sql);
$exe3 = mysqli_query($conn, $sql2);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home | Guru</title>
    <script src="https://kit.fontawesome.com/f8a09ade68.js" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" href="../guru/inputstyle.css"> -->
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
    <!--Navbar START-->
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

        <!-- <div class="alert alert-success" role="alert">
            Data Dihapus
        </div> -->
        <!--Card Item Start-->
        <div class="row justify-content-center text-center align-items-center mt-lg-4">
            <div class="col-lg-12">
                <div class="custom-card card">
                    <button type="button" class="btn btn-custom fw-bold my-3" data-bs-toggle="modal"
                        data-bs-target="#add">
                        Add Borrow Items
                    </button>
                    <div class="card-body text-body">
                        <h5 class="card-title text-center">Data Tools</h5>
                        <div style="max-height: 240px; overflow-y: auto;">
                            <table class="table table-hover table-bordered table-striped align-middle">
                                <thead class="table table-striped">
                                    <tr>
                                        <th>No</th>
                                        <th>Tools Code</th>
                                        <th>Tools Name</th>
                                        <th>Amount Tools</th>
                                        <th>Tools Image</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- PHP loop to populate table -->
                                    <?php
                                    $no = 1;
                                    while ($data = mysqli_fetch_array($exe)) {
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $data['item_code'] ?></td>
                                            <td><?= $data['name'] ?></td>
                                            <td><?= $data['item_stock'] ?> Items</td>
                                            <td>
                                                <img src="assets/images/<?= $data['image'] ?>" alt="" width="90px">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary"
                                                    onclick="showUpdateModal(<?= $data['id'] ?>, '<?= $data['item_code'] ?>', '<?= $data['name'] ?>', <?= $data['item_stock'] ?>)">
                                                    <i class="fa-solid fa-pen"></i> Update
                                                </button>
                                                <button type="button" class="btn btn-danger"
                                                    onclick="showDeleteModal(<?= $data['id'] ?>, '<?= $data['item_code'] ?>', '<?= $data['name'] ?>', <?= $data['item_stock'] ?>)">
                                                    <i class="fa-solid fa-trash"></i> Delete
                                                </button>
                                            </td>

                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <span class="position-absolute top-0 start-30 translate-middle badge custom-badge"><i
                                class="fa-solid fa-desktop"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <!--Card Item End-->
    </div>
    <!--Container END-->

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteLabel">Konfirmasi Penghapusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data item ini?
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" action="controller/delete_item.php" method="POST">
                        <input type="hidden" name="id" id="deleteItemId">
                        <input type="hidden" name="item_code" id="deleteItemCode">
                        <input type="hidden" name="name" id="deleteItemName">
                        <input type="hidden" name="item_stock" id="deleteItemStock">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Add -->
    <div class="modal fade" id="add" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Insert Data Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="controller/newtools.php" method="post" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="form-group">
                                <input type="hidden" name="id" class="form-control" id="addId" value="">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Item Code</label>
                                <input type="text" name="item_code" class="form-control" id="addItemCode" required
                                    placeholder="Item Code Must Be Unique">
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="form-group">
                                <label>Tools Name</label>
                                <input type="text" name="name" class="form-control" id="addName" required
                                    placeholder="Name Of The Tools">
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="form-group">
                                <label>Amount Tools</label>
                                <input type="number" name="item_stock" class="form-control" id="addItemStock" required
                                    placeholder="Amount Of The Tools">
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="form-group">
                                <label for="formFile" class="form-label">Tools Image</label>
                                <input class="form-control" type="file" name="image">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Update -->
    <div class="modal fade" id="update" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Data Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="controller/update_item.php" method="post" enctype="multipart/form-data"> <!-- Tambahkan enctype -->
                        <div class="form-row">
                            <div class="form-group">
                                <input type="hidden" name="id" class="form-control" id="updateId" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Item Code</label>
                                <input type="text" name="item_code" class="form-control" id="updateItemCode" required>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="form-group">
                                <label>Tools Name</label>
                                <input type="text" name="name" class="form-control" id="updateName" required>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="form-group">
                                <label>Amount Tools</label>
                                <input type="number" name="item_stock" class="form-control" id="updateItemStock" required>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="form-group">
                                <label>Upload Image</label> <!-- Label untuk input gambar -->
                                <input type="file" name="image" class="form-control" id="updateImage" accept="image/*"> <!-- Input untuk gambar -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Menampilkan modal update dengan data item
        function showUpdateModal(id, itemCode, name, itemStock) {
            document.getElementById('updateId').value = id;
            document.getElementById('updateItemCode').value = itemCode;
            document.getElementById('updateName').value = name;
            document.getElementById('updateItemStock').value = itemStock;

            var updateModal = new bootstrap.Modal(document.getElementById('update'));
            updateModal.show();
        }
    </script>


    <a id="back-to-top" href="#" class="btn btn-warning btn-md back-to-top" role="button"><i
            class="fas fa-chevron-up"></i></a>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/picker.js"></script>
    <script src="js/picker.date.js"></script>
    <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="home.js"></script>
    <script>
        // Menampilkan modal konfirmasi saat tombol delete diklik
        function showDeleteModal(id, itemCode, name, itemStock) {
            // Isi input hidden dengan data yang relevan
            document.getElementById('deleteItemId').value = id;
            document.getElementById('deleteItemCode').value = itemCode;
            document.getElementById('deleteItemName').value = name;
            document.getElementById('deleteItemStock').value = itemStock;

            // Tampilkan modal
            var myModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            myModal.show();
        }
    </script>
</body>

</html>