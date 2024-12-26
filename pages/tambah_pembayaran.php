<?php
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $KodePsn = $_POST['KodePsn']; // Ambil nilai KodePsn dari form
  $TanggalByr = date("Y-m-d"); // Gunakan tanggal hari ini untuk TanggalByr
  $JumlahByr = $_POST['JumlahByr']; // Ambil nilai JumlahByr dari form

  // SQL query untuk melakukan penambahan pembayaran
  $sql_pembayaran = "INSERT INTO pembayaran (KodePsn, TanggalByr, JumlahByr) VALUES (?, ?, ?)";
  $stmt_pembayaran = $conn->prepare($sql_pembayaran);
  $stmt_pembayaran->bind_param("iss", $KodePsn, $TanggalByr, $JumlahByr);
  if ($stmt_pembayaran->execute()) {
    echo "<script>alert('Pembayaran berhasil ditambahkan!');</script>";
  } else {
    echo "<script>alert('Error: " . $stmt_pembayaran->error . "');</script>";
  }
  $stmt_pembayaran->close();
} ?>
