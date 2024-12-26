<?php
include 'layouts/head.php';
include 'layouts/navbar.php';

$sql = "SELECT * FROM dokter";
$result = $conn->query($sql);
?>

<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0 d-flex justify-content-between">
          <h6>Authors table</h6>
          <a href="tambah_dokter.php" class="btn btn-sm btn-primary">Tambah Dokter</a>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kode Dokter</th>
                  <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dokter</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Spesialis</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Alamat</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Telepon</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Opsi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($result->num_rows > 0) {
                  // Output data of each row
                  while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='align-middle text-center'>{$row['KodeDkt']}</td>";
                    echo "<td class='align-middle'>{$row['NamaDkt']}</td>";
                    echo "<td class='align-middle text-center text-sm'><span class='badge badge-sm bg-gradient-success'>{$row['Spesialis']}</span></td>";
                    echo "<td class='align-middle text-center'><span class='text-secondary text-xs font-weight-bold'>{$row['Alamat']}</span></td>";
                    echo "<td class='align-middle text-center'><span class='text-secondary text-xs font-weight-bold'>{$row['TeleponDkt']}</span></td>";

                    echo "<td class='align-middle text-center'>
                    <a href='edit_dokter.php?id={$row['KodeDkt']}' class='btn btn-sm btn-primary '>Edit</a>
                    <a href='hapus_dokter.php?id={$row['KodeDkt']}' class='btn btn-sm btn-danger'>Hapus</a>
                    </td>";
                    echo "</tr>";
                  }
                } else {
                  echo "<tr><td colspan='6'>No data available</td></tr>";
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
<!-- <?php include '../layouts/footer.php'; ?> -->