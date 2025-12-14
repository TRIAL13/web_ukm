<?php 
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

include "koneksi.php";

$id = $_GET['id'];
$data = $koneksi->query("SELECT * FROM pendaftaran WHERE id='$id'");
$row = $data->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Member</title>
</head>
<body>

<h2>Edit Data Anggota</h2>

<form action="edit_proses.php" method="POST" enctype="multipart/form-data">

    <!-- ID -->
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

    <!-- FOTO LAMA -->
    <input type="hidden" name="foto_lama" value="<?php echo $row['foto']; ?>">

    <label>Nama Lengkap:</label><br>
    <input type="text" name="nama" value="<?php echo $row['nama']; ?>" required><br><br>

    <label>NIM:</label><br>
    <input type="text" name="nim" value="<?php echo $row['nim']; ?>" required><br><br>

    <label>Prodi:</label><br>
    <input type="text" name="prodi" value="<?php echo $row['prodi']; ?>" required><br><br>

    <label>Fakultas:</label><br>
    <input type="text" name="fakultas" value="<?php echo $row['fakultas']; ?>" required><br><br>

    <label>Angkatan:</label><br>
    <input type="number" name="angkatan" value="<?php echo $row['angkatan']; ?>" required><br><br>

    <label>No HP:</label><br>
    <input type="text" name="no_hp" value="<?php echo $row['no_hp']; ?>" required><br><br>

    <label>Foto Saat Ini:</label><br>
    <img src="uploads/<?php echo $row['foto']; ?>" width="120" style="border-radius:5px;"><br><br>

    <label>Ganti Foto (Opsional):</label><br>
    <input type="file" name="foto"><br><br>

    <button type="submit">Simpan Perubahan</button>

</form>

</body>
</html>
