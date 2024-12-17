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

// Ambil data pendaftaran
$sql = "SELECT * FROM pendaftaran ORDER BY tanggal_daftar DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pimpinan - Daftar Pendaftaran Webinar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .back-button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            margin-top: 20px;
            text-decoration: none;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
        .sertifikat-button {
            padding: 8px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }
        .sertifikat-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <h1>Daftar Pendaftaran Webinar</h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID Pendaftaran</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Instansi</th>
                    <th>Kategori</th>
                    <th>Tanggal Daftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id_pendaftaran']) ?></td>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['telepon']) ?></td>
                        <td><?= htmlspecialchars($row['instansi']) ?></td>
                        <td><?= htmlspecialchars($row['kategori']) ?></td>
                        <td><?= htmlspecialchars($row['tanggal_daftar']) ?></td>
                        <td>
                            <!-- Tombol Sertifikat -->
                            <a href="cetak_sertifikat.php?id_pendaftaran=<?= $row['id_pendaftaran'] ?>" class="sertifikat-button" target="_blank">
                                Cetak Sertifikat
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tidak ada pendaftaran yang tersedia saat ini.</p>
    <?php endif; ?>

    <!-- Tombol Kembali -->
    <a href="index.php" class="back-button">Kembali ke Halaman Utama</a>

    <?php $conn->close(); ?>
</body>
</html>
