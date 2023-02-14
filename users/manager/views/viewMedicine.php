<?php
    //title of the pge
    $title = "Medicine Details";

    include("../../includes/header.php");

    //database connection, located in the config directory
    include('../../../config/database_connection.php');
    $id = $_REQUEST['id'];

    //this will hold the quantity before update
    $medicineType = $medicineName = $medicineBrand = $medicineFor = $startingQuantity = $inStock = $dateAdded =  $expirationDate = $success = $futureDate = "";

    //statement to get the old quantity
    $sql = "SELECT * FROM medicines WHERE medicine_ID = '$id'";
    $stmt = $conn->query($sql);

    if($stmt){
        if($stmt->rowCount() > 0){
            while($row = $stmt->fetch()){
                $medicineType = $row['medicineType'];
                $medicineName = $row['medicineName'];
                $medicineBrand = $row['medicineBrand'];
                $medicineFor = $row['medicineFor'];
                $startingQuantity = $row['startingQuantity'];
                $inStock = $row['inStock'];

                $dateAddedString = strtotime($row['dateAdded']);
                $dateAdded = date("F d, Y",$dateAddedString);

                $expirationDateString = strtotime($row['expirationDate']);
                $expirationDate = date("F d, Y",$expirationDateString);
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
    <h1 class="mt-4"> Manager Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./medicines.php" style="text-decoration: none">Medicine Inventory</a>
        </li>
        <li class="breadcrumb-item active">Medicine Details</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-sm-4">
            <div class="card bg-light shadow-lg mb-4 ">
                <div class="card-header text-center fw-bold d-flex justify-content-between p-3" style="background-color: #FFAF1A; color: #91452c"><div>MEDICINE DETAILS</div> <div>
                            <a class="small text-white" href="./medicines.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z"/>
  <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
</svg>
                            </a> 
                        </div></div>
                        <div class="card-body p-4">
                            <!-- egg batch id -->
                            <div class="mb-3">
                                <p class="fw-bold">Medicine Name: <span class="fw-normal ps-2"><?php echo $medicineName; ?></span></p>
                            </div>

                            <!-- egg Size -->
                            <div class="mb-3">
                                <p class="fw-bold">Medicine Type: <span class="fw-normal ps-2"><?php echo $medicineType; ?></span></p>
                            </div>
                    
                            <!-- Quantity -->
                            <div class="mb-3">
                                <p class="fw-bold">Medicine Brand: <span class="fw-normal ps-2"><?php echo $medicineBrand; ?></span></p>
                            </div>

                            <!-- Collection Type -->
                            <div class="mb-3">
                                <p class="fw-bold">Medicine For: <span class="fw-normal ps-2"><?php echo $medicineFor; ?></span></p>
                            </div>

                            
                            <!-- Collection Date -->
                            <div class="mb-3">
                                <p class="fw-bold">Starting Quantity: <span class="fw-normal ps-2"><?php echo $startingQuantity; ?></span></p>
                            </div>
                               
                            <!-- Note -->
                            <div class="mb-3">
                                <p class="fw-bold">In Stock: <span class="fw-normal ps-2"><?php echo $inStock; ?></span></p>
                            </div>

                             <!-- Note -->
                            <div class="mb-3">
                                <p class="fw-bold">Date Added: <span class="fw-normal ps-2"><?php echo $dateAdded; ?></span></p>
                            </div>

                             <!-- Note -->
                            <div class="mb-3">
                                <p class="fw-bold">Expiration Date: <span class="fw-normal ps-2"><?php echo $expirationDate; ?></span></p>
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