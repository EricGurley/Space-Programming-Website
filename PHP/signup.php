<?php
    if (isset($_POST["submit"])) {
        
        $username = $_POST["username"];     // uid is username
        $password = $_POST["password"];
        $email = $_POST["email"];
        $password_repeat = $_POST["password_repeat"];

        require_once 'connect_to_database.php';
        require_once 'functions.php';

        if(invalid_username($username) !== false) {
            header("location: ../HTML/signupmain.php?error=invalidusername");
            exit();
        }
        else if(username_already_exists($conn, $username, $email) !== false) {
            header("location: ../HTML/signupmain.php?error=usernamealreadyexists");
            exit();
        }
        else if(passwords_match($password, $password_repeat) !== false) {
            header("location: ../HTML/signupmain.php?error=passwordsdonotmatch");
            exit();
        }
        else if(invalid_email($email) !== false) {
            header("location: ../HTML/signupmain.php?error=invalidemail");
            exit();
        }
        else {
            $user_created = create_user($conn, $username, $password, $email);
            if ($user_created) {
                header("location: ../HTML/index.php"); // Redirect to the desired page after successful sign-up
                exit();
            } else {
                header("location: ../HTML/signupmain.php?error=stmtfailed"); // Handle potential errors during user creation
                exit();
            }
        }
    }
    else {
        header("location: ../HTML/signupmain.php");
        exit();
}