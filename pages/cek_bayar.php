<?php
include 'layouts/head.php';
include 'layouts/navbar.php';

$sql = "SELECT * FROM resep";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $KodePsn = $_POST['KodePsn'];
    $JumlahByr = $_POST['JumlahByr'];
    $Dibayar = $_POST['Dibayar'];
    $Kembali = $_POST['Kembali'];

    $updateSql = "UPDATE resep SET Bayar=?, Kembali=? WHERE resep.NomerResep=?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("ddi", $Dibayar, $Kembali, $KodePsn);
  
    if ($stmt->execute()) {
        // Set status pendaftaran menjadi 'selesai' setelah pembayaran berhasil
        $updateStatusSql = "UPDATE pendaftaran SET Status='selesai' WHERE NomorPendf=?";
        $stmtUpdateStatus = $conn->prepare($updateStatusSql);
        $stmtUpdateStatus->bind_param("i", $KodePsn);
        $stmtUpdateStatus->execute();
        $stmtUpdateStatus->close();
      
        echo "<script>alert('Pembayaran berhasil!'); window.location.href='cek_bayar.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
  
    $stmt->close(); // Pindahkan penutupan pernyataan setelah pemrosesan hasil eksekusi
}
?>

<div class="container-fluid py-4">
  <!-- Isi form pembayaran dan tabel data di sini -->
</div>

<script>
  // Script JavaScript untuk menghitung kembali
</script>
