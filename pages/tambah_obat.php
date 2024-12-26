<?php
include 'layouts/head.php';
include 'layouts/navbar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namaObt = $_POST['namaObt'];
    $kodeObt = $_POST['kodeObt'];

    // SQL query to insert new medication
    $sql = "INSERT INTO obat (NamaObt, KodeObt) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $namaObt, $kodeObt);

    // Execute the query
    if ($stmt->execute()) {
        echo "<script>alert('Obat berhasil ditambahkan!'); window.location.href='obat.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Tambah Obat</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="namaObt">Nama Obat</label>
                            <input type="text" class="form-control" id="namaObt" name="namaObt" required>
                        </div>
                        <div class="form-group">
                            <label for="kodeObt">Kode Obat</label>
                            <input type="text" class="form-control" id="kodeObt" name="kodeObt" required>
                        </div>
                        <div class="form-group">
                            <label for="jenisObt">Jenis Obat</label>
                            <input type="text" class="form-control" id="jenisObt" name="jenisObt" required>
                        </div>
                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <input type="text" class="form-control" id="kategori" name="kategori" required>
                        </div>
                        <div class="form-group">
                            <label for="hargaObt">Harga Obat</label>
                            <input type="text" class="form-control" id="hargaObt" name="hargaObt" required>
                        </div>
                        <div class="form-group">
                            <label for="jumlahObt">Jumlah Obat</label>
                            <input type="text" class="form-control" id="jumlahObt" name="jumlahObt" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include 'layouts/footer.php';
?>
