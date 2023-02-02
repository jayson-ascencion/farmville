<?php
    //title of the pge
    $title = "Chicken Production Details";

    include("../../includes/header.php");

    //database connection, located in the config directory
    include('../../../config/database_connection.php');
    $id = $_REQUEST['id'];

    //this will hold the quantity before update
    $eggBatch_ID = $eggSize = $quantity = $collectionType = $collectionDate = $note = "";

    //statement to get the old quantity
    $sql = "SELECT * FROM chickenproduction WHERE chickenBatch_ID = '$id'";
    $stmt = $conn->query($sql);

    if($stmt){
        if($stmt->rowCount() > 0){
            while($row = $stmt->fetch()){
                //collect data from the form
                $coopNumber = $row['coopNumber'];
                $batchName = $row['batchName'];
                $breedType = $row['breedType'];
                $batchPurpose = $row['batchPurpose'];
                $startingQuantity = $row['startingQuantity'];
                $inStock = $row['inStock'];

                $dateString = strtotime($row['dateAcquired']);
                $dateAcquired = date('F d, Y',$dateString);
                $acquisitionType = $row['acquisitionType'];
                $note = $row['note'];
            }
            // Free result set
            unset($stmt);
        } else{
            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
        }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }
?>

<div class="container-fluid px-4">
    <h1 class="mt-4"> Manager Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./egg_production.php" style="text-decoration: none">Chicken Production</a>
        </li>
        <li class="breadcrumb-item active">Chicken Details</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-sm-4">
            <div class="card bg-light shadow-lg mb-4 ">
                <div class="card-header text-center fw-bold d-flex justify-content-between p-3" style="background-color: #f37e57"><div>CHICKEN DETAILS</div> <div>
                            <a class="small text-white" href="./chicken_production.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z"/>
  <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
</svg>
                            </a> 
                        </div></div>
                        <div class="card-body p-4">
                            <!-- egg batch id -->
                            <div class="mb-3">
                                <p class="fw-bold">Coop Number: <span class="fw-normal ps-2"><?php echo $coopNumber; ?></span></p>
                            </div>

                            <!-- egg Size -->
                            <div class="mb-3">
                                <p class="fw-bold">Batch Name: <span class="fw-normal ps-2"><?php echo $batchName; ?></span></p>
                            </div>
                    
                            <!-- Quantity -->
                            <div class="mb-3">
                                <p class="fw-bold">Breed Type: <span class="fw-normal ps-2"><?php echo $breedType; ?></span></p>
                            </div>

                            <!-- Collection Type -->
                            <div class="mb-3">
                                <p class="fw-bold">Starting Quantity: <span class="fw-normal ps-2"><?php echo $startingQuantity; ?></span></p>
                            </div>

                            
                            <!-- Collection Date -->
                            <div class="mb-3">
                                <p class="fw-bold">In Stock: <span class="fw-normal ps-2"><?php echo $inStock; ?></span></p>
                            </div>

                            <!-- Collection Date -->
                            <div class="mb-3">
                                <p class="fw-bold">Date Acquired: <span class="fw-normal ps-2"><?php echo $dateAcquired; ?></span></p>
                            </div>

                            <!-- Collection Date -->
                            <div class="mb-3">
                                <p class="fw-bold">Acquisition Type: <span class="fw-normal ps-2"><?php echo $acquisitionType; ?></span></p>
                            </div>
                               
                            <!-- Note -->
                            <div class="mb-3">
                                <p class="fw-bold">Note: <span class="fw-normal ps-2"><?php echo $note; ?></span></p>
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