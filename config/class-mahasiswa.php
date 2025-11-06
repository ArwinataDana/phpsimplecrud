<?php

// Memasukkan file konfigurasi database (class Database)
include_once 'db-config.php';

// Membuat class Mahasiswa yang mewarisi koneksi dari class Database
class Mahasiswa extends Database
{
    // 🟢 Fungsi untuk menambahkan data produk baru ke tabel tb_mahasiswa
    public function inputMahasiswa($data)
    {
        // Mengambil data dari parameter $data (biasanya berasal dari form input)
        $nama_produk    = $data['nama_produk'];
        $nama_brand     = $data['nama_brand']; // kode brand (relasi ke tb_prodi)
        $jenis_device   = $data['jenis_device']; // id_device (relasi ke tb_device)
        $deskripsi      = $data['deskripsi'];
        $status_produk  = $data['status_produk'];

        // Query SQL untuk memasukkan data ke dalam tabel
        $query = "INSERT INTO tb_mahasiswa 
                    (nama_produk, nama_brand, jenis_device, deskripsi, status_produk)
                  VALUES (?, ?, ?, ?, ?)";

        // Menyiapkan statement SQL menggunakan prepared statement
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            die("Prepare gagal: " . $this->conn->error); // Jika gagal, hentikan eksekusi
        }

        // Mengikat parameter ke statement dengan tipe data sesuai urutan kolom
        // s = string, i = integer
        $stmt->bind_param("ssisi", $nama_produk, $nama_brand, $jenis_device, $deskripsi, $status_produk);

        // Menjalankan query
        $result = $stmt->execute();

        // Jika gagal dieksekusi, tampilkan pesan error
        if (!$result) {
            die("Eksekusi gagal: " . $stmt->error);
        }

        // Menutup statement setelah selesai
        $stmt->close();
        return $result;
    }

    // 🟢 Fungsi untuk mengambil semua data produk dari database
    public function getAllMahasiswa()
    {
        // Menggunakan JOIN agar menampilkan nama brand & nama device, bukan ID-nya
        $query = "SELECT 
                    p.id_produk,
                    pr.jenis_brand AS nama_brand,
                    p.nama_produk,
                    d.nama_device AS jenis_device,
                    p.deskripsi,
                    p.status_produk
                  FROM tb_mahasiswa p
                  LEFT JOIN tb_prodi pr ON p.nama_brand = pr.kode_brand
                  LEFT JOIN tb_device d ON p.jenis_device = d.id_device
                  ORDER BY p.id_produk ASC";

        // Menjalankan query langsung tanpa prepared statement karena tanpa input user
        $result = $this->conn->query($query);
        $produk = [];

        // Jika data ditemukan, ambil setiap baris hasil query ke dalam array
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $produk[] = $row;
            }
        }

        // Mengembalikan array hasil data produk
        return $produk;
    }

    // 🟢 Fungsi untuk mengambil satu data produk berdasarkan ID (untuk form edit)
    public function getUpdateMahasiswa($id)
    {
        // Query dengan parameter ID untuk mencari data spesifik
        $query = "SELECT * FROM tb_mahasiswa WHERE id_produk = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) return false;

        // Bind parameter ID ke query
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Ambil hasil sebagai array asosiatif
        $data = $result->fetch_assoc();

        // Tutup statement
        $stmt->close();

        // Kembalikan hasil, false jika tidak ada
        return $data ?: false;
    }

    // 🟢 Fungsi untuk mengedit/update data produk berdasarkan ID
    public function editMahasiswa($data)
    {
        // Mengambil data dari parameter array $data
        $id_produk     = $data['id_produk'];
        $nama_produk   = $data['nama_produk'];
        $nama_brand    = $data['nama_brand'];
        $jenis_device  = $data['jenis_device'];
        $deskripsi     = $data['deskripsi'];
        $status_produk = $data['status_produk'];

        // Query update data berdasarkan id_produk
        $query = "UPDATE tb_mahasiswa 
                  SET nama_produk = ?, nama_brand = ?, jenis_device = ?, deskripsi = ?, status_produk = ?
                  WHERE id_produk = ?";

        // Menyiapkan statement
        $stmt = $this->conn->prepare($query);
        if (!$stmt) return false;

        // Mengikat parameter ke query
        $stmt->bind_param("ssissi", $nama_produk, $nama_brand, $jenis_device, $deskripsi, $status_produk, $id_produk);

        // Menjalankan query
        $result = $stmt->execute();

        // Tutup statement
        $stmt->close();

        // Mengembalikan hasil (true/false)
        return $result;
    }

    // 🟢 Fungsi untuk menghapus data produk berdasarkan ID
    public function deleteMahasiswa($id)
    {
        // Query delete berdasarkan id_produk
        $query = "DELETE FROM tb_mahasiswa WHERE id_produk = ?";

        $stmt = $this->conn->prepare($query);
        if (!$stmt) return false;

        // Bind parameter ID
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();

        // Tutup statement
        $stmt->close();

        // Mengembalikan hasil penghapusan
        return $result;
    }

    // 🟢 Fungsi untuk mencari data produk berdasarkan kata kunci
    public function searchMahasiswa($kataKunci)
    {
        // Menambahkan wildcard % untuk pencarian LIKE
        $likeQuery = "%" . $kataKunci . "%";

        // Query pencarian dengan JOIN agar hasil lebih informatif
        $query = "SELECT 
                    p.id_produk,
                    pr.jenis_brand AS nama_brand,
                    p.nama_produk,
                    d.nama_device AS jenis_device,
                    p.deskripsi,
                    p.status_produk
                  FROM tb_mahasiswa p
                  LEFT JOIN tb_prodi pr ON p.nama_brand = pr.kode_brand
                  LEFT JOIN tb_device d ON p.jenis_device = d.id_device
                  WHERE p.nama_produk LIKE ? 
                     OR pr.jenis_brand LIKE ? 
                     OR d.nama_device LIKE ?
                  ORDER BY p.id_produk ASC";

        // Menggunakan prepared statement agar aman dari SQL Injection
        $stmt = $this->conn->prepare($query);
        if (!$stmt) return [];

        // Bind parameter LIKE ke query
        $stmt->bind_param("sss", $likeQuery, $likeQuery, $likeQuery);

        // Jalankan query dan ambil hasil
        $stmt->execute();
        $result = $stmt->get_result();

        $produk = [];
        // Looping hasil query ke dalam array
        while ($row = $result->fetch_assoc()) {
            $produk[] = $row;
        }

        // Tutup statement
        $stmt->close();

        // Kembalikan hasil pencarian
        return $produk;
    }
}
