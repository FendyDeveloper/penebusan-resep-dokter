<?php
include 'layouts/head.php';
include 'layouts/navbar.php';

// Query untuk mengambil data resep
$sql = "SELECT * FROM resep";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $NomerResep = $_POST['NomerResep'];
  $JumlahByr = $_POST['JumlahByr'];
  $Dibayar = $_POST['Dibayar'];
  $Kembali = $_POST['Kembali'];

  // Periksa apakah NomerResep ada di tabel pasien
  $checkResepSql = "SELECT KodePsn FROM resep WHERE NomerResep = ?";
  $stmtCheckResep = $conn->prepare($checkResepSql);
  $stmtCheckResep->bind_param("s", $NomerResep);
  $stmtCheckResep->execute();
  $stmtCheckResep->store_result();

  if ($stmtCheckResep->num_rows > 0) {
    // Ambil KodePsn dari tabel resep
    $stmtCheckResep->bind_result($KodePsn);
    $stmtCheckResep->fetch();

    // Menyisipkan data pembayaran ke dalam tabel pembayaran
    $insertPembayaranSql = "INSERT INTO pembayaran (NomorByr, KodePsn, TanggalByr, JumlahByr) VALUES (NULL, ?, NOW(), ?)";
    $stmtInsertPembayaran = $conn->prepare($insertPembayaranSql);
    $stmtInsertPembayaran->bind_param("sd", $KodePsn, $JumlahByr);

    if ($stmtInsertPembayaran->execute()) {
      // Update data resep dengan informasi pembayaran
      $updateSql = "UPDATE resep SET Bayar=?, Kembali=? WHERE NomerResep=?";
      $stmt = $conn->prepare($updateSql);
      $stmt->bind_param("ddi", $Dibayar, $Kembali, $NomerResep);

      if ($stmt->execute()) {
        // Set status pendaftaran menjadi 'selesai' setelah pembayaran berhasil
        $updateStatusSql = "UPDATE pendaftaran SET Status='selesai' WHERE NomorPendf=?";
        $stmtUpdateStatus = $conn->prepare($updateStatusSql);
        $stmtUpdateStatus->bind_param("i", $KodePsn);
        $stmtUpdateStatus->execute();
        $stmtUpdateStatus->close();

        echo "<script>alert('Pembayaran berhasil!'); window.location.href='pembayaran.php';</script>";
      } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
      }

      $stmt->close();
    } else {
      echo "<script>alert('Error: " . $stmtInsertPembayaran->error . "');</script>";
    }

    $stmtInsertPembayaran->close();
  } else {
    echo "<script>alert('Nomer Resep tidak valid.');</script>";
  }

  $stmtCheckResep->close();
}
?>

<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0">
          <h6>Form Pembayaran</h6>
        </div>
        <div class="card-body ">
          <form method="POST" action="">
            <div class="form-group">
              <label for="NomerResep">Nomer Resep</label>
              <input type="text" class="form-control" id="NomerResep" name="NomerResep" value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>" required>
            </div>
            <div class="form-group">
              <label for="KodePsn">Kode Pasien</label>
              <?php
              if (isset($_GET['id'])) {
                $id = htmlspecialchars($_GET['id']);
                $sqlKodePsn = "SELECT KodePsn FROM resep WHERE NomerResep = ?";
                $stmtKodePsn = $conn->prepare($sqlKodePsn);
                $stmtKodePsn->bind_param("s", $id);
                $stmtKodePsn->execute();
                $resultKodePsn = $stmtKodePsn->get_result();
                if ($resultKodePsn->num_rows > 0) {
                  $row = $resultKodePsn->fetch_assoc();
                  echo "<input type='text' class='form-control' id='KodePsn' name='KodePsn' value='{$row['KodePsn']}' readonly>";
                }
                $stmtKodePsn->close();
              } else {
                echo "<input type='text' class='form-control' id='KodePsn' name='KodePsn' readonly>";
              }
              ?>
            </div>

            <div class="form-group">
              <?php
              if (isset($_GET['id'])) {
                $id = htmlspecialchars($_GET['id']);
                $sqlTotal = "SELECT resep.TotalHarga, SUM(detail.subtotal) AS subtotal FROM resep LEFT JOIN detail ON resep.NomerResep = detail.NomerResep WHERE resep.NomerResep = ?";
                $stmt = $conn->prepare($sqlTotal);
                $stmt->bind_param("s", $id);
                $stmt->execute();
                $resultTotal = $stmt->get_result();
                if ($resultTotal->num_rows > 0) {
                  $rowTotal = $resultTotal->fetch_assoc();
                  $totalHarga = $rowTotal['TotalHarga'] + $rowTotal['subtotal'];
                  echo "<label for='JumlahByr'>Total Harga</label>";
                  echo "<input type='number' class='form-control' id='JumlahByr' name='JumlahByr' value='{$totalHarga}' readonly>";
                } else {
                  echo "<label for='JumlahByr'>Total Harga</label>";
                  echo "<input type='number' class='form-control' id='JumlahByr' name='JumlahByr' value='0' readonly>";
                }
                $stmt->close();
              } else {
                echo "<label for='JumlahByr'>Total Harga</label>";
                echo "<input type='number' class='form-control' id='JumlahByr' name='JumlahByr' value='0' readonly>";
              }
              ?>
            </div>
            <div class="form-group">
              <label for="Dibayar">Dibayar</label>
              <input type="number" class="form-control" id="Dibayar" name="Dibayar" required>
            </div>
            <div class="form-group">
              <label for="Kembali">Kembali</label>
              <input type="number" class="form-control" id="Kembali" name="Kembali" readonly>
            </div>
            <script>
              document.getElementById('Dibayar').addEventListener('input', function() {
                var jumlahBayar = parseInt(document.getElementById('JumlahByr').value);
                var dibayar = parseInt(document.getElementById('Dibayar').value);
                var kembali = dibayar - jumlahBayar;
                document.getElementById('Kembali').value = kembali;
              });
            </script>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<script>
  document.getElementById('Dibayar').addEventListener('input', function() {
    var jumlahBayar = parseInt(document.getElementById('JumlahByr').value);
    var dibayar = parseInt(document.getElementById('Dibayar').value);
    var kembali = dibayar - jumlahBayar;
    document.getElementById('Kembali').value = kembali;
  });
</script>