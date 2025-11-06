<?php 

// Mengecek apakah ada parameter 'status' di URL untuk menampilkan notifikasi hasil input
if (isset($_GET['status'])) {
    // Jika status bernilai 'failed', tampilkan pesan alert gagal input data
    if ($_GET['status'] == 'failed') {
        echo "<script>alert('Gagal menambahkan data program studi. Silakan coba lagi.');</script>";
    }
}

?>
<!doctype html>
<html lang="en">
	<head>
		<!-- Menyertakan file header (berisi meta tag, CSS, dan title) -->
		<?php include 'template/header.php'; ?>
	</head>

	<body class="layout-fixed fixed-header fixed-footer sidebar-expand-lg sidebar-open bg-body-tertiary">

		<div class="app-wrapper">

			<!-- Menyertakan navbar -->
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
								<h3 class="mb-0">Input Brand</h3>
							</div>
							<div class="col-sm-6">
								<!-- Breadcrumb navigasi -->
								<ol class="breadcrumb float-sm-end">
									<li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
									<li class="breadcrumb-item active" aria-current="page">Input Brand</li>
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
								<!-- Card berisi form input brand -->
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Formulir Brand Vape</h3>
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
                                    
                                    <!-- 🧩 FORM MULAI -->
                                    <!-- Form digunakan untuk menambah data brand baru -->
                                    <!-- Aksi diarahkan ke file proses-prodi.php dengan parameter aksi=inputprodi -->
                                    <form action="proses/proses-prodi.php?aksi=inputprodi" method="POST">
									    <div class="card-body">
                                            
                                            <!-- Input Kode Brand -->
                                            <div class="mb-3">
                                                <label for="kode" class="form-label">Kode Brand</label>
                                                <input 
                                                    type="text" 
                                                    class="form-control" 
                                                    id="kode" 
                                                    name="kode" 
                                                    placeholder="Masukkan Kode Brand" 
                                                    required>
                                            </div>

											<!-- Input Nama Brand -->
											<div class="mb-3">
												<label for="nama" class="form-label">Nama Brand</label>
												<input 
                                                    type="text" 
                                                    class="form-control" 
                                                    id="nama" 
                                                    name="nama" 
                                                    placeholder="Masukkan Nama Brand" 
                                                    required>
											</div>

                                            <!-- 🆕 Field tersembunyi (hidden input) -->
                                            <!-- Digunakan untuk menyimpan ulang nilai dari input utama -->
                                            <input type="hidden" name="kode_brand" value="" id="hidden_kode_brand">
                                            <input type="hidden" name="jenis_brand" value="" id="hidden_jenis_brand">
                                        </div>

									    <!-- Bagian bawah form berisi tombol aksi -->
									    <div class="card-footer">
                                            <!-- Tombol Batal: kembali ke halaman daftar brand -->
                                            <button 
                                                type="button" 
                                                class="btn btn-danger me-2 float-start" 
                                                onclick="window.location.href='master-prodi-list.php'">
                                                Batal
                                            </button>

                                            <!-- Tombol Reset: mengosongkan form -->
                                            <button 
                                                type="reset" 
                                                class="btn btn-secondary me-2 float-start">
                                                Reset
                                            </button>

                                            <!-- Tombol Submit: mengirim data ke server -->
                                            <button 
                                                type="submit" 
                                                class="btn btn-primary float-end">
                                                Submit
                                            </button>
                                        </div>
                                    </form>
                                    <!-- 🧩 FORM SELESAI -->
								</div>
							</div>
						</div>
					</div>
				</div>

			</main>

			<!-- Menyertakan footer halaman -->
			<?php include 'template/footer.php'; ?>

		</div>
		
		<!-- Menyertakan file script tambahan (Bootstrap, AdminLTE, dsb.) -->
		<?php include 'template/script.php'; ?>

        <!-- 🧠 Script JavaScript -->
        <!-- Fungsinya untuk menyalin nilai dari input utama (kode & nama brand)
             ke dalam field tersembunyi sebelum form dikirim -->
        <script>
        document.querySelector('form').addEventListener('submit', function() {
            // Menyalin nilai dari input "kode" ke "hidden_kode_brand"
            document.getElementById('hidden_kode_brand').value = document.getElementById('kode').value;
            // Menyalin nilai dari input "nama" ke "hidden_jenis_brand"
            document.getElementById('hidden_jenis_brand').value = document.getElementById('nama').value;
        });
        </script>

	</body>
</html>
