<?php 
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include "koneksi.php";

// ===================================
// HAPUS DATA
// ===================================
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    $ambil = $koneksi->query("SELECT foto FROM pendaftaran WHERE id='$id'");
    $data = $ambil->fetch_assoc();
    $foto = $data['foto'];

    if (file_exists("uploads/" . $foto)) {
        unlink("uploads/" . $foto);
    }

    $koneksi->query("DELETE FROM pendaftaran WHERE id='$id'");

    echo "<script>alert('Data berhasil dihapus!'); window.location='admin.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Data Member UKM Voli</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }
        th, td {
            border: 1px solid #444;
            padding: 10px;
        }
        img {
            width: 60px;
            border-radius: 6px;
        }
        .btn-hapus {
            background: red;
            color: white;
            padding: 6px 10px;
            border-radius: 4px;
            text-decoration: none;
        }
        .btn-edit {
            background: green;
            color: white;
            padding: 6px 10px;
            border-radius: 4px;
            text-decoration: none;
            text-align: center;
            
        }
        .action-buttons {
    display: flex;
    justify-content: center;
    gap: 10px; /* jarak antar tombol */
    margin-top: 10px;
}

                table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table th {
            background: #003087;
            color: white;
            padding: 10px;
        }

        table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        img {
            width: 90px;
            height: 130px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #ffc400;
        }

        h2 { color: #003087; }

        table th, table td {
    text-align: center;
    vertical-align: middle; /* agar teks/input benar-benar di tengah */
}

    </style>
</head>
<body>
    <!-- NAVBAR -->
    <div class="navbar">
        <div class="nav-left">
            <img src="img/logoUKM.jpg" class="logo">
        </div>

        <div class="nav-right">
            <a href="index.html" class="nav-item">Home</a>
            <a href="about.html" class="nav-item">About</a>
            <a href="tentang_kami.html" class="nav-item">Tentang Kami</a>
            <a href="admin.php" class="nav-item">Admin</a>
            <a href="member.php" class="nav-item">Members</a>
            <a href="contact.html" class="nav-contact">Contact</a>
        </div>
    </div>
    <br>
    <br>
<h2 style="text-align:center;">Data Member / Pendaftar UKM Voli</h2>

<br>
<br>
<a href="logout.php" style="background:red;color:white;padding:8px;text-decoration:none;border-radius:4px;">
    Logout
</a>

<table>
    <tr>
        <th>No</th>
        <th>Foto</th>
        <th>Nama</th>
        <th>NIM</th>
        <th>Prodi</th>
        <th>Fakultas</th>
        <th>Angkatan</th>
        <th>No HP</th>
        <th>Aksi</th>
    </tr>

    <?php
    $no = 1;
    $result = $koneksi->query("SELECT * FROM pendaftaran ORDER BY id DESC");

    while ($row = $result->fetch_assoc()) {
    ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><img src="uploads/<?= $row['foto']; ?>"></td>
            <td><?= $row['nama']; ?></td>
            <td><?= $row['nim']; ?></td>
            <td><?= $row['prodi']; ?></td>
            <td><?= $row['fakultas']; ?></td>
            <td><?= $row['angkatan']; ?></td>
            <td><?= $row['no_hp']; ?></td>
            <td>
<div class="action-buttons">
    <a href="edit.php?id=<?= $row['id']; ?>" class="btn-edit">Edit</a>
    <a href="admin.php?hapus=<?= $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus?');" class="btn-hapus">Hapus</a>
</div>

            </td>
        </tr>
    <?php } ?>
</table>

  <script src="scripts.js"></script>
</body>
</html>
