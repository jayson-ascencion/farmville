<?php
    //page title
    $title = "Update Egg Reduction Details";
    
    //header
    include('../../includes/header.php');

    include('../action/update_egg_reduction.php'); 
    
 
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
        <div class="col-xl-6 col-md-6">
            <div class="card bg-light shadow-lg mb-4 ">
                <div class="card-header text-center fw-bold p-3" style="background-color: #FFAF1A; color: #91452c">UPDATE EGG REDUCTION DETAILS</div>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" novalidate>

                        <!-- retrieves the data from the database based on the id -->
                        <?php
                            //connect to the database
                            include('../../../config/database_connection.php');

                            $id = $_REQUEST['id'];
                            
                            //statement to select the specific schedule to update
                            $sql = "SELECT * FROM eggtransaction WHERE collection_ID = '$id'";
                            $stmt = $conn->query($sql);
                            if($stmt){
                                if($stmt->rowCount() > 0){
                                    while($row = $stmt->fetch()){
                                        $eggSize_ID = $row['eggSize_ID'];
                                        $eggSize = $row['eggSize'];
                                        $quantity = $row['quantity'];
                                        $reductionType = $row['dispositionType'];
                                        $dateReduced = $row['transactionDate'];
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
                                <label for="eggSize_ID" class="mb-2 text-dark">Egg Batch ID</label>
                                <select class="form-select" name="eggSize_ID" disabled>
                                    <?php

                                        //connect to the database
                                        include('../../../config/database_connection.php');

                                        //statement to select the all the medicine names
                                        $sql = "SELECT eggSize_ID, eggSize FROM eggproduction";
                                        $stmt = $conn->query($sql);
                                        if($stmt){
                                            if($stmt->rowCount() > 0){
                                                echo '<option value="' . $eggSize_ID . '">' . $eggSize .'</option>';
                                                while($row = $stmt->fetch()){?>
                                                <option value="<?php echo $row['eggSize_ID']; ?>"> <?php echo $row['eggSize']; ?> </option>
                                            <?php }
                                                // Free result set
                                                unset($result);
                                            } else{
                                                echo '<option> - no medicines found - </option>';
                                            }
                                        } else{
                                            echo "Oops! Something went wrong. Please try again later.";
                                        }
                                        unset($stmt);

                                    ?>
                                </select>
                                <span class="text-danger" style="font-size: small;"> <?php echo $eggBatch_ID_err; ?> </span>
                            </div>

                            <!-- egg Size -->
                            <!-- <div class="form-group mb-3">
                                <label for="eggSize" class="mb-2 text-dark">Egg Size</label>
                                <select class="form-select" name="eggSize" disabled>
                                    <option value="<?php echo $eggSize; ?>"><?php echo $eggSize; ?></option>
                                    <option value="XS">XS</option>
                                    <option value="S">S</option>
                                    <option value="M">M</option>
                                    <option value="L">L</option>
                                    <option value="XL">XL</option>
                                </select>
                            </div>                           -->

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
                                    <?php if($reductionType != "Distributed to Customer") { ?>
                                        <option value="Distributed to Customer">Distributed to Customer</option>
                                    <?php } ?>
                                    <?php if($reductionType != "Personal Consumption") { ?>
                                        <option value="Personal Consumption">Personal Consumption</option>
                                    <?php } ?>
                                    <?php if($reductionType != "Spoiled") { ?>
                                        <option value="Spoiled">Spoiled</option>
                                    <?php } ?>
                                    <!-- <option value="Distributed to Customer">Distributed to Customer</option>
                                    <option value="Consumed">Consumed</option>
                                    <option value="Sold">Sold</option>
                                    <option value="Spoiled">Spoiled</option> -->
                                </select>
                                <span class="text-danger" style="font-size: 13px;"> <?php echo $reductionType_err; ?> </span>
                            </div>

                            <!-- reduction Date -->
                            <div class="form-group mb-3">
                                <label for="dateReduced" class="mb-2 text-dark">Reduction Date</label>
                                <input type="date" min="2022-01-01" max="<?php echo date('Y-m-d'); ?>" name="dateReduced" class="form-control" value="<?php echo $dateReduced; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $dateReduced_err; ?> </span>
                            </div>
                                
                        </div>
                        <input type="hidden" name="eggSize_ID" value="<?php echo $eggSize_ID; ?>"/>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <div class="card-footer w-100 border d-flex justify-content-between">
                            <div class="w-100 m-1">
                                <a class="small btn btn-outline-secondary fw-bold w-100" href="./egg_reduction.php">
                                    Cancel
                                </a> 
                            </div>
                            <div class="w-100 m-1">
                                <button type="submit" name="submit" class="btn btn-outline-success fw-bold w-100">
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
