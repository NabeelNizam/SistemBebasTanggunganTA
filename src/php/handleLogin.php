<?php
// Start session
session_start();

// Include connection file
require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil input dari form dengan validasi
    $email = htmlspecialchars($_POST['email'] ?? '');
    $password = htmlspecialchars($_POST['password'] ?? '');

    // Validasi input kosong
    if (empty($email) || empty($password)) {
        echo "Email dan password wajib diisi.";
        exit;
    }

    // Query untuk mencari user berdasarkan email
    $sql = "SELECT id, password FROM Users WHERE email = ?";
    $params = array($email);
    $stmt = sqlsrv_query($conn, $sql, $params);

    // Jika query gagal
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Jika user ditemukan
    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        // Verifikasi password
        if (password_verify($password, $row['password'])) {
            // Set session
            $_SESSION['user_id'] = $row['id'];
            echo "Login berhasil! Redirecting...";
            header("Location: http://localhost/src/dashboard.html"); // Ubah ke halaman setelah login
            exit;
        } else {
            echo "Password salah.";
        }
    } else {
        echo "Email tidak ditemukan.";
    }

    // Tutup statement
    sqlsrv_free_stmt($stmt);
}

// Tutup koneksi
sqlsrv_close($conn);
?>
