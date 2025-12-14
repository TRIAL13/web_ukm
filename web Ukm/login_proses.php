<?php
session_start();

$admin_user = "admin";
$admin_pass = "n1P3K4b2";

$username = $_POST['username'];
$password = $_POST['password'];

if ($username == $admin_user && $password == $admin_pass) {
    $_SESSION['admin'] = true;
    header("Location: admin.php");
    exit();
} else {
    echo "<script>alert('Login gagal!'); window.location='login.php';</script>";
}
?>
