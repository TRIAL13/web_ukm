<?php  
include "koneksi.php";

// Hitung jumlah anggota
$jml_anggota = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pendaftaran"));

// Jumlah pelatih (manual)
$jml_pelatih = 2;

// Ambil data member
$query = mysqli_query($koneksi, "SELECT * FROM pendaftaran ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members UKM Voli</title>
        <link rel="stylesheet" href="style.css" >
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- NAVBAR -->

    <style>

        .counter-box {
            display: flex;
            gap: 50px;
            margin-bottom: 20px;
        }

        .counter {
            margin-left: 40px;
            background: #f7c600;
            padding: 15px 25px;
            border-radius: 10px;
            font-size: 18px;
            color: #003087;
            font-weight: bold;
        }
table th, table td {
    text-align: center;
    vertical-align: middle; /* agar teks/input benar-benar di tengah */
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

        h2 { color: #003087;
        margin-left: 50px; }
    </style>

<body>
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
    </head>
    <br>
    <br>
<h2>Daftar Member UKM Voli</h2>
    <br>
    <br>
<!-- COUNTER -->
<div class="counter-box">
    <div class="counter">Jumlah Anggota: <?= $jml_anggota ?></div>
    <div class="counter">Jumlah Pelatih: <?= $jml_pelatih ?></div>
</div>

<!-- TABLE MEMBER -->
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
    </tr>

    <?php 
    $no = 1;
    while($row = mysqli_fetch_assoc($query)) { 
    ?>
    <tr>
        <td><?= $no++ ?></td>

        <td>
            <img src="uploads/<?= $row['foto'] ?>" 
                 onerror="this.src='img/default_user.png'">
        </td>

        <td><?= $row['nama'] ?></td>
        <td><?= $row['nim'] ?></td>
        <td><?= $row['prodi'] ?></td>
        <td><?= $row['fakultas'] ?></td>
        <td><?= $row['angkatan'] ?></td>
        <td><?= $row['no_hp'] ?></td>
    </tr>
    <?php } ?>
</table>

  <script src="scripts.js"></script>
</body>
</html>
