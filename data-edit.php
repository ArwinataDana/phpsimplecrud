<?php 

// Memanggil file class-master.php dan class-mahasiswa.php
include_once 'config/class-master.php';
include_once 'config/class-mahasiswa.php';
$master = new MasterData();
$mahasiswa = new Mahasiswa();

// =====================
// AMBIL DATA MASTER
// =====================
// Mengambil daftar brand (dari getProdi)
// Mengambil daftar device (dari getProvinsi)
// Mengambil daftar status produk (dari getStatus)
$prodiList = $master->getProdi(); 
$provinsiList = $master->getProvinsi(); 
$statusList = $master->getStatus(); 

// =====================
// AMBIL DATA PRODUK YANG AKAN DIEDIT
// =====================
// Cek apakah parameter id dikirim lewat URL
// Jika tidak ada 'id', gunakan 'id_produk' sebagai fallback
$idRequested = $_GET['id'] ?? ($_GET['id_produk'] ?? null);

// Ambil data produk berdasarkan id yang ditemukan
$dataMahasiswa = $mahasiswa->getUpdateMahasiswa($idRequested);

// =====================
// NOTIFIKASI STATUS EDIT
// =====================
if(isset($_GET['status'])){
    if($_GET['status'] == 'failed'){
        // Tampilkan pesan jika proses edit gagal
        echo "<script>alert('Gagal mengubah data produk. Silakan coba lagi.');</script>";
    }
}

// =====================
// SIAPKAN NILAI CURRENT / SAAT INI
// =====================
// Ambil id produk (gunakan beberapa kemungkinan nama kolom)
$currentIdProduk = $dataMahasiswa['id_produk'] ?? $dataMahasiswa['id'] ?? $dataMahasiswa['product_id'] ?? '';

// Ambil id/nama brand produk (bergantung pada struktur data)
$currentBrandIdOrName = $dataMahasiswa['jenis_brand'] ?? $dataMahasiswa['id_brand'] ?? $dataMahasiswa['brand_id'] ?? $dataMahasiswa['brand'] ?? $dataMahasiswa['nama_brand'] ?? '';

// Ambil id device saat ini
$currentDeviceId = $dataMahasiswa['jenis_device'] ?? $dataMahasiswa['id_device'] ?? $dataMahasiswa['device_id'] ?? '';

