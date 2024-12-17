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
if (isset($_GET['id_pendaftaran'])) {
    $id_pendaftaran = $_GET['id_pendaftaran'];
    
    // Ambil data pendaftaran berdasarkan ID
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
} else {
    echo "ID Pendaftaran tidak tersedia!";
    exit;
}

// Proses pembaruan data pendaftaran
if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];
    $alamat = $_POST['alamat'];
    $instansi = $_POST['instansi'];
    $kategori = $_POST['kategori'];

    // Query untuk memperbarui data pendaftaran
    $sql_update = "UPDATE pendaftaran SET nama=?, email=?, telepon=?, alamat=?, instansi=?, kategori=? WHERE id_pendaftaran=?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssssssi", $nama, $email, $telepon, $alamat, $instansi, $kategori, $id_pendaftaran);
    
    if ($stmt_update->execute()) {
        echo "Pendaftaran berhasil diperbarui!";
        header("Location: admin.php");
        exit;
    } else {
        echo "Terjadi kesalahan: " . $stmt_update->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pendaftaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .form-container {
            max-width: 500px;
            margin: 0 auto;
        }
        input[type="text"], input[type="email"], input[type="tel"], textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
        }
        button:hover {
            background-color: #218838;
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

    <h1>Edit Pendaftaran Webinar</h1>
    
    <div class="form-container">
        <form action="edit_pendaftaran.php?id_pendaftaran=<?= $row['id_pendaftaran'] ?>" method="POST">
            <label for="nama">Nama:</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($row['nama']) ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" required>

            <label for="telepon">Telepon:</label>
            <input type="tel" name="telepon" value="<?= htmlspecialchars($row['telepon']) ?>" required>

            <label for="alamat">Alamat:</label>
            <textarea name="alamat" required><?= htmlspecialchars($row['alamat']) ?></textarea>

            <label for="instansi">Instansi:</label>
            <input type="text" name="instansi" value="<?= htmlspecialchars($row['instansi']) ?>" required>

            <label for="kategori">Kategori:</label>
            <input type="text" name="kategori" value="<?= htmlspecialchars($row['kategori']) ?>" required>

            <button type="submit" name="submit">Simpan Perubahan</button>
        </form>
    </div>

    <!-- Tombol Kembali ke Halaman Admin -->
    <a href="admin.php" class="back-button">Kembali ke Halaman Admin</a>

</body>
</html>

<?php $conn->close(); ?>
