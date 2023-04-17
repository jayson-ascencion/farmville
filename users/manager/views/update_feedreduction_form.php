<?php
    //page title
    $title = "Update Feed Reduction Details";
    
    //header
    include('../../includes/header.php');

    include('../action/update_feed_reduction.php'); 
    
 
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
            <div class="card bg-light shadow-lg mb-4 ">
                <div class="card-header text-center fw-bold p-3" style="background-color: #FFAF1A; color: #91452c">UPDATE FEED REDUCTION DETAILS</div>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">

                        <!-- retrieves the data from the database based on the id -->
                        <?php
                            //connect to the database
                            include('../../../config/database_connection.php');

                            $id = $_REQUEST['id'];
                            
                            //statement to select the specific schedule to update
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
                        ?>
                        <div class="card-body p-4">
                            <!-- Egg Batch ID -->
                            <div class="form-group mb-3">
                                <label for="feed_ID" class="mb-2 text-dark">Feed ID</label>
                                <select class="form-select" name="feed_ID" disabled>
                                    <?php

                                        //connect to the database
                                        include('../../../config/database_connection.php');

                                        //statement to select the all the medicine names
                                        $sql = "SELECT feed_ID, feedName FROM feeds";
                                        $stmt = $conn->query($sql);
                                        if($stmt){
                                            if($stmt->rowCount() > 0){
                                                echo '<option value="' . $feed_ID . '">' . $feed_ID .'</option>';
                                                while($row = $stmt->fetch()){?>
                                                <option value="<?php echo $row['feed_ID']; ?>"> <?php echo $row['feed_ID'] . " - " . $row['feedName']; ?> </option>
                                            <?php }
                                                // Free result set
                                                unset($result);
                                            } else{
                                                echo '<option> - no medicines found - </option>';
                                            }
                                        } else{
                                            echo "Oops! Something went wrong. Please try again later.";
                                        }
                                        unset($pdo);

                                    ?>
                                </select>
                                <span class="text-danger" style="font-size: small;"> <?php echo $feed_ID_err; ?> </span>
                            </div>

                            <!-- egg Size -->
                            <div class="form-group mb-3">
                                <label for="feedName" class="mb-2 text-dark">Feed Name</label>
                                <input type="number" name="updateQuantity" class="form-control" placeholder="<?php echo $feedName; ?>" required disabled>
                            </div>                          

                            <!-- Quantity -->
                            <div class="form-group mb-3">
                                <label for="updateQuantity" class="mb-2 text-dark">Quantity</label>
                                <input type="number" name="updateQuantity" class="form-control" value="<?php echo $quantity; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $updateQuantity_err; ?> </span>
                            </div>

                            <!-- Reduction Type -->
                            <div class="form-group mb-3">
                                <label for="reductionType" class="mb-2 text-dark">Reduction Type</label>
                                <select class="form-select" name="reductionType">
                                    <option value="<?php echo $reductionType; ?>">
                                        <?php
                                            if(empty($reductionType)){
                                                echo "- select reduction type -";
                                            }else{
                                                echo $reductionType;
                                            }
                                        ?>
                                    </option>
                                    <option value="Spoiled">Spoiled</option>
                                </select>
                                <span class="text-danger" style="font-size: 13px;"> <?php echo $reductionType_err; ?> </span>
                            </div>

                            <!-- reduction Date -->
                            <div class="form-group mb-3">
                                <label for="dateReduced" class="mb-2 text-dark">reduction Date</label>
                                <input type="date" min="2022-01-01" name="dateReduced" class="form-control" value="<?php echo $dateReduced; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $dateReduced_err; ?> </span>
                            </div>
                               
                        </div>
                        <input type="hidden" name="feed_ID" value="<?php echo $feed_ID; ?>"/>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <div class="card-footer w-100 border d-flex justify-content-end">
                            <div class="m-1 w-100">
                                <a class="small btn btn-outline-secondary w-100 fw-bold" href="./feed_reduction.php">
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
