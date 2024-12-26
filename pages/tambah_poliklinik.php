<?php
include 'layouts/head.php';
include 'layouts/navbar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namaPlk = $_POST['namaPlk'];
    $kodePlk = $_POST['kodePlk'];

    // SQL query to insert new polyclinic
    $sql = "INSERT INTO poliklinik (NamaPlk, KodePlk) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $namaPlk, $kodePlk);

    // Execute the query
    if ($stmt->execute()) {
        echo "<script>alert('Poliklinik berhasil ditambahkan!'); window.location.href='poliklinik.php';</script>";
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
                    <h4>Tambah Poliklinik</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="namaPlk">Nama Poliklinik</label>
                            <input type="text" class="form-control" id="namaPlk" name="namaPlk" required>
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
