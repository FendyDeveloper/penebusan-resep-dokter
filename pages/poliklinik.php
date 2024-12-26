<?php
include 'layouts/head.php';
include 'layouts/navbar.php';

// SQL query to fetch all polyclinics
$sql = "SELECT * FROM poliklinik";
$result = $conn->query($sql);
?>

<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0 d-flex justify-content-between">
          <h6>Daftar Poliklinik</h6>
          <a href="tambah_poliklinik.php" class="btn btn-primary">Tambah Poliklinik</a>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Poliklinik</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kode Poliklinik</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Opsi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($result->num_rows > 0) {
                  // Output data of each row
                  while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='align-middle text-center'>{$row['NamaPlk']}</td>";
                    echo "<td class='align-middle text-center'>{$row['KodePlk']}</td>";
                    echo "<td class='align-middle text-center'>";
                    echo "<a href='edit_poliklinik.php?id={$row['KodePlk']}' class='btn btn-primary btn-sm'>Edit</a> ";
                    echo "<a href='hapus_poliklinik.php?KodePoli={$row['KodePlk']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Hapus</a>";
                    echo "</td>";
                    echo "</tr>";
                  }
                } else {
                  echo "<tr><td colspan='3'>No data available</td></tr>";
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
