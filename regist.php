<?php
include('function/connect.php');

function sanitize($data)
{
    global $connection;
    return mysqli_real_escape_string($connection, trim($data));
}

// Registrasi
if (isset($_POST['regis'])) {
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Gunakan password_hash
    $cabang = $_POST['cabang'];
    $level = 'user';

    // Gunakan prepared statements untuk mencegah SQL injection
    $stmt = $connection->prepare("INSERT INTO user (nama, nip, password, cabang, level) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nama, $nip, $password, $cabang, $level);
    $result = $stmt->execute();

    if ($result) {
        echo "<script>alert('Berhasil Sign Up');document.location.href='login.php';</script>";
        exit();
    } else {
        echo "Error: " . $stmt->error;
        exit();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>REGISTRASI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <link rel="stylesheet" type="text/css" href="style/main.css">
</head>

<body>
    <div class="wrapper">
        <div class="filter">
            <div class="box-login">
                <div class="login-title">
                    <h3>Registrasi</h3>

                </div>
                <form method="post" class="input-login">
                    <label for="nip">NIP</label>
                    <input type="text" name="nip" id="nip" required class="input-field"
                        value="<?php echo isset($_POST['nip']) ? sanitize($_POST['nip']) : ''; ?>">

                    <label for="fullname">Nama</label>
                    <input type="text" name="nama" id="nama" required class="input-field"
                        value="<?php echo isset($_POST['nama']) ? sanitize($_POST['nama']) : ''; ?>">

                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required class="input-field">

                    <input type="hidden" name="level" id="level" value="user">

                    <label for="cabang">Cabang</label>
                    <select name="cabang" id="cabang" required class="input-field">
                        <option value="" disabled selected>Pilih Cabang</option>
                        <?php
                        // Menampilkan daftar cabang dalam dropdown
                        $resultCabang = mysqli_query($connection, "SELECT * FROM cabang");
                            while ($rowCabang = mysqli_fetch_assoc($resultCabang)) {
                                echo "<option value='" . $rowCabang['cabang'] . "'>" . $rowCabang['cabang'] . "</option>";
                            }
                        ?>
                    </select>
                   
                    <div class="btn-click">
                        <button type="submit" class="btn subt" name="regis"> <i class="fa-solid fa-address-card"></i>
                            Register</button>
                        <a href="login.php" class="btn back"><i class="fa-solid fa-backward-step"></i> Kembali</a>
                    </div>
                </form>

            </div>
        </div>
    </div>

</body>

</html>