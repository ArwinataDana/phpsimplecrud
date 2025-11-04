<?php 

include_once 'config/class-master.php';
include_once 'config/class-mahasiswa.php';
$master = new MasterData();
$mahasiswa = new Mahasiswa();

// Mengambil daftar brand, device, dan status produk
$prodiList = $master->getProdi(); // diadaptasi jadi daftar brand
$provinsiList = $master->getProvinsi(); // diadaptasi jadi daftar jenis device
$statusList = $master->getStatus(); // diadaptasi jadi daftar status produk

// Mengambil data produk yang akan diedit berdasarkan id dari parameter GET
// fallback pencarian id: gunakan 'id' atau 'id_produk'
$idRequested = $_GET['id'] ?? ($_GET['id_produk'] ?? null);
$dataMahasiswa = $mahasiswa->getUpdateMahasiswa($idRequested);

if(isset($_GET['status'])){
    if($_GET['status'] == 'failed'){
        echo "<script>alert('Gagal mengubah data produk. Silakan coba lagi.');</script>";
    }
}

// Siapkan nilai current untuk brand/device/status dengan fallback keys
$currentIdProduk = $dataMahasiswa['id_produk'] ?? $dataMahasiswa['id'] ?? $dataMahasiswa['product_id'] ?? '';
// Brand saat ini bisa saja disimpan sebagai 'jenis_brand' (id) atau sebagai nama brand (mis. 'Oxva')
$currentBrandIdOrName = $dataMahasiswa['jenis_brand'] ?? $dataMahasiswa['id_brand'] ?? $dataMahasiswa['brand_id'] ?? $dataMahasiswa['brand'] ?? $dataMahasiswa['nama_brand'] ?? '';
// Device id saat ini: fallback nama kunci
$currentDeviceId = $dataMahasiswa['jenis_device'] ?? $dataMahasiswa['id_device'] ?? $dataMahasiswa['device_id'] ?? '';
// Status produk id
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

				<div class="app-content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Formulir Edit Produk</h3>
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

                                    <form action="proses/proses-edit.php" method="POST">
									    <div class="card-body">
                                            <input type="hidden" name="id_produk" value="<?php echo htmlspecialchars($currentIdProduk, ENT_QUOTES); ?>">

                                            <div class="mb-3">
                                                <label for="nama_produk" class="form-label">Nama Produk</label>
                                                <input type="text" class="form-control" id="nama_produk" name="nama_produk" placeholder="Masukkan Nama Produk" value="<?php echo htmlspecialchars($dataMahasiswa['nama_produk'] ?? $dataMahasiswa['product_name'] ?? '', ENT_QUOTES); ?>" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="jenis_brand" class="form-label">Jenis Brand</label>
                                                <select class="form-select" id="jenis_brand" name="jenis_brand" required>
                                                    <option value="" disabled>Pilih Brand</option>
                                                    <?php 
                                                    // Normalisasi current value untuk perbandingan
                                                    $currentNormalized = is_null($currentBrandIdOrName) ? '' : trim((string)$currentBrandIdOrName);
                                                    $currentLower = mb_strtolower($currentNormalized);

                                                    foreach ($prodiList as $prodi){
                                                        // $prodi['id'] diasumsikan id master brand, $prodi['nama'] adalah nama brand
                                                        $prodiId = $prodi['id'] ?? $prodi['id_prodi'] ?? $prodi['brand_id'] ?? '';
                                                        $prodiNama = $prodi['nama'] ?? $prodi['brand_name'] ?? $prodi['nama_brand'] ?? '';

                                                        // Normalisasi nilai dari master list
                                                        $prodiIdStr = (string)$prodiId;
                                                        $prodiNamaLower = mb_strtolower(trim((string)$prodiNama));

                                                        // Pilih jika cocok dengan id ATAU cocok dengan nama (case-insensitive)
                                                        $selectedBrand = '';
                                                        if ($currentNormalized !== '') {
                                                            if ((string)$currentNormalized === $prodiIdStr) {
                                                                $selectedBrand = 'selected';
                                                            } else if ($currentLower === $prodiNamaLower) {
                                                                $selectedBrand = 'selected';
                                                            }
                                                        }

                                                        echo '<option value="'.htmlspecialchars($prodiId, ENT_QUOTES).'" '.$selectedBrand.'>'.htmlspecialchars($prodiNama, ENT_QUOTES).'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="jenis_device" class="form-label">Tipe Device</label>
                                                <select class="form-select" id="jenis_device" name="jenis_device" required>
                                                    <option value="" disabled>Pilih Device</option>
                                                    <?php
                                                    foreach ($provinsiList as $provinsi){
                                                        $provId = $provinsi['id'] ?? $provinsi['id_provinsi'] ?? $provinsi['device_id'] ?? '';
                                                        $provNama = $provinsi['nama'] ?? $provinsi['device_name'] ?? '';
                                                        $selectedDevice = ((string)$currentDeviceId === (string)$provId) ? 'selected' : '';
                                                        echo '<option value="'.htmlspecialchars($provId, ENT_QUOTES).'" '.$selectedDevice.'>'.htmlspecialchars($provNama, ENT_QUOTES).'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="deskripsi" class="form-label">Deskripsi Produk</label>
                                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Masukkan Deskripsi Produk" required><?php echo htmlspecialchars($dataMahasiswa['deskripsi'] ?? $dataMahasiswa['description'] ?? '', ENT_QUOTES); ?></textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label for="status_produk" class="form-label">Status Produk</label>
                                                <select class="form-select" id="status_produk" name="status_produk" required>
                                                    <option value="" disabled>Pilih Status</option>
                                                    <?php 
                                                    foreach ($statusList as $status){
                                                        $statusId = $status['id'] ?? $status['status_id'] ?? '';
                                                        $selectedStatus = ((string)$currentStatusId === (string)$statusId) ? 'selected' : '';
                                                        $statusNama = $status['nama'] ?? $status['status_name'] ?? '';
                                                        echo '<option value="'.htmlspecialchars($statusId, ENT_QUOTES).'" '.$selectedStatus.'>'.htmlspecialchars($statusNama, ENT_QUOTES).'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                        </div>

									    <div class="card-footer">
                                            <button type="button" class="btn btn-danger me-2 float-start" onclick="window.location.href='data-list.php'">Batal</button>
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
