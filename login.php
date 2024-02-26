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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/login.css">
    <title>Login</title>
</head>
<body>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="" method="POST">
                <h1>Daftar Akun</h1>
                <input type="text" placeholder="NIP" name="nip" required />
                <input type="text" placeholder="Username" name="nama" required />
                <input type="password" placeholder="Password" name="password" required />
                <input type="text" placeholder="Cabang" name="cabang" required />
                <button type="submit" name="regis">Sign Up</button>
            </form>
        </div>

        <div class="form-container sign-in-container">
            <form action="" method="POST">
                <h1>Sign in</h1> 
                <?php
                    if(isset($_GET['error'])){
                        echo "<p style='color:red; font-size:.8em; margin-top:.5rem'>* Username atau password salah!</p>";
                    }
                ?>
                <input type="text" placeholder="NIP" name="nip" />
                <input type="password" placeholder="Password" name="password" />  
                <button type="submit" name="login">Sign In</button>
                <a href="index.php"><button type="button">Home</button></a>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');

        signUpButton.addEventListener('click', () => {
            container.classList.add("right-panel-active");
        });

        signInButton.addEventListener('click', () => {
            container.classList.remove("right-panel-active");
        });
    </script>
    
    <footer>
        <p>
            <a target="_blank" href="https://florin-pop.com">Florin Pop</a>
            - Read how I created this and how you can join the challenge
            <a target="_blank" href="https://www.florin-pop.com/blog/2019/03/double-slider-sign-in-up-form/">here</a>.
        </p>
    </footer>
</body>
</html>