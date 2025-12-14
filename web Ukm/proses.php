<?php 
include "koneksi.php";

$nama      = $_POST['nama'];
$nim       = $_POST['nim'];
$prodi     = $_POST['prodi'];
$fakultas  = $_POST['fakultas'];
$angkatan  = $_POST['angkatan'];
$nohp      = $_POST['no_hp'];

// Upload foto
$namaFile = $_FILES['foto']['name'];
$lokasiTmp = $_FILES['foto']['tmp_name'];
$folder = "uploads/";

// jika folder belum ada → buat
if (!is_dir($folder)) {
    mkdir($folder, 0777, true);
}

// pindahkan foto
move_uploaded_file($lokasiTmp, $folder . $namaFile);

// Query insert
$sql = "
    INSERT INTO pendaftaran (nama, nim, prodi, fakultas, angkatan, no_hp, foto)
    VALUES ('$nama', '$nim', '$prodi', '$fakultas', '$angkatan', '$nohp', '$namaFile')
";

// Eksekusi query
if($koneksi->query($sql)){
    echo "Data berhasil dikirim! <a href='member.php'>Lihat Data</a>";
} else {
    echo "Gagal: " . $koneksi->error;
}

?>
