<?php
//start the session
session_start();
ob_start();

if($_SESSION["loggedin"]===true){ 
    if($_SESSION['role']===1){
        include('auth.php');
    }else if($_SESSION['role']===2){
        include('auth.php');
    }else if($_SESSION['role']===3){
        include('auth.php');
    }
}else{
    header("Location: ../../../login.php");
}
// Get the current user's role
$user_role = $_SESSION['role'];
// Set a variable based on the role
if ($user_role == 3) {
    $show_export_buttons = false;
 } else {
    $show_export_buttons = true;
 }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title><?php echo $title; ?></title>

        <!-- farmville icon --> 
        <link rel="icon" type="image/x-icon" href="../../../assets/images/favicon.ico">

        <!-- css files  --> 
        <link rel="stylesheet" type="text/css" href="../../../assets/css/styles.css" />
        <link rel="stylesheet" type="text/css" href="../../../assets/css/datatables.min.css">
        <link rel="stylesheet" type="text/css" href="../../../assets/css/animate.min.css">
        <link rel="stylesheet" type="text/css" href="../../../assets/css/daterangepicker.css">

        <!-- Pagination Source - https://www.youtube.com/watch?v=nMzz1ZIET1A - https://datatables.net/manual/installation -->

        <style>
          /* * { */
            /* margin: 0; */
            /* padding: 0; */
            /* font-family: sans-serif; */
          /* } */
          /* .chartMenu {
            width: 100%;
            height: 40px;
            background: #1A1A1A;
            color: rgba(54, 162, 235, 1);
          }
          .chartMenu p {
            padding: 10px;
            font-size: 20px;
          }
          .chartCard {
            width: 100%;
            height: 50%;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: auto;
            border-radius: 20px;
          } */
          /* .chartBox {
            width: 500px;
            height: 500px; */
            /* padding: 20px;
            border-radius: 20px;
            border: solid 3px orange;
            background: white; */
          /* } */
          /* @media only screen and (max-width: 700px){
            .chartBox{
              width: 90%;
              height: 45%;
              padding: 20px;
            }
          }
          @media only screen and (max-width: 700px){
            .chartBox{
              width: 300px;
              height: 300px;
              padding: 20px;
            }
          }
          @media only screen and (max-width: 700px){
            .chartBox{
              width: 90%;
              height: 90%;
              padding: 20px;
            }
          } */
        </style>
    </head>

    <body class="sb-nav-fixed" style="background-color: #FFEDCC">
        
        <!-- navbar-top -->
        <?php 
        include('navbar-top.php');
        ?>

        <div id="layoutSidenav">
    
        <!-- sidebar -->
        <?php
        include('sidebar.php');
        ?>
    
        <div id="layoutSidenav_content">
        <main>



