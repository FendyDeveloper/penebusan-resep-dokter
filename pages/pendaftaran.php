<?php
include 'layouts/head.php';
include 'layouts/navbar.php';

// SQL query to fetch all registrations
$sql = "SELECT * FROM pendaftaran WHERE Status='daftar'";
$result = $conn->query($sql);
?>

<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0 d-flex justify-content-between">
          <h6>Daftar Pendaftaran</h6>
          <a href="tambah_pendaftaran.php" class="btn btn-primary">Tambah Pendaftaran</a>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
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
                    $namaPlk = "Tidak Diketahui";
                    $sqlPlk = "SELECT NamaPlk FROM poliklinik WHERE KodePlk='{$row['KodePlk']}'";
                    $resultPlk = $conn->query($sqlPlk);
                    if ($resultPlk->num_rows > 0) {
                      $namaPlk = $resultPlk->fetch_assoc()['NamaPlk'];
                    }
                    echo "<td class='align-middle text-center'>{$row['NomorPendf']}</td>";
                    echo "<td class='align-middle text-center'>{$row['TanggalPendf']}</td>";
                    echo "<td class='align-middle text-center'>
                    {$row['KodeDkt']} |
                    {$namaDokter}
                    </td>";
                    echo "<td class='align-middle text-center'>
                      {$row['KodePsn']} |
                      {$namaPasien} 
                    </td>";
                    // echo "<td class='align-middle text-center'>{$namaPlk}</td>";
                    echo "<td class='align-middle text-center'>{$row['KodePlk']}</td>";
                    echo "<td class='align-middle text-center'>{$row['Biaya']}</td>";
                    echo "<td class='align-middle text-center'>{$row['Ket']}</td>";
                    echo "<td class='align-middle text-center'>{$row['Status']}</td>";
                    echo "<td class='align-middle text-center'>";
                    echo "<a href='tambah_resep.php?id={$row['NomorPendf']}' class='btn btn-primary btn-sm'>Proses</a> ";
                    echo "</td>";
                    echo "</tr>";
                  }
                } else {
                  echo "<tr><td colspan='8'>No data available</td></tr>";
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
