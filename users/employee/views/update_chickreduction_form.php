<?php
    //page title
    $title = "Update Chicken Reduction";
    
    //header
    include('../../includes/header.php');

    include('../action/update_chicken_reduction.php'); 
    
?>

<!-- content --> 
<div class="container-fluid px-4">
    <h1 class="mt-4"> Employee Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./chicken_reduction.php" style="text-decoration: none">Chicken Reduction</a>
        </li>
        <li class="breadcrumb-item active">Update Chicken Reduction</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-xl-6 col-md-6">
            <div class="card bg-light shadow-lg mb-4 ">
                <div class="card-header text-center p-3 fw-bold" style="background-color: #FFAF1A; color: #91452c">UPDATE CHICKEN REDUCTION</div>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" novalidate>
                            <?php
                                //connect to the database
                                include('../../../config/database_connection.php');

                                $id = $_REQUEST['id'];
                                
                                //statement to get the old quantity
                                $sql = "SELECT * FROM chickentransaction WHERE transaction_ID = '$id'";
                                $stmt = $conn->query($sql);
                            
                                if($stmt){
                                    if($stmt->rowCount() > 0){
                                        while($row = $stmt->fetch()){
                                            //collect data from the form
                                            $chickenBatch_ID = $row['chickenBatch_ID'];
                                            $coopNumber = $row['coopNumber'];
                                            $batchName = $row['batchName'];
                                            $quantity = $row['quantity'];
                                            $reductionType = $row['dispositionType'];
                                            $note = $row['note'];
                                            $sex = $row['sex'];
                                            // $dateString = strtotime($row['transactionDate']);
                                            $dateReduced = $row['transactionDate']; //date('F d, Y',$dateString); //$row['dateReduced'];
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
                            <!-- Coop Number -->
                            <div class="form-group mb-3">
                            <label for="coopNumber" class="mb-2 text-dark">Coop Number</label>
                                <select class="form-select" name="coopNumber" disabled>
                                    <?php

                                        //connect to the database
                                        include('../../../config/database_connection.php');

                                        //statement to select the all the medicine names
                                        $sql = "SELECT coopNumber FROM chickenproduction";
                                        $stmt = $conn->query($sql);
                                        if($stmt){
                                            if($stmt->rowCount() > 0){
                                                echo '<option value="' . $coopNumber . '">' . $coopNumber .'</option>';
                                                while($row = $stmt->fetch()){?>
                                                <option value="<?php echo $row['coopNumber']; ?>"> <?php echo $row['coopNumber']?> </option>
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
                                <span class="text-danger" style="font-size: small;"> <?php echo $coopNumber_err; ?> </span>
                                <!--<label for="coopNumber" class="mb-2 text-dark">Coop Number</label>
                                <input type="number" name="coopNumber" class="form-control" value="php echo $coopNumber; ?>">
                                <span class="text-danger" style="font-size: small;"> php echo $coopNumber_err; ?> </span>-->
                            </div>

                            <!-- Quantity -->
                            <div class="form-group mb-3">
                                <label for="quantity" class="mb-2 text-dark">Quantity</label>
                                <input type="number" name="quantity" class="form-control"value="<?php echo $quantity; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $updateQuantity_err; ?> </span>
                            </div>                            

                            <!-- Reduction Type -->
                            <div class="form-group mb-3">
                                <label for="reductionType" class="mb-2 text-dark">Reduction Type</label>
                                <select class="form-select" name="reductionType">
                                    <option value="<?php echo $reductionType; ?>"> <?php if(!empty($reductionType)){
                                        echo $reductionType;
                                    }else{
                                        echo "- select a breed type - ";
                                    } ?></option><!--
                                    <option value="Culled">Culled</option>
                                    <option value="Sold">Sold</option>
                                    <option value="Death">Death</option>
                                      -->
                                    <?php if($reductionType != "Culled") { ?>
                                        <option value="Culled">Culled</option>
                                    <?php } ?>
                                    <?php if($reductionType != "Sold") { ?>
                                        <option value="Sold">Sold</option>
                                    <?php } ?>
                                    <?php if($reductionType != "Death") { ?>
                                        <option value="Death">Death</option>
                                    <?php } ?>
                                </select>
                                <span class="text-danger" style="font-size: 13px;"> <?php echo $reductionType_err; ?> </span>
                            </div>
                    
                            <!-- Date Reduced -->
                            <div class="form-group mb-3">
                                <label for="dateReduced" class="mb-2 text-dark">Date Reduced</label>
                                <input type="date" min="2022-01-01" max="<?php echo date('Y-m-d'); ?>" name="dateReduced" class="form-control"value="<?php echo $dateReduced; ?>" required>
                                <span class="text-danger" style="font-size: 13px;"> <?php echo $dateReduced_err; ?> </span>
                            </div>

                        </div> 
                        <input type="hidden" name="coopNumber" value="<?php echo $coopNumber; ?>"/>
                        <input type="hidden" name="sex" value="<?php echo $sex; ?>"/>
                        <input type="hidden" name="chickenBatch_ID" value="<?php echo $chickenBatch_ID; ?>"/>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <div class="card-footer w-100 border d-flex justify-content-between">
                            <div class="w-100 m-1">
                                <a class="small btn  btn-outline-secondary fw-bold w-100" href="./chicken_reduction.php">
                                    Cancel
                                </a> 
                            </div>
                            <div class="w-100 m-1">
                                <button type="submit" name="submit" class="btn  btn-outline-success fw-bold w-100">
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
