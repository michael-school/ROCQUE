<!-- 
    -This page will list all employees by category and have a form to designate new employees.
    -To designate employee email addresses, it will have inputs for email and a drop-down to select a role.
    -If a general user account does not already exist with the inputed email address, an error message will appear.
    -If the account is already registered as an employee, an error message will appear.
    -Accessible only to admin (role 1)
-->

<?php 
    //check login status
    /*i had to reorder this part only on the employees.php page, becuase it kept giving an error with the header function that did not appear on the other employee pages.
       Therefore, I can't use the $role or $path variables*/
    session_start();
    if (!isset($_SESSION['userRole']) || $_SESSION['userRole'] != 1) {
        header("Location: https://datadev.devcatalyst.com/~mahs_BMDBTMBMM?login=failed");
        exit();
    }
?>

<?php 
    $title = "Employees";
    require "../header.php";
?>



<main>
    <section>
        <h1>Assign Role</h1>

        <?php //signup error messages
            if (isset($_GET['error'])) {
                switch ($_GET['error']) {
                    case 'invalidmail':
                        echo '<p class="error">invalid email</p>';
                        break;
                    case 'nouser':
                        echo '<p class="error">No user exists with this email</p>';
                        break;
                    case 'employeeexists':
                        echo '<p class="error">This user is already an employee</p>
                              <p class="notice">To change a user\'s role, talk to your database admin.</p>';
                        break;
                }
            } else if (isset($_GET['signup']) && $_GET['signup'] == 'success') {
                echo '<p class="success">Success</p>';
            }
        ?>
    <div class="center-align">
        <form action="<?php echo $path?>/includes/assignrole.inc.php" method="post"> 
            <label for="selectrole">Assign role</label>
            <select name="role" id="selectrole">
                
                <option value="admin">Administrator</option>
                <option value="inventory">Inventory Manager</option>
                <option value="delivery">Delivery Person</option>
            </select>

            <label for="employee_mail">to employee account:</label>
            <input type="email" id="employee_mail" name="employee-mail" placeholder="Email address">
            <button type="submit" name="role-submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    </section>
    <section>
        <h1>Employee List</h1>
        <div class="table-responsive">
        <table class="table table-striped">
            <tr> <!-- table headers -->
                <th>First Name</th>
                <th>Last Name</th>
                <th>Role</th>
            </tr>
            
            <?php //table body based off of database
                require '../includes/dbh.inc.php';
                $sql = "SELECT Users.first_name as 'first_name', Users.last_name as 'last_name', Roles.NAME as 'role' FROM Users JOIN Employees JOIN Roles WHERE Employees.user_id = Users.primary_key and Employees.role = Roles.primary_key";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr><td>". ucfirst($row["first_name"]). "</td><td>" . ucfirst($row["last_name"]) . "</td><td>". ucfirst($row["role"])."</td></tr>";
                    }
                    echo "</table>";
                } else { echo "0 results"; }
                $conn->close();
                
            ?>
        </table>
        </div>
    </section>
</main>

<?php require "../footer.php";?>
