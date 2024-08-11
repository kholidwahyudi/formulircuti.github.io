<?php
// Database configuration
$servername = "localhost";
$username = "root";  // Ganti dengan username MySQL Anda
$password = "";
$dbname = "cuti_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("<div style='color: red; font-weight: bold;'>Connection failed: " . $conn->connect_error . "</div>");
}

// Get form data
$nama = $_POST['nama'] ?? null;
$tanggal_mulai = $_POST['tanggal_mulai'] ?? null;
$tanggal_selesai = $_POST['tanggal_selesai'] ?? null;
$jenis_cuti = $_POST['jenis_cuti'] ?? null;

// Validate required fields
if (empty($nama) || empty($tanggal_mulai) || empty($tanggal_selesai) || empty($jenis_cuti)) {
    die("<div style='color: red; font-weight: bold;'>Semua kolom harus diisi!</div>");
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO cuti (nama, tanggal_mulai, tanggal_selesai, jenis_cuti) VALUES (?, ?, ?, ?)");

if (!$stmt) {
    die("<div style='color: red; font-weight: bold;'>Statement preparation failed: " . $conn->error . "</div>");
}

// Bind parameters
$stmt->bind_param("ssss", $nama, $tanggal_mulai, $tanggal_selesai, $jenis_cuti);

// Execute the statement
echo "<div style='display: flex; justify-content: center; align-items: center; height: 100vh; font-family: Arial, sans-serif;'>";
if ($stmt->execute()) {
    echo "<div style='color: green; font-weight: bold; font-size: 24px;'>Cuti berhasil diajukan!</div>";
} else {
    echo "<div style='color: red; font-weight: bold; font-size: 24px;'>Error: " . $stmt->error . "</div>";
}
echo "</div>";

// Close connections
$stmt->close();
$conn->close();
?>
