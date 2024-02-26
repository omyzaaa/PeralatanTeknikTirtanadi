<?php
session_start();

include 'shared/koneksi.php';
    
function performLogin($username, $password)
{
    global $conn;

    $query = "SELECT * FROM user WHERE UserName = '$username' AND Password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $row['UserName'];
        $_SESSION['level'] = $row['Level']; // Tambahkan level ke sesi
        redirectToDashboard($row['Level']);
    } else {
        return 'Login failed. Please check your username and password.';
    }
}

function redirectToDashboard($level)
{
    if ($level === 'Admin') {
        header('Location: admin/dashboard.php');
    } elseif ($level === 'Staff') {
        header('Location: staff/dashboard.php');
    } else {
        header('Location: index.php'); // Sesuai kebutuhan jika level tidak ada atau ingin redirect ke halaman lain
    }
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $loginResult = performLogin($username, $password);

    if ($loginResult !== true) {
        $error_message = $loginResult;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-4">
                <form action="" method="post" class="login-form">
                    <h2 class="text-center mb-4">Login</h2>
                    <?php if (isset($error_message)) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $error_message; ?>
                        </div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
