<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome to Gammify!</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        body {
            font: 14px sans-serif;
        }
    </style>
</head>

<body>
    <div class="text-center">
        <?php if (isset($_SESSION['access_token'])) : ?>
            <div style="border: 1px solid white;width:500px;margin-left:auto;margin-right:auto;margin-top:100px; padding:10px;">
            <h2><b>Welcome User</b></h2>
            <img src="<?= $_SESSION["user_image"] ?>" class="img-responsive img-circle img-thumbnail" />
            <h3><b>Name:</b><br><?= $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name'] ?></h3>
            <h3><b>Email:</b><br><?= $_SESSION['user_email_address'] ?></h3>
            </div>
        <?php else : ?>
            <div style="border: 1px solid white;width:500px;margin-left:auto;margin-right:auto;margin-top:100px;padding:10px;">
            <h2><b>Welcome User</b></h2>
            <h3><b>Name:</b><br><?= $_SESSION['username'] ?></h3>
            </div>
        <?php endif; ?>
        <a href="logout.php" class="btn btn-primary mt-3">Logout</a>
    </div>



    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>