<?php
include 'koneksi.php';

$koneksi = connectDatabase();

// Ambil ID dari parameter GET
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    // Ambil data tugas berdasarkan ID
    $result = mysqli_query($koneksi, "SELECT * FROM task WHERE id='$id'");
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Data tidak ditemukan.";
        exit;
    }
} else {
    echo "ID tidak diberikan.";
    exit;
}

// Proses form edit
if (isset($_POST['update_tugas'])) {
    $tugas = mysqli_real_escape_string($koneksi, $_POST['tugas']);
    $prioritas = mysqli_real_escape_string($koneksi, $_POST['prioritas']);
    $date = mysqli_real_escape_string($koneksi, $_POST['date']);

    $query = "UPDATE task SET tugas='$tugas', prioritas='$prioritas', date='$date' WHERE id='$id'";
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-2">
        <h2>Edit Tugas</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="tugas" class="form-label">Nama Tugas</label>
                <input type="text" name="tugas" id="tugas" class="form-control" value="<?php echo $row['tugas']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="prioritas" class="form-label">Prioritas</label>
                <select name="prioritas" id="prioritas" class="form-select" required>
                    <option value="1" <?php if ($row['prioritas'] == 1) echo 'selected'; ?>>tidak penting</option>
                    <option value="2" <?php if ($row['prioritas'] == 2) echo 'selected'; ?>>penting</option>
                    <option value="3" <?php if ($row['prioritas'] == 3) echo 'selected'; ?>>sangat penting</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Tanggal</label>
                <input type="date" name="date" id="date" class="form-control" value="<?php echo $row['date']; ?>" required>
            </div>
            <button type="submit" name="update_tugas" class="btn btn-primary">Simpan Perubahan</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>