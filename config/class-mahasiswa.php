<?php 

// Memasukkan file konfigurasi database
include_once 'db-config.php';

class Mahasiswa extends Database {

    // Method untuk input data mahasiswa
    public function inputMahasiswa($data){
    $nama_produk    = $data['nama_produk'];
    $nama_brand     = $data['nama_brand'];
    $jenis_device   = $data['jenis_device'];
    $deskripsi      = $data['deskripsi'];
    $status_produk  = $data['status_produk'];

    $query = "INSERT INTO tb_mahasiswa (nama_produk, nama_brand, jenis_device, deskripsi, status_produk)
              VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $this->conn->prepare($query);
    if(!$stmt){
        die("Prepare gagal: " . $this->conn->error);
    }

    $stmt->bind_param("sssss", $nama_produk, $nama_brand, $jenis_device, $deskripsi, $status_produk);

    $result = $stmt->execute();
    if(!$result){
        die("Eksekusi gagal: " . $stmt->error);
    }

    $stmt->close();
    return $result;
}


    // Method untuk mengambil semua data mahasiswa
    public function getAllMahasiswa(){
    $query = "SELECT id_mhs, nama_brand, nama_produk, jenis_device, deskripsi, status_produk FROM tb_mahasiswa";
        $result = $this->conn->query($query);

        $produk = [];
        if($result && $result->num_rows > 0){
            while($row = $result->fetch_assoc()) {
                $produk[] = [
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


    // Method untuk mengambil data mahasiswa berdasarkan ID
    public function getUpdateMahasiswa($id){
        // Menyiapkan query SQL untuk mengambil data mahasiswa berdasarkan ID menggunakan prepared statement
        $query = "SELECT * FROM tb_mahasiswa WHERE id_mhs = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = false;
        if($result->num_rows > 0){
            // Mengambil data mahasiswa  
            $row = $result->fetch_assoc();
            // Menyimpan data dalam array
            $data = [
                'id' => $row['id_mhs'],
                'nim' => $row['nim_mhs'],
                'nama' => $row['nama_mhs'],
                'prodi' => $row['prodi_mhs'],
                'alamat' => $row['alamat'],
                'provinsi' => $row['provinsi'],
                'email' => $row['email'],
                'telp' => $row['telp'],
                'status' => $row['status_mhs']
            ];
        }
        $stmt->close();
        // Mengembalikan data mahasiswa
        return $data;
    }

    // Method untuk mengedit data mahasiswa
    public function editMahasiswa($data){
        // Mengambil data dari parameter $data
        $id       = $data['id'];
        $nim      = $data['nim'];
        $nama     = $data['nama'];
        $prodi    = $data['prodi'];
        $alamat   = $data['alamat'];
        $provinsi = $data['provinsi'];
        $email    = $data['email'];
        $telp     = $data['telp'];
        $status   = $data['status'];
        // Menyiapkan query SQL untuk update data menggunakan prepared statement
        $query = "UPDATE tb_mahasiswa SET nim_mhs = ?, nama_mhs = ?, prodi_mhs = ?, alamat = ?, provinsi = ?, email = ?, telp = ?, status_mhs = ? WHERE id_mhs = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        // Memasukkan parameter ke statement
        $stmt->bind_param("ssssssssi", $nim, $nama, $prodi, $alamat, $provinsi, $email, $telp, $status, $id);
        $result = $stmt->execute();
        $stmt->close();
        // Mengembalikan hasil eksekusi query
        return $result;
    }

    // Method untuk menghapus data mahasiswa
    public function deleteMahasiswa($id){
        // Menyiapkan query SQL untuk delete data menggunakan prepared statement
        $query = "DELETE FROM tb_mahasiswa WHERE id_mhs = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        // Mengembalikan hasil eksekusi query
        return $result;
    }

    // Method untuk mencari data mahasiswa berdasarkan kata kunci
    public function searchMahasiswa($kataKunci){
        // Menyiapkan LIKE query untuk pencarian
        $likeQuery = "%".$kataKunci."%";
        // Menyiapkan query SQL untuk pencarian data mahasiswa menggunakan prepared statement
        $query = "SELECT id_mhs, nim_mhs, nama_mhs, nama_prodi, nama_provinsi, alamat, email, telp, status_mhs 
                  FROM tb_mahasiswa
                  JOIN tb_prodi ON prodi_mhs = kode_prodi
                  JOIN tb_provinsi ON provinsi = id_provinsi
                  WHERE nim_mhs LIKE ? OR nama_mhs LIKE ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            // Mengembalikan array kosong jika statement gagal disiapkan
            return [];
        }
        // Memasukkan parameter ke statement
        $stmt->bind_param("ss", $likeQuery, $likeQuery);
        $stmt->execute();
        $result = $stmt->get_result();
        // Menyiapkan array kosong untuk menyimpan data mahasiswa
        $mahasiswa = [];
        if($result->num_rows > 0){
            // Mengambil setiap baris data dan memasukkannya ke dalam array
            while($row = $result->fetch_assoc()) {
                // Menyimpan data mahasiswa dalam array
                $mahasiswa[] = [
                    'id' => $row['id_mhs'],
                    'nim' => $row['nim_mhs'],
                    'nama' => $row['nama_mhs'],
                    'prodi' => $row['nama_prodi'],
                    'provinsi' => $row['nama_provinsi'],
                    'alamat' => $row['alamat'],
                    'email' => $row['email'],
                    'telp' => $row['telp'],
                    'status' => $row['status_mhs']
                ];
            }
        }
        $stmt->close();
        // Mengembalikan array data mahasiswa yang ditemukan
        return $mahasiswa;
    }

}

?>