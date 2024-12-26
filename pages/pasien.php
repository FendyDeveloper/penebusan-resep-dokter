<?php

include 'layouts/head.php';
include 'layouts/navbar.php';

$sql = "SELECT * FROM pasien";
$result = $conn->query($sql);
?>

<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0 d-flex justify-content-between">
          <h6>Authors table</h6>
          <a href="tambah_pasien.php" class="btn btn-primary">Tambah Pasien</a>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kode Pasien</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Alamat</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Gender</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Umur</th>
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
                    echo "<td class='align-middle text-center'>{$row['KodePsn']}</td>";
                    echo "<td class='align-middle text-center'>{$row['NamaPsn']}</td>";
                    echo "<td class='align-middle text-center'>{$row['AlamatPsn']}</td>";
                    echo "<td class='align-middle text-center'>{$row['GenderPsn']}</td>";
                    echo "<td class='align-middle text-center'>{$row['UmurPsn']}</td>";
                    echo "<td class='align-middle text-center'><span class='text-secondary text-xs font-weight-bold'>{$row['TeleponPsn']}</span></td>";
                    echo "<td class='align-middle text-center'>";
                    echo "<a href='edit_pasien.php?id={$row['KodePsn']}' class='btn btn-primary btn-sm'>Edit</a> ";
                    echo "<a href='hapus_pasien.php?KodePsn={$row['KodePsn']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Hapus</a>";
                    echo "</td>";
                   
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