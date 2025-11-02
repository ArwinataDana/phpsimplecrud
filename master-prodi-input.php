<?php 

// Silakan lihat komentar di file data-input.php untuk penjelasan kode ini, karena struktur dan logikanya serupa.
if(isset($_GET['status'])){
    if($_GET['status'] == 'failed'){
        echo "<script>alert('Gagal menambahkan data program studi. Silakan coba lagi.');</script>";
    }
}

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
								<h3 class="mb-0">Input Brand</h3>
							</div>
							<div class="col-sm-6">
								<ol class="breadcrumb float-sm-end">
									<li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
									<li class="breadcrumb-item active" aria-current="page">Input Brand</li>
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
										<h3 class="card-title">Formulir Brand Vape</h3>
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
                                    
                                    <!-- 🧩 FORM MULAI -->
                                    <form action="proses/proses-prodi.php?aksi=inputprodi" method="POST">
									    <div class="card-body">
                                            <div class="mb-3">
                                                <label for="kode" class="form-label">Kode Brand</label>
                                                <input type="text" class="form-control" id="kode" name="kode" placeholder="Masukkan Kode Brand" required>
                                            </div>
											<div class="mb-3">
												<label for="nama" class="form-label">Nama Brand</label>
												<input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Brand" required>
											</div>

                                            <!-- 🆕 Tambahan field tersembunyi -->
                                            <input type="hidden" name="kode_brand" value="" id="hidden_kode_brand">
                                            <input type="hidden" name="jenis_brand" value="" id="hidden_jenis_brand">
                                        </div>

									    <div class="card-footer">
                                            <button type="button" class="btn btn-danger me-2 float-start" onclick="window.location.href='master-prodi-list.php'">Batal</button>
                                            <button type="reset" class="btn btn-secondary me-2 float-start">Reset</button>
                                            <button type="submit" class="btn btn-primary float-end">Submit</button>
                                        </div>
                                    </form>
                                    <!-- 🧩 FORM SELESAI -->
								</div>
							</div>
						</div>
					</div>
				</div>

			</main>

			<?php include 'template/footer.php'; ?>

		</div>
		
		<?php include 'template/script.php'; ?>

        <!-- 🧠 Script untuk menyalin nilai dari form utama ke field tersembunyi -->
        <script>
        document.querySelector('form').addEventListener('submit', function() {
            document.getElementById('hidden_kode_brand').value = document.getElementById('kode').value;
            document.getElementById('hidden_jenis_brand').value = document.getElementById('nama').value;
        });
        </script>

	</body>
</html>
