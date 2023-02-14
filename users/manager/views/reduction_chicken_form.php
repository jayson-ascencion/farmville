<?php
    //page title
    $title = "Reduce Chicken";
    
    //header
    include('../../includes/header.php');

    include('../action/chicken_reduction.php'); 
  
?>
 
<!-- content --> 
<div class="container-fluid px-4">
    <h1 class="mt-4"> Manager Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./chicken_reduction.php" style="text-decoration: none">Chicken Reduction</a>
        </li>
        <li class="breadcrumb-item active">Add Chicken Reduction</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-xl-6 col-md-6">
            <div class="card bg-light  shadow-lg mb-4">
                <div class="card-header text-center p-3 fw-bold" style="background-color: #FFAF1A; color: #91452c">ADD CHICKEN REDUCTION</div>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                        <div class="card-body p-4">
                            <!-- Coop Number -->
                            <div class="form-group mb-3">
                                <label for="coopNumber" class="mb-2 text-dark">Coop Number</label>
                                <select class="form-select" name="coopNumber">
                                    <?php
                                        if(empty($coopNumber)){
                                            echo '<option value="" selected>- select a coop number -</option>';
                                        }else{
                                            ?>
                                                <option value="<?php echo $coopNumber; ?>"selected><?php echo $coopNumber; ?></option>';
                                            <?php
                                        }
                                    ?>
                                    <?php

                                        //connect to the database
                                        include('../../../config/database_connection.php');

                                        //statement to select the all the medicine names
                                        $sql = "SELECT coopNumber FROM chickenproduction WHERE archive='not archived'";
                                        $stmt = $conn->query($sql);
                                        if($stmt){
                                            if($stmt->rowCount() > 0){
                                                while($row = $stmt->fetch()){?>
                                                <option value="<?php echo $row['coopNumber']; ?>"> <?php echo $row['coopNumber']?> </option>
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
                                <span class="text-danger" style="font-size: small;"> <?php echo $coopNumber_err; ?> </span>
                            </div>

                            <!-- Quantity -->
                            <div class="form-group mb-3">
                                <label for="quantity" class="mb-2 text-dark">Quantity</label>
                                <input type="number" name="quantity" class="form-control"value="<?php echo $quantity; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $quantity_err; ?> </span>
                            </div>                            

                            <!-- Reduction Type -->
                            <div class="form-group mb-3">
                                <label for="reductionType" class="mb-2 text-dark">Reduction Type</label>
                                <select class="form-select" name="reductionType">
                                    <?php
                                        if(empty($reductionType)){
                                            echo '<option value="" selected>- select a reduction type -</option>';
                                        }else{
                                            ?>
                                                <option value="<?php echo $reductionType; ?>"selected><?php echo $reductionType; ?></option>';
                                            <?php
                                        }
                                    ?>
                                    <option value="Culled">Culled</option>
                                    <option value="Sold">Sold</option>
                                    <option value="Death">Death</option>
                                </select>
                                <span class="text-danger" style="font-size: 13px;"> <?php echo $reductionType_err; ?> </span>
                            </div>
                    
                            <!-- Date Reduced -->
                            <div class="form-group mb-3">
                                <label for="dateReduced" class="mb-2 text-dark">Date Reduced</label>
                                <input type="date" name="dateReduced" class="form-control"value="<?php echo $dateReduced; ?>" required>
                                <span class="text-danger" style="font-size: 13px;"> <?php echo $dateReduced_err; ?> </span>
                            </div>

                        </div>
                        <div class="card-footer w-100 border d-flex justify-content-between">
                            <div class="w-100 m-1">
                                <a class="btn  btn-outline-danger fw-bold w-100" href="./chicken_reduction.php">
                                    Cancel
                                </a> 
                            </div>
                            <div class="w-100 m-1">
                                <button type="submit" name="submit" class="btn  btn-outline-success fw-bold w-100">
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
