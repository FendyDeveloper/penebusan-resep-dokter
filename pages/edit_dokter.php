<?php
include 'layouts/head.php';
include 'layouts/navbar.php';

// Memeriksa apakah parameter id telah diberikan
if (isset($_GET['id'])) {
    $kodeDkt = $_GET['id'];

    // Memeriksa apakah form telah disubmit
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Ambil data dari form
        $namaDkt = $_POST['namaDkt'];
        $spesialis = $_POST['spesialis'];
        $alamat = $_POST['alamat'];
        $teleponDkt = $_POST['teleponDkt'];

        // Query untuk update informasi dokter
        $updateSql = "UPDATE dokter SET NamaDkt='$namaDkt', Spesialis='$spesialis', Alamat='$alamat', TeleponDkt='$teleponDkt' WHERE KodeDkt='$kodeDkt'";

        if ($conn->query($updateSql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }

    // Query untuk mendapatkan informasi dokter berdasarkan KodeDkt
    $sql = "SELECT * FROM dokter WHERE KodeDkt='$kodeDkt'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
?>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header ">
                            <h6>Edit Dokter</h6>
                            <form method="post" action="#">
                                <div class="mb-3">
                                    <label for="namaDkt" class="form-label">Nama Dokter:</label>
                                    <input type="text" class="form-control" id="namaDkt" name="namaDkt" value="<?php echo $row['NamaDkt']; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="spesialis" class="form-label">Spesialis:</label>
                                    <input type="text" class="form-control" id="spesialis" name="spesialis" value="<?php echo $row['Spesialis']; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat:</label>
                                    <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $row['Alamat']; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="teleponDkt" class="form-label">Telepon:</label>
                                    <input type="text" class="form-control" id="teleponDkt" name="teleponDkt" value="<?php echo $row['TeleponDkt']; ?>">
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    <?php
    } else {
        echo "Dokter not found";
    }
} else {
    echo "Invalid request";
}
include 'layouts/footer.php';
    ?>