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

// $sql =  'SELECT * FROM barang';
$sql2 =  "SELECT * FROM users WHERE role ='guru'";
// $exe = mysqli_query($conn, $sql);
$exe3 = mysqli_query($conn, $sql2);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home | Guru</title>
    <script src="https://kit.fontawesome.com/f8a09ade68.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styleguru.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../guru//styleguru.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<style>
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

    #passwordTooltip {
        display: none;
        position: absolute;
        top: 50px;
        left: 30px;
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        padding: 8px;
        border-radius: 5px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 1000;
    }
</style>

<body>
    <!--Navbar START-->
    <nav class="navbar navbar-expand-lg fw-bold">
        <div class="container">
            <a class="navbar-brand" href="#"><img class="logo" src="../assets/image/logolab.png" style="height: 40px;"
                    alt=""></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="homeguru.php">Home</a>
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
                        <a class="nav-link active" href="addguru.php">Add Admin</a>
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
                    <p class="card-text">Rekayasa Perangkat Lunak - You can enjoy our online service <i class="fa-solid fa-clock"></i></p>
                </div>
            </div>
        </div>
        <!-- <div class="alert alert-success" role="alert">
            Data Dihapus
        </div> -->
        <!--Card Item Start-->
        <div class="row justify-content-center text-center align-items-center mt-lg-4">
            <div class="col-lg-8">
                <div class="custom-card card">
                    <button type="button" class="btn btn-custom fw-bold my-3" data-bs-toggle="modal" data-bs-target="#add">
                        Add New Admin
                    </button>
                    <div class="card-body text-body">
                        <h5 class="card-title text-center">Existing Admin</h5>
                        <div style="max-height: 240px; overflow-y: auto;">
                            <table class="table table-striped table-hover">
                                <thead class="table table-striped">
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- PHP loop to populate table -->
                                    <?php
                                    $no = 1;
                                    while ($data = mysqli_fetch_array($exe3)) {
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $data['name'] ?></td>
                                            <td><?= $data['username'] ?></td>
                                            <td><?= $data['email'] ?></td>
                                            <td>
                                                <!-- Tombol Delete -->
                                                <button type="button" class="btn btn-danger btn-sm" onclick="showDeleteModal(<?= $data['id'] ?>, '<?= $data['username'] ?>', '<?= $data['name'] ?>', '<?= $data['email'] ?>')">Delete</button>
                                                <!-- Tombol Update -->
                                                <button type="button" class="btn btn-warning btn-sm" onclick="showUpdateModal(<?= $data['id'] ?>, '<?= $data['username'] ?>', '<?= $data['name'] ?>', '<?= $data['email'] ?>')">Update</button>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <span class="position-absolute top-0 start-30 translate-middle badge custom-badge"><i class="fa-solid fa-desktop"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <!--Card Item End-->
    </div>
    <!--Container END-->

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteLabel">Delete Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this admin data?
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" action="controller/delete_item.php" method="POST">
                        <input type="hidden" name="id" id="deleteItemId">
                        <input type="hidden" name="username" id="deleteItemUsername">
                        <input type="hidden" name="name" id="deleteItemName">
                        <input type="hidden" name="email" id="deleteItemEmail">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add -->
    <div class="modal fade" id="add" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Insert Data Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="../controller/regisconn.php">
                        <div class="form-row">
                            <div class="form-group">
                                <input type="hidden" name="id" class="form-control" id="addId" value="">
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" id="nama" class="form-control form-control-md" placeholder="Enter Your Name" required />
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" id="username" class="form-control form-control-md" placeholder="Enter Username" required />
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" id="email" class="form-control form-control-md" placeholder="Enter Email" required />
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" id="password" class="form-control form-control-md" placeholder="Enter Password" required />
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="form-group">
                                <input type="hidden" name="role" id="role" class="form-control form-control-md" value="guru" />
                            </div>
                        </div>
                        <div class="modal-footer mt-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Modal -->
    <div class="modal fade" id="update" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Admin Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="controller/updateguru.php" method="post">
                        <input type="hidden" name="id" id="updateId">
                        <div class="form-row mt-3">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" id="updateusername" required>
                        </div>
                        <div class="form-row mt-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" id="updateName" required>
                        </div>
                        <div class="form-row mt-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" id="updateemail" required>
                        </div>
                        <div class="form-row mt-3 position-relative">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" id="updatePassword" placeholder="">

                            <!-- Icon dengan tooltip -->
                            <i class="fa-solid fa-info-circle mt-2 ms-2" id="passwordInfoIcon" style="cursor: pointer;"></i>

                            <!-- Tooltip yang akan muncul saat icon di-hover -->
                            <div id="passwordTooltip" style="display: none; position: absolute; top: 50px; left: 30px; background-color: #f8f9fa; border: 1px solid #ddd; padding: 8px; border-radius: 5px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); z-index: 1000;">
                                <p style="margin: 0; font-size: 12px; color: #333; font-weight:bold;">Jangan mengisi inputan password jika tidak ingin mengubahnya. Isi jika Anda ingin mengganti password lama.</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                    <script>
                        document.getElementById('passwordInfoIcon').addEventListener('mouseover', function() {
                            // Tampilkan tooltip saat cursor di atas icon
                            document.getElementById('passwordTooltip').style.display = 'block';
                        });

                        document.getElementById('passwordInfoIcon').addEventListener('mouseout', function() {
                            // Sembunyikan tooltip saat cursor keluar dari icon
                            document.getElementById('passwordTooltip').style.display = 'none';
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Menampilkan modal update dengan data item
        function showUpdateModal(id, username, name, email) {
            // Isi field modal dengan data yang dikirim
            document.getElementById('updateId').value = id;
            document.getElementById('updateusername').value = username;
            document.getElementById('updateName').value = name;
            document.getElementById('updateemail').value = email;
            // document.getElementById('updatePassword').value = password;

            // Tampilkan modal
            var updateModal = new bootstrap.Modal(document.getElementById('update'));
            updateModal.show();
        }
    </script>


    <a id="back-to-top" href="#" class="btn btn-warning btn-md back-to-top" role="button"><i class="fas fa-chevron-up"></i></a>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/picker.js"></script>
    <script src="js/picker.date.js"></script>
    <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="home.js"></script>
    <script>
        function showDeleteModal(id, username, name, email) {
            // Isi input hidden dengan data yang relevan
            document.getElementById('deleteItemId').value = id;
            document.getElementById('deleteItemUsername').value = username;
            document.getElementById('deleteItemName').value = name;
            document.getElementById('deleteItemEmail').value = email;

            // Tampilkan modal
            var myModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            myModal.show();
        }
    </script>
</body>

</html>