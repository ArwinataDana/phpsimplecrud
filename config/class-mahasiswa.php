<?php

// Memasukkan file konfigurasi database
include_once 'db-config.php';

class Mahasiswa extends Database
{
    // 🟢 Input produk
    public function inputMahasiswa($data)
    {
        $nama_produk    = $data['nama_produk'];
        $nama_brand     = $data['nama_brand']; // kode brand (dari tb_prodi)
        $jenis_device   = $data['jenis_device']; // id_device dari tb_device
        $deskripsi      = $data['deskripsi'];
        $status_produk  = $data['status_produk'];

        $query = "INSERT INTO tb_mahasiswa 
                    (nama_produk, nama_brand, jenis_device, deskripsi, status_produk)
                  VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            die("Prepare gagal: " . $this->conn->error);
        }

        $stmt->bind_param("ssisi", $nama_produk, $nama_brand, $jenis_device, $deskripsi, $status_produk);
        $result = $stmt->execute();

        if (!$result) {
            die("Eksekusi gagal: " . $stmt->error);
        }

        $stmt->close();
        return $result;
    }

    // 🟢 Ambil semua data produk (JOIN ke tb_prodi dan tb_device)
    public function getAllMahasiswa()
    {
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

        $result = $this->conn->query($query);
        $produk = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $produk[] = $row;
            }
        }
        return $produk;
    }

    // 🟢 Ambil data berdasarkan ID
    public function getUpdateMahasiswa($id)
    {
        $query = "SELECT * FROM tb_mahasiswa WHERE id_produk = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) return false;

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        $stmt->close();
        return $data ?: false;
    }

    // 🟢 Edit data produk
    public function editMahasiswa($data)
    {
        $id_produk     = $data['id_produk'];
        $nama_produk   = $data['nama_produk'];
        $nama_brand    = $data['nama_brand'];
        $jenis_device  = $data['jenis_device'];
        $deskripsi     = $data['deskripsi'];
        $status_produk = $data['status_produk'];

        $query = "UPDATE tb_mahasiswa 
                  SET nama_produk = ?, nama_brand = ?, jenis_device = ?, deskripsi = ?, status_produk = ?
                  WHERE id_produk = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) return false;

        $stmt->bind_param("ssissi", $nama_produk, $nama_brand, $jenis_device, $deskripsi, $status_produk, $id_produk);
        $result = $stmt->execute();

        $stmt->close();
        return $result;
    }

    // 🟢 Hapus produk
    public function deleteMahasiswa($id)
    {
        $query = "DELETE FROM tb_mahasiswa WHERE id_produk = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) return false;

        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    // 🟢 Pencarian produk
    public function searchMahasiswa($kataKunci)
    {
        $likeQuery = "%" . $kataKunci . "%";
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

        $stmt = $this->conn->prepare($query);
        if (!$stmt) return [];

        $stmt->bind_param("sss", $likeQuery, $likeQuery, $likeQuery);
        $stmt->execute();
        $result = $stmt->get_result();

        $produk = [];
        while ($row = $result->fetch_assoc()) {
            $produk[] = $row;
        }

        $stmt->close();
        return $produk;
    }
}
