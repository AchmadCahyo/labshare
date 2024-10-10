<?php
session_start();
include "../config/conn.php";
if (empty($_SESSION['username']) or empty($_SESSION['role'])) {
  echo "<script>alert('To open this page, please log in first!');document.location='../login.php'</script>";
}
$user_id = $_SESSION['id'];
$query2 = "SELECT peminjaman.*, barang.name AS tool_name, users.name AS user_name FROM peminjaman 
INNER JOIN barang ON peminjaman.tools_id = barang.id 
INNER JOIN users ON peminjaman.borrower_id = users.id 
WHERE borrower_id = '$user_id' AND (status = 'check' OR status = 'borrowed')";
// echo $query2;
$query3 = "SELECT peminjaman.*, barang.name AS tool_name, users.name AS user_name FROM peminjaman 
INNER JOIN barang ON peminjaman.tools_id = barang.id 
INNER JOIN users ON peminjaman.borrower_id = users.id 
WHERE borrower_id = '$user_id' AND status = 'returned'";
$exe = mysqli_query($conn, $query2);
$exe3 = mysqli_query($conn, $query3);
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home | Siswa</title>
  <link rel="stylesheet" href="../guru/styleguru.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://kit.fontawesome.com/f8a09ade68.js" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/f8a09ade68.js" crossorigin="anonymous"></script>
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
            <a class="nav-link active" aria-current="page" href="homesiswa.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="peminjamansiswa.php">Go To Loan Page</a>
          </li>
        </ul>
        <form class="logout d-flex mt-3 nav-link" role="submit">
          <p class="me-2"><i class="fa-solid fa-user-graduate"></i> Hello, <?= $_SESSION['name'] ?></p>
          <p class="me-2">|</p>
          <a href="../controller/logout.php" role="button"><i class="fa-solid fa-right-from-bracket nav-link"> Log
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

    <!--Card Item Start-->
    <div class="row">
      <div class="col-lg-6 mb-4 d-flex align-items-stretch">
        <div class="card w-100">
          <div class="card-body">
            <h5 class="card-title text-center">Loan Request</h5>
            <div class="scroll-section">
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
                          <form action="kembali.php" method="post">
                            <input type="hidden" name="id" value="<?= $data['id'] ?>">
                            <button class="btn btn-primary" name="update">Return</button>
                          </form>
                        <?php elseif ($data['status'] === 'wait'): ?>
                          <button class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#waitModal-<?= $data['id'] ?>">Detail Return</button>

                        <?php else: ?>
                          <?= $data['status'] ?>
                        <?php endif; ?>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>

            </div>
            <!-- <a href="peminjamansiswa.php" class="btn btn-primary d-block mt-3">Go to Your Loan Page</a> -->
          </div>
        </div>
      </div>
      <div class="col-lg-6 mb-4 d-flex align-items-stretch">
        <div class="card w-100">
          <div class="card-body">
            <h5 class="card-title text-center">History Loan</h5>
            <div class="scroll-section">
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
                  while ($data = mysqli_fetch_array($exe3)) {
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
                      <td>Returned</td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <!-- <a href="peminjamansiswa.php" class="btn btn-primary d-block mt-3">Go to Your Loan Page</a> -->
          </div>
        </div>
      </div>
    </div>
    <!--Card Item End-->
  </div>
  <!--Container END-->

  <?php
  // Memproses modal secara terpisah di luar tabel
  $exe = mysqli_query($conn, $query2); // Jalankan lagi query agar bisa digunakan ulang
  while ($data = mysqli_fetch_array($exe)) { ?>
    <!-- Modal Data Returned -->
    <div class="modal fade" id="waitModal-<?= $data['id'] ?>" tabindex="-1"
      aria-labelledby="waitModalLabel-<?= $data['id'] ?>" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="waitModalLabel-<?= $data['id'] ?>">
              Returned Details
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-start">
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label">Borrower</label>
              <div class="col-sm-9">
                <p class="form-control-plaintext fw-bold">
                  <?= $data['borrower_name'] ?></p>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label">Tool</label>
              <div class="col-sm-9">
                <p class="form-control-plaintext fw-bold"><?= $data['name'] ?></p>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label">Loan Amount</label>
              <div class="col-sm-9">
                <p class="form-control-plaintext fw-bold">
                  <?= $data['number_tools'] ?> Items</p>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label">Loan Date</label>
              <div class="col-sm-9">
                <p class="form-control-plaintext fw-bold"><?= $data['loan_date'] ?>
                </p>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label">Return Date</label>
              <div class="col-sm-9">
                <p class="form-control-plaintext fw-bold">
                  <?= $data['return_date'] ?></p>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label">Actual Return Date</label>
              <div class="col-sm-9">
                <p class="form-control-plaintext fw-bold">
                  <?= date('d F Y', strtotime($data['actual_return_date'])) ?>
                </p>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="alert alert-info fw-bold" role="alert" style="text-align: center; margin-top: 20px;">
              Show this message to the admin while carrying the borrowed tools.
            </div>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>
  <!-- Back to top -->
  <a href="#" class="back-to-top"><i class="fas fa-arrow-up"></i></a>

  <!-- Footer
    <div class="footer">
        <p>&copy; 2023 Rekayasa Perangkat Lunak. All Rights Reserved.</p>
    </div> -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Include Bootstrap JS at the end of the body -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>