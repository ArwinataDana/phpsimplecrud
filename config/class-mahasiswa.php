<?php

// Memasukkan file konfigurasi database
include_once 'db-config.php';

class Mahasiswa extends Database
{

    // Method untuk input data produk
    public function inputMahasiswa($data)
    {
        $nama_produk    = $data['nama_produk'];
        $nama_brand     = $data['nama_brand'];
        $jenis_device   = $data['jenis_device'];
        $deskripsi      = $data['deskripsi'];
        $status_produk  = $data['status_produk'];

        $query = "INSERT INTO tb_mahasiswa (nama_produk, nama_brand, jenis_device, deskripsi, status_produk)
              VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            die("Prepare gagal: " . $this->conn->error);
        }

        $stmt->bind_param("ssssi", $nama_produk, $nama_brand, $jenis_device, $deskripsi, $status_produk);

        $result = $stmt->execute();
        if (!$result) {
            die("Eksekusi gagal: " . $stmt->error);
        }

        $stmt->close();
        return $result;
    }


    // Method untuk mengambil semua data produk
    public function getAllMahasiswa()
    {
        $query = "SELECT id_produk, nama_brand, nama_produk, jenis_device, deskripsi, status_produk FROM tb_mahasiswa";
        $result = $this->conn->query($query);

        $produk = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $produk[] = [
                    'id_produk' => $row['id_produk'],
                    'nama_brand' => $row['nama_brand'],
                    'nama_produk' => $row['nama_produk'],
                    'jenis_device' => $row['jenis_device'],
                    'deskripsi' => $row['deskripsi'],
                    'status_produk' => $row['status_produk']
                ];
            }
        }
        return $produk;
    }


    // Method untuk mengambil data produk berdasarkan ID
    public function getUpdateMahasiswa($id)
    {
        $query = "SELECT * FROM tb_mahasiswa WHERE id_produk = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = false;
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $data = [
                'id_produk' => $row['id_produk'],
                'nama_produk' => $row['nama_produk'],
                'nama_brand' => $row['nama_brand'],
                'jenis_device' => $row['jenis_device'],
                'deskripsi' => $row['deskripsi'],
                'status_produk' => $row['status_produk']
            ];
        }
        $stmt->close();
        return $data;
    }

    // Method untuk mengedit data produk
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
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ssssii", $nama_produk, $nama_brand, $jenis_device, $deskripsi, $status_produk, $id_produk);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Method untuk menghapus data produk
    public function deleteMahasiswa($id)
    {
        $query = "DELETE FROM tb_mahasiswa WHERE id_produk = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Method untuk mencari data produk berdasarkan kata kunci
    public function searchMahasiswa($kataKunci)
    {
        $likeQuery = "%" . $kataKunci . "%";
        $query = "SELECT id_produk, nama_produk, nama_brand, jenis_device, deskripsi, status_produk
                  FROM tb_mahasiswa
                  WHERE nama_produk LIKE ? OR nama_brand LIKE ? OR jenis_device LIKE ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            return [];
        }
        $stmt->bind_param("sss", $likeQuery, $likeQuery, $likeQuery);
        $stmt->execute();
        $result = $stmt->get_result();

        $produk = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $produk[] = [
                    'id_produk' => $row['id_produk'],
                    'nama_produk' => $row['nama_produk'],
                    'nama_brand' => $row['nama_brand'],
                    'jenis_device' => $row['jenis_device'],
                    'deskripsi' => $row['deskripsi'],
                    'status_produk' => $row['status_produk']
                ];
            }
        }
        $stmt->close();
        return $produk;
    }
}
