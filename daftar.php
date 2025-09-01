<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Pendaftaran Beasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/style.css" rel="stylesheet">
    <script>
    function cekIPK() {
        let ipk = parseFloat(document.getElementById("ipk").value);
        let beasiswa = document.getElementById("jenis_beasiswa");
        let berkas = document.getElementById("file_berkas");
        let tombol = document.getElementById("btnDaftar");

        if (isNaN(ipk)) {
            beasiswa.disabled = true;
            berkas.disabled = true;
            tombol.disabled = true;
            document.getElementById("info").innerHTML = "";
            return;
        }

        if (ipk < 3) {
            beasiswa.disabled = true;
            berkas.disabled = true;
            tombol.disabled = true;
            document.getElementById("info").innerHTML = "<div class='alert alert-danger'>IPK Anda " + ipk + " (kurang dari 3.0), tidak memenuhi syarat!</div>";
        } else {
            beasiswa.disabled = false;
            berkas.disabled = false;
            tombol.disabled = false;
            document.getElementById("jenis_beasiswa").focus();
            document.getElementById("info").innerHTML = "<div class='alert alert-success'>IPK Anda " + ipk + " (memenuhi syarat), silakan pilih beasiswa.</div>";
        }
    }
    </script>
</head>
<body class="container mt-4">

   
    <ul class="nav nav-pills justify-content-center mb-3">
        <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
        <li class="nav-item"><a href="daftar.php" class="nav-link active">Daftar Beasiswa</a></li>
        <li class="nav-item"><a href="hasil.php" class="nav-link">Lihat Hasil</a></li>
    </ul>

 
    <h2 class="text-center mb-4">Form Pendaftaran Beasiswa</h2>
    <hr>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama     = $_POST['nama'];
        $email    = $_POST['email'];
        $no_hp    = $_POST['no_hp'];
        $semester = $_POST['semester'];
        $ipk      = $_POST['ipk'];
        $jenis_beasiswa = $_POST['jenis_beasiswa'];

        $file_name = $_FILES['file_berkas']['name'];
        $file_tmp  = $_FILES['file_berkas']['tmp_name'];
        if ($file_name != "") {
            if (!is_dir("upload")) {
                mkdir("upload", 0777, true);
            }
            move_uploaded_file($file_tmp, "upload/" . $file_name);
        }

        $sql = "INSERT INTO pendaftaran (nama,email,no_hp,semester,ipk,jenis_beasiswa,file_berkas,status_ajuan) 
                VALUES ('$nama','$email','$no_hp','$semester','$ipk','$jenis_beasiswa','$file_name','Belum diverifikasi')";
        if (mysqli_query($conn, $sql)) {
            echo "<div class='alert alert-success'>Pendaftaran berhasil!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
        }
    }
    ?>

  
    <div class="card shadow p-3" style="max-width: 700px; margin:auto; font-size: 0.9rem;">
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>No HP</label>
                <input type="number" name="no_hp" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Semester</label>
                <select name="semester" class="form-control" required>
                    <?php for ($i=1; $i<=8; $i++) echo "<option>$i</option>"; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>IPK</label>
                <input type="number" step="0.01" min="0" max="4" name="ipk" id="ipk" class="form-control" oninput="cekIPK()" required>
            </div>

            <div id="info"></div>

            <div class="mb-3">
                <label>Jenis Beasiswa</label>
                <select name="jenis_beasiswa" id="jenis_beasiswa" class="form-control" disabled>
                    <option value="Akademik">Akademik</option>
                    <option value="Non Akademik">Non Akademik</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Upload Berkas</label>
                <input type="file" name="file_berkas" id="file_berkas" class="form-control" disabled>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" id="btnDaftar" class="btn btn-primary" disabled>Daftar</button>
                <a href="index.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>

</body>
</html>
