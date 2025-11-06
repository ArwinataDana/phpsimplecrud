<?php 

// Memasukkan file class-master.php untuk memanggil class MasterData
include_once 'config/class-master.php';

// Membuat objek dari class MasterData
$master = new MasterData();

// Mengambil daftar program studi dari database
// Dalam konteks aplikasi ini, getProdi() diadaptasi sebagai daftar brand
$prodiList = $master->getProdi();

// Mengambil daftar provinsi dari database
// Dalam konteks aplikasi ini, getProvinsi() diadaptasi sebagai daftar jenis device
$provinsiList = $master->getProvinsi();

// Mengambil daftar status dari database
// Dalam konteks aplikasi ini, digunakan sebagai daftar status produk
$statusList = $master->getStatus();

// Mengecek apakah ada parameter 'status' pada URL
if(isset($_GET['status'])){
    // Jika parameter status bernilai 'failed', tampilkan alert gagal
    if($_GET['status'] == 'failed'){
        echo "<script>alert('Gagal menambahkan data mahasiswa. Silakan coba lagi.');</script>";
    }
}
?>
<!doctype html>
<html lang="en">
	<head>
		<?php include 'template/header.php'; ?> <!-- Memanggil file header template -->
	</head>

	<body class="layout-fixed fixed-header fixed-footer sidebar-expand-lg sidebar-open bg-body-tertiary">

		<div class="app-wrapper">

			<?php include 'template/navbar.php'; ?> <!-- Memanggil template navbar -->

			<?php include 'template/sidebar.php'; ?> <!-- Memanggil template sidebar -->

			<main class="app-main">

				<!-- Bagian header konten utama -->
				<div class="app-content-header">
					<div class="container-fluid">
						<div class="row">
							<div class="col-sm-6">
								<h3 class="mb-0">Input Produk</h3> <!-- Judul halaman -->
							</div>
							<div class="col-sm-6">
								<!-- Breadcrumb navigasi -->
								<ol class="breadcrumb float-sm-end">
									<li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
									<li class="breadcrumb-item active" aria-current="page">Input Produk</li>
								</ol>
							</div>
						</div>
					</div>
				</div>

				<!-- Bagian isi utama -->
				<div class="app-content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-12">
								<div class="card">
									<!-- Header card -->
									<div class="card-header">
										<h3 class="card-title">Memasukan Produk</h3> <!-- Judul form -->
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

									<!-- Form input produk -->
                                   <form action="proses/proses-input.php" method="POST">
                                        <div class="card-body">
                                            
                                            <!-- Input nama produk -->
                                            <div class="mb-3">
                                                <label for="nama_produk" class="form-label">Nama Produk</label>
                                                <input type="text" class="form-control" id="nama_produk" name="nama_produk" placeholder="Masukkan Nama Produk" required>
                                            </div>

                                            <!-- Dropdown jenis brand -->
                                            <div class="mb-3">
                                                <label for="nama_brand" class="form-label">Jenis Brand</label>
                                                <select class="form-select" id="nama_brand" name="nama_brand" required>
                                                    <option value="" selected disabled>Pilih Brand</option>
                                                    <?php 
                                                    // Melakukan loop untuk menampilkan semua data brand dari $prodiList
                                                    foreach ($prodiList as $prodi){
                                                        // Menampilkan pilihan (option) berdasarkan id dan nama brand
                                                        echo '<option value="'.$prodi['id'].'">'.$prodi['nama'].'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <!-- Dropdown tipe device -->
                                            <div class="mb-3">
                                                <label for="jenis_device" class="form-label">Tipe Device</label>
                                                <select class="form-select" id="jenis_device" name="jenis_device" required>
                                                    <option value="" selected disabled>Pilih Device</option>
                                                    <?php
                                                    // Melakukan loop untuk menampilkan semua data device dari $provinsiList
                                                    foreach ($provinsiList as $provinsi){
                                                        // Menampilkan pilihan (option) berdasarkan id dan nama device
                                                        echo '<option value="'.$provinsi['id'].'">'.$provinsi['nama'].'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <!-- Input deskripsi produk -->
                                            <div class="mb-3">
                                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                                <input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Masukkan Deskripsi Produk" required>
                                            </div>

                                            <!-- Dropdown status produk -->
                                            <div class="mb-3">
                                                <label for="status_produk" class="form-label">Status</label>
                                                <select class="form-select" id="status_produk" name="status_produk" required>
                                                    <option value="" selected disabled>Pilih Status</option>
                                                    <?php 
                                                    // Melakukan loop untuk menampilkan semua status produk
                                                    foreach ($statusList as $status){
                                                        // Menampilkan pilihan status berdasarkan id dan nama status
                                                        echo '<option value="'.$status['id'].'">'.$status['nama'].'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Bagian footer form -->
                                        <div class="card-footer">
                                            <!-- Tombol batal untuk kembali ke halaman data-list -->
                                            <button type="button" class="btn btn-danger me-2 float-start" onclick="window.location.href='data-list.php'">Batal</button>

                                            <!-- Tombol reset untuk mengosongkan form -->
                                            <button type="reset" class="btn btn-secondary me-2 float-start">Reset</button>

                                            <!-- Tombol submit untuk mengirim data ke proses-input.php -->
                                            <button type="submit" class="btn btn-primary float-end">Submit</button>
                                        </div>
                                    </form>

								</div>
							</div>
						</div>
					</div>
				</div>

			</main>

			<?php include 'template/footer.php'; ?> <!-- Memanggil template footer -->

		</div>
		
		<?php include 'template/script.php'; ?> <!-- Memanggil file script pendukung -->

	</body>
</html>