// Ambil id status produk
$currentStatusId = $dataMahasiswa['status_produk'] ?? $dataMahasiswa['status'] ?? '';

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

				<!-- Header halaman -->
				<div class="app-content-header">
					<div class="container-fluid">
						<div class="row">
							<div class="col-sm-6">
								<h3 class="mb-0">Edit Produk</h3>
							</div>
							<div class="col-sm-6">
								<ol class="breadcrumb float-sm-end">
									<li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
									<li class="breadcrumb-item active" aria-current="page">Edit Produk</li>
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
										<h3 class="card-title">Formulir Edit Produk</h3>
										<div class="card-tools">
											<!-- Tombol collapse dan close card -->
											<button type="button" class="btn btn-tool" data-lte-toggle="card-collapse" title="Collapse">
												<i data-lte-icon="expand" class="bi bi-plus-lg"></i>
												<i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
											</button>
											<button type="button" class="btn btn-tool" data-lte-toggle="card-remove" title="Remove">
												<i class="bi bi-x-lg"></i>
											</button>
										</div>
									</div>

                                    <!-- =====================
                                         FORM EDIT PRODUK
                                         ===================== -->
                                    <form action="proses/proses-edit.php" method="POST">
									    <div class="card-body">

                                            <!-- ID produk (disembunyikan) -->
                                            <input type="hidden" name="id_produk" value="<?php echo htmlspecialchars($currentIdProduk, ENT_QUOTES); ?>">

                                            <!-- Input nama produk -->
                                            <div class="mb-3">
                                                <label for="nama_produk" class="form-label">Nama Produk</label>
                                                <input type="text" class="form-control" id="nama_produk" name="nama_produk" placeholder="Masukkan Nama Produk" value="<?php echo htmlspecialchars($dataMahasiswa['nama_produk'] ?? $dataMahasiswa['product_name'] ?? '', ENT_QUOTES); ?>" required>
                                            </div>

                                            <!-- Dropdown jenis brand -->
                                            <div class="mb-3">
                                                <label for="jenis_brand" class="form-label">Jenis Brand</label>
                                                <select class="form-select" id="jenis_brand" name="jenis_brand" required>
                                                    <option value="" disabled>Pilih Brand</option>
                                                    <?php 
                                                    // Normalisasi nilai brand saat ini untuk perbandingan
                                                    $currentNormalized = is_null($currentBrandIdOrName) ? '' : trim((string)$currentBrandIdOrName);
                                                    $currentLower = mb_strtolower($currentNormalized);

                                                    // Loop semua data brand dari tabel master
                                                    foreach ($prodiList as $prodi){
                                                        // Ambil ID dan nama brand
                                                        $prodiId = $prodi['id'] ?? $prodi['id_prodi'] ?? $prodi['brand_id'] ?? '';
                                                        $prodiNama = $prodi['nama'] ?? $prodi['brand_name'] ?? $prodi['nama_brand'] ?? '';

                                                        // Konversi ke string untuk perbandingan
                                                        $prodiIdStr = (string)$prodiId;
                                                        $prodiNamaLower = mb_strtolower(trim((string)$prodiNama));

                                                        // Cek apakah data produk cocok dengan id atau nama brand
                                                        $selectedBrand = '';
                                                        if ($currentNormalized !== '') {
                                                            if ((string)$currentNormalized === $prodiIdStr) {
                                                                $selectedBrand = 'selected';
                                                            } else if ($currentLower === $prodiNamaLower) {
                                                                $selectedBrand = 'selected';
                                                            }
                                                        }

                                                        // Tampilkan opsi brand
                                                        echo '<option value="'.htmlspecialchars($prodiId, ENT_QUOTES).'" '.$selectedBrand.'>'.htmlspecialchars($prodiNama, ENT_QUOTES).'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <!-- Dropdown tipe device -->
                                            <div class="mb-3">
                                                <label for="jenis_device" class="form-label">Tipe Device</label>
                                                <select class="form-select" id="jenis_device" name="jenis_device" required>
                                                    <option value="" disabled>Pilih Device</option>
                                                    <?php
                                                    // Loop semua data device dari master
                                                    foreach ($provinsiList as $provinsi){
                                                        $provId = $provinsi['id'] ?? $provinsi['id_provinsi'] ?? $provinsi['device_id'] ?? '';
                                                        $provNama = $provinsi['nama'] ?? $provinsi['device_name'] ?? '';
                                                        // Cek apakah device saat ini cocok
                                                        $selectedDevice = ((string)$currentDeviceId === (string)$provId) ? 'selected' : '';
                                                        echo '<option value="'.htmlspecialchars($provId, ENT_QUOTES).'" '.$selectedDevice.'>'.htmlspecialchars($provNama, ENT_QUOTES).'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <!-- Input deskripsi produk -->
                                            <div class="mb-3">
                                                <label for="deskripsi" class="form-label">Deskripsi Produk</label>
                                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Masukkan Deskripsi Produk" required><?php echo htmlspecialchars($dataMahasiswa['deskripsi'] ?? $dataMahasiswa['description'] ?? '', ENT_QUOTES); ?></textarea>
                                            </div>

                                            <!-- Dropdown status produk -->
                                            <div class="mb-3">
                                                <label for="status_produk" class="form-label">Status Produk</label>
                                                <select class="form-select" id="status_produk" name="status_produk" required>
                                                    <option value="" disabled>Pilih Status</option>
                                                    <?php 
                                                    // Loop semua data status dari master
                                                    foreach ($statusList as $status){
                                                        $statusId = $status['id'] ?? $status['status_id'] ?? '';
                                                        $statusNama = $status['nama'] ?? $status['status_name'] ?? '';
                                                        // Cek apakah status cocok
                                                        $selectedStatus = ((string)$currentStatusId === (string)$statusId) ? 'selected' : '';
                                                        echo '<option value="'.htmlspecialchars($statusId, ENT_QUOTES).'" '.$selectedStatus.'>'.htmlspecialchars($statusNama, ENT_QUOTES).'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                        </div>

									    <!-- Footer form -->
									    <div class="card-footer">
                                            <!-- Tombol batal -->
                                            <button type="button" class="btn btn-danger me-2 float-start" onclick="window.location.href='data-list.php'">Batal</button>
                                            <!-- Tombol simpan perubahan -->
                                            <button type="submit" class="btn btn-warning float-end">Update Produk</button>
                                        </div>
                                    </form>

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
