<?php
include 'layouts/head.php';
include 'layouts/navbar.php';

if (isset($_GET['KodePsn'])) {
    $kodePsn = $_GET['KodePsn'];

    // SQL query to delete a patient
    $sql = "DELETE FROM pasien WHERE KodePsn=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $kodePsn);

    // Execute the query
    if ($stmt->execute()) {
        echo "<script>alert('Data pasien berhasil dihapus!'); window.location.href='pasien.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
    $stmt->close();
} else {
    echo "<script>alert('Invalid request'); window.location.href='pasien.php';</script>";
}

include 'layouts/footer.php';
?>
