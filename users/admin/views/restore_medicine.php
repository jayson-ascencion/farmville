<?php
    //title of the pge
    $title = "Archive Medicine";

    include("../../includes/header.php");

    //database connection, located in the config directory
    include('../../../config/database_connection.php');

    $id = $_REQUEST['id'];
    
    //statement to select the specific schedule to update
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
                $dateAdded = $row['dateAdded'];
                $expirationDate = $row['expirationDate'];
            }
            // Free result set
            unset($result);
        } else{
            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
        }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }
    unset($pdo);

    try{
        
        //processing the data from the form submitted
        if(isset($_POST['archiveRecord'])){
            $id = $_POST['id'];
                $archived = 'not archived';

            // Prepare an insert statement
            $sql = "UPDATE medicines m
                    LEFT JOIN medicinereduction mr ON m.medicine_ID = mr.medicine_ID
                    SET m.archive=:archived, mr.archive=:archived 
                    WHERE m.medicine_ID = '$id'";
            
            if($stmt = $conn->prepare($sql))
            {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":archived", $param_archived, PDO::PARAM_STR);
                
                // Set parameters
                $param_archived = $archived;

                // Attempt to execute the prepared statement
                if($stmt->execute())
                {
                    $_SESSION['status'] = "Record Successfully Restored";
                    header("Location: medicines.php");
                } 
                else
                {
                echo "Something went wrong. Please try again later.";
                }

                // Close statement
                unset($stmt);
            }
            
        
        }
        

    }catch(PDOException $e){
        echo ("Error: " . $e->getMessage());
    }
?>

<!-- content --> 
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
                <div class="card-header text-center fw-bold p-3" style="background-color: #FFAF1A; color: #91452c">
                    <div class="text-center">Are you sure you want to restore this record?</div>
                </div>

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
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">

                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <div class="card-footer w-100 border d-flex justify-content-between">
                        <div class="m-1 w-100">
                            <a class="small btn btn-outline-secondary w-100 fw-bold" href="./medicines.php">
                                Cancel
                            </a> 
                        </div>
                        <div class="m-1 w-100">
                            <button type="submit" name="archiveRecord" class="btn btn-outline-success w-100 fw-bold">
                            Restore
                            </button>                                  
                        </div>
                    </div>
                </form>
                    
            </div>
        </div>
    </div>
</div>
<!-- end of content -->

<?php
    //header
    include('../../includes/footer.php');

    //scripts
    include('../../includes/scripts.php');
?>
