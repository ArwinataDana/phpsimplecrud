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
$dataMahasiswa = $mahasiswa->getUpdateMahasiswa($_GET['id']);

if(isset($_GET['status'])){
    if($_GET['status'] == 'failed'){
        echo "<script>alert('Gagal mengubah data produk. Silakan coba lagi.');</script>";
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
                                            <input type="hidden" name="id_produk" value="<?php echo $dataMahasiswa['id_produk']; ?>">

                                            <div class="mb-3">
                                                <label for="nama_produk" class="form-label">Nama Produk</label>
                                                <input type="text" class="form-control" id="nama_produk" name="nama_produk" placeholder="Masukkan Nama Produk" value="<?php echo $dataMahasiswa['nama_produk']; ?>" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="jenis_brand" class="form-label">Jenis Brand</label>
                                                <select class="form-select" id="jenis_brand" name="jenis_brand" required>
                                                    <option value="" disabled>Pilih Brand</option>
                                                    <?php 
                                                    foreach ($prodiList as $prodi){
                                                        $selectedBrand = ($dataMahasiswa['jenis_brand'] == $prodi['id']) ? 'selected' : '';
                                                        echo '<option value="'.$prodi['id'].'" '.$selectedBrand.'>'.$prodi['nama'].'</option>';
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
                                                        $selectedDevice = ($dataMahasiswa['jenis_device'] == $provinsi['id']) ? 'selected' : '';
                                                        echo '<option value="'.$provinsi['id'].'" '.$selectedDevice.'>'.$provinsi['nama'].'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="deskripsi" class="form-label">Deskripsi Produk</label>
                                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Masukkan Deskripsi Produk" required><?php echo $dataMahasiswa['deskripsi']; ?></textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label for="status_produk" class="form-label">Status Produk</label>
                                                <select class="form-select" id="status_produk" name="status_produk" required>
                                                    <option value="" disabled>Pilih Status</option>
                                                    <?php 
                                                    foreach ($statusList as $status){
                                                        $selectedStatus = ($dataMahasiswa['status_produk'] == $status['id']) ? 'selected' : '';
                                                        echo '<option value="'.$status['id'].'" '.$selectedStatus.'>'.$status['nama'].'</option>';
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
