<?php
    if($_SESSION['role']!==2){
        header("Location: ../../../login.php");
    }
?>