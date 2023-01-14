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

        .accordion .card-link .fa-chevron-down {
            margin-right: 0;
            transition: transform 0.2s ease-in-out;
        }

        .accordion .card-link:not(.collapsed) .fa-chevron-down {
            transform: rotate(180deg);
        }


    </style>
</head>

<body>
    <?php include "nvgtop.php" ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Group List</h1>
        </div><!-- End Page Title -->
        <section class="container section">
                        <?php 
                            include 'config/database.php';

                            try {
                                $query = "SELECT * from complaint WHERE group_name IS NOT NULL GROUP BY complaint.group_name";
                                $stmt = $con->prepare($query);
                                $stmt->execute();
                                $num = $stmt->rowCount();
                                if ($num > 0) {

                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row);
                                        echo "<div class='accordion' id='accordion$complaintID'>
                                                <div class='card'>
                                                    <a class='card-header collapsed card-link d-flex align-items-center' data-bs-toggle='collapse' data-bs-target='#collapse$complaintID'>";
                                                        echo "<b class='header-title'>$group_name</b>
                                                        <div class=' ms-auto float-end'>
                                                            <i class='fa-solid fa-chevron-down me-2'></i>
                                                        </div>                                                    
                                                    </a>
                                                    <div class=' ms-auto float-end'>
                                                                    <i class='fa-regular fa-pen-to-square me-2'></i>
                                                                    <a type='button' onclick='del_group(\"$group_name\")'><i class='fa-regular fa-trash-can me-2'></i></a>             
                                                    </div>
                                                    ";

                                                    echo "<div id='collapse$complaintID' class='accordion-collapse collapse' aria-labelledby='headingOne' data-bs-parent='#accordion$complaintID'>
                                                    <div class='accordion-body p-0'>
                                                        <div class='overflow-auto'>
                                                            <table class='table table-hover table-responsive table-bordered mb-0'>
                                                                <tr>
                                                                    <th>Title</th>
                                                                    <th>Department</th>
                                                                    <th>Status</th>
                                                                    <th>Created Date</th>
                                                                    <th>Action</th>
                                                                </tr>";

                                    $query1 = "SELECT * from complaint WHERE group_name=:groupname";
                                    $stmt1 = $con->prepare($query1);
                                    $stmt1->bindParam(":groupname", $group_name);
                                    $stmt1->execute();
                                    $num1 = $stmt1->rowCount();
                                    if ($num1 > 0) {
                                        while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                                            $title=$row1['title'];
                                            $status=$row1['status'];
                                            $date=$row1['createdate'];
                                            $complaint_id=$row1['complaintID'];
                                                            echo "
                                                                <tr>
                                                                    <td>$title</td>
                                                                    <td>Executive</td>
                                                                    <td>$status</td>
                                                                    <td>$date</td>
                                                                    <td><a href='helpdesk_complain_detail.php?complaintID=$complaintID'><i class='fa-regular fa-pen-to-square'></i></a><a href='complain_detail.php?complaintID=$complaint_id'><i class='fa-solid fa-eye '></i></a></td>
                                                                </tr>";
                                        }
                                    }
                                        echo "              </table>
                                                            </div>
                                                        </div>
                                                    </div>";

                                                    
                                        echo        
                                                "</div>
                                             </div>";
                                    } 
                                }                               
                            }
                            // show error
                            catch (PDOException $exception) {
                                die('ERROR: ' . $exception->getMessage());
                            }
        
                        ?>
                        
                    

        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

    <script src="js/main.js"></script>
    <script>
        // $('.card-btn').click(function() {
        //     $(this).find('i').toggleClass('fas fa-plus fas fa-minus')
        // });

        function del_group(group_name) {
            if (confirm("Delete a group ?") == true) {
                window.location.href = "remove_group.php?groupname="+group_name; 
            }
        }
    </script>
</body>

</html>