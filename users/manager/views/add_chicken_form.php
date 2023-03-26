<?php
    //page title
    $title = "Add Chicken Batch";
    
    //header
    include('../../includes/header.php');

    //save chicken action
    include('../action/save_chicken.php'); 
    
 
?>

<!-- content --> 
<div class="container-fluid px-4">
    <h1 class="mt-4"> Manager Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./chicken_production.php" style="text-decoration: none">Chicken Production</a>
        </li>
        <li class="breadcrumb-item active">Add New Chicken Batch</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-xl-6 col-md-6">
            <div class="card bg-light shadow-lg mb-4 ">
                <div class="card-header text-center fw-bold p-3" style="background-color: #FFAF1A; color: #91452c">ADD CHICKEN BATCH</div>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" novalidate>
                        <div class="card-body p-4">
                             <!-- Age -->
                             <div class="form-group mb-3">
                                <label for="age" class="mb-2 text-dark">Age</label>
                                <input type="number" name="age" class="form-control" value="<?php echo $age; ?>">
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $age_err; ?> </span>
                            </div>

                            <!-- Coop Number -->
                            <div class="form-group mb-3">
                                <label for="coopNumber" class="mb-2 text-dark">Coop Number</label>
                                <input type="number" name="coopNumber" class="form-control" value="<?php echo $coopNumber; ?>" required>
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
                                    <?php
                                        if(empty($breedType)){
                                            echo '<option value="" selected>- select a breed type -</option>';
                                        }else{
                                            ?>
                                                <option value="<?php echo $breedType; ?>"selected><?php echo $breedType; ?></option>';
                                            <?php
                                        }
                                    ?>
                                    <option value="Leghorns">Leghorns</option>
                                    <option value="Rhode Island Reds">Rhode Island Reds</option>
                                    <option value="Sussex">Sussex</option>
                                    <option value="Plymouth">Plymouth</option>
                                </select>
                                <span class="text-danger" style="font-size: 13px;"> <?php echo $breedType_err; ?> </span>
                            </div>
                    
                            <!-- Batch Purpose -->
                            <div class="form-group mb-3">
                                <label for="batchPurpose" class="mb-2 text-dark">Batch Purpose</label>
                                <select class="form-select" name="batchPurpose">
                                    <?php
                                        if(empty($batchPurpose)){
                                            echo '<option value="" selected>- select a batch purpose -</option>';
                                        }else{
                                            ?>
                                                <option value="<?php echo $batchPurpose; ?>"selected><?php echo $batchPurpose; ?></option>';
                                            <?php
                                        }
                                    ?>
                                    <option value="Meat">Meat</option>
                                    <option value="Layers">Layers</option>
                                    <option value="Breeding">Breeding</option>
                                </select>
                                <span class="text-danger" style="font-size: 13px;"> <?php echo $batchPurpose_err; ?> </span>
                            </div>
 
                            <!-- Starting Quantity -->
                            <div class="form-group mb-3">
                                <label for="startingQuantity" class="mb-2 text-dark">Quantity</label>
                                <input type="number" name="startingQuantity" class="form-control" value="<?php echo $startingQuantity; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $startingQuantity_err; ?> </span>
                            </div>
                            
                            <!-- Date Acquired -->
                            <div class="form-group mb-3">
                                <label for="dateAcquired" class="mb-2 text-dark">Date Acquired</label>
                                <input type="date" min="2022-01-01" name="dateAcquired" class="form-control" value="<?php echo $dateAcquired; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $dateAcquired_err; ?> </span>
                            </div>

                            <!-- Acquisition Type-->
                            <div class="form-group mb-3">
                                <label for="acquisitionType" class="mb-2 text-dark">Acquisition Type</label>
                                <select class="form-select" name="acquisitionType">
                                    <?php
                                        if(empty($acquisitionType)){
                                            echo '<option value="" selected>- select an acquisition type -</option>';
                                        }else{
                                            ?>
                                                <option value="<?php echo $acquisitionType; ?>"selected><?php echo $acquisitionType; ?></option>';
                                            <?php
                                        }
                                    ?>
                                    <option value="Hatched on Farm">Hatched on Farm</option>
                                    <option value="Purchased">Purchased</option>
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
                        <div class="card-footer w-100 border d-flex justify-content-between">
                            <div class="w-100 m-1">
                                <a class="btn  btn-outline-secondary fw-bold w-100" href="./chicken_production.php">
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
