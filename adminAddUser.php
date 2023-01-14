<?php
include "reusable_components/user_session.php"
?>
<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add User - Admin</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <script src="https://kit.fontawesome.com/f9f6f2f33c.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <style>
        input[type="file"] {
            display: none;
        }

        .custom-file-upload {
            border: 1px solid #ccc;
            display: inline-block;
            padding: 6px 12px;
            cursor: pointer;
        }
    </style>

</head>

<body>
    <?php include "nvgtop.php" ?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Admin Management</h1>
        </div><!-- End Page Title -->
        <div class="card p-3">
            <div class="card-header">
                Add User
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <section class="container section">
                        <?php
                        if ($_POST) {
                            $uppercase = preg_match('@[A-Z]@', $_POST['new_pass']);
                            $lowercase = preg_match('@[a-z]@', $_POST['new_pass']);
                            $number    = preg_match('@[0-9]@', $_POST['new_pass']);

                            $email = $_POST['email'];
                            $role = $_POST['role'];
                            $department = $_POST['department'];


                            // error message is empty
                            $file_upload_error_messages = "";

                            if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['role']) || empty($_POST['department']) || empty($_POST['new_pass']) || empty($_POST['con_pass'])) {
                                echo "<div class='alert alert-danger'>Please fill in all fields can not be empty!</div>";
                            } else {

                                if (strlen($_POST['new_pass']) >= 8) {
                                    if ($uppercase && $lowercase && $number) {
                                        if ($_POST['new_pass'] !== $_POST['con_pass']) {
                                            $file_upload_error_messages .= "<div>Passwords do not match! Please type again.</div>";
                                        }
                                    } else {
                                        $file_upload_error_messages .= "<div>Your password must contain at least one uppercase, one lowercase and one number!</div>";
                                    }
                                } else {
                                    $file_upload_error_messages .= "<div>Your password must contain at least 8 characters!</div>";
                                }

                                if (strlen($_POST['username']) >= 6) {
                                    if (strpos(trim($_POST['username']), ' ')) {
                                        $file_upload_error_messages .= "<div>Username should not contain whitespace!</div>";
                                    }
                                } else {
                                    $file_upload_error_messages .= "<div>Your username must contain at least 6 characters!</div>";
                                }



                                // check if form was submitted
                                if (!empty($file_upload_error_messages)) {
                                    echo "<div class='alert alert-danger'>";
                                    echo "<div>{$file_upload_error_messages}</div>";
                                    echo "</div>";
                                } else {

                                    try {
                                        // write update query
                                        // in this case, it seemed like we have so many fields to pass and
                                        // it is better to label them and not use question marks
                                        $query = "INSERT INTO users
                                    SET username=:username,email=:email, password=:password,role=:role, departmentID=:departmentid";
                                        // prepare query for excecution
                                        $stmt = $con->prepare($query);
                                        // posted values
                                        $username = htmlspecialchars(strip_tags($_POST['username']));
                                        $new_pass = $_POST['new_pass'];

                                        // bind the parameters
                                        $stmt->bindParam(':username', $username);
                                        $stmt->bindParam(':password', $new_pass);
                                        $stmt->bindParam(':email', $email);
                                        $stmt->bindParam(':role', $role);
                                        $stmt->bindParam(':departmentid', $department);
                                        // Execute the query
                                        if ($stmt->execute()) {
                                            echo "<script type=\"text/javascript\"> window.location.href='admin_user_list.php'</script>";
                                        } else {
                                            echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                                        }
                                    }
                                    // show errors
                                    catch (PDOException $exception) {
                                        die('ERROR: ' . $exception->getMessage());
                                    }
                                }
                            }
                        }


                        ?>
                        <form class="d-flex mt-5" action="<?php echo $_SERVER["PHP_SELF"];
                                                            ?>" method="POST" enctype="multipart/form-data">
                            <div class="col-9 ms-5">
                                <div class="mb-3">
                                    <label for="exampleInputUsername" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="exampleInputusername" aria-describedby="username" name='username'>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail" class="form-label">Email</label>
                                    <input type="text" class="form-control" id="exampleInputEmail" name='email'>
                                </div>
                                <div class="mb-3">
                                    <label for="new_pass" class="form-label">New Password</label>
                                    <input type="password" class="form-control" name='new_pass' id="new_pass">
                                </div>
                                <div class="mb-3">
                                    <label for="com_pass" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="con_pass" id="com_pass">
                                </div>
                                <div class="mb-3">
                                    <label for="role" class="form-label text-end m-0 pe-2">Role</label>
                                    <select class="form-select" id="role" name="role">
                                        <option value="student" selected>Student</option>
                                        <option value="helpdesk">Helpdesk</option>
                                        <option value="executive">Executive</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="department" class="form-label text-end m-0 pe-2">Department</label>
                                    <select class="form-select" id="department" name="department">
                                        <?php
                                        include 'config/database.php';

                                        $query = "SELECT * FROM department";
                                        $stmt = $con->prepare($query);
                                        $stmt->execute();

                                        $num = $stmt->rowCount();

                                        if ($num > 0) {
                                            echo "<option value=''> -- Optional --</option>";
                                            // retrieve our table contents
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row);
                                                echo "<option value='$department_ID'>$department_name</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="d-flex mt-5">
                                    <button type="submit" class="btn btn-secondary col-4">Create</button>
                                    <button type="button" class="btn btn-secondary ms-3 col-4" onclick="window.location.href = 'admin_user_list.php'">Cancel</button>
                                </div>

                            </div>
                        </form>
                    </section>
                </li>
            </ul>
        </div>
    </main>

    <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>