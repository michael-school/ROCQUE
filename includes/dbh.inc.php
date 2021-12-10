<?php

$servername = 'localhost:3306';
$dbUsername = 'mahs_BMDBTMBMM';
$dbPassword = 'mustangs';
$dbName = 'mahs_BMDBTMBMM';

$conn = mysqli_connect($servername, $dbUsername, $dbPassword, $dbName);

if(!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}