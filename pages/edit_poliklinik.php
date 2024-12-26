<?php
include 'layouts/head.php';
include 'layouts/navbar.php';

if (isset($_GET['id'])) {
    $kodePoli = $_GET['id'];
    // Check if the form has been submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect form data
        $nama = $_POST['nama'];
        $kodePoliklinik = $_POST['kodePoliklinik'];

        // SQL query to update polyclinic data
        $sql = "UPDATE poliklinik SET NamaPlk=? WHERE KodePlk=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $nama, $kodePoliklinik);

        // Execute the query
        if ($stmt->execute()) {
            echo "<script>alert('Data poliklinik berhasil diperbarui!'); window.location.href='poliklinik.php';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    }

    // Query to get polyclinic information based on KodePlk
    $sql = "SELECT * FROM poliklinik WHERE KodePlk='$kodePoli'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nama = $row['NamaPlk'];
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Edit Poliklinik</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="nama">Nama Poliklinik</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="kodePoliklinik">Kode Poliklinik</label>
                            <input type="text" class="form-control" id="kodePoliklinik" name="kodePoliklinik" value="<?php echo $kodePoli; ?>" required readonly>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } else {
    echo "Data poliklinik tidak ditemukan";
}
} else {
    echo "Invalid request";
}
include 'layouts/footer.php';
?>
