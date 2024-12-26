<?php
include 'layouts/head.php';
include 'layouts/navbar.php';

// SQL query to fetch all medications
$sql = "SELECT * FROM obat";
$result = $conn->query($sql);
?>

<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0 d-flex justify-content-between">
          <h6>Daftar Obat</h6>
          <div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah Stok</button>
            <a href="tambah_obat.php" class="btn btn-primary">Tambah Obat</a>
          </div>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kode Obat</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Obat</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jenis Obat</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kategori</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Harga Obat</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah Obat</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Opsi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='align-middle text-center'>{$row['KodeObat']}</td>";
                    echo "<td class='align-middle text-center'>{$row['NamaObat']}</td>";
                    echo "<td class='align-middle text-center'>{$row['JenisObat']}</td>";
                    echo "<td class='align-middle text-center'>{$row['Kategori']}</td>";
                    echo "<td class='align-middle text-center'>{$row['HargaObat']}</td>";
                    echo "<td class='align-middle text-center'>{$row['JumlahObat']}</td>";
                    echo "<td class='align-middle text-center'>";
                    echo "<a href='edit_obat.php?id={$row['KodeObat']}' class='btn btn-primary btn-sm'>Edit</a> ";
                    echo "<a href='hapus_obat.php?KodeObt={$row['KodeObat']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\");'>Hapus</a>";
                    echo "</td>";
                    echo "</tr>";
                  }
                } else {
                  echo "<tr><td colspan='7' class='text-center'>Tidak ada data tersedia</td></tr>";
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
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Stok</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="updateStockForm">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kode</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if ($result->num_rows > 0) {
                $result->data_seek(0); // Reset result pointer to the beginning
                while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td class='align-middle text-center'>{$row['KodeObat']}</td>";
                  echo "<td class='align-middle text-left'>{$row['NamaObat']}</td>";
                  echo "<td class='align-middle'>
                          <div class='input-group'>
                            <span class='input-group-text'>{$row['JumlahObat']}</span>
                            <input type='number' class='form-control' name='jumlahObat[{$row['KodeObat']}]' value='0' min='0'>
                            <button class='btn btn-outline-secondary' type='button' onclick='increment(this)'>+</button>
                          </div>
                        </td>";
                  echo "</tr>";
                }
              } else {
                echo "<tr><td colspan='3' class='text-center'>Tidak ada data tersedia</td></tr>";
              }
              ?>
            </tbody>
          </table>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary" form="updateStockForm">Update</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.getElementById('updateStockForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const formData = new FormData(this);
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "update_stok.php", true);
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        location.reload(); // Reload page to reflect changes
      }
    };
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(new URLSearchParams(formData).toString());
  });

  function increment(btn) {
    var input = btn.previousElementSibling;
    var value = parseInt(input.value);
    input.value = value + 1;
  }
</script>

<?php
include 'layouts/footer.php';
?>
