<?php
function connectDatabase() {
    $koneksi = mysqli_connect('localhost', 'root', '', 'twooman');
    if (!$koneksi) {
        die("Koneksi database gagal: " . mysqli_connect_error());
    }
    return $koneksi;
}
?>