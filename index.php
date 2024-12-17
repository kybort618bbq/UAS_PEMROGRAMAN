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

// Ambil data dari tabel webinar
$sql = "SELECT id_webinar, tema_webinar, deskripsi, tanggal, jam FROM webinar ORDER BY tanggal, jam";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webinar Tersedia</title>
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
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .role-button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            margin-top: 20px;
            text-decoration: none;
        }
        .role-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Daftar Webinar</h1>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID Webinar</th>
                    <th>Tema Webinar</th>
                    <th>Deskripsi</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id_webinar']) ?></td>
                        <td><?= htmlspecialchars($row['tema_webinar']) ?></td>
                        <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                        <td><?= htmlspecialchars($row['tanggal']) ?></td>
                        <td><?= htmlspecialchars($row['jam']) ?></td>
                        <td>
                            <form action="daftar.php" method="POST">
                                <input type="hidden" name="id_webinar" value="<?= $row['id_webinar'] ?>">
                                <button type="submit">Daftar</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tidak ada webinar yang tersedia saat ini.</p>
    <?php endif; ?>

    <!-- Tombol Admin dan Pimpinan -->
    <div>
        <a href="admin.php" class="role-button">Admin</a>
        <a href="pimpinan.php" class="role-button">Pimpinan</a>
    </div>

    <?php $conn->close(); ?>
</body>
</html>
