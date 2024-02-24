
<?php
include('function/connect.php');

function sanitize($data) {
    global $connection;
    return mysqli_real_escape_string($connection, trim($data));
  }
// Login

function performLogin($nip, $password) {
    global $connection;

    // Gunakan prepared statements untuk mencegah SQL injection
    $stmt = $connection->prepare("SELECT * FROM user WHERE nip = ?");
    $stmt->bind_param("s", $nip);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verifikasi password menggunakan password_verify
        if (password_verify($password, $row['password'])) {
            session_start();
            $_SESSION['login'] = $row['nip'];
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['cabang'] = $row['cabang'];
            $_SESSION['id_user'] = $row['id_user'];

            if ($row['level'] == 'admin') {
                header('Location: admin');
                exit();
            } else if ($row['level'] == 'user') {
                header('Location: user/halaman_user.php');
                exit();
            } else if ($row['level'] == 'adminpme') {
                header('Location: adminpme');
                exit();
            }
        }
    }

    // Jika login gagal, arahkan kembali ke halaman login
    header('Location: login.php?error');
    exit();
}

// Handle form submission untuk login
if (isset($_POST['login'])) {
    $nip = sanitize($_POST['nip']);
    $password = sanitize($_POST['password']);

    // Panggil fungsi performLogin
    performLogin($nip, $password);
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
    <title>Login</title>
    <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="style/main.css">
</head>

<body>
    <div class="wrapper">
        <div class="filter">
        <div class="box-login">
                <div class="login-title">
                    <h1 style=" color: #4f4f4f; ">Divisi PLT</h1>
                    <h3>Login</h3>
                    <p style="color: #ef8521">Peralatan Teknik Tirtanadi</p>
                </div>
                <form method="post" class="input-login">
                <label for="username">NIP</label>
                    <input type="text" name="nip" id="nip" required class="input-field" placeholder="masukkan NIP">
                    <label for="password">Password</label>
                    <input type ="password" name="password" id="password" required class="input-field" placeholder="password">
                    <input type="checkbox" onclick="myFunction()" title="Show password here">
                    <i class="fa-solid fa-eye"></i>
                    <script>
                        function myFunction(){
                            var x = document.getElementById("password");
                            if(x.type === "password"){
                                x.type = "text";
                            }
                            else{
                                x.type = "password";
                            }
                        }
                    </script>
                    <?php
                            if(isset($_GET['error'])){
                        echo "<p style='color:red; font-size:.8em; margin-top:.5rem'>* Username atau password salah!</p>";
                    }
                    ?>
                    <div class="btn-click">
                        <button type="submit"  class="btn subt" name="login"><i class="fa-solid fa-right-to-bracket"></i>    Login</button>
                        <a href="regist.php" class="btn back"><i class="fa-solid fa-address-card"></i>   Regist</a>
                        <a href="index.php" class="btn back"><i class="fa-solid fa-home"></i>   Home</a>
                    </div>          
                </form>
            </div>
        </div>
        </div>


</body>
</html>

