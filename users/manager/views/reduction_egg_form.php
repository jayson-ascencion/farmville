<?php
    //page title
    $title = "Egg Reduction Form";
    
    //header
    include('../../includes/header.php');

    include('../action/egg_reduction.php'); 
    
 
?>

<!-- content --> 
<div class="container-fluid px-4">
    <h1 class="mt-4"> Manager Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./egg_reduction.php" style="text-decoration: none">Egg Reduction</a>
        </li>
        <li class="breadcrumb-item active">Add Egg Reduction</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-xl-6 col-md-6">
            <div class="card bg-light  shadow-lg mb-4">
                <div class="card-header text-center fw-bold p-3" style="background-color: #FFAF1A; color: #91452c">ADD EGG REDUCTION</div>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" novalidate>
                        <div class="card-body p-4">
                            <!-- ID  -->
                            <div class="form-group mb-3">
                                <label for="eggBatch_ID" class="mb-2 text-dark">Egg Batch ID</label>
                                <select class="form-select" name="eggBatch_ID" required>
                                    <option value="<?php echo $eggBatch_ID; ?>">
                                        <?php
                                        if(!empty($eggBatch_ID)){
                                            echo $eggBatch_ID;
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
                                        $sql = "SELECT eggSize, eggBatch_ID FROM eggproduction WHERE archive='not archived' AND quantity > 0";
                                        $stmt = $conn->query($sql);
                                        if($stmt){
                                            if($stmt->rowCount() > 0){
                                                while($row = $stmt->fetch()){?>
                                                <option value="<?php echo $row['eggBatch_ID']; ?>"> <?php echo $row['eggBatch_ID']  . " - " . $row["eggSize"];?> </option>
                                            <?php }
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
                                </select>
                                <span class="text-danger" style="font-size: small;"> <?php echo $eggBatch_ID_err; ?> </span>
                            </div>

                            <!-- Quantity -->
                            <div class="form-group mb-3">
                                <label for="quantity" class="mb-2 text-dark">Quantity</label>
                                <input type="number" name="quantity" class="form-control" value="<?php echo $quantity; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $quantity_err; ?> </span>
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
                                    <option value="Consumed">Personal Consumption</option>
                                    <option value="Spoiled">Spoiled</option> -->
                                </select>
                                <span class="text-danger" style="font-size: 13px;"> <?php echo $reductionType_err; ?> </span>
                            </div>
                            
                            <!-- Date Reduced -->
                            <div class="form-group mb-3">
                                <label for="dateReduced" class="mb-2 text-dark">Date Reduced</label>
                                <input type="date" min="2022-01-01" max="<?php echo date('Y-m-d'); ?>" name="dateReduced" class="form-control" value="<?php echo $dateReduced; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $dateReduced_err; ?> </span>
                            </div>
    

                        </div>
                        <div class="card-footer w-100 border d-flex justify-content-between">
                            <div class="w-100 m-1">
                                <a class="small btn btn-outline-secondary fw-bold w-100" href="./egg_reduction.php">
                                    Cancel
                                </a> 
                            </div>
                            <div class="w-100 m-1">
                                <button type="submit" name="submit" class="btn btn-outline-success fw-bold w-100">
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
