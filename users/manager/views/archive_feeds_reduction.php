<?php
    //page title
    $title = "Delete Feed Reduction";
    
    //header
    include('../../includes/header.php');

    //connect to the database
    include('../../../config/database_connection.php');

    $id = $_REQUEST['id'];
    
    //statement to get the old brand
    $sql = "SELECT * FROM feedreduction WHERE feedReduction_ID = '$id'";
    $stmt = $conn->query($sql);

    if($stmt){
        if($stmt->rowCount() > 0){
            while($row = $stmt->fetch()){
                $feed_ID = $row['feed_ID'];
                $feedName = $row['feedName'];
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
            $sql = "UPDATE feedreduction SET archive=:archived WHERE feedReduction_ID = '$id'";
            
            if($stmt = $conn->prepare($sql))
            {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":archived", $param_archived, PDO::PARAM_STR);
                
                // Set parameters
                $param_archived = $archived;

                // Attempt to execute the prepared statement
                if($stmt->execute())
                {
                    $_SESSION['status'] = "Feeds Reduction Data is Successfully Deleted.";
                    header("Location: feed_reduction.php");
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
            <a href="./feeds.php" style="text-decoration: none">Feed Inventory</a>
        </li>
        <li class="breadcrumb-item active">Feed Details</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-sm-4">
            <div class="card bg-light shadow-lg mb-4 ">
                <div class="card-header text-center fw-bold p-3" style="background-color: #FFAF1A; color: #91452c">
                    <div class="text-center">Are you sure you want to delete this record?</div>
                </div>
                <div class="card-body p-4">
                    <!-- FEED ID -->
                    <div class="mb-3">
                        <p class="fw-bold">Feed ID: <span class="fw-normal ps-2"><?php echo $feed_ID; ?></span></p>
                    </div>

                    <!-- FEED NAME -->
                    <div class="mb-3">
                        <p class="fw-bold">Feed Name: <span class="fw-normal ps-2"><?php echo $feedName; ?></span></p>
                    </div>

                    <!-- QUANTITY -->
                    <div class="mb-3">
                        <p class="fw-bold">Quantity: <span class="fw-normal ps-2"><?php echo $quantity; ?></span></p>
                    </div>

                    
                    <!-- REDUCTION TYPE -->
                    <div class="mb-3">
                        <p class="fw-bold">Reduction Type: <span class="fw-normal ps-2"><?php echo $reductionType; ?></span></p>
                    </div>
                        
                    <!-- DATE REDUCED -->
                    <div class="mb-3">
                        <p class="fw-bold">Date Reduced: <span class="fw-normal ps-2"><?php echo $dateReduced; ?></span></p>
                    </div>

                </div>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <div class="card-footer w-100 border d-flex justify-content-end">
                        <div>


                        </div>
                        <div class="m-1 w-100">
                            <a class="small btn btn-outline-danger w-100 fw-bold" href="./feeds.php">
                                Cancel
                            </a> 
                            
                        </div>
                        <div class="m-1 w-100">
                            <button type="submit" name="archiveRecord" class="btn btn-outline-success w-100 fw-bold">
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
    //header
    include('../../includes/footer.php');

    //scripts
    include('../../includes/scripts.php');
?>
