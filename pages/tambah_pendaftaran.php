<?php
include 'layouts/head.php';
include 'layouts/navbar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $TanggalPendf = $_POST['TanggalPendf'];
    $KodeDkt = $_POST['KodeDkt'];
    $KodePsn = $_POST['KodePsn'];
    $KodePlk = $_POST['KodePlk']; // Memperbaiki ini agar sesuai dengan select option
    $Biaya = $_POST['Biaya'];
    $Ket = $_POST['Ket'];

    // SQL query to insert new registration
    $sql = "INSERT INTO pendaftaran (TanggalPendf, KodeDkt, KodePsn, KodePlk, Biaya, Ket) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssis", $TanggalPendf, $KodeDkt, $KodePsn, $KodePlk, $Biaya, $Ket);

    // Execute the query
    if ($stmt->execute()) {
        echo "<script>alert('Pendaftaran berhasil ditambahkan!'); window.location.href='pendaftaran.php';</script>";
        //var_dump($_POST);
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
                    <h4>Tambah Pendaftaran</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="TanggalPendf">Tanggal Pendaftaran</label>
                            <input type="date" class="form-control" id="TanggalPendf" name="TanggalPendf" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="KodeDkt">Kode Dokter</label>
                            <select class="form-control" id="KodeDkt" name="KodeDkt" required>
                                <?php
                                $sql = "SELECT KodeDkt, NamaDkt, Spesialis, KodePlk FROM dokter"; // Mengambil KodePlk juga dari tabel dokter
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['KodeDkt'] . "' KodePlk='" . $row['KodePlk'] . "'>" . $row['NamaDkt'] . ' | ' . $row['Spesialis'] . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>Tidak ada dokter tersedia</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="KodePsn">Kode Pasien</label>
                            <select class="form-control" id="KodePsn" name="KodePsn" required>
                                <?php
                                $sql = "SELECT KodePsn, NamaPsn FROM pasien";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['KodePsn'] . "'>" . $row['NamaPsn'] . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>Tidak ada pasien tersedia</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <input type="hidden" class="form-control" id="KodePlk" name="KodePlk" value=""> <!-- Menambahkan input hidden untuk KodePlk -->
                        <div class="form-group">
                            <label for="Biaya">Biaya</label>
                            <input type="number" class="form-control" id="Biaya" name="Biaya" required>
                        </div>
                        <div class="form-group">
                            <label for="Ket">Keterangan</label>
                            <textarea class="form-control" id="Ket" name="Ket" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('KodeDkt').addEventListener('change', function() {
        var kodePlk = this.options[this.selectedIndex].getAttribute('KodePlk');
        document.getElementById('KodePlk').value = kodePlk;
    });
</script>

<?php
include 'layouts/footer.php';
?>
