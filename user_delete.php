<?php
// include database connection
include 'config/database.php';
try {     
    $userid=isset($_GET['userid']) ? $_GET['userid'] :  die('ERROR: Record ID not found.');

    
    $del_query = "DELETE FROM users WHERE userID=?";
    $stmt = $con->prepare($del_query);
    $stmt->bindParam(1, $userid);
    if($stmt->execute()){
        header('Location: admin_user_list.php');
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