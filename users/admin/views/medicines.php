<?php
    //title of the pge
    $title = "Medicine Inventory";

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
    <h1 class="mt-4"> Manager Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./index.php" style="text-decoration: none">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Medicine Inventory</li>
    </ol>
 
    <div class="wrapper">
        <div class="container">
            <div class="row mb-5">
                <div class="p-0">
                    <div class="card shadow-lg ">
                        <div class="card-header" style="background-color: #FFAF1A; color: #91452c">
                            
                            <div class="row justify-content-between">
                                <div class="col-xl-3 col-md-6">
                                    <h4 class="pt-2 fs-5 fw-bold">Archived Medicine Records</h4>
                                </div>

                            </div>
                        </div>
                        <div>
                            <?php include("../../includes/loader.php"); ?>
                        </div>
                        <div class="card-body displayTable">
                            <div class="table-responsive m-1">
                                <?php
                                    // Include config file
                                    include('./query/medicine_records.php');
                                ?>
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