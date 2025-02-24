<?php
include 'koneksi.php';
include 'tasks.php';

$koneksi = connectDatabase();
  
// Tambah Task
if (isset($_POST['tambah_tugas'])) {
    tambahTugas($koneksi, $_POST['tugas'], $_POST['prioritas'], $_POST['date']);
}

// Menandai Task Selesai
if (isset($_GET['complete'])) {
    tandaiTugasSelesai($koneksi, $_GET['complete']);
}

// Menghapus Task
if (isset($_GET['delete'])) {
    hapusTugas($koneksi, $_GET['delete']);
}

$result = ambilDataTugas($koneksi);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
<body>
<div class="container mt-2">
    <br>
    <form method="POST" class="border rounded bg-light p-2">
        <h2 class="text-center">To-Do List</h2>
        <label class="form-label">Nama Tugas</label>
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

    </div>
        <hr>

<table class="table table-stripped">
    <thead>
        <tr align="center">
            <th>No</th>
            <th>Tugas</th>
            <th>Prioritas</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr align="center">
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
                        <a href="formedit.php?id=<?php echo $row['id'] ?>" class="btn btn-warning">edit</a>
                        <a href="?delete=<?php echo $row['id'] ?>" class="btn btn-danger">Hapus</a>
                    </td>
                </tr>
            <?php }
        } else { ?>
            <tr>
                <td colspan="6" class="text-center">Tidak ada data tugas.</td>
            </tr>
        <?php } ?>
    </tbody>
</table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>