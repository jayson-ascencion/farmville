<?php
    //title of the pge
    $title = "Egg Production Details";

    include("../../includes/header.php");

    //database connection, located in the config directory
    include('../../../config/database_connection.php');
    $id = $_REQUEST['id'];

    //this will hold the eggSize before update
    $collection_ID = $eggBatch_ID = $eggSize = $reductionType = $dateReduced = "";

    //statement to get the old eggSize
    $sql = "SELECT * FROM eggtransaction WHERE collection_ID = '$id'";
    $stmt = $conn->query($sql);

    if($stmt){
        if($stmt->rowCount() > 0){
            while($row = $stmt->fetch()){
                $collection_ID = $row['collection_ID'];
                // $eggBatch_ID = $row['eggBatch_ID'];
                $eggSize = $row['eggSize'];
                // $reductionType = $row['reductionType'];
                $quantity = $row['quantity'];
                $dateString = strtotime($row['transactionDate']);
                $dateReduced = date("F d, Y",$dateString);
            }
            // Free result set
            unset($result);
        } else{
            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
        }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }
?>

<div class="container-fluid px-4">
    <h1 class="mt-4"> Employee Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./egg_production.php" style="text-decoration: none">Egg Production</a>
        </li>
        <li class="breadcrumb-item active">Egg Reduction Details</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-sm-4">
            <div class="card bg-light shadow-lg mb-4 ">
                <div class="card-header text-center fw-bold d-flex justify-content-between p-3" style="background-color: #FFAF1A; color: #91452c"><div>EGG REDUCTION DETAILS</div> <div>
                            <a class="small text-white" href="./egg_reduction.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z"/>
  <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
</svg>
                            </a> 
                        </div></div>
                        <div class="card-body p-4">
                            <!-- egg batch id -->
                            <!-- <div class="mb-3">
                                <p class="fw-bold">Egg Reduction ID: <span class="fw-normal ps-2"><?php echo $collection_ID; ?></span></p>
                            </div> -->

                            <!-- egg Size -->
                            <!-- <div class="mb-3">
                                <p class="fw-bold">Collection ID: <span class="fw-normal ps-2"><?php echo $eggBatch_ID; ?></span></p>
                            </div> -->
                    
                            <!-- Size -->
                            <div class="mb-3">
                                <p class="fw-bold">Size: <span class="fw-normal ps-2"><?php echo $eggSize; ?></span></p>
                            </div>
                    
                            <!-- Quantity -->
                            <div class="mb-3">
                                <p class="fw-bold">Quantity: <span class="fw-normal ps-2"><?php echo $quantity; ?></span></p>
                            </div>

                            <!-- Collection Type -->
                            <div class="mb-3">
                                <p class="fw-bold">Reduction Type: <span class="fw-normal ps-2"><?php echo $reductionType; ?></span></p>
                            </div>

                            
                            <!-- Collection Date -->
                            <div class="mb-3">
                                <p class="fw-bold">Reduction Date: <span class="fw-normal ps-2"><?php echo $dateReduced; ?></span></p>
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