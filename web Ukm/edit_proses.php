<?php 
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

include "koneksi.php";

$id        = $_POST['id'];
$nama      = $_POST['nama'];
$nim       = $_POST['nim'];
$prodi     = $_POST['prodi'];
$fakultas  = $_POST['fakultas'];
$angkatan  = $_POST['angkatan'];
$no_hp     = $_POST['no_hp'];

// -------------------------
// HANDLING FOTO
// -------------------------
$foto_lama = $_POST['foto_lama'];  // dari hidden input
$foto_baru = $_FILES['foto']['name'];

if ($foto_baru != "") {

    $ext = pathinfo($foto_baru, PATHINFO_EXTENSION);
    $nama_file_baru = "foto_" . time() . "." . $ext;

    $upload_path = "uploads/" . $nama_file_baru;

    if (move_uploaded_file($_FILES['foto']['tmp_name'], $upload_path)) {

        // hapus foto lama jika ada
        if ($foto_lama != "" && file_exists("uploads/" . $foto_lama)) {
            unlink("uploads/" . $foto_lama);
        }

        $foto_final = $nama_file_baru;

    } else {
        echo "Upload foto gagal";
        exit;
    }

} else {
    // jika tidak upload foto baru
    $foto_final = $foto_lama;
}

// -------------------------
// UPDATE DATA
// -------------------------
$sql = "UPDATE pendaftaran SET 
            nama='$nama',
            nim='$nim',
            prodi='$prodi',
            fakultas='$fakultas',
            angkatan='$angkatan',
            no_hp='$no_hp',
            foto='$foto_final'
        WHERE id='$id'";

if($koneksi->query($sql)){
    echo "<script>
            alert('Data berhasil diperbarui!');
            window.location='admin.php';
          </script>";
} else {
    echo "Gagal: " . $koneksi->error;
}
?>
