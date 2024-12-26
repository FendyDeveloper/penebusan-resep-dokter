<?php
include 'layouts/head.php';
include 'layouts/navbar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $NomerResep = $_POST['NomerResep'];
  $KodeObat = $_POST['KodeObat'];
  $Harga = $_POST['Harga'];
  $Dosis = $_POST['Dosis'];
  $JumlahObat = $_POST['JumlahObat'];
  $SubTotal = $_POST['SubTotal'];

  // Check for duplicate entry
  $sqlCheckDuplicate = "SELECT * FROM detail WHERE NomerResep = ? AND KodeObat = ?";
  $stmtCheckDuplicate = $conn->prepare($sqlCheckDuplicate);
  $stmtCheckDuplicate->bind_param("ss", $NomerResep, $KodeObat);
  $stmtCheckDuplicate->execute();
  $resultDuplicate = $stmtCheckDuplicate->get_result();

  if ($resultDuplicate->num_rows > 0) {
    echo "<script>alert('Error : Obat yang anda pilih sudah pernah dipesan'); window.location.href='resep.php';</script>";
  } else {
    // Check current stock of the selected medicine
    $sqlCheckStock = "SELECT JumlahObat FROM obat WHERE KodeObat = ?";
    $stmtCheckStock = $conn->prepare($sqlCheckStock);
    $stmtCheckStock->bind_param("s", $KodeObat);
    $stmtCheckStock->execute();
    $result = $stmtCheckStock->get_result();

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $currentStock = $row['JumlahObat'];

      if ($currentStock >= $JumlahObat) {
        // Update stock by reducing the current stock
        $newStock = $currentStock - $JumlahObat;
        $sqlUpdateStock = "UPDATE obat SET JumlahObat = ? WHERE KodeObat = ?";
        $stmtUpdateStock = $conn->prepare($sqlUpdateStock);
        $stmtUpdateStock->bind_param("is", $newStock, $KodeObat);
        $stmtUpdateStock->execute();

        // Insert data into the detail table
        $sql = "INSERT INTO detail (NomerResep, KodeObat, Harga, Dosis, JumlahObat, SubTotal) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdddi", $NomerResep, $KodeObat, $Harga, $Dosis, $JumlahObat, $SubTotal);

        if ($stmt->execute()) {
          echo "<script>alert('Detail Resep Obat berhasil ditambahkan!'); window.location.href='resep.php';</script>";
        } else {
          echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
        $stmt->close();
      } else {
        echo "<script>alert('Stok obat tidak mencukupi!');</script>";
      }
    } else {
      echo "<script>alert('Obat tidak ditemukan!');</script>";
    }
    $stmtCheckStock->close();
  }
  $stmtCheckDuplicate->close();
}
?>

<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0">
          <h6>Input Detail Resep Obat</h6>
        </div>
        <div class="card-body">
          <form method="POST" action="">
            <div class="form-group">
              <label for="NomerResep">Nomor Resep</label>
              <select class="form-control" id="NomerResep" name="NomerResep" required>
                <?php
                if (isset($_GET['id'])) {
                  $id = $_GET['id'];
                  $sql = "SELECT NomerResep FROM resep WHERE NomerResep = ?";
                  $stmt = $conn->prepare($sql);
                  $stmt->bind_param("s", $id);
                  $stmt->execute();
                  $result = $stmt->get_result();
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo "<option value='" . $row['NomerResep'] . "' selected>" . $row['NomerResep'] . "</option>";
                    }
                  } else {
                    echo "<option value=''>Tidak ada nomor resep tersedia</option>";
                  }
                  $stmt->close();
                } else {
                  echo "<option value=''>Tidak ada nomor resep tersedia</option>";
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="KodeObat">Obat</label>
              <select class="form-control" id="KodeObat" name="KodeObat" required onchange="getHarga()">
              <option value='' >Pilih obat</option>
                <?php
                $sql = "SELECT KodeObat, NamaObat, HargaObat FROM obat";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['KodeObat'] . "'>" . $row['NamaObat'] . " - " . $row['HargaObat']  . "</option>";
                  }
                } else {
                  echo "<option value=''>Tidak ada obat tersedia</option>";
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              
              <input type="number" class="form-control" id="Harga" name="Harga" hidden>
            </div>
            <div class="form-group">
              <label for="Dosis">Dosis</label>
              <div class="input-group">
                <input type="number" class="form-control" id="Dosis" name="Dosis" required>
                <select class="input-group-text border-1" id="basic-addon2">
                  <option>* 1 hari</option>
                  <option>* 2 hari</option>
                  <option>* 3 hari</option>
                  <option>* 4 hari</option>
                  <option>* 5 hari</option>
                  <option>* 6 hari</option>
                  <option>* 7 hari</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="JumlahObat">Jumlah Obat</label>
              <input type="number" class="form-control" id="JumlahObat" name="JumlahObat" required>
            </div>
            <div class="form-group">
              <label for="SubTotal">SubTotal</label>
              <input type="number" class="form-control" id="SubTotal" name="SubTotal" readonly>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function getHarga() {
    var kodeObat = document.getElementById('KodeObat').value;
    var hargaObat = document.getElementById('Harga');
    var options = document.getElementById('KodeObat').options;
    var selectedOption = options[options.selectedIndex];
    var harga = selectedOption.text.split(' - ')[1];
    hargaObat.value = harga;
  }

  // Function to calculate subtotal based on harga and jumlah obat
  function calculateSubTotal() {
    var harga = document.getElementById('Harga').value;
    var jumlahObat = document.getElementById('JumlahObat').value;
    var subtotal = harga * jumlahObat;
    document.getElementById('SubTotal').value = subtotal;
  }

  // Event listener to call calculateSubTotal function when harga or jumlah obat changes
  document.getElementById('Harga').addEventListener('input', calculateSubTotal);
  document.getElementById('JumlahObat').addEventListener('input', calculateSubTotal);
</script>

<?php
include 'layouts/footer.php';
?>
