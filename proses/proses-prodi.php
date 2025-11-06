<?php

// Memasukkan file class-master.php untuk mengakses class MasterData
include '../config/class-master.php';
// Membuat objek dari class MasterData
$master = new MasterData();

// Mengecek aksi yang dilakukan berdasarkan parameter GET 'aksi'
if ($_GET['aksi'] == 'inputprodi') {
    // Mengambil data brand dari form input menggunakan metode POST
    $dataProdi = [
        'kode_brand'  => isset($_POST['kode_brand']) ? $_POST['kode_brand'] : null,   // sebelumnya 'kode'
        'jenis_brand' => isset($_POST['jenis_brand']) ? $_POST['jenis_brand'] : null  // sebelumnya 'nama'
    ];

    // Memanggil method inputProdi untuk memasukkan data brand
    $input = $master->inputProdi($dataProdi);
    if ($input) {
        // Jika berhasil
        header("Location: ../master-prodi-list.php?status=inputsuccess");
    } else {
        // Jika gagal
        header("Location: ../master-prodi-input.php?status=failed");
    }

} elseif ($_GET['aksi'] == 'updateprodi') {
    // ✅ Perbaikan utama: sesuaikan nama field dengan form edit
    // Form master-prodi-edit.php mengirimkan 'kode' dan 'nama'
    $dataProdi = [
        'kode' => isset($_POST['kode']) ? $_POST['kode'] : null,
        'nama' => isset($_POST['nama']) ? $_POST['nama'] : null
    ];

    // Memanggil method updateProdi untuk mengupdate data brand
    $update = $master->updateProdi($dataProdi);
    if ($update) {
        // Jika berhasil
        header("Location: ../master-prodi-list.php?status=editsuccess");
    } else {
        // Jika gagal
        header("Location: ../master-prodi-edit.php?id=" . $dataProdi['kode'] . "&status=failed");
    }

} elseif ($_GET['aksi'] == 'deleteprodi') {
    // Mengambil id brand dari parameter GET
    $id = isset($_GET['id']) ? $_GET['id'] : null;

    // Memanggil method deleteProdi untuk menghapus data brand berdasarkan id
    $delete = $master->deleteProdi($id);
    if ($delete) {
        // Jika berhasil
        header("Location: ../master-prodi-list.php?status=deletesuccess");
    } else {
        // Jika gagal
        header("Location: ../master-prodi-list.php?status=deletefailed");
    }
}

?>
