<?php
session_start();
include 'koneksi.php'; // File koneksi database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pastikan data 'username' dan 'password' tersedia sebelum melakukan proses login
    if(isset($_POST['username']) && isset($_POST['password'])) {
        // Ambil data yang dikirimkan dari formulir login
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Query untuk mencari pengguna berdasarkan username/email dan password
        $query = "SELECT * FROM users WHERE (username = ? OR email = ?) AND password = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $username, $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // Pengguna ditemukan, mulai sesi
            $_SESSION['username'] = $username;
            // Redirect ke halaman dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            // Jika tidak ditemukan, tampilkan pesan error atau redirect ke halaman login dengan pesan error
            echo "Username/email atau password salah.";
        }
    } else {
        // Jika data 'username' atau 'password' tidak tersedia, tampilkan pesan error
        echo "Username/email atau password tidak tersedia.";
    }
}
?>
