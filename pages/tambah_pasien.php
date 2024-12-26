<?php
include 'layouts/head.php';
include 'layouts/navbar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $kodePasien = $_POST['kodePasien'];
    $alamat = $_POST['alamat'];
    $gender = $_POST['gender'];
    $umur = $_POST['umur'];
    $telepon = $_POST['telepon'];

    $sql = "INSERT INTO pasien (NamaPsn, KodePsn, AlamatPsn, GenderPsn, UmurPsn, TeleponPsn) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssis", $nama, $kodePasien, $alamat, $gender, $umur, $telepon);

    if ($stmt->execute()) {
        echo "<script>alert('Data pasien berhasil ditambahkan!'); window.location.href='pasien.php';</script>";
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
                    <h4>Tambah Pasien</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="form-group">
                            <label for="nama">Nama Pasien</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="kodePasien">Kode Pasien</label>
                            <input type="text" class="form-control" id="kodePasien" name="kodePasien" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" required>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select class="form-control" id="gender" name="gender">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="umur">Umur</label>
                            <input type="number" class="form-control" id="umur" name="umur" required>
                        </div>
                        <div class="form-group">
                            <label for="telepon">Telepon</label>
                            <input type="text" class="form-control" id="telepon" name="telepon" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>