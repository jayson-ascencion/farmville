<?php
    //page title
    $title = "Update Egg Reduction Details";
    
    //header
    include('../../includes/header.php');

    //connect to the database
    include('../../../config/database_connection.php');

    $id = $_REQUEST['id'];
    
    //statement to select the specific schedule to update
    $sql = "SELECT * FROM eggreduction WHERE eggReduction_ID = '$id'";
    $stmt = $conn->query($sql);
    if($stmt){
        if($stmt->rowCount() > 0){
            while($row = $stmt->fetch()){
                $eggBatch_ID = $row['eggBatch_ID'];
                $eggSize = $row['eggSize'];
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
    unset($pdo);

    try{
        
        //processing the data from the form submitted
        if(isset($_POST['archiveRecord'])){
            $id = $_POST['id'];
            $archived = 'archived';

            // Prepare an insert statement
            $sql = "UPDATE eggreduction SET archive=:archived WHERE eggReduction_ID = '$id'";
            
            if($stmt = $conn->prepare($sql))
            {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":archived", $param_archived, PDO::PARAM_STR);
                
                // Set parameters
                $param_archived = $archived;

                // Attempt to execute the prepared statement
                if($stmt->execute())
                {
                    $_SESSION['status'] = "Egg Reduction Data is Successfully Archived.";
                    header("Location: egg_reduction.php");
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
            <a href="./egg_reduction.php" style="text-decoration: none">Egg Reduction</a>
        </li>
        <li class="breadcrumb-item active">Update Egg Reduction</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-sm-4">
            <div class="card bg-light shadow-lg mb-4 ">
                <div class="card-header text-center fw-bold p-3" style="background-color: #f37e57;">UPDATE EGG REDUCTION DETAILS</div>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                    <div class="card-body p-4">

                            <!-- egg Size -->
                            <div class="mb-3">
                                <p class="fw-bold">Egg Batch ID: <span class="fw-normal ps-2"><?php echo $eggBatch_ID; ?></span></p>
                            </div>
                    
                            <!-- Quantity -->
                            <div class="mb-3">
                                <p class="fw-bold">Size: <span class="fw-normal ps-2"><?php echo $eggSize; ?></span></p>
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
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <div class="card-footer w-100 border d-flex justify-content-between">
                            <div class="w-100 m-1">
                                <a class="small btn btn-outline-danger fw-bold w-100" href="./egg_reduction.php">
                                    Cancel
                                </a> 
                            </div>
                            <div class="w-100 m-1">
                                <button type="submit" name="archiveRecord" class="btn btn-outline-success fw-bold w-100">
                                    Save
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
