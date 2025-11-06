<?php
include_once '../config/class-mahasiswa.php';
$mahasiswa = new Mahasiswa();

// Ambil data dari form edit produk
$dataMahasiswa = [
    'id_produk'     => $_POST['id_produk'],
    'nama_produk'   => $_POST['nama_produk'],
    'nama_brand'    => $_POST['jenis_brand'],
    'jenis_device'  => $_POST['jenis_device'],
    'deskripsi'     => $_POST['deskripsi'],
    'status_produk' => $_POST['status_produk']
];

$edit = $mahasiswa->editMahasiswa($dataMahasiswa);

// Redirect sesuai hasil edit
if ($edit) {
    header("Location: ../data-list.php?status=editsuccess");
} else {
    header("Location: ../data-edit.php?id=" . $dataMahasiswa['id_produk'] . "&status=failed");
}
exit();
?>
