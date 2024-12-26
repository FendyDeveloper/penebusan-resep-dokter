<?php
include 'layouts/head.php';
include 'layouts/navbar.php';

// Memeriksa apakah nomor pendaftaran telah dikirim melalui URL
if(isset($_GET['id'])) {
    $idPendaftaran = $_GET['id'];
    
    // Mengambil informasi pendaftaran berdasarkan nomor pendaftaran
    $sqlPendaftaran = "SELECT * FROM pendaftaran WHERE NomorPendf = ?";
    $stmtPendaftaran = $conn->prepare($sqlPendaftaran);
    $stmtPendaftaran->bind_param("s", $idPendaftaran);
    $stmtPendaftaran->execute();
    $resultPendaftaran = $stmtPendaftaran->get_result();
    
    // Memeriksa apakah pendaftaran ditemukan
    if($resultPendaftaran->num_rows > 0) {
        $rowPendaftaran = $resultPendaftaran->fetch_assoc();
        ?>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex justify-content-between">
                            <h6>Detail Pendaftaran</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nomor Pendaftaran</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Pendaftaran</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kode Dokter</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kode Pasien</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kode Poliklinik</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Biaya</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Keterangan</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class='align-middle text-center'><?php echo $rowPendaftaran['NomorPendf']; ?></td>
                                            <td class='align-middle text-center'><?php echo $rowPendaftaran['TanggalPendf']; ?></td>
                                            <td class='align-middle text-center'><?php echo $rowPendaftaran['KodeDkt']; ?></td>
                                            <td class='align-middle text-center'><?php echo $rowPendaftaran['KodePsn']; ?></td>
                                            <td class='align-middle text-center'><?php echo $rowPendaftaran['KodePlk']; ?></td>
                                            <td class='align-middle text-center'><?php echo $rowPendaftaran['Biaya']; ?></td>
                                            <td class='align-middle text-center'><?php echo $rowPendaftaran['Ket']; ?></td>
                                            <td class='align-middle text-center'><?php echo $rowPendaftaran['Status']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } else {
        echo "<script>alert('Error: Data pendaftaran tidak ditemukan');</script>";
    }
    $stmtPendaftaran->close();
} else {
    echo "<script>alert('Error: Nomor pendaftaran tidak ditemukan');</script>";
}
?>
<?php include 'layouts/footer.php'; ?>
