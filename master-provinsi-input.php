<?php 

// Mengecek apakah ada parameter 'status' di URL
// Jika 'status' bernilai 'failed', maka akan menampilkan notifikasi alert bahwa penambahan data gagal
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'failed') {
        echo "<script>alert('Gagal menambahkan data provinsi. Silakan coba lagi.');</script>";
    }
}

?>
<!doctype html>
<html lang="en">
	<head>
		<?php include 'template/header.php'; // Menyertakan file header (berisi meta tag, CSS, dan title halaman) ?>
	</head>

	<body class="layout-fixed fixed-header fixed-footer sidebar-expand-lg sidebar-open bg-body-tertiary">

		<!-- Wrapper utama untuk struktur layout aplikasi -->
		<div class="app-wrapper">

			<?php include 'template/navbar.php'; // Menyertakan bagian navbar (menu atas) ?>

			<?php include 'template/sidebar.php'; // Menyertakan bagian sidebar (menu samping) ?>

			<!-- Bagian utama halaman -->
			<main class="app-main">

				<!-- Header konten: berisi judul halaman dan breadcrumb -->
				<div class="app-content-header">
					<div class="container-fluid">
						<div class="row">
							<div class="col-sm-6">
								<!-- Judul halaman -->
								<h3 class="mb-0">Input Data Tipe Device</h3>
							</div>
							<div class="col-sm-6">
								<!-- Breadcrumb navigasi -->
								<ol class="breadcrumb float-sm-end">
									<li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
									<li class="breadcrumb-item active" aria-current="page">Input Device</li>
								</ol>
							</div>
						</div>
					</div>
				</div>

				<!-- Bagian isi halaman -->
				<div class="app-content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-12">
								<div class="card">
									<!-- Header kartu -->
									<div class="card-header">
										<h3 class="card-title">Formulir Tipe Device</h3>
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

									<!-- Form input tipe device -->
                                    <form action="proses/proses-provinsi.php?aksi=inputprovinsi" method="POST">
									    <div class="card-body">
											<!-- Input nama tipe device -->
											<div class="mb-3">
												<label for="nama" class="form-label">Nama Tipe Device</label>
												<input 
													type="text" 
													class="form-control" 
													id="nama" 
													name="nama" 
													placeholder="Masukkan Tipe Device" 
													required
												>
											</div>
                                        </div>

										<!-- Bagian footer card (berisi tombol aksi) -->
									    <div class="card-footer">
											<!-- Tombol batal: kembali ke halaman list tipe device -->
                                            <button 
												type="button" 
												class="btn btn-danger me-2 float-start" 
												onclick="window.location.href='master-provinsi-list.php'"
											>
												Batal
											</button>

											<!-- Tombol reset: menghapus isi input -->
                                            <button 
												type="reset" 
												class="btn btn-secondary me-2 float-start"
											>
												Reset
											</button>

											<!-- Tombol submit: mengirim data ke file proses-provinsi.php -->
                                            <button 
												type="submit" 
												class="btn btn-primary float-end"
											>
												Submit
											</button>
                                        </div>
                                    </form>
								</div>
							</div>
						</div>
					</div>
				</div>

			</main>

			<?php include 'template/footer.php'; // Menyertakan bagian footer halaman ?>

		</div>
		
		<?php include 'template/script.php'; // Menyertakan file script JS (Bootstrap, plugin, dsb) ?>

	</body>
</html>
