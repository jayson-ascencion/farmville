<?php
    //page title
    $title = "Add New Medicine";
    
    //header
    include('../../includes/header.php');

    //save medicine action
    include('../action/save_medicine.php'); 
    
 
?>

<!-- content --> 
<div class="container-fluid px-4">
    <h1 class="mt-4"> Manager Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./medicines.php" style="text-decoration: none">Medicines Inventory</a>
        </li>
        <li class="breadcrumb-item active">Add New Medicine</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-xl-6 col-md-6">
            <div class="card  bg-light shadow-lg mb-4">
                <div class="card-header text-center fw-bold p-3" style="background-color: #FFAF1A; color: #91452c">ADD NEW MEDICINE</div>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" novalidate>
                        <div class="card-body p-4">
                            <!-- Medicine Type -->
                            <div class="form-group mb-3">
                                <label for="medicineType" class="mb-2 text-dark">Medicine Type</label>
                                <select class="form-select" name="medicineType">
                                    <?php
                                        if(empty($medicineType)){
                                            echo '<option value="">- select a medicine type -</option>';
                                        }else{
                                            ?>
                                                <option value="<?php echo $medicineType; ?>"><?php echo $medicineType; ?></option>';
                                            <?php
                                        }
                                    ?>
                                    <option value="Medication">Medication</option>
                                    <option value="Vaccination">Vaccination</option>
                                </select>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $medicineType_err; ?> </span>
                            </div>

                            <!-- Medicine Name -->
                            <div class="form-group mb-3">
                                <label for="medicineName" class="mb-2 text-dark">Medicine Name</label>
                                <input type="text" name="medicineName" class="form-control" value="<?php echo $medicineName; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $medicineName_err; ?> </span>
                            </div>                            

                            <!-- Medicine Brand -->
                            <div class="form-group mb-3">
                                <label for="medicineBrand" class="mb-2 text-dark">Medicine Brand </label>
                                <input type="text" name="medicineBrand" class="form-control" value="<?php echo $medicineBrand; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $medicineBrand_err; ?> </span>
                            </div>
                    
                            <!-- Medicine For -->
                            <div class="form-group mb-3">
                                <label for="medicineFor" class="mb-2 text-dark">Medicine For: </label>
                                <select class="form-select" name="medicineFor">
                                    <?php
                                        if(empty($medicineFor)){
                                            echo '<option value="">- select medicine for -</option>';
                                        }else{
                                            ?>
                                                <option value="<?php echo $medicineFor; ?>"><?php echo $medicineFor; ?></option>';
                                            <?php
                                        }
                                    ?>
                                    <option value="Newcastle's Disease">Newcastle's Disease</option>
                                    <option value="Infectious Bronchitis">Infectious Bronchitis</option>
                                    <option value="Avian Influenza">Avian Influenza</option>
                                    <option value="Fowl Pox">Fowl Pox</option>
                                    <option value="Avian Malaria">Avian Malaria</option>
                                    <option value="Marek's Disease">Marek's Disease</option>
                                    <option value="Colibacillosis">Colibacillosis</option>
                                    <option value="Coccidiosis">Coccidiosis</option>
                                    <option value="Fowl Cholera">Fowl Cholera</option>
                                    <option value="Pullorum">Pullorum</option>
                                </select>
                                <span class="text-danger" style="font-size: 13px;"> <?php echo $medicineFor_err; ?> </span>
                            </div>

                            <!-- Starting Quantity -->
                            <div class="form-group mb-3">
                                <label for="startingQuantity" class="mb-2 text-dark">Starting Quantity <span style="font-size: 13px;">(without reductions)</span></label>
                                <input type="number" name="startingQuantity" class="form-control" value="<?php echo $startingQuantity; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $startingQuantity_err; ?> </span>
                            </div>
                            
                            <!-- inStock Quantity -->
                            <!-- <div class="form-group mb-3">
                                <label for="inStock" class="mb-2 text-dark">In Stock</label>
                                <input type="number" name="inStock" class="form-control" value=" echo $inStock; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">   echo $inStock_err; ?> </span>
                            </div> -->

                            <div class="d-flex flex-column flex-sm-column flex-lg-row gap-2">
                                <!-- Date Added -->
                                <div class="form-group w-100 mb-3">
                                    <label for="dateAdded" class="mb-2 text-dark">Date Added </label>
                                    <input type="date" min="2022-01-01" max="<?php echo date('Y-m-d'); ?>" name="dateAdded" class="form-control" value="<?php echo $dateAdded; ?>" required>
                                    <span class="text-danger" style="font-size: 13px;"> <?php echo $dateAdded_err; ?> </span>
                                </div>
                                    
                                <!-- Expiration Date -->
                                <div class="form-group w-100 mb-3">
                                    <label for="expirationDate" class="mb-2 text-dark">Expiration Date</label>
                                    <!-- <input type="date" min="2022-01-01" name="expirationDate" class="form-control" value=" echo $expirationDate; ?>" required> -->
                                    <input type="date" min="<?php echo date('Y-m-d'); ?>" name="expirationDate" class="form-control" value="<?php echo $expirationDate; ?>" required>
                                    <span class="text-danger" style="font-size: 13px;"> <?php echo $expirationDate_err; ?> </span>
                                </div>
                            </div>
                               
                        </div>
                        <div class="card-footer w-100 border d-flex justify-content-between">
                            <div class="m-1 w-100">
                                <a class="small fw-bold w-100 btn btn-outline-secondary" href="./medicines.php">
                                    Cancel
                                </a> 
                            </div>
                            <div class="m-1 w-100">
                                <button type="submit" name="submit" class="btn fw-bold w-100 btn-outline-success">
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
