<?php

// Memasukkan file class-mahasiswa.php untuk mengakses class Mahasiswa
include '../config/class-mahasiswa.php';

// Membuat objek dari class Mahasiswa
$mahasiswa = new Mahasiswa();

// Mengambil data mahasiswa dari form input menggunakan metode POST dan menyimpannya dalam array
$dataMahasiswa = [
    'nama_brand'    => isset($_POST['nama_brand']) ? $_POST['nama_brand'] : '',
    'nama_produk'   => isset($_POST['nama_produk']) ? $_POST['nama_produk'] : '',
    'jenis_device'  => isset($_POST['jenis_device']) ? $_POST['jenis_device'] : '',
    'deskripsi'     => isset($_POST['deskripsi']) ? $_POST['deskripsi'] : '',
    'status_produk' => isset($_POST['status_produk']) ? $_POST['status_produk'] : ''
];

// Memanggil method inputMahasiswa untuk memasukkan data mahasiswa dengan parameter array $dataMahasiswa
$input = $mahasiswa->inputMahasiswa($dataMahasiswa);

// Mengecek apakah proses input berhasil atau tidak - true/false
if ($input) {
    // Jika berhasil, redirect ke halaman data-list.php dengan status inputsuccess
    header("Location: ../data-list.php?status=inputsuccess");
} else {
    // Jika gagal, redirect ke halaman data-input.php dengan status failed
    header("Location: ../data-input.php?status=failed");
}

exit; // disarankan untuk menghentikan script setelah redirect
?>
