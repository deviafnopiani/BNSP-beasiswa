<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Pendaftaran Beasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/style.css" rel="stylesheet">
</head>

<body class="container mt-4">

    <!-- Navigasi -->
    <ul class="nav nav-pills justify-content-center mb-3">
        <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
        <li class="nav-item"><a href="daftar.php" class="nav-link">Daftar Beasiswa</a></li>
        <li class="nav-item"><a href="hasil.php" class="nav-link active">Lihat Hasil</a></li>
    </ul>

    <!-- Judul -->
    <h2 class="text-center mb-4">Hasil Pendaftaran Beasiswa</h2>
    <hr>

    <!-- Tabel Hasil -->
    <div class="card shadow">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle mb-0">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>Semester</th>
                        <th>IPK</th>
                        <th>Jenis Beasiswa</th>
                        <th>Berkas</th>
                        <th>Status Ajuan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM pendaftaran ORDER BY id_pendaftaran DESC");
                    $no = 1;
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td class='text-center'>".$no++."</td>
                                    <td>".$row['nama']."</td>
                                    <td>".$row['email']."</td>
                                    <td>".$row['no_hp']."</td>
                                    <td class='text-center'>".$row['semester']."</td>
                                    <td class='text-center'>".$row['ipk']."</td>
                                    <td>".$row['jenis_beasiswa']."</td>
                                    <td class='text-center'>";
                                        if ($row['file_berkas'] != "") {
                                            echo "<a href='upload/".$row['file_berkas']."' target='_blank' class='btn btn-sm btn-outline-primary'>Lihat</a>";
                                        } else {
                                            echo "-";
                                        }
                            echo    "</td>
                                    <td class='text-center'>
                                        <span class='badge bg-secondary'>".$row['status_ajuan']."</span>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9' class='text-center'>Belum ada pendaftar</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tombol Kembali -->
    <div class="text-center mt-3">
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </div>

</body>
</html>
