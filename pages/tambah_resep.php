<?php
include 'koneksi.php';

// Memeriksa apakah id pendaftaran telah dikirim melalui URL
if(isset($_GET['id'])) {
    $idPendaftaran = $_GET['id'];
    
    // Mengambil informasi pendaftaran berdasarkan id
    $sqlPendaftaran = "SELECT NomorPendf, TanggalPendf, KodeDkt, KodePsn, KodePlk, Biaya FROM pendaftaran WHERE NomorPendf = ?";
    $stmtPendaftaran = $conn->prepare($sqlPendaftaran);
    $stmtPendaftaran->bind_param("s", $idPendaftaran);
    $stmtPendaftaran->execute();
    $resultPendaftaran = $stmtPendaftaran->get_result();
    
    // Memeriksa apakah pendaftaran ditemukan
    if($resultPendaftaran->num_rows > 0) {
        $rowPendaftaran = $resultPendaftaran->fetch_assoc();
        
        // Mendapatkan informasi dari pendaftaran
        $nomorResep = $rowPendaftaran['NomorPendf'];
        $tanggalResep = $rowPendaftaran['TanggalPendf'];
        $kodeDokter = $rowPendaftaran['KodeDkt'];
        $kodePasien = $rowPendaftaran['KodePsn'];
        $kodePoliklinik = $rowPendaftaran['KodePlk'];
        $totalHarga = $rowPendaftaran['Biaya'];
        
        // Mendefinisikan variabel Bayar dan Kembali
        $bayar = 0;
        $kembali = 0;
        
        // Memasukkan resep ke dalam tabel resep
        $sqlTambahResep = "INSERT INTO resep (NomerResep, TanggalResep, KodeDkt, KodePsn, KodePlk, TotalHarga, Bayar, Kembali) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtTambahResep = $conn->prepare($sqlTambahResep);
        $stmtTambahResep->bind_param("ssssdddi", $nomorResep, $tanggalResep, $kodeDokter, $kodePasien, $kodePoliklinik, $totalHarga, $bayar, $kembali);
        
        // Mengeksekusi perintah untuk menambahkan resep
        if ($stmtTambahResep->execute()) {
            // Mengubah status pendaftaran menjadi 'proses'
            $sqlUpdateStatus = "UPDATE pendaftaran SET Status = 'proses' WHERE NomorPendf = ?";
            $stmtUpdateStatus = $conn->prepare($sqlUpdateStatus);
            $stmtUpdateStatus->bind_param("s", $nomorResep);
            $stmtUpdateStatus->execute();
            $stmtUpdateStatus->close();
            
            echo "<script>alert('Resep berhasil ditambahkan!'); window.location.href='resep.php';</script>";
        } else {
            echo "<script>alert('Error: " . $stmtTambahResep->error . "');</script>";
        }
        
    } else {
        echo "<script>alert('Error: Data pendaftaran tidak ditemukan');</script>";
    }
    $stmtPendaftaran->close();
}
?>
