<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register</title>

  <script src="https://kit.fontawesome.com/f8a09ade68.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="register.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<body>
  <section class="vh-200">
    <div class="container p-5">
      <form method="POST" action="controller/regisconn.php">
        <div class="text-center fs-2 fw-bold">
          Register
        </div>
        <table class="form-table">
          <tr>
            <td>
              <input type="hidden" name="id">
            </td>
          </tr>
          <tr>
            <td>
              <input type="text" name="name" id="nama" class="form-control form-control-lg" placeholder="Enter Your Name" required />
            </td>
          </tr>
          <tr>
            <td>
              <input type="text" name="username" id="username" class="form-control form-control-lg" placeholder="Enter Username" required />
            </td>
          </tr>
          <tr>
            <td>
              <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="Enter Email" required />
            </td>
          </tr>
          <tr>
            <td>
              <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Enter Password" required />
            </td>
          </tr>
          <!-- <tr>
            <td>
              <input type="password" name="cpassword" id="cppassword" class="form-control form-control-lg" placeholder="Confirm Password" required />
            </td>
          </tr> -->
          <tr>
            <td>
              <select class="form-select" name="role" id="level" style="width: 100%;">
                <option value="" disabled selected>--Pilih--</option>
                <option value="siswa">Siswa</option>
              </select>
            </td>
          </tr>
          <tr>
            <td>
              <div class="d-flex justify-content-between align-items-center mt-4">
                <p class="login-register-text">Already Have an Account? <a href="login.php">Login</a></p>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <button type="submit" class="btn btn-primary btn-lg" style="width: 100%; padding: 1rem;"name="submit">Register</button>
            </td>
          </tr>
        </table>
      </form>
    </div>
  </section>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/picker.js"></script>
  <script src="js/picker.date.js"></script>
  <script src="js/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>


</html>