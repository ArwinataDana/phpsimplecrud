<?php

// Mengimpor file class-mahasiswa.php yang berisi class Mahasiswa
include_once 'config/class-mahasiswa.php';

// Membuat objek dari class Mahasiswa untuk mengakses fungsi CRUD
$mahasiswa = new Mahasiswa();

// Mengecek apakah ada parameter 'status' yang dikirim melalui URL (GET)
if(isset($_GET['status'])){
	// Jika status ditemukan, maka tampilkan pesan notifikasi sesuai nilainya
	if($_GET['status'] == 'inputsuccess'){
		// Pesan ketika data berhasil ditambahkan
		echo "<script>alert('Data produk berhasil ditambahkan.');</script>";
	} else if($_GET['status'] == 'editsuccess'){
		// Pesan ketika data berhasil diubah
		echo "<script>alert('Data produk berhasil diubah.');</script>";
	} else if($_GET['status'] == 'deletesuccess'){
		// Pesan ketika data berhasil dihapus
		echo "<script>alert('Data produk berhasil dihapus.');</script>";
	} else if($_GET['status'] == 'deletefailed'){
		// Pesan ketika penghapusan data gagal
		echo "<script>alert('Gagal menghapus data produk. Silakan coba lagi.');</script>";
	}
}

// Mengambil semua data produk (mahasiswa) dari database
$dataMahasiswa = $mahasiswa->getAllMahasiswa();

?>
<!doctype html>
<html lang="en">
	<head>
		<?php include 'template/header.php'; // Mengimpor bagian header (meta, CSS, dll) ?>
	</head>

	<body class="layout-fixed fixed-header fixed-footer sidebar-expand-lg sidebar-open bg-body-tertiary">

		<div class="app-wrapper">

			<?php include 'template/navbar.php'; // Menyertakan menu navigasi atas ?>

			<?php include 'template/sidebar.php'; // Menyertakan sidebar kiri ?>

			<main class="app-main">

				<!-- Bagian judul halaman -->
				<div class="app-content-header">
					<div class="container-fluid">
						<div class="row">
							<div class="col-sm-6">
								<h3 class="mb-0">Daftar Produk</h3>
							</div>
							<div class="col-sm-6">
								<!-- Breadcrumb navigasi -->
								<ol class="breadcrumb float-sm-end">
									<li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
									<li class="breadcrumb-item active" aria-current="page">Beranda</li>
								</ol>
							</div>
						</div>
					</div>
				</div>

				<!-- Bagian utama konten -->
				<div class="app-content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Tabel Mahasiswa</h3> <!-- Judul tabel -->
										<div class="card-tools">
											<!-- Tombol collapse dan remove card -->
											<button type="button" class="btn btn-tool" data-lte-toggle="card-collapse" title="Collapse">
												<i data-lte-icon="expand" class="bi bi-plus-lg"></i>
												<i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
											</button>
											<button type="button" class="btn btn-tool" data-lte-toggle="card-remove" title="Remove">
												<i class="bi bi-x-lg"></i>
											</button>
										</div>
									</div>

									<!-- Tabel daftar produk -->
									<div class="card-body p-0 table-responsive">
										<table class="table table-striped" role="table">
											<thead>
												<tr>
													<th>No</th>
													<th>Nama Brand</th>
													<th>Nama Produk</th>
													<th>Jenis Produk</th>
													<th>Deskripsi Produk</th>
													<th class="text-center" style="width: 120px;">Status</th>
												</tr>
											</thead>
											<tbody>
											<?php
											// Mengecek apakah data kosong
											if (count($dataMahasiswa) == 0) {
												// Jika tidak ada data, tampilkan pesan
												echo '<tr class="align-top">
													<td colspan="6" class="text-center">Tidak ada data produk.</td>
												</tr>';
											} else {
												// Menampilkan data produk baris per baris
												foreach ($dataMahasiswa as $index => $produk) {

													// Menentukan tampilan badge status (Aktif / Tidak Aktif)
													if ($produk['status_produk'] == 1) {
														$statusLabel = '<span class="badge bg-success">Aktif</span>';
													} else {
														$statusLabel = '<span class="badge bg-danger">Tidak Aktif</span>';
													}

													// Menampilkan data produk ke dalam baris tabel
													echo '<tr class="align-top">
														<td>'.($index + 1).'</td> <!-- Nomor urut -->
														<td>'.$produk['nama_brand'].'</td> <!-- Nama brand -->
														<td>'.$produk['nama_produk'].'</td> <!-- Nama produk -->
														<td>'.$produk['jenis_device'].'</td> <!-- Jenis atau tipe produk -->
														<td class="text-break text-wrap" style="max-width:480px; white-space:normal; word-wrap:break-word; word-break:break-word; padding:8px 12px;">'.$produk['deskripsi'].'</td> <!-- Deskripsi produk -->
														<td class="text-center align-middle" style="vertical-align: middle;">'.$statusLabel.'</td> <!-- Status badge -->
													</tr>';
												}
											}
											?>
											</tbody>
										</table>
									</div>

									<!-- Tombol tambah produk -->
									<div class="card-footer">
										<button type="button" class="btn btn-primary" onclick="window.location.href='data-input.php'">
											<i class="bi bi-plus-lg"></i> Tambah Produk
										</button>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>

			</main>

			<?php include 'template/footer.php'; // Menyertakan footer ?>

		</div>
		
		<?php include 'template/script.php'; // Menyertakan file script JS ?>

	</body>
</html>
