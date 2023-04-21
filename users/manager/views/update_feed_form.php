<?php
    //page title
    $title = "Update Feed Details";
    
    //header
    include('../../includes/header.php');

    include('../action/update_feed.php'); 
    
 
?>

<!-- content --> 
<div class="container-fluid px-4">
    <h1 class="mt-4"> Manager Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./feed_reduction.php" style="text-decoration: none">Feed Reduction</a>
        </li>
        <li class="breadcrumb-item active">Update Feed Reduction</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-xl-6 col-md-6">
            <div class="card bg-light shadow mb-4 ">
                <div class="card-header text-center fw-bold p-3" style="background-color: #FFAF1A; color: #91452c">UPDATE FEED INVENTORY DETAILS</div>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" novalidate>

                        <!-- retrieves the data from the database based on the id -->
                        <?php
                            //connect to the database
                            include('../../../config/database_connection.php');

                            $id = $_REQUEST['id'];
                            
                            //statement to select the specific schedule to update
                            $sql = "SELECT * FROM feeds WHERE feed_ID = '$id'";
                            $stmt = $conn->query($sql);
                            if($stmt){
                                if($stmt->rowCount() > 0){
                                    while($row = $stmt->fetch()){
                                        $feed_ID = $row['feed_ID'];
                                        $feedName = $row['feedName'];
                                        $brand = $row['brand'];
                                        $startingQuantity = $row['startingQuantity'];
                                        $inStock = $row['inStock'];
                                        $datePurchased = $row['datePurchased'];
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
                        ?>
                        <div class="card-body p-4">
                            <!-- Feed Name -->
                            <div class="form-group mb-3">
                                <label for="feedName" class="mb-2 text-dark">Feed Name</label>
                                <input type="text" name="feedName" class="form-control" value="<?php echo $feedName; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $feedName_err; ?> </span>
                            </div>    
                            
                            <!-- Feed Brand -->
                            <div class="form-group mb-3">
                                <label for="brand" class="mb-2 text-dark">Feed Brand</label>
                                <input type="text" name="brand" class="form-control" value="<?php echo $brand; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $brand_err; ?> </span>
                            </div> 

                            <!-- Starting Quantity -->
                            <div class="form-group mb-3">
                                <label for="startingQuantity" class="mb-2 text-dark">Starting Quantity</label>
                                <input type="number" name="startingQuantity" class="form-control" value="<?php echo $startingQuantity; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $startingQuantity_err; ?> </span>
                            </div>

                            <!-- In Stock Quantity -->
                            <div class="form-group mb-3">
                                <label for="inStock" class="mb-2 text-dark">In Stock</label>
                                <input type="number" name="inStock" class="form-control" value="<?php echo $inStock; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $inStock_err; ?> </span>
                            </div>

                            <!-- Purchased Date -->
                            <div class="form-group mb-3">
                                <label for="datePurchased" class="mb-2 text-dark">Date Purchased</label>
                                <input type="date" min="2022-01-01" max="<?php echo date('Y-m-d'); ?>" name="datePurchased" class="form-control" value="<?php echo $datePurchased; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $datePurchased_err; ?> </span>
                            </div>
                               
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <div class="card-footer w-100 border d-flex justify-content-end">
                            <div>


                            </div>
                            <div class="m-1 w-100">
                                <a class="small btn btn-outline-secondary w-100 fw-bold" href="./feeds.php">
                                    Cancel
                                </a> 
                                
                            </div>
                            <div class="m-1 w-100">
                                <button type="submit" name="submit" class="btn btn-outline-success w-100 fw-bold">
                                Update
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
