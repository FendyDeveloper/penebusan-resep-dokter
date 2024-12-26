<?php
include 'layouts/head.php';
include 'layouts/navbar.php';


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
    </div
    </div>
</div>

<!-- Modal Detail Pembayaran -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateStockForm">
                    <div class="mb-3">
                        <label for="tanggalBayar" class="form-label">Tanggal Pembayaran</label>
                        <input type="text" class="form-control" id="tanggalBayar" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="kodePasien" class="form-label">Kode Pasien</label>
                        <input type="text" class="form-control" id="kodePasien" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="namaPasien" class="form-label">Nama Pasien</label>
                        <input type="text" class="form-control" id="namaPasien" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="jumlahBayar" class="form-label">Jumlah Bayar</label>
                        <input type="text" class="form-control" id="jumlahBayar" readonly>
                    </div>
                    <!-- <?php
                    // $sqlResep = "SELECT * FROM resep WHERE KodePsn = ?";
                    // $stmtResep = $conn->prepare($sqlResep);
                    // $stmtResep->bind_param("s", $kodePsn);
                    // $stmtResep->execute();
                    // $resultResep = $stmtResep->get_result();
                    
                    ?>
                    <div class="mb-3">
                        <label for="dibayar" class="form-label">Dibayar</label>
                        <input type="text" class="form-control" id="dibayar" value="<?php echo $dibayar; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="kembali" class="form-label">Kembali</label>
                        <input type="text" class="form-control" id="kembali" readonly>
                    </div>
                    Anda bisa menambahkan field lainnya sesuai kebutuhan -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('exampleModal').addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var nomorByr = button.getAttribute('data-bs-nomorbyr');
        var kodePsn = button.getAttribute('data-bs-kodepsn');
        
        // Buat permintaan AJAX untuk mendapatkan detail pembayaran
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "get_detail_pembayaran.php?nomorbyr=" + nomorByr, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);
                document.getElementById('tanggalBayar').value = data.TanggalByr;
                document.getElementById('kodePasien').value = data.KodePsn;
                document.getElementById('namaPasien').value = data.NamaPsn;
                document.getElementById('jumlahBayar').value = data.JumlahByr;
            }
        };
        xhr.send();
    });
</script>

<?php
include 'layouts/footer.php';
?>

