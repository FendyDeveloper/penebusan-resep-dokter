<?php
include 'layouts/head.php';
include 'layouts/navbar.php';

if (isset($_GET['id'])) {
    $kodeObat = $_GET['id'];
    // Check if the form has been submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect form data
        $namaObat = $_POST['namaObat'];
        $kodeObat = $_POST['kodeObat'];
        $jenisObat = $_POST['jenisObat'];
        $kategori = $_POST['kategori'];
        $hargaObat = $_POST['hargaObat'];
        $jumlahObat = $_POST['jumlahObat'];

        // SQL query to update medication data
        $sql = "UPDATE obat SET NamaObat=?, JenisObat=?, Kategori=?, HargaObat=?, JumlahObat=? WHERE KodeObat=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssii", $namaObat, $jenisObat, $kategori, $hargaObat, $jumlahObat, $kodeObat);

        // Execute the query
        if ($stmt->execute()) {
            echo "<script>alert('Data obat berhasil diperbarui!'); window.location.href='obat.php';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    }

    // Query to get medication information based on KodeObt
    $sql = "SELECT * FROM obat WHERE KodeObat='$kodeObat'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $namaObat = $row['NamaObat'];
        $jenisObat = $row['JenisObat'];
        $kategori = $row['Kategori'];
        $hargaObat = $row['HargaObat'];
        $jumlahObat = $row['JumlahObat'];
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Edit Obat</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="namaObat">Nama Obat</label>
                            <input type="text" class="form-control" id="namaObat" name="namaObat" value="<?php echo $namaObat; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="kodeObat">Kode Obat</label>
                            <input type="text" class="form-control" id="kodeObat" name="kodeObat" value="<?php echo $kodeObat; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="jenisObat">Jenis Obat</label>
                            <input type="text" class="form-control" id="jenisObat" name="jenisObat" value="<?php echo $jenisObat; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <input type="text" class="form-control" id="kategori" name="kategori" value="<?php echo $kategori; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="hargaObat">Harga Obat</label>
                            <input type="text" class="form-control" id="hargaObat" name="hargaObat" value="<?php echo $hargaObat; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="jumlahObat">Jumlah Obat</label>
                            <input type="text" class="form-control" id="jumlahObat" name="jumlahObat" value="<?php echo $jumlahObat; ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    } else {
        echo "<script>alert('No medication found with that ID.'); window.location.href='obat.php';</script>";
    }
} else {
    echo "<script>alert('No ID provided.'); window.location.href='obat.php';</script>";
}

include 'layouts/footer.php';
?>
