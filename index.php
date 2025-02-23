<?php
$koneksi = mysqli_connect('localhost', 'root', '', 'twooman');

// Tambah Task
if (isset($_POST['tambah_tugas'])) {
    $tugas = mysqli_real_escape_string($koneksi, $_POST['tugas']);
    $prioritas = mysqli_real_escape_string($koneksi, $_POST['prioritas']);
    $date = mysqli_real_escape_string($koneksi, $_POST['date']);

    if (!empty($tugas) && !empty($prioritas) && !empty($date)) {
        if (mysqli_query($koneksi, "INSERT INTO task (tugas, prioritas, date, status) VALUES ('$tugas', '$prioritas', '$date', '0')")) {
            echo "<script>alert('Data Berhasil Ditambahkan');</script>";
        } else {
            echo "<script>alert('Gagal menambahkan data: " . mysqli_error($koneksi) . "');</script>";
        }
    } else {
        echo "<script>alert('Semua Kolom Harus Diisi!');</script>";
    }
}

// Menandai Task Selesai
if (isset($_GET['complete'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['complete']); // Sanitasi input
    if (mysqli_query($koneksi, "UPDATE task SET status=1 WHERE id='$id'")) {
        echo "<script>alert('Data Berhasil Diperbarui');</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data: " . mysqli_error($koneksi) . "');</script>";
    }
    header('location: index.php');
}

// Menghapus Task
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['delete']); // Sanitasi input
    if (mysqli_query($koneksi, "DELETE FROM task WHERE id='$id'")) {
        echo "<script>alert('Data Berhasil Dihapus');</script>";
    } else {
        echo "<script>alert('Gagal menghapus data: " . mysqli_error($koneksi) . "');</script>";
    }
    header('location: index.php');
}

$result = mysqli_query($koneksi, "SELECT * FROM task ORDER BY status ASC, prioritas DESC, date ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-2">
        <br>
        <form method="POST" class="border rounded bg-light p-2">
            <h2 class="text-center">Aplikasi To-Do List</h2>
            <label class="form-label">Nama Task</label>
            <input type="text" name="tugas" class="form-control" placeholder="Masukan Tugas Anda" autocomplete="off" autofocus required>
            <label class="form-label">Prioritas</label>
            <select name="prioritas" class="form-control">
                <option value="">--Pilih Prioritas--</option>
                <option value="1">tidak penting</option>
                <option value="2">penting</option>
                <option value="3">sangat penting</option>
            </select>
            <label class="form-label">Tanggal</label>
            <input type="date" name="date" class="form-control" value="<?php echo date('Y-m-d') ?>" required>
            <button type="submit" class="btn btn-primary w-100 mt-2" name="tambah_tugas">Tambah Tugas</button>
        </form>

        <hr>

        <table class="table table-stripped">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Tasks</td>
                    <td>Priority</td>
                    <td>Tanggal</td>
                    <td>Status</td>
                    <td>Aksi</td>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $row['tugas'] ?></td>
                            <td>
                                <?php
                                if ($row['prioritas'] == 1) {
                                    echo "tidak penting";
                                } elseif ($row['prioritas'] == 2) {
                                    echo "penting";
                                } else {
                                    echo "sangat penting";
                                }
                                ?>
                            </td>
                            <td><?php echo $row['date'] ?></td>
                            <td>
                                <?php
                                if ($row['status'] == 0) {
                                    echo "belum Selesai";
                                } else {
                                    echo "Selesai";
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($row['status'] == 0) { ?>
                                    <a href="?complete=<?php echo $row['id'] ?>" class="btn btn-success">Selesai</a>
                                <?php } ?>
                                <a href="?delete=<?php echo $row['id'] ?>" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                    <?php }
                } else {
                    echo "tidak ada data";
                }
                ?>
            </tbody>
        </table>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>