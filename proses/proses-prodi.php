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
    // Mengambil data brand dari form edit menggunakan metode POST
    $dataProdi = [
        'id_brand'    => isset($_POST['id_brand']) ? $_POST['id_brand'] : null,        // sebelumnya 'id'
        'kode_brand'  => isset($_POST['kode_brand']) ? $_POST['kode_brand'] : null,    // sebelumnya 'kode'
        'jenis_brand' => isset($_POST['jenis_brand']) ? $_POST['jenis_brand'] : null   // sebelumnya 'nama'
    ];

    // Memanggil method updateProdi untuk mengupdate data brand
    $update = $master->updateProdi($dataProdi);
    if ($update) {
        // Jika berhasil
        header("Location: ../master-prodi-list.php?status=editsuccess");
    } else {
        // Jika gagal
        header("Location: ../master-prodi-edit.php?id=" . $dataProdi['id_brand'] . "&status=failed");
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
