<?php
session_start();
include '../config.php';

$email = $_POST['email'];
$password = $_POST['password'];

$data = mysqli_query($conn, "select * from users where email='$email'");
$row = mysqli_fetch_array($data);

$unHashPassword = password_verify($password, $row['password']);

print_r($row);

if ($row['role'] === 'seller') {
  if (mysqli_num_rows($data) > 0) {

    $_SESSION['username'] = $row['username'];
    $_SESSION['role'] = $row['role'];

    header("location: ../view/kamar");
  }
}

if ($unHashPassword) {
  if (mysqli_num_rows($data) > 0) {
    $_SESSION['username'] = $row['username'];
    $_SESSION['role'] = $row['role'];
    $_SESSION['address'] = $row['address'];
    $_SESSION['phone'] = $row['phone_number'];
    $_SESSION['id_user'] = $row['id_user'];

    header("location: ../view/landing-page");
  }
} else {
  echo 'Email dan Password tiak ada';
}
