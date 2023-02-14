<?php
    //page title
    $title = "Update Chicken Batch";
    
    //header
    include('../../includes/header.php');

    include('../action/update_chicken.php'); 
    
 
?>

<!-- content --> 
<div class="container-fluid px-4">
    <h1 class="mt-4"> Manager Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./chicken_production.php" class="text-decoration-none">Chicken Production</a>
        </li>
        <li class="breadcrumb-item active">Update Chicken Production</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-xl-6 col-md-6">
            <div class="card bg-light shadow-lg mb-4 ">
                <div class="card-header text-center p-3 fw-bold" style="background-color: #FFAF1A; color: #91452c">UPDATE CHICKEN BATCH</div>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                        <?php
                                //connect to the database
                                include('../../../config/database_connection.php');

                                $id = $_REQUEST['id'];
                                
                                //statement to select the specific chicken to update
                                $sql = "SELECT * FROM chickenproduction WHERE chickenBatch_ID = '$id'";
                                $stmt = $conn->query($sql);
                                if($stmt){
                                    if($stmt->rowCount() > 0){
                                        while($row = $stmt->fetch()){
                                            $coopNumber = $row['coopNumber'];
                                            $batchName = $row['batchName'];
                                            $breedType = $row['breedType'];
                                            $batchPurpose = $row['batchPurpose'];
                                            $startingQuantity = $row['startingQuantity'];
                                            $inStock = $row['inStock'];
                                            $dateAcquired = $row['dateAcquired'];
                                            $acquisitionType = $row['acquisitionType'];
                                            $note = $row['note'];
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
                                <input type="number" name="coopNumber" class="form-control"value="<?php echo $coopNumber; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $coopNumber_err; ?> </span>
                            </div>

                            <!-- Batch Name -->
                            <div class="form-group mb-3">
                                <label for="batchName" class="mb-2 text-dark">Batch Name</label>
                                <input type="text" name="batchName" class="form-control"value="<?php echo $batchName; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $batchName_err; ?> </span>
                            </div>        
                                                
                            <!-- Breed Type -->
                            <div class="form-group mb-3">
                                <label for="breedType" class="mb-2 text-dark">Breed Type</label>
                                <select class="form-select" name="breedType">
                                    <option value="<?php echo $breedType; ?>"> <?php if(!empty($breedType)){
                                        echo $breedType;
                                    }else{
                                        echo "- select a breed type - ";
                                    } ?></option><!--
                                    <option value="Leghorns">Leghorns</option>
                                    <option value="Rhode Island Reds">Rhode Island Reds</option>
                                    <option value="Sussex">Sussex</option>
                                    <option value="Plymouth">Plymouth</option>
                                      -->
                                    <?php if($breedType != "Leghorns") { ?>
                                        <option value="Leghorns">Leghorns</option>
                                    <?php } ?>
                                    <?php if($breedType != "Rhode Island Reds") { ?>
                                        <option value="Rhode Island Reds">Rhode Island Reds</option>
                                    <?php } ?>
                                    <?php if($breedType != "Sussex") { ?>
                                        <option value="Sussex">Sussex</option>
                                    <?php } ?>
                                    <?php if($breedType != "Plymouth") { ?>
                                        <option value="Plymouth">Plymouth</option>
                                    <?php } ?>
                                    <!--  -->
                                </select>
                                <span class="text-danger" style="font-size: 13px;"> <?php echo $breedType_err; ?> </span>
                            </div>
                    
                            <!-- Batch Purpose -->
                            <div class="form-group mb-3">
                                <label for="batchPurpose" class="mb-2 text-dark">Batch Purpose</label>
                                <select class="form-select" name="batchPurpose">
                                    <option value="<?php echo $batchPurpose; ?>"> <?php if(!empty($batchPurpose)){
                                        echo $batchPurpose;
                                    }else{
                                        echo "- select a purpose - ";
                                    } ?></option><!-- 
                                    <option value="Meat">Meat</option>
                                    <option value="Layers">Layers</option>
                                    <option value="Breeding">Breeding</option>
                                     -->
                                    <?php if($batchPurpose != "Meat") { ?>
                                        <option value="Meat">Meat</option>
                                    <?php } ?>
                                    <?php if($batchPurpose != "Layers") { ?>
                                        <option value="Layers">Layers</option>
                                    <?php } ?>
                                    <?php if($batchPurpose != "Breeding") { ?>
                                        <option value="Breeding">Breeding</option>
                                    <?php } ?>
                                    <!--  -->
                                </select>
                                <span class="text-danger" style="font-size: 13px;"> <?php echo $batchPurpose_err; ?> </span>
                            </div>

                            <!-- Starting Quantity -->
                            <div class="form-group mb-3">
                                <label for="startingQuantity" class="mb-2 text-dark">Starting Quantity</label>
                                <input type="number" name="startingQuantity" class="form-control" value="<?php echo $startingQuantity; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $startingQuantity_err; ?> </span>
                            </div>
                            
                            <!-- inStock Quantity -->
                            <div class="form-group mb-3">
                                <label for="inStock" class="mb-2 text-dark">In Stock Quantity</label>
                                <input type="number" name="inStock" class="form-control" value="<?php echo $inStock; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $inStock_err; ?> </span>
                            </div>

                            <!-- Date Acquired -->
                            <div class="form-group mb-3">
                                <label for="dateAcquired" class="mb-2 text-dark">Date Acquired</label>
                                <input type="date" name="dateAcquired" class="form-control" value="<?php echo $dateAcquired; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $dateAcquired_err; ?> </span>
                            </div>

                            <!-- Acquisition Type-->
                            <div class="form-group mb-3">
                                <label for="acquisitionType" class="mb-2 text-dark">Acquisition Type</label>
                                <select class="form-select" name="acquisitionType">
                                    <option value="<?php echo $acquisitionType; ?>"> <?php if(!empty($acquisitionType)){
                                        echo $acquisitionType;
                                    }else{
                                        echo "- select a unit - ";
                                    } ?></option>
                                    <!--
                                    <option value="Hatched on Farm">Hatched on Farm</option>
                                    <option value="Purchased">Purchased</option>
                                      -->
                                    <?php if($acquisitionType != "Hatched on Farm") { ?>
                                        <option value="Hatched on Farm">Hatched on Farm</option>
                                    <?php } ?>
                                    <?php if($acquisitionType != "Purchased") { ?>
                                        <option value="Purchased">Purchased</option>
                                    <?php } ?>
                                </select>
                                <span class="text-danger" style="font-size: 13px;"> <?php echo $acquisitionType_err; ?> </span>
                            </div>
                               
                            <!-- Note -->
                            <div class="form-group mb-3">
                                <label for="note" class="mb-2 text-dark">Note <span style="font-size: 13px">(optional)</span></label>
                                <textarea class="form-control" name="note" rows="3"><?php echo $note; ?></textarea>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $note_err; ?> </span>
                            </div>

                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <div class="card-footer w-100 border d-flex justify-content-end">
                            <div class="w-100 m-1">
                                <a class="btn  btn-outline-danger fw-bold w-100" href="./chicken_production.php">
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

