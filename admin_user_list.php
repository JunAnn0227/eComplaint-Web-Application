<?php
include "reusable_components/user_session.php"
?>
<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - User List</title>
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
            <h1>User List</h1>
        </div><!-- End Page Title -->

        <section class="container section">
        <?php
                    include 'config/database.php';

                    $query = "SELECT * FROM users";
                    $stmt = $con->prepare($query);
                    $stmt->execute();

                    $num = $stmt->rowCount();

                    if ($num > 0) {

                        echo "<div class='overflow-auto'>";
                        echo "<table class='table table-hover table-responsive table-bordered text-center align-middle'>";

                        //creating our table heading
                        echo "<tr>";
                        echo "<th>User ID</th>";
                        echo "<th>Username</th>";
                        echo "<th>Email</th>";
                        echo "<th>Role</th>";
                        echo "<th>Action</th>";
                        echo "</tr>";

                        // retrieve our table contents
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);

                            echo "<td>{$userID}</td>";
                            echo "<td>{$username}</td>";
                            echo "<td>{$email}</td>";
                            echo "<td>{$role}</td>";
                            echo "<td>";
                            // read one record
                            echo "<a href='admin_user_detail.php?userid={$userID}' class='btn btn-info m-r-1em m-3'>View Detail</a>";
                            
                            echo "<a href='admin_user_edit.php?userid={$userID}' class='btn btn-primary m-r-1em m-3'>Edit</a>";

                            // we will use this links on next part of this post
                            echo "<a href='user_delete.php?userid={$userID}'  class='btn btn-danger m-3'>Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }


                        // end table
                        echo "</table>";
                        echo "</div>";
                    } else {
                        echo "<div class='alert alert-danger'>No records found.</div>";
                    }
                ?>
        </section>
        
        </main>

        <script src="js/main.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>