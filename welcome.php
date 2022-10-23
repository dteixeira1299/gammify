<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

include 'config.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome to Gammify!</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- fontawesome -->
    <link rel="stylesheet" href="assets/fontawesome/all.min.css">
    <style>
        body {
            font: 14px sans-serif;
        }
    </style>
</head>

<body>
    <div class="text-center">
        <div style="border: 1px solid white;width:500px;margin-left:auto;margin-right:auto;margin-top:100px;padding:10px;">
            <h2><b>Welcome User</b></h2>
            <h3><b>Name:</b><br><?= $_SESSION['username'] ?></h3>
        </div>
        <a href="logout.php" class="btn btn-primary mt-3">Logout</a>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-10 col-12 border border-light border-1 p-3">
                [content]
            </div>
            <div class="col-sm-2 col-12 border border-light border-1 p-3">
                <table class="table table-primary">
                    <thead>
                        <tr>
                            <th>Online Users</th>
                        </tr>
                    </thead>
                    <tbody id="table-online-users">

                        <?php
                        $sql = "SELECT * FROM users";
                        $result = $db_connect->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><i class="fa-solid fa-circle text-success"></i> <?= $row['username']; ?></td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr >
                            <td colspan='5'>No Result found !</td>
                            </tr>";
                        }
                        mysqli_close($db_connect);
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>