<?php
    //title of the pge
    $title = "Delete Reduction";

    include("../../includes/header.php");

    //database connection, located in the config directory
    include('../../../config/database_connection.php');
    $id = $_REQUEST['id'];

    //this will hold the quantity before update
    $chickenBatch_ID = $coopNumber = $batchName = $quantity = $reductionType = $dateReduced = "";

    //statement to get the old quantity
    $sql = "SELECT * FROM chickenreduction WHERE reduction_ID = '$id'";
    $stmt = $conn->query($sql);

    if($stmt){
        if($stmt->rowCount() > 0){
            while($row = $stmt->fetch()){
                //collect data from the form
                $chickenBatch_ID = $row['chickenBatch_ID'];
                $coopNumber = $row['coopNumber'];
                $batchName = $row['batchName'];
                $quantity = $row['quantity'];
                $reductionType = $row['reductionType'];
                $dateReduced = $row['dateReduced'];
            }
            // Free result set
            unset($result);
        } else{
            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
        }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }

    try{
        
        //processing the data from the form submitted
        if(isset($_POST['archiveRecord'])){
            $id = $_POST['id'];
            $archived = 'archived';

            // Prepare an insert statement
            $sql = "UPDATE chickenreduction SET archive=:archived WHERE reduction_ID = '$id'";
            
            if($stmt = $conn->prepare($sql))
            {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":archived", $param_archived, PDO::PARAM_STR);
                
                // Set parameters
                $param_archived = $archived;

                // Attempt to execute the prepared statement
                if($stmt->execute())
                {
                    $_SESSION['status'] = "Chicken Reduction Data is Successfully Archived.";
                    header("Location: chicken_reduction.php");
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

<div class="container-fluid px-4">
    <h1 class="mt-4"> Manager Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./egg_production.php" style="text-decoration: none">Chicken Reduction</a>
        </li>
        <li class="breadcrumb-item active">Chicken Reduction Details</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-sm-4">
            <div class="card bg-light shadow-lg mb-4 ">
                <div class="card-header text-center fw-bold p-3" style="background-color: #f37e57"><div class=" text-center ">CHICKEN REDUCTION DETAILS</div> </div>
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                        <div class="card-body p-4">
                            <!-- egg batch id -->
                            <div class="mb-3">
                                <p class="fw-bold">Chicken Batch ID: <span class="fw-normal ps-2"><?php echo $chickenBatch_ID; ?></span></p>
                            </div>

                            <!-- egg Size -->
                            <div class="mb-3">
                                <p class="fw-bold">Coop Number: <span class="fw-normal ps-2"><?php echo $coopNumber; ?></span></p>
                            </div>
                    
                            <!-- Quantity -->
                            <div class="mb-3">
                                <p class="fw-bold">Batch Name: <span class="fw-normal ps-2"><?php echo $batchName; ?></span></p>
                            </div>

                            <!-- Collection Type -->
                            <div class="mb-3">
                                <p class="fw-bold">Reduction Type: <span class="fw-normal ps-2"><?php echo $reductionType; ?></span></p>
                            </div>

                            
                            <!-- Collection Date -->
                            <div class="mb-3">
                                <p class="fw-bold">Date Reduced: <span class="fw-normal ps-2"><?php echo $dateReduced; ?></span></p>
                            </div>


                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <div class="card-footer w-100 border d-flex justify-content-between">
                            <div class="w-100 m-1">
                                <a class="btn  btn-outline-danger fw-bold w-100" href="./chicken_reduction.php">
                                    Cancel
                                </a> 
                            </div>
                            <div class="w-100 m-1">
                                <button type="submit" name="archiveRecord" class="btn  btn-outline-success fw-bold w-100">
                                    Delete
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
    include("../../includes/footer.php");
    
    include("../../includes/scripts.php");
    

?>