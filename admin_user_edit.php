<?php
ob_start();
include "reusable_components/user_session.php"
?>
<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - User Detail</title>
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
            <h1>Profile</h1>
        </div><!-- End Page Title -->
        <section class="container section">
            <?php
            include 'config/database.php';

            try {
                $current_id = isset($_GET['userid']) ? $_GET['userid'] : "";
                // prepare select query
                $query_user = "SELECT * from users WHERE userID = :id ";
                $stmt_user = $con->prepare($query_user);

                $stmt_user->bindParam(":id", $current_id);
                // execute our query
                $stmt_user->execute();
                $row_user = $stmt_user->fetch(PDO::FETCH_ASSOC);

                $username = $row_user['username'];
                $name = $row_user['name'];
                $email_ = $row_user['email'];
                $image = $row_user['image'] == NULL ? "images/profile_pic.png" : "images/" . $row_user['image'];
                $role = $row_user['role'];
                $helpdesk = $row_user['helpdesk'];
            }

            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }

            ?>
            <?php
            if ($_POST) {
                $uppercase = preg_match('@[A-Z]@', $_POST['new_pass']);
                $lowercase = preg_match('@[a-z]@', $_POST['new_pass']);
                $number    = preg_match('@[0-9]@', $_POST['new_pass']);
                $helpdesk = $_POST['helpdesk'];

                $image = !empty($_FILES["image"]["name"])
                    ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                    : "NULL"; //pathinfo($old_image, PATHINFO_BASENAME);
                $image = htmlspecialchars(strip_tags($image));

                if (empty($image) && $image == "NULL") {
                    $image = $store_image . "no_image.jpg";
                }
                // error message is empty
                $file_upload_error_messages = "";

                //new password = new_pas ..... old password =
                if (empty($_POST['username'])) {
                    echo "<div class='alert alert-danger'>Please make sure feild in </div>";
                } else {
                    if (!empty($_POST['new_pass'])) {
                        if (strlen($_POST['new_pass']) >= 8) {
                            if (($uppercase && $lowercase && $number)) {
                                if ($_POST['new_pass'] !== "") {
                                    if ($_POST['new_pass'] !== $_POST['con_pass']) {
                                        $file_upload_error_messages .= "<div>Passwords do not match, please check again your new password or confirm password!</div>";
                                    }
                                }
                            } else {
                                $file_upload_error_messages .= "<div>Your password must contain at least one uppercase, one lowercase and one number!</div>";
                            }
                        } else {
                            $file_upload_error_messages .= "<div>Your password must contain at least 8 characters!</div>";
                        }

                        if (!empty($file_upload_error_messages)) {
                            echo "<div class='alert alert-danger'>";
                            echo "<div>{$file_upload_error_messages}</div>";
                            echo "</div>";
                        }
                    }

                    if (empty($file_upload_error_messages)) {
                        if (strlen($_POST['username']) >= 6) {
                            if (strpos(trim($_POST['username']), ' ')) {
                                $file_upload_error_messages .= "<div>Username should not contain whitespace!</div>";
                            }
                        } else {
                            $file_upload_error_messages .= "<div>Your username must contain at least 6 characters!</div>";
                        }

                        if (!empty($_FILES["image"]["name"])) {
                            if ($image && $image != "NULL") {
                                // upload to file to folder
                                $target_directory = "images/";
                                $target_file = $target_directory . $image; // uploads/(image name)
                                $file_type = pathinfo($target_file, PATHINFO_EXTENSION); // find the image format like jpg, png ..
                                // make sure that file is a real image
                                $check = getimagesize($_FILES["image"]["tmp_name"]);

                                if ($check !== false) {
                                    // submitted file is an image
                                    // make sure certain file types are allowed
                                    $allowed_file_types = array("jpg", "jpeg", "png", "gif");
                                    if (!in_array($file_type, $allowed_file_types)) {
                                        $file_upload_error_messages .= "<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
                                    }
                                    // make sure file does not exist
                                    if (file_exists($target_file)) {
                                        $file_upload_error_messages .= "<div>Image already exists. Try to change file name.</div>";
                                    }
                                    // make sure submitted file is not too large, can't be larger than 1 MB
                                    if ($_FILES['image']['size'] > (1024000)) {
                                        $file_upload_error_messages .= "<div>Image must be less than 1 MB in size.</div>";
                                    }
                                    // make sure the 'uploads' folder exists
                                    // if not, create it
                                    if (!is_dir($target_directory)) {
                                        mkdir($target_directory, 0777, true);
                                    }
                                } else {
                                    $file_upload_error_messages .= "<div>Submitted file is not an image.</div>";
                                }
                                // if $file_upload_error_messages is still empty
                                if (empty($file_upload_error_messages)) {
                                    // it means there are no errors, so try to upload the file
                                    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                                        // it means photo was uploaded
                                        $file_upload_error_messages .= "<div>Unable to upload photo.</div>";
                                    }
                                }
                            }
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
                                $query = "UPDATE users
                        SET username=:username, password=:password, image=:image, helpdesk=:helpdesk WHERE userID=:id";
                                // prepare query for excecution
                                $stmt = $con->prepare($query);
                                // posted values
                                $username = htmlspecialchars(strip_tags($_POST['username']));
                                $oldpassword = " ";
                                if (!empty($_POST['new_pass'])) {
                                    $oldpassword =  str_replace(" ", "", htmlspecialchars(strip_tags($_POST['new_pass'])));
                                }

                                $flag_same_image = false;
                                if ($image == "NULL" ) {
                                    $flag_same_image = true;
                                }

                                // bind the parameters
                                $stmt->bindParam(':username', $username);
                                $stmt->bindParam(':password', $oldpassword);
                                $stmt->bindParam(':id', $id);
                                $stmt->bindParam(':image', $image);
                                $stmt->bindParam(':helpdesk', $helpdesk);
                                // Execute the query
                                if ($stmt->execute()) {
                                    // if the image not same then remove previous one and not the default one
                                    if (!$flag_same_image && !strpos($image, "profile_pic.jpg")) {
                                        unlink($image);
                                    }
                                    header("Location: admin_user_list.php");
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
            }
            ?>
            <form class="d-flex mt-5" action="<?php echo $_SERVER["PHP_SELF"] . "?userid={$current_id}";
                                                ?>" method="POST" enctype="multipart/form-data">
                <div class="col-3 text-center">
                    <img src="<?php

                                if ($image != 'NULL') {
                                    echo $image;
                                } else {
                                    echo $image_;
                                }
                                ?>" width="150px">
                    <label for="file-upload" class="btn btn-info mt-4 col-10">Custom Upload</label>
                    <input id="file-upload" type="file" name="image" />
                    <div class="m-4 text-start">
                        <label for="formGroupExampleInput" class="form-label">Role</label>
                        <input type="text" class="form-control col-10" id="formGroupExampleInput" placeholder="<?php echo $role
                                                                                                                ?>" disabled>
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="<?php echo $name ?>" disabled>
                    </div>
                </div>
                <div class="col-9 ms-5">

                    <div class="mb-3">
                        <label for="exampleInputUsername" class="form-label">Username</label>
                        <input type="text" class="form-control" id="exampleInputusername" aria-describedby="username" name='username' value="<?php echo htmlspecialchars(isset($_POST['username']) ? $_POST['username'] : $username, ENT_QUOTES);
                                                                                                                                                ?>">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail" class="form-label">Email</label>
                        <input type="text" class="form-control" id="exampleInputEmail" name='email' value="<?php echo htmlspecialchars(isset($_POST['email']) ? $_POST['email'] : $email_, ENT_QUOTES);
                                                                                                            ?>">
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
                        <label for="helpdesk" class="form-label text-end m-0 pe-2">Helpdesk</label>
                        <select class="form-select" id="helpdesk" name="helpdesk">
                            <option value="1">True</option>
                            <option value="0" selected>False</option>
                        </select>
                    </div>
                    <div class="d-flex mt-5">
                        <button type="submit" class="btn btn-secondary col-4">Update</button>
                        <button type="button" class="btn btn-secondary ms-3 col-4" onclick="window.location.href = 'dashboard.php'">Cancel</button>
                    </div>
                </div>
                </div>
            </form>
        </section>
    </main>

    <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>