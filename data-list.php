<?php

include_once 'config/class-mahasiswa.php';
$mahasiswa = new Mahasiswa();
// Menampilkan alert berdasarkan status yang diterima melalui parameter GET
if(isset($_GET['status'])){
	// Mengecek nilai parameter GET 'status' dan menampilkan alert yang sesuai menggunakan JavaScript
	if($_GET['status'] == 'inputsuccess'){
		echo "<script>alert('Data mahasiswa berhasil ditambahkan.');</script>";
	} else if($_GET['status'] == 'editsuccess'){
		echo "<script>alert('Data mahasiswa berhasil diubah.');</script>";
	} else if($_GET['status'] == 'deletesuccess'){
		echo "<script>alert('Data mahasiswa berhasil dihapus.');</script>";
	} else if($_GET['status'] == 'deletefailed'){
		echo "<script>alert('Gagal menghapus data mahasiswa. Silakan coba lagi.');</script>";
	}
}
$dataMahasiswa = $mahasiswa->getAllMahasiswa();

?>
<!doctype html>
<html lang="en">
	<head>
		<?php include 'template/header.php'; ?>
	</head>

	<body class="layout-fixed fixed-header fixed-footer sidebar-expand-lg sidebar-open bg-body-tertiary">

		<div class="app-wrapper">

			<?php include 'template/navbar.php'; ?>

			<?php include 'template/sidebar.php'; ?>

			<main class="app-main">

				<div class="app-content-header">
					<div class="container-fluid">
						<div class="row">
							<div class="col-sm-6">
								<h3 class="mb-0">Daftar Produk</h3>
							</div>
							<div class="col-sm-6">
								<ol class="breadcrumb float-sm-end">
									<li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
									<li class="breadcrumb-item active" aria-current="page">Beranda</li>
								</ol>
							</div>
						</div>
					</div>
				</div>

				<div class="app-content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Tabel Mahasiswa</h3>
										<div class="card-tools">
											<button type="button" class="btn btn-tool" data-lte-toggle="card-collapse" title="Collapse">
												<i data-lte-icon="expand" class="bi bi-plus-lg"></i>
												<i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
											</button>
											<button type="button" class="btn btn-tool" data-lte-toggle="card-remove" title="Remove">
												<i class="bi bi-x-lg"></i>
											</button>
										</div>
									</div>
									<div class="card-body p-0 table-responsive">
										<table class="table table-striped" role="table">
											<thead>
												<tr>
													<th>No</th>
													<th>Nama Brand</th>
													<th>Nama Produk</th>
													<th>Jenis Produk</th>
													<th>Deskripsi Produk</th>
													<th>Status</th> <!-- ✅ Kolom status baru -->
												</tr>
											</thead>
												<tbody>
												<?php
												if (count($dataMahasiswa) == 0) {
													echo '<tr class="align-middle">
														<td colspan="6" class="text-center">Tidak ada data produk.</td>
													</tr>';
												} else {
													foreach ($dataMahasiswa as $index => $produk) {

														// ✅ Tambahan kecil untuk menampilkan status dengan badge
														if($produk['status_produk'] == 1){
															$statusLabel = '<span class="badge bg-success">Aktif</span>';
														} else {
															$statusLabel = '<span class="badge bg-danger">Tidak Aktif</span>';
														}

														echo '<tr class="align-middle">
															<td>'.($index + 1).'</td>
															<td>'.$produk['nama_brand'].'</td>
															<td>'.$produk['nama_produk'].'</td>
															<td>'.$produk['jenis_device'].'</td>
															<td>'.$produk['deskripsi'].'</td>
															<td class="text-center">'.$statusLabel.'</td> <!-- ✅ tampilkan status -->
														</tr>';
													}
												}
												?>
												</tbody>

										</table>
									</div>
									<div class="card-footer">
										<button type="button" class="btn btn-primary" onclick="window.location.href='data-input.php'"><i class="bi bi-plus-lg"></i> Tambah Produk</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</main>

			<?php include 'template/footer.php'; ?>

		</div>
		
		<?php include 'template/script.php'; ?>

	</body>
</html>
