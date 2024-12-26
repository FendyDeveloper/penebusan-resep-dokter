<?php
include 'koneksi.php'; // Sertakan file koneksi.php untuk menghubungkan ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $NomorByr = $_POST['NomorByr'];

    // SQL query untuk mendapatkan detail pembayaran berdasarkan NomorByr
    $sql = "SELECT p.NomorByr, p.TanggalByr, p.KodePsn, ps.NamaPsn, p.JumlahByr
            FROM pembayaran p
            JOIN pasien ps ON p.KodePsn = ps.KodePsn
            WHERE p.NomorByr = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $NomorByr);
    $stmt->execute();
    $result = $stmt->get_result();

    $details = [];
    while ($row = $result->fetch_assoc()) {
        $details[] = $row;
    }

    $stmt->close();
    echo json_encode($details);
}
?>
