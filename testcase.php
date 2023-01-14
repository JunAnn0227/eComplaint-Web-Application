<?php
include "reusable_components/user_session.php"
?>
<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student - Dashboard</title>
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
            <h1>Test case</h1>
        </div><!-- End Page Title -->

        <section class="container section">

            <div class="d-flex justify-content-evenly align-items-between pb-md-0 pb-3 row">       
        
            <div class="overflow-auto">
                <table class='table table-hover table-responsive table-bordered'>
                    <tr class="text-center">
                        <th>Test Scenario</th>
                        <th>P/N</th>
                        <th>Pages</th>
                        <th>Live Demo</th>
                    </tr>
                    <tr>
                        <td>Test Scenario</td>
                        <td>P/N</td>
                        <td>Pages</td>
                        <td>Live Demo</td>
                    </tr>
                    
                    
                </table>
            </div>
        </section>
        
        </main>

        <script src="js/main.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>