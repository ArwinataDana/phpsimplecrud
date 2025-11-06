<?php
// =========================================
// CLASS MASTERDATA
// -----------------------------------------
// File ini berfungsi untuk mengelola data master
// seperti: program studi (brand), device (provinsi),
// serta status produk secara umum.
// =========================================

// Memasukkan file konfigurasi database (koneksi)
include_once 'db-config.php';

// Kelas MasterData mewarisi koneksi dari kelas Database
class MasterData extends Database {

    // =========================================
    // 🔹 METHOD: Ambil daftar brand (tb_prodi)
    // =========================================
    public function getProdi() {
        $query = "SELECT * FROM tb_prodi";
        $result = $this->conn->query($query);
        $prodi = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $prodi[] = [
                    'id'   => $row['kode_brand'],
                    'nama' => $row['jenis_brand']
                ];
            }
        }
        return $prodi;
    }

    // =========================================
    // 🔹 METHOD: Ambil daftar device (tb_device)
    // =========================================
    public function getProvinsi() {
        $query = "SELECT * FROM tb_device";
        $result = $this->conn->query($query);
        $provinsi = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $provinsi[] = [
                    'id'   => $row['id_device'],
                    'nama' => $row['nama_device']
                ];
            }
        }
        return $provinsi;
    }

    // =========================================
    // 🔹 METHOD: Ambil status statis
    // =========================================
    public function getStatus() {
        return [
            ['id' => 1, 'nama' => 'Ada'],
            ['id' => 2, 'nama' => 'Tidak Ada'],
        ];
    }

    // =========================================
    // 🔹 METHOD: Input data brand (tb_prodi)
    // =========================================
    public function inputProdi($data) {
        $kodeProdi = $data['kode'] ?? $data['kode_brand'] ?? null;
        $namaProdi = $data['nama'] ?? $data['jenis_brand'] ?? null;

        if (empty($kodeProdi) || empty($namaProdi)) {
            return false;
        }

        $query = "INSERT INTO tb_prodi (kode_brand, jenis_brand) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) return false;

        $stmt->bind_param("ss", $kodeProdi, $namaProdi);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    // =========================================
    // 🔹 METHOD: Update data brand (tb_prodi)
    // =========================================
    public function updateProdi($data) {
        $kodeProdi = isset($data['kode']) ? $data['kode'] : (isset($data['kode_brand']) ? $data['kode_brand'] : null);
        $namaProdi = isset($data['nama']) ? $data['nama'] : (isset($data['jenis_brand']) ? $data['jenis_brand'] : null);


        if (empty($kodeProdi) || empty($namaProdi)) {
            return false;
        }

        $query = "UPDATE tb_prodi SET jenis_brand = ? WHERE kode_brand = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) return false;

        $stmt->bind_param("ss", $namaProdi, $kodeProdi);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    // =========================================
    // 🔹 METHOD: Ambil atau update brand
    // -----------------------------------------
    // - Jika parameter berupa string (kode_brand),
    //   maka fungsi ini akan mengambil data 1 baris.
    // - Jika parameter berupa array (berisi 'kode' & 'nama'),
    //   maka fungsi akan menjalankan update.
    // =========================================
    public function getupdateProdi($data) {
        // Jika parameter berupa string → ambil data
        if (!is_array($data)) {
            $kode = $data;
            $query = "SELECT * FROM tb_prodi WHERE kode_brand = ?";
            $stmt = $this->conn->prepare($query);
            if (!$stmt) return false;

            $stmt->bind_param("s", $kode);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();

            return [
                'id'   => $row['kode_brand'] ?? '',
                'nama' => $row['jenis_brand'] ?? ''
            ];
        }

        // Jika parameter berupa array → lakukan update
        $kodeProdi = $data['kode'] ?? null;
        $namaProdi = $data['nama'] ?? null;
        if (empty($kodeProdi) || empty($namaProdi)) {
            return false;
        }

        $query = "UPDATE tb_prodi SET jenis_brand = ? WHERE kode_brand = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) return false;

        $stmt->bind_param("ss", $namaProdi, $kodeProdi);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    // =========================================
    // 🔹 METHOD: Hapus data brand (tb_prodi)
    // =========================================
    public function deleteProdi($id) {
        $query = "DELETE FROM tb_prodi WHERE kode_brand = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) return false;

        $stmt->bind_param("s", $id);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    // =========================================
    // 🔹 METHOD: Input data device (tb_device)
    // =========================================
    public function inputProvinsi($data) {
        $namaProvinsi = $data['nama'] ?? null;
        if (empty($namaProvinsi)) return false;

        $query = "INSERT INTO tb_device (nama_device) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) return false;

        $stmt->bind_param("s", $namaProvinsi);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    // =========================================
    // 🔹 METHOD: Ambil data device berdasarkan ID
    // =========================================
    public function getUpdateProvinsi($id) {
        $query = "SELECT * FROM tb_device WHERE id_device = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) return false;

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $provinsi = null;

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $provinsi = [
                'id'   => $row['id_device'],
                'nama' => $row['nama_device']
            ];
        }

        $stmt->close();
        return $provinsi;
    }

    // =========================================
    // 🔹 METHOD: Update data device (tb_device)
    // =========================================
    public function updateProvinsi($data) {
        $idProvinsi   = $data['id'] ?? null;
        $namaProvinsi = $data['nama'] ?? null;
        if (empty($idProvinsi) || empty($namaProvinsi)) return false;

        $query = "UPDATE tb_device SET nama_device = ? WHERE id_device = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) return false;

        $stmt->bind_param("si", $namaProvinsi, $idProvinsi);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    // =========================================
    // 🔹 METHOD: Hapus data device (tb_device)
    // =========================================
    public function deleteProvinsi($id) {
        $query = "DELETE FROM tb_device WHERE id_device = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) return false;

        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }
}

?>
