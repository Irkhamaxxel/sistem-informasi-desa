<?php
$host = 'localhost';  // atau '127.0.0.1'
$user = 'root';       // username MySQL Anda
$password = '';       // password MySQL Anda, biasanya kosong untuk default
$dbname = 'sidata'; // nama database Anda

$koneksi = new mysqli($host, $user, $password, $dbname);

if ($koneksi->connect_error) {
    die('Koneksi gagal: ' . $koneksi->connect_error);
}

?>