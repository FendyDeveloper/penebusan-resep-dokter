<?php
include 'layouts/head.php';
include 'layouts/navbar.php';

if (isset($_GET['id'])) {
    $kodePsn = $_GET['id'];
    // Check if the form has been submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect form data
        $nama = $_POST['nama'];
        $kodePasien = $_POST['kodePasien'];
        $alamat = $_POST['alamat'];
        $gender = $_POST['gender'];
        $umur = $_POST['umur'];
        $telepon = $_POST['telepon'];

        // SQL query to update patient data
        $sql = "UPDATE pasien SET NamaPsn=?, AlamatPsn=?, GenderPsn=?, UmurPsn=?, TeleponPsn=? WHERE KodePsn=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssis", $nama, $alamat, $gender, $umur, $telepon, $kodePasien);

        // Execute the query
        if ($stmt->execute()) {
            echo "<script>alert('Data pasien berhasil diperbarui!'); window.location.href='pasien.php';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    }

    // Query to get patient information based on KodePsn
    $sql = "SELECT * FROM pasien WHERE KodePsn='$kodePsn'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nama = $row['NamaPsn'];
        $alamat = $row['AlamatPsn'];
        $gender = $row['GenderPsn'];
        $umur = $row['UmurPsn'];
        $telepon = $row['TeleponPsn'];
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Edit Pasien</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="nama">Nama Pasien</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="kodePasien">Kode Pasien</label>
                            <input type="text" class="form-control" id="kodePasien" name="kodePasien" value="<?php echo $kodePsn; ?>" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select class="form-control" id="gender" name="gender">
                                <option value="L" <?php echo ($gender == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                                <option value="P" <?php echo ($gender == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="umur">Umur</label>
                            <input type="number" class="form-control" id="umur" name="umur" value="<?php echo $umur; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="telepon">Telepon</label>
                            <input type="text" class="form-control" id="telepon" name="telepon" value="<?php echo $telepon; ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } else {
    echo "Data pasien tidak ditemukan";
}
} else {
    echo "Invalid request";
}
include 'layouts/footer.php';
?>
