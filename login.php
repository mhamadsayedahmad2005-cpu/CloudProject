<?php
include "connect.php";
session_start();
$email = $_POST["email"];
$password = $_POST["password"];


if ($email === "admin" && $password === "admin") {
    $_SESSION["login"] = true;
    $_SESSION['role'] = 'admin';
    header("Location: manageData.php");
    exit();
}

$qry = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn, $qry);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);
    if ($password === $row["password"]) {
        $_SESSION["login"] = true;
        $_SESSION['id'] = $row['id'];
        header("Location: home.php");
        exit();
    } else {
        echo "Email or password incorrect";
    }
} else {
    echo "Register first";
}
?>
