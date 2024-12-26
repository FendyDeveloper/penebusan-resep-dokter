<?php
include 'layouts/head.php';
include 'layouts/navbar.php';
include 'koneksi.php'; // Sertakan file koneksi.php untuk menghubungkan ke database

// Proses penyimpanan data dari form (jika ada)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Data dari form
    $NomerResep = $_POST['NomerResep'];
    $KodeObat = $_POST['KodeObat'];
    $Harga = $_POST['Harga'];
    $Dosis = $_POST['Dosis'];
    $JumlahObat = $_POST['JumlahObat'];
    $SubTotal = $_POST['SubTotal'];

    // Insert ke tabel detail
    $sql = "INSERT INTO detail (NomerResep, KodeObat, Harga, Dosis, JumlahObat, SubTotal) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdddi", $NomerResep, $KodeObat, $Harga, $Dosis, $JumlahObat, $SubTotal);

    if ($stmt->execute()) {
        echo "<script>alert('Detail Resep Obat berhasil ditambahkan!');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
    $stmt->close();

    // Data tambahan untuk tabel pembayaran
    $KodePsn = $_POST['KodePsn'];
    $TanggalByr = date("Y-m-d");
    $JumlahByr = 0;

    // Insert ke tabel pembayaran
    $sql_pembayaran = "INSERT INTO pembayaran (KodePsn, TanggalByr, JumlahByr) VALUES (?, ?, ?)";
    $stmt_pembayaran = $conn->prepare($sql_pembayaran);
    $stmt_pembayaran->bind_param("iss", $KodePsn, $TanggalByr, $JumlahByr);

    if ($stmt_pembayaran->execute()) {
        echo "<script>alert('Pembayaran berhasil ditambahkan!');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt_pembayaran->error . "');</script>";
    }
    $stmt_pembayaran->close();
}

$sql_pendaftaran = "SELECT * FROM pendaftaran WHERE Status='daftar'";
$result_pendaftaran = $conn->query($sql_pendaftaran);

$sql_resep = "SELECT * FROM resep";
$result_resep = $conn->query($sql_resep);



