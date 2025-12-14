<?php
$koneksi = new mysqli("localhost", "root", "", "ukm_voli");

if($koneksi->connect_error){
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>