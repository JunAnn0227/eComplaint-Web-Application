<?php
    session_start();
    session_unset();
    if (session_unset() && session_destroy()) {
        header("location: login.php");
    }  
?>