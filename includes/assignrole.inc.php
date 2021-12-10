<?php

//determines location for the header functions
$exitpath = 'https://datadev.devcatalyst.com/~mahs_BMDBTMBMM/employee/employees.php';

if (isset($_POST['role-submit'])) {
    
    require 'dbh.inc.php';
    $role;
    switch ($_POST['role']) {
        case 'admin':
            $role = 1;
            break;
        case 'inventory':
            $role = 2;
            break;
        case 'delivery':
            $role = 3;
            break;
    }
    $email = $_POST['employee-mail'];

    //check for valid email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: $exitpath?error=invalidmail");
        exit();
    } else {

        $sql = "SELECT primary_key, email FROM Users WHERE email=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: $exitpath?error=sqlerror");
            exit();
        } else {
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->bind_result($user_id, $user_email);

            //idk what this does or why it has to be in a while loop, but it finally fixed all my problems after multiple hours
            while ($stmt->fetch()) {
            
            }

            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);

            if ($resultCheck == 0) { // email does not already exist
                header("Location: $exitpath?error=nouser");
                exit();
            } else { //email already exists
                
                //check for employee status
                $sql = "SELECT Employees.primary_key as 'employee_id' FROM Users JOIN Employees WHERE Employees.user_id = '$user_id'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    // user account is already an employee
                    header("Location: $exitpath?error=employeeexists");
                    exit();
                } else { 
                    // user account is not yet an employee (and will now become one)
                    $sql = 'INSERT INTO Employees (user_id, role) VALUES (?, ?)';
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: $exitpath?error=sqlerror");
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "is", $user_id, $role);
                        mysqli_stmt_execute($stmt);
                        $conn->close();
                        header("Location: $exitpath?assign=success");
                        exit();
                    }
                }
            }
        }

    }

} else {
    header("Location: $exitpath");
    exit();
}