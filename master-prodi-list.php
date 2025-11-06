<?php

// Memanggil file class-master.php untuk mengakses class MasterData
include_once 'config/class-master.php';
$master = new MasterData(); // Membuat objek dari class MasterData

// Mengecek apakah ada parameter 'status' di URL untuk menampilkan notifikasi
if (isset($_GET['status'])) {
	// Menampilkan alert sesuai status yang dikirim dari proses input/edit/delete
	if ($_GET['status'] == 'inputsuccess') {
		echo "<script>alert('Data prodi berhasil ditambahkan.');</script>";
	} else if ($_GET['status'] == 'editsuccess') {
		echo "<script>alert('Data prodi berhasil diubah.');</script>";
	} else if ($_GET['status'] == 'deletesuccess') {
		echo "<script>alert('Data prodi berhasil dihapus.');</script>";
	} else if ($_GET['status'] == 'deletefailed') {
		echo "<script>alert('Gagal menghapus data prodi. Silakan coba lagi.');</script>";
	}
}

// Mengambil semua data brand (prodi) dari database menggunakan method getProdi()
$dataProdi = $master->getProdi();

?>
<!doctype html>
<html lang="en">
	<head>
		<?php include 'template/header.php'; // Memanggil bagian header ?>
	</head>

	<body class="layout-fixed fixed-header fixed-footer sidebar-expand-lg sidebar-open bg-body-tertiary">

		<div class="app-wrapper">

			<?php include 'template/navbar.php'; // Menyertakan file navbar ?>

			<?php include 'template/sidebar.php'; // Menyertakan file sidebar ?>

			<main class="app-main">

				<!-- Header konten utama -->
				<div class="app-content-header">
					<div class="container-fluid">
						<div class="row">
							<div class="col-sm-6">
								<h3 class="mb-0">Data Brand</h3>
							</div>
							<div class="col-sm-6">
								<!-- Breadcrumb navigasi -->
								<ol class="breadcrumb float-sm-end">
									<li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
									<li class="breadcrumb-item active" aria-current="page">Master Brand</li>
								</ol>
							</div>
						</div>
					</div>
				</div>

				<!-- Isi konten utama -->
				<div class="app-content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Daftar Brand Device</h3>
										<div class="card-tools">
											<!-- Tombol untuk collapse dan remove card -->
											<button type="button" class="btn btn-tool" data-lte-toggle="card-collapse" title="Collapse">
												<i data-lte-icon="expand" class="bi bi-plus-lg"></i>
												<i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
											</button>
											<button type="button" class="btn btn-tool" data-lte-toggle="card-remove" title="Remove">
												<i class="bi bi-x-lg"></i>
											</button>
										</div>
									</div>

									<!-- Tabel data brand -->
									<div class="card-body p-0 table-responsive">
										<table class="table table-striped" role="table">
											<thead>
												<tr>
													<th>No</th>
													<th>Kode</th>
													<th>Nama</th>
													<th class="text-center">Aksi</th>
												</tr>
											</thead>
											<tbody>
												<?php
													// Jika tidak ada data yang ditemukan
													if (count($dataProdi) == 0) {
														echo '<tr class="align-middle">
															<td colspan="4" class="text-center">Tidak ada data prodi.</td>
														</tr>';
													} else {
														// Jika ada data, tampilkan setiap baris brand
														foreach ($dataProdi as $index => $prodi) {
															echo '<tr class="align-middle">
																<td>'.($index + 1).'</td> <!-- Nomor urut -->
																<td>'.$prodi['id'].'</td> <!-- Kode brand -->
																<td>'.$prodi['nama'].'</td> <!-- Nama brand -->
																<td class="text-center">
																	<!-- Tombol Edit -->
																	<button type="button" class="btn btn-sm btn-warning me-1" onclick="window.location.href=\'master-prodi-edit.php?id='.$prodi['id'].'\'">
																		<i class="bi bi-pencil-fill"></i> Edit
																	</button>

																	<!-- Tombol Hapus dengan konfirmasi -->
																	<button type="button" class="btn btn-sm btn-danger" 
																		onclick="if(confirm(\'Yakin ingin menghapus data program studi ini?\')){window.location.href=\'proses/proses-prodi.php?aksi=deleteprodi&id='.$prodi['id'].'\'}">
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

									<!-- Tombol tambah data -->
									<div class="card-footer">
										<button type="button" class="btn btn-primary" onclick="window.location.href='master-prodi-input.php'">
											<i class="bi bi-plus-lg"></i> Tambah Brand
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
