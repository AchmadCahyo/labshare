<?php
include "../config/conn.php";

$name = $_REQUEST['name'];
$username = $_REQUEST['username'];
$pass = hash('sha256', $_REQUEST['password']);
$email = $_REQUEST['email'];
$role = $_REQUEST['role'];

$query = "INSERT INTO users VALUES (null, '$name', '$username', '$email', '$pass', '$role')";
// echo $query;
$exe = mysqli_query($conn, $query);

if ($exe) {
    echo "<script>alert('Adding Data Successfully!'); document.location.href='../login.php'</script>";

}else {
    echo "<script>alert('Adding Data Unsuccessfully!'); document.location.href='../'</script>";
}