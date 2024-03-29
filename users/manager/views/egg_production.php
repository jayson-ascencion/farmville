<?php
    //title of the pge
    $title = "Egg Production";

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
    <h1 class="mt-4"> Manager Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./index.php" style="text-decoration: none">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Egg Production</li>
    </ol>

    <div class="wrapper mt-1">
        <div class="container">
            <div class="row mb-5">
                <div class="p-0">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header fw-bold pb-2 fs-5" style="background-color: #FFAF1A; color: #91452c">
                        <div class="p-2">
                            Total Eggs In Stock <span class="fs-6 fw-normal">(trays)</span>: 
                        </div>
                        </div>
                    <div class="row p-3 text-center">
                        <div class="col-sm">
                            <div class="card bg-secondary text-white mb-2">
                                <div class="card-header">Extra Small: <span class="fw-bold fs-5">
                                    <?php
                                        //connect to the database
                                        include('../../../config/database_connection.php');

                                        //to count how many schedules are completed
                                        $sql = "SELECT inStock FROM eggproduction WHERE eggSize = 'XS'";
                                        $stmt = $conn->query($sql);
                                        $stmt->execute();
                                        $total = $stmt->fetchColumn();
                                        if($total > 0){
                                            echo $total;
                                        }else{
                                            echo "0";
                                        }

                                        // Close connection
                                        unset($conn);
                                    ?>
                                </span></div>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="card bg-primary text-white mb-2">
                                <div class="card-header">Small: <span class="fw-bold fs-5">
                                    <?php
                                        //connect to the database
                                        include('../../../config/database_connection.php');

                                        //to count how many schedules are completed
                                        $sql = "SELECT inStock FROM eggproduction WHERE eggSize = 'S'";
                                        $stmt = $conn->query($sql);
                                        $stmt->execute();
                                        $total = $stmt->fetchColumn();
                                        if($total > 0){
                                            echo $total;
                                        }else{
                                            echo "0";
                                        }

                                        // Close connection
                                        unset($conn);
                                    ?>
                                </span></div>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="card bg-warning text-white mb-2">
                                <div class="card-header">Medium: <span class="fw-bold fs-5">
                                    <?php
                                        //connect to the database
                                        include('../../../config/database_connection.php');

                                        //to count how many schedules are completed
                                        $sql = "SELECT inStock FROM eggproduction WHERE eggSize = 'M'";
                                        $stmt = $conn->query($sql);
                                        $stmt->execute();
                                        $total = $stmt->fetchColumn();
                                        if($total > 0){
                                            echo $total;
                                        }else{
                                            echo "0";
                                        }

                                        // Close connection
                                        unset($conn);
                                    ?>
                                </span></div>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="card bg-success text-white mb-2">
                                <div class="card-header">Large: <span class="fw-bold fs-5">
                                    <?php
                                        //connect to the database
                                        include('../../../config/database_connection.php');

                                        //to count how many schedules are completed
                                        $sql = "SELECT inStock FROM eggproduction WHERE eggSize = 'L'";
                                        $stmt = $conn->query($sql);
                                        $stmt->execute();
                                        $total = $stmt->fetchColumn();
                                        if($total > 0){
                                            echo $total;
                                        }else{
                                            echo "0";
                                        }

                                        // Close connectionprint_r($stmt->fetchColumn());
                                        unset($conn);
                                    ?>
                                </span></div>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="card bg-danger text-white mb-2">
                                <div class="card-header">Extra Large: <span class="fw-bold fs-5">
                                    <?php
                                        //connect to the database
                                        include('../../../config/database_connection.php');

                                        //to count how many schedules are completed
                                        $sql = "SELECT inStock FROM eggproduction WHERE eggSize = 'XL'";
                                        $stmt = $conn->query($sql);
                                        $stmt->execute();
                                        $total = $stmt->fetchColumn();
                                        if($total > 0){
                                            echo $total;
                                        }else{
                                            echo "0";
                                        }

                                        // Close connection
                                        unset($conn);
                                    ?>
                                </span></div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="card shadow-sm"> 
                        <div class="card-header" style="background-color: #FFAF1A;">

                            <!-- <div class="w-100 d-flex justify-content-between p-2">
                                <div>
                                    <h4 class="pt-2 fw-bold fs-5">Egg Production</h4>
                                </div>

                                <div>
                                    <a href="add_egg_form.php" class="btn btn-primary pt-2">Add Egg</a>
                                </div>
                            </div> -->
                            <div class="row justify-content-between">
                                <div class="col-xl-3 col-md-6">
                                    <h4 class="pt-2 fs-5 fw-bold" style="background-color: #FFAF1A; color: #91452c">Egg Production</h4>
                                </div>

                                <div class="col-xl-3 col-md-3 align-content-end">
                                    <div class="w-100 d-flex justify-content-end">
                                        <div class="m-1 w-100 float-end">
                                            <a href="add_egg_form.php" class="btn btn-success shadow-sm w-100 fw-bold">Add New Collection</a>
                                        </div>
                                        <!-- <div class="m-1 w-100">
                                            <a href="#" class="btn btn-outline-danger shadow-sm w-100 fw-bold">Archives</a>                                 
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php include("../../includes/loader.php"); ?>
                        </div>
                        <div class="card-body displayTable">
                            <div class="table-responsive m-1">
                                <?php
                                    //this will display all the chicken production data
                                    include('./query/egg_production_records.php');
                                ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>        
        </div>
    </div> 
<?php
    include("../../includes/footer.php");
    
    include("../../includes/scripts.php");
?>