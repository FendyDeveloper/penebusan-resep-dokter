<?php
include 'layouts/head.php';
include 'layouts/navbar.php';

// SQL query to fetch all prescriptions with status 'proses' in pendaftaran table
$sql = "SELECT resep.*, SUM(detail.subtotal) AS subtotal FROM resep LEFT JOIN detail ON resep.NomerResep = detail.NomerResep 
        JOIN pendaftaran ON resep.NomerResep = pendaftaran.NomorPendf WHERE pendaftaran.Status = 'proses' GROUP BY resep.NomerResep";
$result = $conn->query($sql);

?>

<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0 d-flex justify-content-between">
          <h6>Daftar Resep</h6>
          <a href="cek_antrian.php" class="btn btn-primary">Antrian</a>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nomor Resep</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Resep</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kode Dokter</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kode Pasien</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kode Poliklinik</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Harga</th>
                  <!-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Bayar</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kembali</th> -->
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Opsi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($result->num_rows > 0) {
                  // Output data of each row
                  while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    $namaDokter = "Tidak Diketahui";
                    $sqlDokter = "SELECT NamaDkt FROM dokter WHERE KodeDkt='{$row['KodeDkt']}'";
                    $resultDokter = $conn->query($sqlDokter);
                    if ($resultDokter->num_rows > 0) {
                      $namaDokter = $resultDokter->fetch_assoc()['NamaDkt'];
                    }
                    $namaPasien = "Tidak Diketahui";
                    $sqlPasien = "SELECT NamaPsn FROM pasien WHERE KodePsn='{$row['KodePsn']}'";
                    $resultPasien = $conn->query($sqlPasien);
                    if ($resultPasien->num_rows > 0) {
                      $namaPasien = $resultPasien->fetch_assoc()['NamaPsn'];
                    }
                    $spesialis = "Tidak Diketahui";
                    $sqlDkt = "SELECT Spesialis FROM dokter WHERE KodeDkt='{$row['KodeDkt']}'";
                    $resultDkt = $conn->query($sqlDkt);
                    if ($resultDkt->num_rows > 0) {
                      $spesialis = $resultDkt->fetch_assoc()['Spesialis'];
                    }
                    echo "<td class='align-middle text-center'>{$row['NomerResep']}</td>";
                    echo "<td class='align-middle text-center'>{$row['TanggalResep']}</td>";
                    echo "<td class='align-middle text-center'>{$namaDokter}</td>";
                    echo "<td class='align-middle text-center'>{$namaPasien}</td>";
                    echo "<td class='align-middle text-center'>{$spesialis}</td>";

                    $totalHarga = $row['TotalHarga'] + $row['subtotal']; // Menambahkan subtotal ke total harga
                    echo "<td class='align-middle text-center'>{$totalHarga}</td>"; 
                    // echo "<a href='proses_obat.php?id={$row['KodePsn']}' class='btn btn-success btn-sm'>Bayar</a> ";
                    // echo "<td class='align-middle text-center'>{$row['Bayar']}</td>";
                    // echo "<td class='align-middle text-center'>{$row['Kembali']}</td>";
                    echo "<td class='align-middle text-center'>
                    <a href='proses_pembayaran.php?id={$row['NomerResep']}' class='btn btn-success btn-sm'>Bayar</a>
                    <a href='proses_obat.php?id={$row['NomerResep']}' class='btn btn-primary btn-sm'>Pesan Obat</a>
                    </td>";
                    echo "</tr>";
                  }
                } else {
                  echo "<tr><td colspan='9'>No data available</td></tr>";
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
<?php
include 'layouts/footer.php';
?>
