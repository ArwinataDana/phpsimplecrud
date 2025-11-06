<?php

// Memasukkan file konfigurasi database
include_once 'db-config.php';

// Membuat class MasterData yang mewarisi koneksi dari class Database
class MasterData extends Database {

    // 🟢 Method untuk mendapatkan daftar brand (dari tabel tb_prodi)
    public function getProdi(){
        // Query untuk mengambil semua data brand
        $query = "SELECT * FROM tb_prodi";
        $result = $this->conn->query($query);
        $prodi = [];

        // Jika data ditemukan, masukkan ke dalam array asosiatif
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $prodi[] = [
                    'id' => $row['kode_brand'],   // ID brand
                    'nama' => $row['jenis_brand'] // Nama brand
                ];
            }
        }
        return $prodi; // Mengembalikan array berisi daftar brand
    }

    // 🟢 Method untuk mendapatkan daftar device (dari tabel tb_device)
    public function getProvinsi(){
        // Query untuk mengambil semua data device
        $query = "SELECT * FROM tb_device";
        $result = $this->conn->query($query);
        $provinsi = [];

        // Jika data ditemukan, simpan dalam array
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $provinsi[] = [
                    'id' => $row['id_device'],   // ID device
                    'nama' => $row['nama_device'] // Nama device
                ];
            }
        }
        return $provinsi; // Mengembalikan array berisi daftar device
    }

    // 🟢 Method untuk mendapatkan daftar status produk (array statis, bukan dari database)
    public function getStatus(){
        return [
            ['id' => 1, 'nama' => 'Ada'],        // Status aktif
            ['id' => 2, 'nama' => 'Tidak Ada'],  // Status non-aktif
        ];
    }

    // 🟢 Method untuk menambahkan data brand (tb_prodi)
    public function inputProdi($data){
        // Mengambil nilai kode dan nama brand dari input data (fleksibel terhadap nama field)
        $kodeProdi = isset($data['kode']) ? $data['kode'] : (isset($data['kode_brand']) ? $data['kode_brand'] : null);
        $namaProdi = isset($data['nama']) ? $data['nama'] : (isset($data['jenis_brand']) ? $data['jenis_brand'] : null);

        // ✅ Cegah eksekusi jika data tidak lengkap
        if (empty($kodeProdi) || empty($namaProdi)) {
            return false;
        }

        // Query untuk menyimpan data brand ke tabel tb_prodi
        $query = "INSERT INTO tb_prodi (kode_brand, jenis_brand) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false; // Jika prepare gagal, kembalikan false
        }

        // Mengikat parameter
        $stmt->bind_param("ss", $kodeProdi, $namaProdi);
        $result = $stmt->execute();

        // Tutup statement setelah selesai
        $stmt->close();
        return $result; // Mengembalikan hasil true/false
    }


    // 🟢 Method untuk memperbarui data brand berdasarkan kode brand
    public function updateProdi($data){
        // Ambil nilai kode dan nama dari parameter $data
        $kodeProdi = isset($data['kode']) ? $data['kode'] : (isset($data['kode_brand']) ? $data['kode_brand'] : null);
        $namaProdi = isset($data['nama']) ? $data['nama'] : (isset($data['jenis_brand']) ? $data['jenis_brand'] : null);

        // Query update data brand
        $query = "UPDATE tb_prodi SET jenis_brand = ? WHERE kode_brand = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }

        // Bind parameter
        $stmt->bind_param("ss", $namaProdi, $kodeProdi);
        $result = $stmt->execute();

        // Tutup statement
        $stmt->close();
        return $result;
    }


    // 🟢 Method lain untuk mengupdate brand (fungsi sama seperti updateProdi)
    public function getupdateProdi($data){
        $kodeProdi = $data['kode'];
        $namaProdi = $data['nama'];

        // Query update data brand
        $query = "UPDATE tb_prodi SET jenis_brand = ? WHERE kode_brand = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }

        $stmt->bind_param("ss", $namaProdi, $kodeProdi);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    // 🟢 Method untuk menghapus data brand dari tabel tb_prodi
    public function deleteProdi($id){
        $query = "DELETE FROM tb_prodi WHERE kode_brand = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }

        $stmt->bind_param("s", $id);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    // 🟢 Method untuk menambahkan data device baru ke tabel tb_device
    public function inputProvinsi($data){
        $namaProvinsi = $data['nama']; // Nama device
        $query = "INSERT INTO tb_device (nama_device) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }

        $stmt->bind_param("s", $namaProvinsi);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    // 🟢 Method untuk mengambil data device berdasarkan id_device (untuk proses edit)
    public function getUpdateProvinsi($id){
        $query = "SELECT * FROM tb_device WHERE id_device = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }

        // Bind ID device ke query
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $provinsi = null;

        // Jika data ditemukan, ambil hasil ke array
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $provinsi = [
                'id' => $row['id_device'],
                'nama' => $row['nama_device']
            ];
        }

        $stmt->close();
        return $provinsi; // Kembalikan data device yang ditemukan
    }

    // 🟢 Method untuk mengupdate nama device berdasarkan id_device
    public function updateProvinsi($data){
        $idProvinsi = $data['id'];
        $namaProvinsi = $data['nama'];

        // Query untuk update data device
        $query = "UPDATE tb_device SET nama_device = ? WHERE id_device = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }

        $stmt->bind_param("si", $namaProvinsi, $idProvinsi);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    // 🟢 Method untuk menghapus data device berdasarkan id_device
    public function deleteProvinsi($id){
        $query = "DELETE FROM tb_device WHERE id_device = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }

        // Bind ID ke query
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

}

?>
