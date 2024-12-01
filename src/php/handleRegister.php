<?php
require_once 'connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = htmlspecialchars($_POST['nama'] ?? '');
    $nim = htmlspecialchars($_POST['nim'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $password = htmlspecialchars($_POST['password'] ?? '');
    $prodi_id = htmlspecialchars($_POST['prodi_id'] ?? '');
    $role = 1;

    // Validasi data
    if (empty($nama) || empty($nim) || empty($email) || empty($password) || empty($prodi_id)) {
        die("Pastikan semua data terisi.");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email tidak valid.");
    }
    if (!is_numeric($prodi_id)) {
        die("Prodi ID harus berupa angka.");
    }

    // Cek apakah email sudah ada di database
    $checkEmailSql = "SELECT id FROM Users WHERE email = ?";
    $checkEmailStmt = sqlsrv_query($conn, $checkEmailSql, array($email));
    if ($checkEmailStmt === false) {
        die("Terjadi kesalahan saat memeriksa email: " . print_r(sqlsrv_errors(), true));
    }
    if (sqlsrv_fetch_array($checkEmailStmt, SQLSRV_FETCH_ASSOC)) {
        die("Email sudah terdaftar. Gunakan email lain.");
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Input ke tabel Users dan ambil ID baru dengan OUTPUT INSERTED.id
    $insertUserSql = "INSERT INTO Users (name, email, password, role) 
                      OUTPUT INSERTED.id 
                      VALUES (?, ?, ?, ?)";
    $params = array($nama, $email, $hashedPassword, $role);
    $stmt = sqlsrv_query($conn, $insertUserSql, $params);
    if ($stmt === false) {
        die("Terjadi kesalahan saat menyimpan data pengguna: " . print_r(sqlsrv_errors(), true));
    }

    // Ambil ID dari hasil query OUTPUT
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $user_id = $row['id'] ?? null;

    if ($user_id === null) {
        die("Gagal mendapatkan ID pengguna. Registrasi tidak bisa dilanjutkan.");
    }

    // Input ke tabel UserDetail
    $insertUserDetailSql = "INSERT INTO UserDetail (user_id, prodi_id, nim) VALUES (?, ?, ?)";
    $paramsUserDetail = array($user_id, $prodi_id, $nim);
    $stmtUserDetail = sqlsrv_query($conn, $insertUserDetailSql, $paramsUserDetail);
    if ($stmtUserDetail === false) {
        die("Terjadi kesalahan saat menyimpan detail pengguna: " . print_r(sqlsrv_errors(), true));
    }

    echo "Registrasi berhasil!";
    header("Location: /src/login.php");
}
?>
