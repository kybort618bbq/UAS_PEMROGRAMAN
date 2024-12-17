<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$password = "";
$dbname = "webinarteknologi_";

$conn = new mysqli($host, $user, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil ID pendaftaran dari parameter URL
$id_pendaftaran = $_GET['id_pendaftaran'];

// Ambil data peserta berdasarkan ID
$sql = "SELECT * FROM pendaftaran WHERE id_pendaftaran = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_pendaftaran);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
} else {
    echo "Pendaftaran tidak ditemukan!";
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Webinar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
        }
        .sertifikat-container {
            border: 2px solid #28a745;
            padding: 30px;
            display: inline-block;
            max-width: 600px;
            width: 100%;
        }
        h1 {
            color: #28a745;
        }
        p {
            font-size: 18px;
        }
        .btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            margin-top: 20px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .back-btn {
            padding: 10px 20px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            margin-top: 20px;
            cursor: pointer;
            text-decoration: none;
        }
        .back-btn:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>

    <div class="sertifikat-container">
        <h1>Sertifikat Webinar</h1>
        <p>Dengan ini menyatakan bahwa:</p>
        <h2><?= htmlspecialchars($row['nama']) ?></h2>
        <p>Telah mengikuti webinar dengan tema: <strong><?= htmlspecialchars($row['kategori']) ?></strong></p>
        <p>Diselenggarakan oleh: <?= htmlspecialchars($row['instansi']) ?></p>
        <p>Tanggal Pendaftaran: <?= htmlspecialchars($row['tanggal_daftar']) ?></p>

        <!-- Tombol untuk mengunduh sertifikat -->
        <button class="btn" onclick="window.print()">Cetak Sertifikat</button>
    </div>

    <!-- Tombol Kembali ke Halaman Utama -->
    <a href="index.php" class="back-btn">Kembali ke Halaman Utama</a>

</body>
</html>

<?php
// Menutup koneksi database
$conn->close();
?>
