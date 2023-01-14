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
    <link href="css/student.css" rel="stylesheet">
</head>

<body>
    <?php include "nvgtop.php" ?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Complaint Form</h1>
            <?php
            try {
                $complaintID = isset($_GET['complaintID']) ? $_GET['complaintID'] : "";
                $query = "SELECT title,detail,status,category,createdate,notetext,filename,department.department_name from complaint 
                                left join department on complaint.departmentID=department.department_ID 
                                left join notetable on complaint.noteID=notetable.noteID
                                left join attachment on complaint.attachmentID=attachment.attachmentID
                                WHERE complaint.complaintID=:complaintID";
                $stmt = $con->prepare($query);
                $stmt->bindParam(":complaintID", $complaintID);
                $stmt->execute();
                $num = $stmt->rowCount();

                if ($num > 0) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    extract($row);
                    $title = $title;
                    $detail = $detail;
                    $status = $status;
                    $department = $department_name;
                    $date = $createdate;
                    $note = $notetext;
                    $file = $filename;
                }
            }
            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }


            if ($_POST) {
                $assign = $_POST['assign'];

                //check complaint group
                if($_POST['complaint_group'] == ""){
                    $complaint_group = NULL;
                }else{
                    $complaint_group = $_POST['complaint_group'];
                }


                //check action
                $action = $_POST['action'];

                //insert into database
                try {
                    $query_in = "UPDATE complaint SET group_name=:group_name, status=:status, departmentID=:departmentID WHERE complaintID=:complaintID";
                    $stmt_in = $con->prepare($query_in);
                    $stmt_in->bindParam(':group_name', $complaint_group);
                    $stmt_in->bindParam(':status', $action);
                    $stmt_in->bindParam(':departmentID', $assign);
                    $stmt_in->bindParam(':complaintID', $complaintID);
                    if ($stmt_in->execute()) {
                        echo "<meta http-equiv='refresh' content='0'>";
                    } else {
                        echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                    }
                }
                // show errors
                catch (PDOException $exception) {
                    die('ERROR: ' . $exception->getMessage());
                }
            }
            ?>

        </div><!-- End Page Title -->
        <section class="container section">
            <form action="<?php echo $_SERVER["PHP_SELF"] . "?complaintID=$complaintID"; ?>" method="POST">
                <div class="row d-flex align-items-center my-3">
                    <div class="col-4 py-2">Title</div>
                    <div class="col-8 py-2 border border-3 rounded"><?php echo $title?></div>
                </div>
                <div class="row d-flex align-items-center my-3">
                    <div class="col-4 py-2">Detail</div>
                    <div class="col-8 py-2 border border-3 rounded"><?php echo $detail?></div>
                </div>
                <div class="row my-3">
                    <div class="col-4 py-2">Photo/Video:</div>
                    <div class="col-8 py-2 border border-3 rounded"><img src="images/photo.png" alt="" width="100px"></div>
                </div>
                <div class="row d-flex align-items-center my-3">
                    <div class="col-4 py-2">Department</div>
                    <div class="col-8 py-2 border border-3 rounded"><?php echo $department?></div>
                </div>
                <div class="row d-flex align-items-center my-3 border-bottom border-2 pb-3">
                    <div class="col-4 py-2">Date</div>
                    <div class="col-8 py-2 border border-3 rounded"><?php echo $date?></div>
                </div>
                <div class="row d-flex align-items-center my-3">
                    <div class="col-4  py-2">Current Status:</div>
                    <div class="col-8  py-2 px-0">
                        <div class="btn <?php if ($status == "pending" || $status == "keep_in_view") {
                                            echo "btn-warning";
                                        } else if ($status == "active") {
                                            echo "btn-success";
                                        } else {
                                            echo "btn-secondary";
                                        } ?>"><?php switch ($status) {
                                                    case "pending":
                                                        echo "Pending";
                                                        break;
                                                    case "kiv":
                                                        echo "Keep in View";
                                                        break;
                                                    case "active":
                                                        echo "Active";
                                                        break;
                                                    default:
                                                        echo "Closed";
                                                } ?></div>
                    </div>
                </div>
                </div>
                <div class="row d-flex align-items-center my-3">
                    <div class="py-2 col-4">Group: </div>
                    <div class="col-8 px-0 ">
                        <input list="list_category" name="complaint_group" class="form-control border border-3 rounded">
                        <datalist id="list_category">
                            <?php
                            $query_getexact_group = "SELECT group_name FROM complaint WHERE complaintID=:complaintID";
                            $stmt_getexact_group = $con->prepare($query_getexact_group);
                            $stmt_getexact_group->bindParam(":complaintID", $complaintID);
                            $stmt_getexact_group->execute();
                            $row_getexact_group = $stmt_getexact_group->fetch(PDO::FETCH_ASSOC);
                            if ($row_getexact_group['group_name'] !== NULL) {
                                echo "<option selected value='" . $row_getexact_group['group_name'] . "'>";
                            }


                            $query_getgroup = "SELECT group_name FROM complaint";
                            $stmt_getgroup = $con->prepare($query_getgroup);
                            $stmt_getgroup->execute();
                            $num_getgroup = $stmt_getgroup->rowCount();

                            if ($num_getgroup > 0) {
                                while ($row_getgroup = $stmt_getgroup->fetch(PDO::FETCH_ASSOC)) {
                                    extract($row_getgroup);
                                    echo "<option value='$group_name'>";
                                }
                            }
                            ?>
                        </datalist>
                    </div>
                </div>
                <div class="row d-flex align-items-center my-3">
                    <div class="col-4 py-2">Notes</div>
                    <div class="col-8 py-2 border border-3 rounded">Ali</div>
                </div>
                <div class="row d-flex align-items-center my-3">
                    <div class="py-2 col-4">Action: </div>
                    <div class="col-8 px-0 d-flex align-items-center">
                        <input type="radio" name="action" value="active" id="accept" class="ms-1 mx-2" checked>
                        <label for="accept" class="me-4">Accept</label>
                        <input type="radio" name="action" value="closed" id="closed" class="ms-1 mx-2">
                        <label for="closed" class="me-4">Closed</label>
                    </div>
                </div>
                <div class="row d-flex align-items-center my-3">
                    <div class="py-2 col-4">Assign: </div>
                    <div class="col-8 px-0 d-flex align-items-center">
                        <select name="assign" id="assgin" class="form-select border border-3 rounded">
                            <?php
                            $query_getdepartment = "SELECT * FROM department";
                            $stmt_getdepartment = $con->prepare($query_getdepartment);
                            $stmt_getdepartment->execute();
                            $num_getdepartment = $stmt_getdepartment->rowCount();

                            if ($num_getdepartment > 0) {
                                while ($row_getdepartment = $stmt_getdepartment->fetch(PDO::FETCH_ASSOC)) {
                                    extract($row_getdepartment);
                                    echo "<option value='$department_ID'>$department_name</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="d-flex m-auto mt-5">
                    <button type="submit" class="btn btn-secondary col-4">Update</button>
                    <button type="button" class="btn btn-secondary ms-3 col-4" onclick="window.location.href = 'dashboard.php'">Cancel</button>
                </div>
            </form>
        </section>
    </main>

    <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>