<?php
include 'layouts/head.php';
include 'layouts/navbar.php';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $namaDkt = $_POST['namaDkt'];
    $spesialis = $_POST['spesialis'];
    $alamat = $_POST['alamat'];
    $teleponDkt = $_POST['teleponDkt'];

    // SQL query to insert new doctor
    $sql = "INSERT INTO dokter (NamaDkt, Spesialis, Alamat, TeleponDkt) VALUES ('$namaDkt', '$spesialis', '$alamat', '$teleponDkt')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h6>Tambah Dokter</h6>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="mb-3">
                            <label for="namaDkt" class="form-label">Nama Dokter:</label>
                            <input type="text" class="form-control" id="namaDkt" name="namaDkt" required>
                        </div>
                        <div class="mb-3">
                            <label for="spesialis" class="form-label">Spesialis:</label>
                            <input type="text" class="form-control" id="spesialis" name="spesialis" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat:</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" required>
                        </div>
                        <div class="mb-3">
                            <label for="teleponDkt" class="form-label">Telepon:</label>
                            <input type="text" class="form-control" id="teleponDkt" name="teleponDkt" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


    <?php
    include 'layouts/footer.php';
    ?>