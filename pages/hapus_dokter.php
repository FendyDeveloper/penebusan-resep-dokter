<?php
include 'layouts/head.php';
include 'layouts/navbar.php';

// Check if the 'id' parameter is set
if (isset($_GET['id'])) {
    $kodeDkt = $_GET['id'];

    // SQL query to delete the doctor
    $deleteSql = "DELETE FROM dokter WHERE KodeDkt='$kodeDkt'";

    // Execute the query
    if ($conn->query($deleteSql) === TRUE) {
        echo "<script>alert('Dokter berhasil dihapus!'); window.location.href='dokter.php';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "<script>alert('Invalid request'); window.location.href='dokter.php';</script>";
}

include 'layouts/footer.php';
?>
