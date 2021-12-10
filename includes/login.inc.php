<?php

if (isset($_POST['login-submit'])) {
    $exitpath = 'https://'.$_SERVER['HTTP_HOST'].$_POST['return'];
    require 'dbh.inc.php';

    $mail = $_POST['mail'];
    $password = $_POST['pwd'];
    //check for empty fields
    if (empty($mail) || empty($password)) {
        header('Location: '.$exitpath.'?login=failed&error=emptyfields');
        exit();
    } 
    //check database
    else {
        $sql = "SELECT Users.primary_key as 'user_id', pwd, first_name, last_name FROM Users WHERE Users.email LIKE ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header('Location: '.$exitpath.'?login=failed&error=sqlerror');
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, 's', $conn->real_escape_string($mail));
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            //is there a result?
            if ($row = mysqli_fetch_assoc($result)) {
                // check password
                $pwdCheck = password_verify($password, $row['pwd']);
                if ($pwdCheck == false) {
                    header('Location: '.$exitpath.'?login=failed&error=wrongpwd');
                    exit();
                } else if ($pwdCheck == true) {
                    //if password is correct: 
                        session_start();
                        $_SESSION['userId'] = $row['user_id'];
                        $_SESSION['userFirstName'] = $row['first_name'];
                        $_SESSION['userLastName'] = $row['last_name'];
                        
                        //set employee role
                        $sql = "SELECT Employees.role as 'role' FROM Users JOIN Employees WHERE ".$row['user_id']." = Employees.user_id";
                        $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            header('Location: '.$exitpath.'?login=failed&error=sqlerror');
                            exit();
                        } else {
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            //is there a result?
                            if ($row = mysqli_fetch_assoc($result)) {
                                $_SESSION['userRole'] = $row['role'];
                            }
                        }

                        header('Location: '.$exitpath.'?login=success');
                        exit();
                } else {
                    header('Location: '.$exitpath.'?login=failed&error=wrongpwd2');
                    exit();
                }

            } else {
                header('Location: '.$exitpath.'?login=failed&error=nouser'.mysqli_error($conn));
                exit();
            }
        }
    }
} else {
    header('Location: ../index.php');
    exit();
}