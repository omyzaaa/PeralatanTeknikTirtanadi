<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['level'] !== 'Staff') {
    header('Location: ../login.php');
    exit();
}

include '../shared/koneksi.php';


$username = $_SESSION['username'];
$query = "SELECT * FROM User WHERE UserName = '$username'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Error: User not found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../shared/style.css">
    <title>Dashboard</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
        <?php include '../asset/sidebar.php' ?>
            <main class="main-content col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Welcome, <?= $user['UserName']; ?>!</h2>
                    </div>
                    <div class="card-body">
                        <p>This is your dashboard content.</p>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>

  