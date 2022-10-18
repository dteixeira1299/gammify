<?php

//start session on web page
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}

//Include Google Client Library for PHP autoload file
require_once 'google-api-php-client/vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

include 'google-api-key.php';

//Set the OAuth 2.0 Client ID
//$google_client->setClientId('');

//Set the OAuth 2.0 Client Secret key
//$google_client->setClientSecret('');

//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('http://localhost/gammify/redirect.php');

//
$google_client->addScope('email');

$google_client->addScope('profile');

//This $_GET["code"] variable value received after user has login into their Google Account redirct to PHP script then this variable value has been received
if (isset($_GET["code"])) {
    //It will Attempt to exchange a code for an valid authentication token.
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

    //This condition will check there is any error occur during geting authentication token. If there is no any error occur then it will execute if block of code/
    if (!isset($token['error'])) {
        //Set the access token used for requests
        $google_client->setAccessToken($token['access_token']);

        //Store "access_token" value in $_SESSION variable for future use.
        $_SESSION['access_token'] = $token['access_token'];

        //Create Object of Google Service OAuth 2 class
        $google_service = new Google_Service_Oauth2($google_client);

        //Get user profile data from google
        $data = $google_service->userinfo->get();

        //Below you can find Get profile data and store into $_SESSION variable
        if (!empty($data['given_name'])) {
            $_SESSION['user_first_name'] = $data['given_name'];
        }

        if (!empty($data['family_name'])) {
            $_SESSION['user_last_name'] = $data['family_name'];
        }

        if (!empty($data['email'])) {
            $_SESSION['user_email_address'] = $data['email'];
            $_SESSION['user_name'] = explode("@",$data['email'])[0];
        }

        if (!empty($data['gender'])) {
            $_SESSION['user_gender'] = $data['gender'];
        }

        if (!empty($data['picture'])) {
            $_SESSION['user_image'] = $data['picture'];
        }
    }
}

//This is for check user has login into system by using Google account
if (!isset($_SESSION['access_token'])) {
    //Redirect user to obtain authorization
    header("location: " . $google_client->createAuthUrl());
} else {

    








}




create_user(){
    $username = $_SESSION['user_name'];

    // Prepare an insert statement
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
    if($stmt = mysqli_prepare($db_connect, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
        
        // Set parameters
        $param_username = $username;
        $param_password = password_hash("google", PASSWORD_DEFAULT); // Creates a password hash
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){

            // The users directory path
            $dir = "users";
            
            // Check the existence of users directory
            if(!file_exists($dir)){
                // Create users directory
                mkdir($dir);
                // create user directory
                mkdir($dir . '/' . $username);
            } else{
                // If users directory exists, create user directory only
                if(!file_exists($dir . '/' . $username)){
                    mkdir($dir . '/' . $username);
                }
            }
            
            // Store data in session variables
            $_SESSION["loggedin"] = true;
            // Redirect user to welcome page
            header("location: welcome.php");
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
}

get_user(){
// Prepare a select statement
$sql = "SELECT id FROM users WHERE username = ?";
        
if($stmt = mysqli_prepare($db_connect, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "s", $param_username);
    
    // Set parameters
    $param_username = $_SESSION['user_name'];
    
    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
        /* store result */
        mysqli_stmt_store_result($stmt);
        
        if(mysqli_stmt_num_rows($stmt) == 1){
            echo "This username is already taken.";
        } else{
            $username = trim($_POST["username"]);
        }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }

    // Close statement
    mysqli_stmt_close($stmt);
}
}