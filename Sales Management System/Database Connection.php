<?php
$conn = new mysqli("localhost","root",
"Password","sales_reporting");

if($conn->connect_error){
    die("Connection failed");
}
?>