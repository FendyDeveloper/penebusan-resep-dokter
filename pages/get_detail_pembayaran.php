<?php
include 'koneksi.php';

if (isset($_GET['nomorbyr'])) {
    $nomorByr = $_GET['nomorbyr'];

    $sql = "SELECT p.TanggalByr, p.KodePsn, pa.NamaPsn, p.JumlahByr
            FROM pembayaran p
            JOIN pasien pa ON p.KodePsn = pa.KodePsn
            WHERE p.NomorByr = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $nomorByr);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        echo json_encode(["error" => "No data found"]);
    }

    $stmt->close();
}
?>
