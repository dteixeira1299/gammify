<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: welcome.php");
    exit;
}

// Include config file
require_once "../config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, username, avatar, bg, password FROM users WHERE username = ? AND deleted_at IS NULL";

        if ($stmt = mysqli_prepare($db_connect, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $avatar, $bg, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["avatar"] = $avatar;
                            $_SESSION["bg"] = $bg;

                            // The users directory path
                            $dir = "../users";

                            if (!file_exists($dir)) {
                                // Create users directory
                                mkdir($dir);
                            }

                            if (!file_exists($dir . '/' . $username)) {
                                // create user directory
                                mkdir($dir . '/' . $username);
                            }

                            if (!file_exists($dir . '/' . $username . '/avatar')) {
                                // create avatar user directory
                                mkdir($dir . '/' . $username . '/avatar');
                            }

                            if (!file_exists($dir . '/' . $username . '/bg')) {
                                // create bg user directory
                                mkdir($dir . '/' . $username . '/bg');
                            }

                            // Redirect user to welcome page
                            header("location: welcome.php");

                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else {
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($db_connect);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gammify: Login</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- fontawesome -->
    <link rel="stylesheet" href="assets/fontawesome/all.min.css">
    <style>
        body {
            font: 14px sans-serif;
        }

        .wrapper {
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
            margin-top: 100px;
            padding: 20px;
            border: 1px solid white;
        }

        .btn-login-google {
            position: relative;
        }

        .btn-login-google .fa-brands {
            position: absolute;
            line-height: 24px;
            top: 50%;
            margin-top: -12px;
            left: 10px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <h2>Welcome to Gammify!</h2>
        <p>Please fill in your credentials to login.</p>

        <?php
        if (!empty($login_err)) {
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="mb-3">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
            <div class="mb-3">
                <a class="btn btn-secondary w-100 text-uppercase btn-login-google" href="redirect.php"><i class="fa-brands fa-google"></i> Login with Google</a>
            </div>
        </form>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>