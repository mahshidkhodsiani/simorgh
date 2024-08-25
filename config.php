<?php
// $servername = "89.32.250.180";
// $username = "vuqgpgoc_admin";
// $password = "ZKdN]DZ1kEuJ";
// $dbname = "vuqgpgoc_simorgh";

// $cfg['Lang'] = 'fa';
// $cfg['Charset'] = 'utf8mb4';


// $conn = mysqli_connect($servername, $username, $password, $dbname);


// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// $conn->set_charset("utf8");



$servername = "localhost";
$username = "root";
$password = "";
$dbname = "simorgh";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
