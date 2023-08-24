<?php
    //title of the pge
    $title = "Feeds Inventory";

    //header
    include("../../includes/header.php");
?>
<!-- content --> 
<div class="container-fluid px-4">
    <?php
        if(isset($_SESSION['status'])){
            echo '<div class="position-relative">
                    <div class="successAlert position-absolute top-0 end-0 mt-2 alert alert-success alert-dismissible fade show animate__animated animate__fadeIn float-end" role="alert">                  
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill me-1" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </svg>'. $_SESSION['status'] .'
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                 </div>';
            unset($_SESSION['status']);
        } 
    ?>
    <h1 class="mt-4"> Employee Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./index.php" style="text-decoration: none">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Feeds Inventory</li>
    </ol>

    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="p-0">
                    <div class="card shadow-lg mb-5">
                        <div class="card-header" style="background-color: #FFAF1A; color: #91452c">
                            <div class="row justify-content-between">
                                <div class="col-xl-3 col-md-6">
                                    <h4 class="pt-2 fs-5 fw-bold">Feed Records</h4>
                                </div>

                                <div class="col-xl-2 col-md-4 align-content-end">
                                    <div class="w-100 d-flex justify-content-end">
                                        <div class="m-1 w-100 float-end">
                                            <a href="add_feeds_form.php" class="btn btn-primary shadow-sm w-100 fw-bold">Add New Feed</a>
                                        </div>
                                        <!-- <div class="m-1 w-100 float-end">
                                            <a href="replenish_feeds.php" class="btn btn-success shadow-sm w-100 fw-bold">Replenish Stock</a>
                                        </div> -->
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-body">
                            <div>
                                <?php include("../../includes/loader.php"); ?>
                            </div>
                            <div class="table-responsive displayTable m-1">
                                <?php
                                    // Include query to display records
                                    include('./query/feed_records.php');
                                ?>
                                <!-- <p>please</p> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>   
            
            <div class="row">
                <div class="p-0">
                    <div class="card shadow-lg mb-5">
                        <div class="card-header" style="background-color: #FFAF1A; color: #91452c">
                            <div class="row justify-content-between">
                                <div class="col-xl-3 col-md-6">
                                    <h4 class="pt-2 fs-5 fw-bold">Feed Replenishments History</h4>
                                </div>

                                <div class="col-xl-2 col-md-4 align-content-end">
                                    <div class="w-100 d-flex justify-content-end">
                                        <!-- <div class="m-1 w-100 float-end">
                                            <a href="add_feeds_form.php" class="btn btn-primary shadow-sm w-100 fw-bold">Add New Feeds</a>
                                        </div> -->
                                        <div class="m-1 w-100 float-end">
                                            <a href="add_feeds_replenishment_form.php" class="btn btn-success shadow-sm w-100 fw-bold">Replenish Stock</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-body">
                            <div>
                                <?php 
                                include("../../includes/loader.php"); 
                                ?>
                            </div>
                            <div class="table-responsive displayTable m-1">
                                <?php
                                    // Include query to display records
                                    include('./query/feed_replenishment_history.php');
                                ?>
                                <p>please</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
    

</div>
<!-- end of content -->
<?php
    include("../../includes/footer.php");

    include("../../includes/scripts.php");

?>