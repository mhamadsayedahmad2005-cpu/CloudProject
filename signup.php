<?php

include "connect.php";
$username=$_POST["name"];
$email=$_POST["email"];
$password=$_POST["password"];
$qry2="Select * from users where email='$email'";
$result=mysqli_query($conn,$qry2);
if(mysqli_num_rows($result)>0){
    echo"You Are Already Registered";
}
else{
$qry="INSERT INTO users(name ,email ,password) Values('$username', '$email', '$password')";
if(mysqli_query($conn, $qry)){
    echo"Register successfull. Please Login!";
}
}
?>
