<?php

include_once 'config/class-mahasiswa.php';
$mahasiswa = new Mahasiswa();

// Menampilkan alert berdasarkan status yang diterima melalui parameter GET
if (isset($_GET['status'])) {
	if ($_GET['status'] == 'inputsuccess') {
		echo "<script>alert('Data produk berhasil ditambahkan.');</script>";
	} else if ($_GET['status'] == 'editsuccess') {
		echo "<script>alert('Data produk berhasil diubah.');</script>";
	} else if ($_GET['status'] == 'deletesuccess') {
		echo "<script>alert('Data produk berhasil dihapus.');</script>";
	} else if ($_GET['status'] == 'deletefailed') {
		echo "<script>alert('Gagal menghapus data produk. Silakan coba lagi.');</script>";
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
									<li class="breadcrumb-item active" aria-current="page">Daftar Produk</li>
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
										<h3 class="card-title">Tabel Produk</h3>
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
										<table class="table table-striped table-bordered text-center" role="table">
											<thead class="table-dark">
												<tr>
													<th>No</th>
													<th>Nama Produk</th>
													<th>Jenis Brand</th>
													<th>Jenis Device</th>
													<th>Deskripsi</th>
													<th class="text-center" style="width: 120px;">Status</th>
													<th style="width: 150px;">Aksi</th>
												</tr>
											</thead>
											<tbody>
											<?php
											if (count($dataMahasiswa) == 0) {
												echo '<tr class="align-top">
													<td colspan="7" class="text-center">Tidak ada data produk.</td>
												</tr>';
											} else {
												foreach ($dataMahasiswa as $index => $produk) {

													// Badge status
													$statusLabel = '';
													switch ($produk['status_produk'] ?? 0) {
														case 1:
															$statusLabel = '<span class="badge bg-success">Aktif</span>';
															break;
														case 2:
															$statusLabel = '<span class="badge bg-danger">Tidak Aktif</span>';
															break;
														case 3:
															$statusLabel = '<span class="badge bg-warning text-dark">Cuti</span>';
															break;
														case 4:
															$statusLabel = '<span class="badge bg-primary">Lulus</span>';
															break;
														default:
															$statusLabel = '<span class="badge bg-secondary">Tidak Diketahui</span>';
													}

													// Data produk
													$nama_produk = htmlspecialchars($produk['nama_produk'] ?? '', ENT_QUOTES);
													$nama_brand = htmlspecialchars($produk['nama_brand'] ?? '', ENT_QUOTES);
													$jenis_device = htmlspecialchars($produk['jenis_device'] ?? '', ENT_QUOTES);
													$deskripsi = htmlspecialchars($produk['deskripsi'] ?? '', ENT_QUOTES);
													$id_produk = $produk['id_produk'] ?? '';

													echo '<tr class="align-top">
														<td>'.($index + 1).'</td>
														<td>'.$nama_produk.'</td>
														<td>'.$nama_brand.'</td>
														<td>'.$jenis_device.'</td>
														<td class="text-break text-wrap" style="max-width:480px; white-space:normal; word-wrap:break-word; word-break:break-word; padding:8px 12px;">'.$deskripsi.'</td>
														<td class="text-center align-middle">'.$statusLabel.'</td>
														<td class="text-center align-middle" style="vertical-align: middle; white-space: nowrap; padding: 8px 12px;">
															<button type="button" class="btn btn-sm btn-warning" style="margin-right: 10px;"
																onclick="window.location.href=\'data-edit.php?id='.$id_produk.'\'">
																<i class="bi bi-pencil-fill"></i> Edit
															</button>
															<button type="button" class="btn btn-sm btn-danger"
																onclick="if(confirm(\'Yakin ingin menghapus produk ini?\')){window.location.href=\'proses/proses-delete.php?id='.$id_produk.'\'}">
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

			<?php include 'template/footer.php'; ?>
		</div>

		<?php include 'template/script.php'; ?>

	</body>
</html>
