<?php
include 'koneksi.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST['jumlahObat'] as $kodeObat => $jumlah) {
        if ($jumlah > 0) {
            // Check if the stock exists in the database
            $sqlCheck = "SELECT JumlahObat FROM obat WHERE KodeObat = ?";
            $stmtCheck = $conn->prepare($sqlCheck);
            $stmtCheck->bind_param("s", $kodeObat);
            $stmtCheck->execute();
            $stmtCheck->store_result();
            
            if ($stmtCheck->num_rows > 0) {
                // If stock exists, update it
                $stmtCheck->bind_result($currentStock);
                $stmtCheck->fetch();
                $newStock = $currentStock + $jumlah;

                $sqlUpdate = "UPDATE obat SET JumlahObat = ? WHERE KodeObat = ?";
                $stmtUpdate = $conn->prepare($sqlUpdate);
                $stmtUpdate->bind_param("is", $newStock, $kodeObat);
                $stmtUpdate->execute();
                $stmtUpdate->close();
            }
            $stmtCheck->close();
        }
    }
    echo "success";
}
?>
