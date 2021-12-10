<?php
if (isset($_POST['signup-submit'])) {
    $exitpath = 'https://'.$_SERVER['HTTP_HOST'].$_POST['return'];
    require 'dbh.inc.php';

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['mail'];
    $tel = $_POST['tel'];
    $password = $_POST['pwd'];
    $passwordRepeat = $_POST['pwd-repeat'];
    $termsChecked = ($_POST['terms'] == 'checked') ? true : false;


    // checks for empty fields
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($passwordRepeat)) {
        header("Location: $exitpath?signup=failed&error=emptyfields&firstName=$firstName&lastName=$lastName&mail=$email");
        exit();
    } 
    // checks terms and conditions
    if (!$termsChecked) {
        header("Location: $exitpath?signup=failed&error=terms");
        exit();
    } 
    //checks for invalid name and email
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $firstName) && !preg_match("/^[a-zA-Z0-9]*$/", $lastName)) {
        header("Location: $exitpath?signup=failed&error=invalidmailname");
        exit();
    }
    // checks for valid email
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: $exitpath?signup=failed&error=invalidmail&firstName=$firstName&lastName=$lastName");
        exit();
    }
    // checks for valid name
    else if (!preg_match("/^[a-zA-Z0-9]*$/", $firstName) && !preg_match("/^[a-zA-Z0-9]*$/", $lastName)) {
        header("Location: $exitpath?signup=failed&error=invalidname&mail=$email");
        exit();
    }
    // checks for valid Phone Number
    else if (!preg_match("/^[0-9]*$/", $tel)) {
        header("Location: $exitpath?signup=failed&error=invalidtel&mail=$email&firstName=$firstName&lastName=$lastName");
        exit();
    }
    // check for matching passwords
    else if ($password !== $passwordRepeat) {
        header("Location: $exitpath?signup=failed&error=passwordCheck&ufirstName=$firstName&lastName=$lastName&mail=$email");
        exit();
    } else {
        $sql = "SELECT email FROM Users WHERE email=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: $exitpath?signup=failed&error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);
            if ($resultCheck > 0) { // email already exists
                header("Location: $exitpath?signup=failed&error=mailtaken");
                exit();
            } else { //email does not already exists
                $sql = "INSERT INTO Users (first_name, last_name, email, pwd, phone_number) VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: $exitpath?signup=failed&error=sqlerror");
                    exit();
                } else {
                    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

                    mysqli_stmt_bind_param($stmt, "sssss", $firstName, $lastName, $email, $hashedPwd, $tel);
                    mysqli_stmt_execute($stmt);

                    header("Location: $exitpath?signup=success");
                    exit();
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    header("Location: ../index.php");
    exit();
}