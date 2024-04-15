<?php
    function invalid_username($username) {
        if (!preg_match("/^[a-zA-Z0-9 ]+$/", $username)) {
            return true;
        }
        else {
            return false;
        }
    }

                                                                    // TODO: Possibly still the culprit
    function username_already_exists($conn, $username, $email) {    // This seems to be functioning but login is still trolling
        $sql = "SELECT * FROM users WHERE username = ? OR email = ?;";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../HTML/signupmain.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss", $username, $email);
        mysqli_stmt_execute($stmt);

        $result_data = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result_data)) {
            mysqli_stmt_close($stmt);
            return $row;
        }
        else {
            mysqli_stmt_close($stmt);
            return false;
        }
    }

    function passwords_match($password, $password_repeat) {
        if ($password !== $password_repeat) {
            return true;
        }
        else {
            return false;
        }
    }

    function invalid_email($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        else {
            return false;
        }
    }

    function create_user($conn, $username, $password, $email) {
        $sql = "INSERT INTO users (username, user_password, email) VALUES (?, ?, ?);";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../HTML/signupmain.php?error=stmtfailed");
            exit();
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($stmt, "sss", $username, $hashed_password, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

                                                                
        header("location: ../HTML/signupmain.php?error=none"); 
        exit();
    }

    // Login functions
    
    function login($conn, $username, $password) {
        $username_already_exists = username_already_exists($conn, $username, '');
        
        // If the username / email does not exist
        if ($username_already_exists === false) {   // This is not triggering
            header("location: ../HTML/login.html?error=loginfailed");
            exit();
        }

        $password_hashed = $username_already_exists["user_password"];
        $check_password = password_verify($password, $password_hashed);

                                            // TODO: Possible cause of login failure
        if ($check_password === false) {    // This is not triggering. This is probably the biggest hint
            header("location: ../HTML/login.html?error=loginfailed");
            exit();
        }   //If the password is not correct
        else if ($check_password === true) {
            session_start();
            $_SESSION["id_number"] = $username_already_exists["id_number"];
            $_SESSION["username"] = $username_already_exists["username"];
            header("location: ../HTML/index.php");
            exit();
        }
    }
