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

// Cek apakah form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_webinar = $_POST['id_webinar'] ?? '';
    $nama = $_POST['nama'] ?? '';
    $email = $_POST['email'] ?? '';
    $telepon = $_POST['telepon'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $instansi = $_POST['instansi'] ?? '';
    $kategori = $_POST['kategori'] ?? '';
    $tanggal_daftar = date('Y-m-d'); // Tanggal pendaftaran otomatis diisi hari ini

    // Validasi input sederhana
    if (!empty($id_webinar) && !empty($nama) && !empty($email)) {
        // Masukkan data ke tabel pendaftaran
        $stmt = $conn->prepare("INSERT INTO pendaftaran (id_webinar, nama, email, telepon, alamat, instansi, kategori, tanggal_daftar) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssss", $id_webinar, $nama, $email, $telepon, $alamat, $instansi, $kategori, $tanggal_daftar);

        if ($stmt->execute()) {
            echo "<p>Pendaftaran berhasil! Terima kasih telah mendaftar.</p>";
        } else {
            echo "<p>Terjadi kesalahan: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        echo "<p> </p>";
    }
}

// Jika tidak ada ID webinar, kembali ke halaman index
if (empty($_POST['id_webinar'])) {
    header("Location: index.php");
    exit();
}

// Ambil data webinar berdasarkan ID
$id_webinar = $_POST['id_webinar'];
$sql = "SELECT tema_webinar FROM webinar WHERE id_webinar = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_webinar);
$stmt->execute();
$stmt->bind_result($tema_webinar);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Webinar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            max-width: 600px;
            margin: auto;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input, textarea, select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .readonly {
            background-color: #f4f4f4;
        }
        .back-button {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h1>Pendaftaran Webinar: <?= htmlspecialchars($tema_webinar) ?></h1>
    <form action="daftar.php" method="POST">
        <input type="hidden" name="id_webinar" value="<?= htmlspecialchars($id_webinar) ?>">

        <label for="nama">Nama Lengkap</label>
        <input type="text" name="nama" id="nama" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>

        <label for="telepon">Telepon</label>
        <input type="text" name="telepon" id="telepon">

        <label for="alamat">Alamat</label>
        <textarea name="alamat" id="alamat" rows="3"></textarea>

        <label for="instansi">Instansi</label>
        <input type="text" name="instansi" id="instansi">

        <label for="kategori">Kategori</label>
        <select name="kategori" id="kategori">
            <option value="Mahasiswa">Mahasiswa</option>
            <option value="Dosen">Dosen</option>
            <option value="Umum">Umum</option>
        </select>

        <!-- Kolom Tanggal Daftar (readonly) -->
        <label for="tanggal_daftar">Tanggal Pendaftaran</label>
        <input type="text" name="tanggal_daftar" id="tanggal_daftar" value="<?= date('Y-m-d') ?>" class="readonly" readonly>

        <button type="submit">Daftar</button>
    </form>

    <!-- Tombol Kembali ke Daftar Webinar -->
    <a href="index.php" class="back-button">Kembali ke Daftar Webinar</a>
</body>
</html>
