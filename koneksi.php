<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "test1";

// GUNAKAN mysqli_connect, BUKAN mysqli_query
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>