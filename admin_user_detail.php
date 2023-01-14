<?php
include "reusable_components/user_session.php"
?>
<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - User Detail</title>
    <!-- Latest compiled and minified Bootstrap Css-->
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
        $current_id=isset($_GET['userid']) ? $_GET['userid'] : "";
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
            <form class="d-flex mt-5" action="<?php echo $_SERVER["PHP_SELF"]; 
                                                ?>" method="POST" enctype="multipart/form-data">
                <div class="col-3 text-center">
                    <img src="<?php  
                    
                    if ($image!='NULL') {
                        echo $image;
                    } 
                    else {
                        echo $image_;
                    }
                                ?>" width="150px">
                    <input id="file-upload" type="file" name="image" />
                    <div class="m-4 text-start">
                        <label for="formGroupExampleInput" class="form-label">Role</label>
                        <input type="text" class="form-control col-10" id="formGroupExampleInput" placeholder="<?php echo $role 
                                                                                                                ?>">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="<?php echo $name ?>" disabled>
                    </div>
                </div>
                <div class="col-9 ms-5">

                    <div class="mb-3">
                        <label for="exampleInputUsername" class="form-label">Username</label>
                        <input type="text" class="form-control" id="exampleInputusername" disabled aria-describedby="username" name='username' value="<?php echo htmlspecialchars(isset($_POST['username']) ? $_POST['username'] : $username, ENT_QUOTES);  
                                                                                                                                                ?>">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail" class="form-label">Email</label>
                        <input type="text" class="form-control" id="exampleInputEmail" disabled name='email' value="<?php echo htmlspecialchars(isset($_POST['email']) ? $_POST['email'] : $email_, ENT_QUOTES);  
                                                                                                            ?>">
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