?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <h6>Tabel Pembayaran</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal Pembayaran</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kode Pasien</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Pasien</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah Bayar</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Query untuk mengambil data pembayaran
                                $sql_tabel = "SELECT NomorByr, KodePsn, TanggalByr, JumlahByr FROM pembayaran";
                                $result_tabel = $conn->query($sql_tabel);

                                if ($result_tabel->num_rows > 0) {
                                    while ($row = $result_tabel->fetch_assoc()) {
                                        echo "<tr>";
                                        $namaPasien = "Tidak Diketahui";
                                        $sqlPasien = "SELECT NamaPsn FROM pasien WHERE KodePsn='{$row['KodePsn']}'";
                                        $resultPasien = $conn->query($sqlPasien);

                                        if ($resultPasien->num_rows > 0) {
                                            $namaPasien = $resultPasien->fetch_assoc()['NamaPsn'];
                                        }

                                        echo "<td>" . htmlspecialchars($row["TanggalByr"]) . "</td>";
                                        echo "<td>" . htmlspecialchars($row["KodePsn"]) . "</td>";
                                        echo "<td class='align-middle text-center'>{$namaPasien}</td>";
                                        echo "<td>" . htmlspecialchars($row["JumlahByr"]) . "</td>";
                                        echo "<td><a href='#' class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#exampleModal' data-bs-nomorbyr='{$row['NomorByr']}' data-bs-kodepsn='{$row['KodePsn']}'>Detail</a></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>No data available</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Atau ganti dengan modal-xl untuk modal sangat lebar -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Pembayaran</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kode Pasien</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Pasien</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Bayar</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dibayar</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kembali</th>
                        </tr>
                    </thead>
                    <tbody id="detailTableBody">
                        <!-- Konten modal akan diisi oleh JavaScript -->
                    </tbody>
                </table>
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal <br> Pendaftaran</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kode Dokter</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kode Pasien</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kode Poliklinik</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Biaya</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Keterangan</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                        </tr>
                    </thead>
                    <tbody id="detailTableBodyPendaftaran">
                        <!-- Konten modal akan diisi oleh JavaScript -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var exampleModal = document.getElementById('exampleModal');
    exampleModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var nomorByr = button.getAttribute('data-bs-nomorbyr');
        var kodePsn = button.getAttribute('data-bs-kodepsn'); // Ambil kode pasien

        // AJAX request untuk mendapatkan detail pembayaran berdasarkan NomorByr
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "get_obat_detail.php", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                var tbody = document.getElementById('detailTableBody');
                var tbodyPendaftaran = document.getElementById('detailTableBodyPendaftaran');
                tbody.innerHTML = ''; // Kosongkan tabel modal
                tbodyPendaftaran.innerHTML = ''; // Kosongkan tabel modal

                if (response.length > 0) {
                    response.forEach(function (item) {
                        var tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td class='align-middle text-center'>${item.TanggalByr}</td>
                            <td class='align-middle text-center'>${item.KodePsn}</td>
                            <td class='align-middle text-center'>${item.NamaPsn}</td>
                            <td class='align-middle text-center'>${item.JumlahByr}</td>
                            <td class='align-middle text-center'>${item.Dibayar}</td>
                            <td class='align-middle text-center'>${item.Kembali}</td>`;
                        tbody.appendChild(tr);

                        // Tambahkan baris untuk detail pendaftaran
                        var trPendaftaran = document.createElement('tr');
                        trPendaftaran.innerHTML = `
                            <td class='align-middle text-center'>${item.No}</td>
                            <td class='align-middle text-center'>${item.TanggalPendaftaran}</td>
                            <td class='align-middle text-center'>${item.KodeDokter}</td>
                            <td class='align-middle text-center'>${item.KodePasien}</td>
                            <td class='align-middle text-center'>${item.KodePoliklinik}</td>
                            <td class='align-middle text-center'>${item.Biaya}</td>
                            <td class='align-middle text-center'>${item.Keterangan}</td>
                            <td class='align-middle text-center'>${item.Status}</td>`;
                        tbodyPendaftaran.appendChild(trPendaftaran);
                    });
                } else {
                    tbody.innerHTML = "<tr><td colspan='6' class='text-center'>Tidak ada data tersedia</td></tr>";
                    tbodyPendaftaran.innerHTML = "<tr><td colspan='8' class='text-center'>Tidak ada data tersedia</td></tr>";
                }
            }
        };
        xhr.send('NomorByr=' + nomorByr + '&KodePsn=' + kodePsn); // Kirim kode pasien bersama dengan NomorByr
    });
});
</script>

<?php
include 'layouts/footer.php';
?>

<?php
include 'layouts/head.php';
include 'layouts/navbar.php';

// Query untuk mengambil data resep
$sql = "SELECT * FROM resep";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $KodePsn = $_POST['KodePsn'];
    $JumlahByr = $_POST['JumlahByr'];
    $Dibayar = $_POST['Dibayar'];
    $Kembali = $_POST['Kembali'];

    // Periksa apakah KodePsn ada di tabel pasien
    $checkPatientSql = "SELECT KodePsn FROM pasien WHERE KodePsn = ?";
    $stmtCheckPatient = $conn->prepare($checkPatientSql);
    $stmtCheckPatient->bind_param("s", $KodePsn);
    $stmtCheckPatient->execute();
    $stmtCheckPatient->store_result();

    if ($stmtCheckPatient->num_rows > 0) {
        // Menyisipkan data pembayaran ke dalam tabel pembayaran
        $insertPembayaranSql = "INSERT INTO pembayaran (NomorByr, KodePsn, TanggalByr, JumlahByr) VALUES (NULL, ?, NOW(), ?)";
        $stmtInsertPembayaran = $conn->prepare($insertPembayaranSql);
        $stmtInsertPembayaran->bind_param("sd", $KodePsn, $JumlahByr);

        if ($stmtInsertPembayaran->execute()) {
            // Update data resep dengan informasi pembayaran
            $updateSql = "UPDATE resep SET Bayar=?, Kembali=? WHERE NomerResep=?";
            $stmt = $conn->prepare($updateSql);
            $stmt->bind_param("ddi", $Dibayar, $Kembali, $KodePsn);

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
        echo "<script>alert('Kode Pasien tidak valid.');</script>";
    }

    $stmtCheckPatient->close();
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
              <label for="KodePsn">Nomer Resep</label>
              <input type="text" class="form-control" id="KodePsn" name="KodePsn" value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>" required>
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

<script>
  document.getElementById('Dibayar').addEventListener('input', function() {
    var jumlahBayar = parseInt(document.getElementById('JumlahByr').value);
    var dibayar = parseInt(document.getElementById('Dibayar').value);
    var kembali = dibayar - jumlahBayar;
    document.getElementById('Kembali').value = kembali;
  });
</script>



