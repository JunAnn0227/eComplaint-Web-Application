<?php
include "reusable_components/user_session.php"
?>

<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student - Dahboard</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <script src="https://kit.fontawesome.com/f9f6f2f33c.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        .fa-eye:hover {
            color: red;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <?php include "nvgtop.php" ?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Complaint Form</h1>
        </div><!-- End Page Title -->
        <section class="container section">
            <?php
            if ($_POST) {
                include 'config/database.php';
                $title = $_POST['title'];
                $message = $_POST['message'];

                // new 'complaint_image' field
                $complaint_image = !empty($_FILES["complaint_image"]["name"])
                    ? sha1_file($_FILES['complaint_image']['tmp_name']) . "-" . basename($_FILES["complaint_image"]["name"])
                    : "NULL";
                $complaint_image = htmlspecialchars(strip_tags($complaint_image));

                // error message is empty
                $file_upload_error_messages = "";

                if ($title == "" || $message == "") {
                    echo "<div class='alert alert-danger'>Please make sure have * column are not emplty!</div>";
                } else {

                    if (strlen($username) <= 6) {
                        $file_upload_error_messages .= "<div>Your username must contain at least 6 characters!</div>";
                    }
                    // now, if complaint_image is not empty, try to upload the complaint_image
                    if ($complaint_image && $complaint_image != "NULL") {

                        // upload to file to folder
                        $target_directory = "images/";
                        $target_file = $target_directory . $complaint_image;
                        $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

                        // make sure that file is a real complaint_image
                        $check = getimagesize($_FILES["complaint_image"]["tmp_name"]);
                        if ($check !== false) {
                            // submitted file is an complaint_image
                            // make sure certain file types are allowed
                            $allowed_file_types = array("jpg", "jpeg", "png", "gif");
                            if (!in_array($file_type, $allowed_file_types)) {
                                $file_upload_error_messages .= "<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
                            }
                            // make sure file does not exist
                            if (file_exists($target_file)) {
                                $file_upload_error_messages .= "<div>complaint_image already exists. Try to change file name.</div>";
                            }
                            // make sure submitted file is not too large, can't be larger than 1 MB
                            if ($_FILES['complaint_image']['size'] > (1024000)) {
                                $file_upload_error_messages .= "<div>complaint_image must be less than 1 MB in size.</div>";
                            }
                            // make sure the 'uploads' folder exists
                            // if not, create it
                            if (!is_dir($target_directory)) {
                                mkdir($target_directory, 0777, true);
                            }
                        } else {
                            $file_upload_error_messages .= "<div>Submitted file is not an complaint_image.</div>";
                        }
                        // if $file_upload_error_messages is still empty
                        if (empty($file_upload_error_messages)) {
                            // it means there are no errors, so try to upload the file
                            if (!move_uploaded_file($_FILES["complaint_image"]["tmp_name"], $target_file)) {
                                // it means photo was uploaded
                                $file_upload_error_messages .= "<div>Unable to upload photo.</div>";
                            }
                        }
                    }


                    if (!empty($file_upload_error_messages)) {
                        echo "<div class='alert alert-danger'>";
                        echo "<div>{$file_upload_error_messages}</div>";
                        echo "</div>";
                    } else {
                        $query_attachment = "INSERT INTO attachment SET complaintID=:complaintID,position=:position,filename=:filename,type=:type";

                        $stmt_attachment = $con->prepare($query_attachment);
                        $put_null = NULL;
                        $stmt_attachment->bindParam(':complaintID', $put_null);
                        $stmt_attachment->bindParam(':position', $target_directory);
                        $stmt_attachment->bindParam(':filename', $_FILES["complaint_image"]["name"]);
                        $stmt_attachment->bindParam(':type', $file_type);

                        
                        if ($stmt_attachment->execute()) {
                            $query_attachmentid = "SELECT MAX(attachmentID) from attachment";
                            $stmt_attachmentid = $con->prepare($query_attachmentid);
                            $stmt_attachmentid->execute();
                            $num_attachmentid = $stmt_attachmentid->rowCount();

                            if ($num_attachmentid > 0) {
                                $row_attachmentid = $stmt_attachmentid->fetch(PDO::FETCH_ASSOC);
                                $attachment_id = $row_attachmentid['MAX(attachmentID)'];
                            }
                            try {

                                // insert query
                                $query_complaint_form = "INSERT INTO complaint SET title=:title, detail=:detail,attachmentID=:attachmentID,status=:status,userID=:userID";
                                // prepare query for execution
                                $stmt_complaint_form = $con->prepare($query_complaint_form);
                                // to record whether same complaint_image

                                // bind the parameters
                                $stmt_complaint_form->bindParam(':title', $title);
                                $stmt_complaint_form->bindParam(':detail', $message);
                                $stmt_complaint_form->bindParam(':attachmentID', $attachment_id);
                                $status = "pending";
                                $stmt_complaint_form->bindParam(':status', $status);
                                $stmt_complaint_form->bindParam(':userID', $_SESSION['user_id']);
                                // Execute the query
                                if ($stmt_complaint_form->execute()) {
                                    echo "<div class='alert alert-success'>Record was saved.</div>";
                                } else {
                                    echo "<div class='alert alert-danger'>Unable to save record.</div>";
                                }
                            }
                            // show error
                            catch (PDOException $exception) {
                                die('ERROR: ' . $exception->getMessage());
                            }
                        }
                    }
                }
            }

            ?>

            <!-- title 
            detail
            status 
            userID by users
            complaint_images by attachment

            ==================
            attachment
            ===========
            complaintID by complaint table
            position???? 
            filename - complaint_imagesname .... 
            type - png... -->


            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">
                <div class="text-decoration-underline py-4">Add New:</div>
                <div class="row">
                    <div class="col-4 pb-3">Title</div>
                    <div class="col-8 pb-3">
                        <input type="text" name="title" class='form-control' value="<?php if (isset($_POST['title'])) {
                                                                                        echo $_POST['title'];
                                                                                    } else {
                                                                                        echo "";
                                                                                    } ?>">
                    </div>
                    <div class="col-4 pb-3">Message</div>
                    <div class="col-8 pb-3">
                        <textarea rows="5" cols="33" name='message' class='form-control' value="<?php if (isset($_POST['message'])) {
                                                                                                    echo $_POST['message'];
                                                                                                } else {
                                                                                                    echo "";
                                                                                                } ?>"></textarea>
                    </div>
                </div>
                <div class="border-top border-1 border-dark">
                    <div class="py-3">Attached: Photo / Video</div>
                    <input type="file" name="complaint_image" class='form-control' />
                </div>
                <div class="pt-3 text-center">
                <button type="submit" class="btn btn-secondary col-sm-4 col-12 ">Send</button>
                </div>
            </form>
        </section>
    </main>

    <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>