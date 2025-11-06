<?php 

// Memasukkan file class-master.php untuk mengakses class MasterData
include_once 'config/class-master.php';

// Membuat objek dari class MasterData
$master = new MasterData();

// Mengambil data program studi berdasarkan ID yang dikirim melalui URL (GET)
$dataProdi = $master->getUpdateProdi($_GET['id']);

// Mengecek apakah ada parameter 'status' di URL untuk menampilkan notifikasi
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'failed') {
        // Menampilkan alert jika proses update data gagal
        echo "<script>alert('Gagal mengubah data program studi. Silakan coba lagi.');</script>";
    }
}

?>
<!doctype html>
<html lang="en">
	<head>
		<!-- Menyertakan file header template (berisi CSS, meta tag, dan title) -->
		<?php include 'template/header.php'; ?>
	</head>

	<body class="layout-fixed fixed-header fixed-footer sidebar-expand-lg sidebar-open bg-body-tertiary">

		<div class="app-wrapper">

			<!-- Menyertakan bagian navbar -->
			<?php include 'template/navbar.php'; ?>

			<!-- Menyertakan sidebar navigasi -->
			<?php include 'template/sidebar.php'; ?>

			<!-- Bagian utama konten halaman -->
			<main class="app-main">

				<!-- Header halaman -->
				<div class="app-content-header">
					<div class="container-fluid">
						<div class="row">
							<div class="col-sm-6">
								<h3 class="mb-0">Edit Program Studi</h3>
							</div>
							<div class="col-sm-6">
								<!-- Breadcrumb navigasi -->
								<ol class="breadcrumb float-sm-end">
									<li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
									<li class="breadcrumb-item active" aria-current="page">Edit Prodi</li>
								</ol>
							</div>
						</div>
					</div>
				</div>

				<!-- Konten utama halaman -->
				<div class="app-content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-12">
								<!-- Card berisi form edit program studi -->
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Formulir Program Studi</h3>
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

                                    <!-- Form untuk mengubah data program studi -->
                                    <form action="proses/proses-prodi.php?aksi=updateprodi" method="POST">
									    <div class="card-body">
                                            <!-- Input kode program studi (tidak bisa diubah) -->
                                            <div class="mb-3">
                                                <label for="nama" class="form-label">Kode Program</label>
                                                <input 
													type="text" 
													class="form-control-plaintext" 
													id="kode" 
													name="kode" 
													placeholder="Masukkan Kode Program Studi" 
													value="<?php echo $dataProdi['id']; ?>" 
													required 
													readonly>
                                            </div>

											<!-- Input nama program studi -->
											<div class="mb-3">
												<label for="nama" class="form-label">Nama Program Studi</label>
												<input 
													type="text" 
													class="form-control" 
													id="nama" 
													name="nama" 
													placeholder="Masukkan Nama Program Studi" 
													value="<?php echo $dataProdi['nama']; ?>" 
													required>
											</div>
                                        </div>

									    <!-- Tombol aksi di bagian bawah form -->
									    <div class="card-footer">
                                            <!-- Tombol batal kembali ke halaman daftar prodi -->
                                            <button 
												type="button" 
												class="btn btn-danger me-2 float-start" 
												onclick="window.location.href='master-prodi-list.php'">
												Batal
											</button>

                                            <!-- Tombol submit untuk update data -->
                                            <button 
												type="submit" 
												class="btn btn-warning float-end">
												Update Data
											</button>
                                        </div>
                                    </form>
								</div>
							</div>
						</div>
					</div>
				</div>

			</main>

			<!-- Menyertakan footer template -->
			<?php include 'template/footer.php'; ?>

		</div>
		
		<!-- Menyertakan file JavaScript dan plugin tambahan -->
		<?php include 'template/script.php'; ?>

	</body>
</html>
