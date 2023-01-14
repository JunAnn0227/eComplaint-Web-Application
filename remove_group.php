<?php
// include database connection
include 'config/database.php';
try {     
    $groupname=isset($_GET['groupname']) ? $_GET['groupname'] :  die('ERROR: Record ID not found.');

    
    $del_query = "UPDATE complaint SET group_name=NULL WHERE group_name=?";
    $stmt = $con->prepare($del_query);
    $stmt->bindParam(1, $groupname);
    if($stmt->execute()){
        header('Location: helpdesk_group.php');
    }
    else{
        die('Unable to delete record.');
    }    
    

}
// show error
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>