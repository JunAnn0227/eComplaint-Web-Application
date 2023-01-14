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

        .box {
            width: 200px;
        }
    </style>
</head>

<body>
    <?php include "nvgtop.php" ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Sent Form</h1>
        </div><!-- End Page Title -->
        <section class="container section">
            <div class="d-flex py-4 justify-content-center align-items-center text-center px-sm-5 px-0">
                <label for="list_complain" class="form-label text-end m-0 pe-2">Sent:</label>
                    <select class="form-select" id="list_complain" name="list_complain" onchange="filter(this)">
                        <option value="all">All</option>
                        <option value="pending">Pending</option>
                        <option value="keep_in_view">Keep in View</option>
                        <option value="active">Active</option>
                        <option value="closed">Closed</option>
                    </select>
            </div>

            <div class="overflow-auto">
                <table class='table table-hover table-responsive table-bordered'>
                    <tr>
                        <th>Title</th></a>
                        <th>Executive</th>
                        <th>Status</th>
                        <th>Last Updated</th>
                        <th>Action</th>
                    </tr>
                    <?php 
                        if ($role=='student') {
                            include 'config/database.php';

                            try {
                                $query = "SELECT * from complaint WHERE userID = :userID";
                                $stmt = $con->prepare($query);
                                $stmt->bindParam(":userID", $_SESSION['user_id']);
                                $stmt->execute();
                                $num = $stmt->rowCount();

                                if ($num > 0) {
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row);
                                        echo "<tr class='complain'>
                                                <td>$title</td>
                                                <td>$departmentID</td>
                                                <td class='status'>$status</td>
                                                <td>$modifydate</td>
                                                <td><a href='complain_detail.php?complaintID=$complaintID'><i class='fa-solid fa-eye'></i></a></td>
                                            </tr>";
                                    }
                                }
                                
                            }
                            // show error
                            catch (PDOException $exception) {
                                die('ERROR: ' . $exception->getMessage());
                            }
                            
                        }
                        if ($role=='helpdesk' || $role=='admin' || $helpdesk==true) {
                            include 'config/database.php';

                            try {
                                $query = "SELECT * from complaint";
                                $stmt = $con->prepare($query);
                                $stmt->execute();
                                $num = $stmt->rowCount();

                                if ($num > 0) {
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row);
                                        echo "<tr class='complain'>
                                                <td>$title</td>
                                                <td>$departmentID</td>
                                                <td class='status'>$status</td>
                                                <td>$modifydate</td>
                                                <td><a href='complain_detail.php?complaintID=$complaintID'><i class='fa-solid fa-eye'></i></a></td>
                                            </tr>";
                                    }
                                }
                                
                            }
                            // show error
                            catch (PDOException $exception) {
                                die('ERROR: ' . $exception->getMessage());
                            }
                        }
                    
                    ?>
                </table>
            </div>
        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

    <script src="js/main.js"></script>
    <script>
        function filter(fil_ter) {
            var complain_length=document.getElementsByClassName("complain").length;
            
            if (fil_ter.value=='pending') {
                for (var i=0 ; i<complain_length ; i++) {
                    if (!(document.getElementsByClassName("status")[i].innerHTML=="pending")) {
                        document.getElementsByClassName("complain")[i].style.display = "none";
                    }
                    else {
                        document.getElementsByClassName("complain")[i].style.display = "";
                    }
                }
            }
            if (fil_ter.value=='keep_in_view') {
                for (var i=0 ; i<complain_length ; i++) {
                    if (!(document.getElementsByClassName("status")[i].innerHTML=="kiv")) {
                        document.getElementsByClassName("complain")[i].style.display = "none";
                    }
                    else {
                        document.getElementsByClassName("complain")[i].style.display = "";
                    }
                }
            }
            if (fil_ter.value=='active') {
                for (var i=0 ; i<complain_length ; i++) {
                    if (!(document.getElementsByClassName("status")[i].innerHTML=="active")) {
                        document.getElementsByClassName("complain")[i].style.display = "none";
                    }
                    else {
                        document.getElementsByClassName("complain")[i].style.display = "";
                    }
                }
            }
            if (fil_ter.value=='closed') {
                for (var i=0 ; i<complain_length ; i++) {
                    if (!(document.getElementsByClassName("status")[i].innerHTML=="closed")) {
                        document.getElementsByClassName("complain")[i].style.display = "none";
                    }
                    else {
                        document.getElementsByClassName("complain")[i].style.display = "";
                    }
                }
            }
            if (fil_ter.value=='all') {
                for (var i=0 ; i<complain_length ; i++) {
                    document.getElementsByClassName("complain")[i].style.display = "";
                }
            }
            


        }

    </script>
</body>

</html>