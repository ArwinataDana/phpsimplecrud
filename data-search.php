<?php
include_once 'config/class-mahasiswa.php';
$mahasiswa = new Mahasiswa();
$kataKunci = '';
$cariMahasiswa = []; // inisialisasi agar aman jika tidak ada parameter search

// Mengecek apakah ada parameter GET 'search'
if (isset($_GET['search'])) {
    $kataKunci = $_GET['search'];
    // Mencari data produk berdasarkan kata kunci
    $cariMahasiswa = $mahasiswa->searchMahasiswa($kataKunci);
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
                        <h3 class="mb-0">Pencarian Produk</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Cari Produk</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <!-- Form Pencarian -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3 class="card-title">Form Pencarian</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse" title="Collapse">
                                        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="data-search.php" method="GET" class="row g-3">
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="search" name="search"
                                               placeholder="Masukkan nama produk..." value="<?php echo htmlspecialchars($kataKunci ?? '', ENT_QUOTES); ?>" required>
                                    </div>
                                    <div class="col-md-2 d-grid">
                                        <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Cari</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Hasil Pencarian -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Hasil Pencarian Produk</h3>
                            </div>
                            <div class="card-body">
                                <?php
                                if (isset($_GET['search'])) {
                                    if (!empty($cariMahasiswa) && count($cariMahasiswa) > 0) {
                                        echo '<table class="table table-striped table-bordered text-center" role="table">
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
                                            <tbody>';
                                        foreach ($cariMahasiswa as $index => $mhs) {
                                            // Konversi status produk
                                            $status = '';
                                            switch ($mhs['status_produk'] ?? 0) {
                                                case 1:
                                                    $status = '<span class="badge bg-success">Aktif</span>';
                                                    break;
                                                case 2:
                                                    $status = '<span class="badge bg-danger">Tidak Aktif</span>';
                                                    break;
                                                case 3:
                                                    $status = '<span class="badge bg-warning text-dark">Cuti</span>';
                                                    break;
                                                case 4:
                                                    $status = '<span class="badge bg-primary">Lulus</span>';
                                                    break;
                                                default:
                                                    $status = '<span class="badge bg-secondary">Tidak Diketahui</span>';
                                            }

                                            // Hindari undefined index & nilai null
                                            $nama_produk = htmlspecialchars($mhs['nama_produk'] ?? '', ENT_QUOTES);
                                            // **PERBAIKAN UTAMA**: gunakan 'nama_brand' (bukan 'jenis_brand')
                                            $jenis_brand = htmlspecialchars($mhs['nama_brand'] ?? '', ENT_QUOTES);
                                            $jenis_device = htmlspecialchars($mhs['jenis_device'] ?? '', ENT_QUOTES);
                                            $deskripsi = htmlspecialchars($mhs['deskripsi'] ?? '', ENT_QUOTES);
                                            $id_produk = $mhs['id_produk'] ?? '';

                                            echo '<tr>
        <td>' . ($index + 1) . '</td>
        <td>' . $nama_produk . '</td>
        <td>' . $jenis_brand . '</td>
        <td>' . $jenis_device . '</td>
        <td class="text-break text-wrap" style="max-width:480px; white-space:normal; word-wrap:break-word; word-break:break-word; padding:8px 12px;">' . $deskripsi . '</td>
        <td class="text-center align-middle" style="vertical-align: middle;">' . $status . '</td>
<td class="text-center align-middle" style="vertical-align: middle; white-space: nowrap; padding: 8px 12px;">
    <button type="button" class="btn btn-sm btn-warning" style="margin-right: 10px;"
        onclick="window.location.href=\'data-edit.php?id=' . $id_produk . '\'">
        <i class="bi bi-pencil-fill"></i> Edit
    </button>
    <button type="button" class="btn btn-sm btn-danger"
        onclick="if(confirm(\'Yakin ingin menghapus produk ini?\')){window.location.href=\'proses/proses-delete.php?id=' . $id_produk . '\'}">
        <i class="bi bi-trash-fill"></i> Hapus
    </button>
</td>

    </tr>';

                                        }

                                        echo '</tbody></table>';
                                    } else {
                                        echo '<div class="alert alert-warning text-center" role="alert">
                                                Tidak ditemukan data produk dengan kata kunci 
                                                "<strong>' . htmlspecialchars($kataKunci ?? '', ENT_QUOTES) . '</strong>".
                                              </div>';
                                    }
                                } else {
                                    echo '<div class="alert alert-info text-center" role="alert">
                                            Silakan masukkan kata kunci produk untuk memulai pencarian.
                                          </div>';
                                }
                                ?>
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
