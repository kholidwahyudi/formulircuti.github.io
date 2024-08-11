<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cuti_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk mengambil data cuti
$sql = "SELECT nama, tanggal_mulai, tanggal_selesai FROM cuti";
$result = $conn->query($sql);

$cutiData = [];

if ($result && $result->num_rows > 0) {
    // Fetch semua data cuti
    while($row = $result->fetch_assoc()) {
        $cutiData[] = $row;
    }
}

// Mengembalikan data sebagai JSON
header('Content-Type: application/json');
echo json_encode($cutiData);

$conn->close();
?>
