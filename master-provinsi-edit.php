<?php 

// Memanggil file class-master.php untuk mengakses class MasterData
include_once 'config/class-master.php';
$master = new MasterData(); // Membuat objek dari class MasterData

// Mengambil data provinsi (dalam konteks ini berarti tipe device) berdasarkan ID yang dikirim melalui URL
$dataProvinsi = $master->getUpdateProvinsi($_GET['id']);

// Mengecek apakah ada parameter 'status' di URL untuk menampilkan notifikasi gagal update
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'failed') {
        echo "<script>alert('Gagal mengubah data provinsi. Silakan coba lagi.');</script>";
    }
}

?>
<!doctype html>
<html lang="en">
	<head>
		<?php include 'template/header.php'; // Menyertakan file header (berisi meta, CSS, dll) ?>
	</head>

	<body class="layout-fixed fixed-header fixed-footer sidebar-expand-lg sidebar-open bg-body-tertiary">

		<div class="app-wrapper">

			<?php include 'template/navbar.php'; // Menyertakan navbar utama ?>

			<?php include 'template/sidebar.php'; // Menyertakan sidebar navigasi ?>

			<main class="app-main">

				<!-- Header untuk konten utama halaman -->
				<div class="app-content-header">
					<div class="container-fluid">
						<div class="row">
							<div class="col-sm-6">
								<h3 class="mb-0">Edit Tipe Device</h3>
							</div>
							<div class="col-sm-6">
								<!-- Breadcrumb navigasi halaman -->
								<ol class="breadcrumb float-sm-end">
									<li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
									<li class="breadcrumb-item active" aria-current="page">Edit Tipe Device</li>
								</ol>
							</div>
						</div>
					</div>
				</div>

				<!-- Bagian isi utama halaman -->
				<div class="app-content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Formulir Tipe Device</h3>
										<div class="card-tools">
											<!-- Tombol collapse dan remove untuk kartu -->
											<button type="button" class="btn btn-tool" data-lte-toggle="card-collapse" title="Collapse">
												<i data-lte-icon="expand" class="bi bi-plus-lg"></i>
												<i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
											</button>
											<button type="button" class="btn btn-tool" data-lte-toggle="card-remove" title="Remove">
												<i class="bi bi-x-lg"></i>
											</button>
										</div>
									</div>

									<!-- Formulir untuk mengedit data tipe device -->
                                    <form action="proses/proses-provinsi.php?aksi=updateprovinsi" method="POST">
									    <div class="card-body">
                                            <!-- Input tersembunyi untuk menyimpan ID data -->
                                            <input type="hidden" name="id" value="<?php echo $dataProvinsi['id']; ?>">

											<!-- Input untuk nama tipe device -->
											<div class="mb-3">
												<label for="nama" class="form-label">Nama Tipe Device</label>
												<input 
													type="text" 
													class="form-control" 
													id="nama" 
													name="nama" 
													placeholder="Masukkan Tipe Device" 
													value="<?php echo $dataProvinsi['nama']; ?>" 
													required
												>
											</div>
                                        </div>

										<!-- Tombol aksi di bagian bawah form -->
									    <div class="card-footer">
											<!-- Tombol batal (kembali ke halaman list tipe device) -->
                                            <button type="button" class="btn btn-danger me-2 float-start" onclick="window.location.href='master-provinsi-list.php'">
												Batal
											</button>
											<!-- Tombol untuk menyimpan perubahan -->
                                            <button type="submit" class="btn btn-warning float-end">
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

			<?php include 'template/footer.php'; // Menyertakan footer halaman ?>

		</div>
		
		<?php include 'template/script.php'; // Menyertakan file script JS (Bootstrap, plugin, dll) ?>

	</body>
</html>
