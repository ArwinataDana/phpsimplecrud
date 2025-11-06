<?php

// Memanggil file class-master.php yang berisi class MasterData untuk mengelola data tipe device
include_once 'config/class-master.php';
$master = new MasterData();

// Mengecek apakah parameter 'status' dikirim melalui URL untuk menampilkan notifikasi
if (isset($_GET['status'])) {
	// Menampilkan notifikasi sesuai status aksi CRUD
	if ($_GET['status'] == 'inputsuccess') {
		echo "<script>alert('Data provinsi berhasil ditambahkan.');</script>";
	} else if ($_GET['status'] == 'editsuccess') {
		echo "<script>alert('Data provinsi berhasil diubah.');</script>";
	} else if ($_GET['status'] == 'deletesuccess') {
		echo "<script>alert('Data provinsi berhasil dihapus.');</script>";
	} else if ($_GET['status'] == 'deletefailed') {
		echo "<script>alert('Gagal menghapus data provinsi. Silakan coba lagi.');</script>";
	}
}

// Mengambil seluruh data tipe device (dalam kode ini disebut 'provinsi') dari database
$dataProvinsi = $master->getProvinsi();

?>
<!doctype html>
<html lang="en">
<head>
	<!-- Memasukkan file header.php yang berisi konfigurasi meta, CSS, dan library frontend -->
	<?php include 'template/header.php'; ?>
</head>

<body class="layout-fixed fixed-header fixed-footer sidebar-expand-lg sidebar-open bg-body-tertiary">

	<div class="app-wrapper">

		<!-- Menyertakan bagian navbar dan sidebar dari template -->
		<?php include 'template/navbar.php'; ?>
		<?php include 'template/sidebar.php'; ?>

		<!-- Bagian utama konten halaman -->
		<main class="app-main">

			<!-- Header halaman -->
			<div class="app-content-header">
				<div class="container-fluid">
					<div class="row">
						<div class="col-sm-6">
							<h3 class="mb-0">Data Tipe Device</h3>
						</div>
						<div class="col-sm-6">
							<!-- Breadcrumb navigasi -->
							<ol class="breadcrumb float-sm-end">
								<li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
								<li class="breadcrumb-item active" aria-current="page">Tipe Device</li>
							</ol>
						</div>
					</div>
				</div>
			</div>

			<!-- Konten utama -->
			<div class="app-content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<h3 class="card-title">Tipe Device</h3>
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

								<!-- Tabel daftar tipe device -->
								<div class="card-body p-0 table-responsive">
									<table class="table table-striped" role="table">
										<thead>
											<tr>
												<th>No</th>
												<th>Nama</th>
												<th class="text-center">Aksi</th>
											</tr>
										</thead>
										<tbody>
											<?php
												// Mengecek apakah ada data yang tersedia
												if (count($dataProvinsi) == 0) {
													// Jika tidak ada data, tampilkan pesan kosong
													echo '<tr class="align-middle">
														<td colspan="3" class="text-center">Tidak ada data provinsi.</td>
													</tr>';
												} else {
													// Jika ada data, tampilkan baris data secara berurutan
													foreach ($dataProvinsi as $index => $provinsi) {
														echo '<tr class="align-middle">
															<td>' . ($index + 1) . '</td>
															<td>' . $provinsi['nama'] . '</td>
															<td class="text-center">
																<!-- Tombol Edit -->
																<button type="button" class="btn btn-sm btn-warning me-1" 
																	onclick="window.location.href=\'master-provinsi-edit.php?id=' . $provinsi['id'] . '\'">
																	<i class="bi bi-pencil-fill"></i> Edit
																</button>

																<!-- Tombol Hapus dengan konfirmasi -->
																<button type="button" class="btn btn-sm btn-danger" 
																	onclick="if(confirm(\'Yakin ingin menghapus data tipe device ini?\')){window.location.href=\'proses/proses-provinsi.php?aksi=deleteprovinsi&id=' . $provinsi['id'] . '\'}">
																	<i class="bi bi-trash-fill"></i> Hapus
																</button>
															</td>
														</tr>';
													}
												}
											?>
										</tbody>
									</table>
								</div>

								<!-- Tombol untuk menambah data baru -->
								<div class="card-footer">
									<button type="button" class="btn btn-primary" onclick="window.location.href='master-provinsi-input.php'">
										<i class="bi bi-plus-lg"></i> Tambah Tipe Device
									</button>
								</div>
							</div> <!-- /card -->
						</div>
					</div>
				</div>
			</div>

		</main>

		<!-- Menyertakan footer template -->
		<?php include 'template/footer.php'; ?>

	</div>
	
	<!-- Menyertakan file script.js dan plugin Bootstrap -->
	<?php include 'template/script.php'; ?>

</body>
</html>
