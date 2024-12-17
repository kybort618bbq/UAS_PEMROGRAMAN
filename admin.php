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
    <title>Admin - Kelola Pendaftaran Webinar</title>
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
        button {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
        }
        .edit-button {
            background-color: #ffc107;
            color: white;
        }
        .edit-button:hover {
            background-color: #e0a800;
        }
        .delete-button {
            background-color: #dc3545;
            color: white;
        }
        .delete-button:hover {
            background-color: #c82333;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
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
    </style>
</head>
<body>

    <h1>Kelola Pendaftaran Webinar</h1>

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
                        <td class="action-buttons">
                            <!-- Tombol Edit -->
                            <a href="edit_pendaftaran.php?id_pendaftaran=<?= $row['id_pendaftaran'] ?>" class="edit-button">
                                Edit
                            </a>

                            <!-- Tombol Hapus -->
                            <a href="hapus_pendaftaran.php?id_pendaftaran=<?= $row['id_pendaftaran'] ?>" class="delete-button" onclick="return confirm('Apakah Anda yakin ingin menghapus pendaftaran ini?');">
                                Hapus
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
