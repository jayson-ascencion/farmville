<?php
    //page title
    $title = "Update Feed Details";
    
    //header
    include('../../includes/header.php');

    include('../action/update_feed_replenishment.php'); 
     
 
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
        <div class="col-md-4">
            <div class="card bg-light shadow mb-4 ">
                <div class="card-header text-center fw-bold p-3" style="background-color: #FFAF1A; color: #91452c">UPDATE FEED INVENTORY DETAILS</div>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" novalidate>

                        <!-- retrieves the data from the database based on the id -->
                        <?php
                            //connect to the database
                            include('../../../config/database_connection.php');

                            $id = $_REQUEST['id'];
                            
                            //statement to select the specific schedule to update
                            $sql = "SELECT * FROM feedtransaction WHERE transaction_ID = '$id'";
                            $stmt = $conn->query($sql);
                            if($stmt){
                                if($stmt->rowCount() > 0){
                                    while($row = $stmt->fetch()){
                                        $feed_ID = $row['feed_ID'];
                                        $quantity = $row['quantity'];
                                        // $inStock = $row['inStock'];
                                        $datePurchased = $row['transactionDate'];
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
                            <div class="form-group mb-3">
                            <label for="feed_ID" class="mb-2 text-dark">Feed Name</label>
                                    <select class="form-select" name="feed_ID" required>
                                        <option value="<?php echo $feed_ID; ?>">
                                            <?php
                                            if(!empty($feed_ID)){
                                                //connect to the database
                                                include('../../../config/database_connection.php');
                                                $selectedID = "";
                                                //statement to select the all the medicine names
                                                $sql = "SELECT feedName FROM feeds WHERE feed_ID = '$feed_ID'";
                                                $stmt = $conn->query($sql);
                                                if($stmt){
                                                    if($stmt->rowCount() > 0){
                                                        while($row = $stmt->fetch()){
                                                            echo $row['feedName'];
                                                     }
                                                        // Free result set
                                                        unset($result);
                                                    } else{

                                                        echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                                                    }
                                                } else{
                                                    echo "Oops! Something went wrong. Please try again later.";
                                                }
                                                unset($stmt);
                                            }else{
                                                echo "- select a batch id -";
                                            }
                                            ?>
                                        </option>
                                        <?php

                                            //connect to the database
                                            include('../../../config/database_connection.php');
                                            $selectedID = "";
                                            //statement to select the all the medicine names
                                            $sql = "SELECT feedName, feed_ID FROM feeds";
                                            $stmt = $conn->query($sql);
                                            if($stmt){
                                                if($stmt->rowCount() > 0){
                                                    while($row = $stmt->fetch()){?>
                                                    <option value="<?php echo $row['feed_ID']; ?>"> <?php echo $row["feedName"];?> </option>
                                                <?php }
                                                    // Free result set
                                                    unset($result);
                                                } else{

                                                    echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                                                }
                                            } else{
                                                echo "Oops! Something went wrong. Please try again later.";
                                            }
                                            unset($stmt);

                                        ?>
                                    </select>
                                    <span class="text-danger" style="font-size: small;"> <?php echo $feed_ID_err; ?> </span>
                                </div>                

                                <!-- Quantity -->
                                <div class="form-group mb-3">
                                    <label for="quantity" class="mb-2 text-dark">Quantity</label>
                                    <input type="number" name="quantity" class="form-control"value="<?php echo $quantity; ?>" required>
                                    <span class="text-danger" style="font-size: 13px;">  <?php echo $quantity_err; ?> </span>
                                </div>

                                <!-- Date Purchased -->
                                <div class="form-group mb-3">
                                    <label for="datePurchased" class="mb-2 text-dark">Date Purchased </label>
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
