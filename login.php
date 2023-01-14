<?php
    ob_start();
    session_start();
    if (isset($_SESSION['logged_in'])) {
        header("location: dashboard.php");
    }
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="css/student.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="container background_color1">
<?php
    $message="";
    if ($_POST) {
        $message="";
        $username_ = isset($_POST['username_']) ? $_POST['username_'] : NULL;
        $password_ = isset($_POST['password_']) ? $_POST['password_'] : NULL;
        if ($username_ != NULL && $password_ != NULL) {
            include 'config/database.php';

            try {
                $query = "SELECT * from users WHERE username = :username_";
                $stmt = $con->prepare($query);
                $stmt->bindParam(":username_", $username_);
                $stmt->execute();
                $num = $stmt->rowCount();

                if ($num > 0) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($password_== $row['password']) {
                        $_SESSION['logged_in']=true;
                        $_SESSION['user_id']=$row['userID'];

                        header("location: dashboard.php");
                    }  
                    else {
                        $message.="<div class='alert alert-danger' role='alert'>Incorrect password!</div>";
                    }
                } else {
                    $message.="<div class='alert alert-danger' role='alert'>User not found! (Invalid account)</div>";
                }
            }

            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        } else {
            $message.="<div class='alert alert-danger' role='alert'>Account username and password cannot be empty!</div>";
        }
    }
    if ($message!="") {
        echo "<div class='mt-3'>$message</div>";
    }
?>
    <div class="background_color1 mt-5 mb-5 pb-4">
        <div class="text-center pt-5">
            <h1>Online Complaint Portal</h1>
            <p>Did somethings bother you ? <a href="">let us know</a></p>
        </div>
        <div class="m-5 bg-light rounded">
            <h3 class="p-3 text-center">Please login to continue.</h3>

            <div class="d-flex m-3">
                <div class="col-lg-9 d-lg-block col-12">
                    <form class="p-5" method="POST">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Username</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name='username_'>
                            <div id="emailHelp" class="form-text">Your username must be same as your ID.</div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" name='password_'>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="align-item-center col-3 d-lg-block d-none">
                    <img src="images/login_page_pic.png" width="250px">
                </div>
            </div>
        </div>
    </div>

</body>

</html>