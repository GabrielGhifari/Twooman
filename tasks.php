<?php
function tambahTugas($koneksi, $tugas, $prioritas, $date) {
    $tugas = mysqli_real_escape_string($koneksi, $tugas);
    $prioritas = mysqli_real_escape_string($koneksi, $prioritas);
    $date = mysqli_real_escape_string($koneksi, $date);

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
?>

<?php
function tandaiTugasSelesai($koneksi, $id) {
    $id = mysqli_real_escape_string($koneksi, $id);
    if (mysqli_query($koneksi, "UPDATE task SET status=1 WHERE id='$id'")) {
        echo "<script>alert('Data Berhasil Diperbarui');</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data: " . mysqli_error($koneksi) . "');</script>";
    }
    header('location: index.php');
}
?>

<?php
function hapusTugas($koneksi, $id) {
    $id = mysqli_real_escape_string($koneksi, $id);
    if (mysqli_query($koneksi, "DELETE FROM task WHERE id='$id'")) {
        echo "<script>alert('Data Berhasil Dihapus');</script>";
    } else {
        echo "<script>alert('Gagal menghapus data: " . mysqli_error($koneksi) . "');</script>";
    }
    header('location: index.php');
}
?>
<?php
function ambilDataTugas($koneksi) {
    return mysqli_query($koneksi, "SELECT * FROM task ORDER BY status ASC, prioritas DESC, date ASC");
}
?>