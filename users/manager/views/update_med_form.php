<?php
    //page title
    $title = "Update Medicine";
    
    //header
    include('../../includes/header.php');

    include('../action/update_medicine.php'); 
    
 
?>

<!-- content --> 
<div class="container-fluid px-4">
    <h1 class="mt-4"> Manager Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./medicines.php" style="text-decoration: none">Medicines Inventory</a>
        </li>
        <li class="breadcrumb-item active">Update Medicine Details</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-xl-6 col-md-6">
            <div class="card bg-light shadow-lg mb-4 ">
                <div class="card-header text-center fw-bold p-3" style="background-color: #f37e57">UPDATE MEDICINE DETAILS</div>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">

                        <!-- retrieves the data from the database based on the id -->
                        <?php
                            //connect to the database
                            include('../../../config/database_connection.php');

                            $id = $_REQUEST['id'];
                            
                            //statement to select the specific schedule to update
                            $sql = "SELECT * FROM medicines WHERE medicine_ID = '$id'";
                            $stmt = $conn->query($sql);
                            if($stmt){
                                if($stmt->rowCount() > 0){
                                    while($row = $stmt->fetch()){
                                        $medicineType = $row['medicineType'];
                                        $medicineName = $row['medicineName'];
                                        $medicineBrand = $row['medicineBrand'];
                                        $medicineFor = $row['medicineFor'];
                                        $startingQuantity = $row['startingQuantity'];
                                        $inStock = $row['inStock'];
                                        $dateAdded = $row['dateAdded'];
                                        $expirationDate = $row['expirationDate'];
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
                        ?>
                        <div class="card-body p-4">
                            <!-- Medicine Type -->
                            <div class="form-group mb-3">
                                <label for="medicineType" class="mb-2 text-dark">Medicine Type</label>
                                <select class="form-select" name="medicineType">
                                 <!-- <option value="< echo $medicineType; ?>" selected> -->
                                 <option value="<?php echo $medicineType; ?>"><?php echo $medicineType; ?></option>
                                    <!--  if(!empty($medicineType)){
                                        echo $medicineType;
                                    }else{
                                        echo "- select medicine type - ";
                                    } ?> -->
                                    <!-- </option> -->
                                    <!-- <option value="Medication">Medication</option>
                                    <option value="Vaccination">Vaccination</option> -->
                                    <?php if($medicineType != "Medication") { ?>
                                        <option value="Medication">Medication</option>
                                    <?php } ?>
                                    <?php if($medicineType != "Vaccination") { ?>
                                        <option value="Vaccination">Vaccination</option>
                                    <?php } ?>
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
                                                <option value="<?php echo $medicineFor; ?>" selected><?php echo $medicineFor; ?></option>';
                                            <?php
                                        }
                                    ?><!--
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
                                      -->
                                    <?php if($medicineFor != "Newcastle's Disease") { ?>
                                        <option value="Newcastle's Disease">Newcastle's Disease</option>
                                    <?php } ?>
                                    <?php if($medicineFor != "Infectious Bronchitis") { ?>
                                        <option value="Infectious Bronchitis">Infectious Bronchitis</option>
                                    <?php } ?>
                                    <?php if($medicineFor != "Avian Influenza") { ?>
                                        <option value="Avian Influenza">Avian Influenza</option>
                                    <?php } ?>
                                    <?php if($medicineFor != "Fowl Pox") { ?>
                                        <option value="Fowl Pox">Fowl Pox</option>
                                    <?php } ?>
                                    <?php if($medicineFor != "Avian Malaria") { ?>
                                        <option value="Avian Malaria">Avian Malaria</option>
                                    <?php } ?>
                                    <?php if($medicineFor != "Marek's Disease") { ?>
                                        <option value="Marek's Disease">Marek's Disease</option>
                                    <?php } ?>
                                    <?php if($medicineFor != "Colibacillosis") { ?>
                                        <option value="Colibacillosis">Colibacillosis</option>
                                    <?php } ?>
                                    <?php if($medicineFor != "Coccidiosis") { ?>
                                        <option value="Coccidiosis">Coccidiosis</option>
                                    <?php } ?>
                                    <?php if($medicineFor != "Fowl Cholera") { ?>
                                        <option value="Fowl Cholera">Fowl Cholera</option>
                                    <?php } ?>
                                    <?php if($medicineFor != "Pullorum") { ?>
                                        <option value="Pullorum">Pullorum</option>
                                    <?php } ?>
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
                            <div class="form-group mb-3">
                                <label for="inStock" class="mb-2 text-dark">In Stock</label>
                                <input type="number" name="inStock" class="form-control" value="<?php echo $inStock; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $inStock_err; ?> </span>
                            </div>

                            <div class="d-flex flex-column flex-sm-column flex-lg-row gap-2">
                                <!-- Date Added -->
                                <div class="form-group w-100 mb-3">
                                    <label for="dateAdded" class="mb-2 text-dark">Date Added </label>
                                    <input type="date" name="dateAdded" class="form-control" value="<?php echo $dateAdded; ?>" required>
                                    <span class="text-danger" style="font-size: 13px;"> <?php echo $dateAdded_err; ?> </span>
                                </div>
                                    
                                <!-- Expiration Date -->
                                <div class="form-group w-100 mb-3">
                                    <label for="expirationDate" class="mb-2 text-dark">Expiration Date</label>
                                    <input type="date" name="expirationDate" class="form-control" value="<?php echo $expirationDate; ?>" required>
                                    <span class="text-danger" style="font-size: 13px;"> <?php echo $expirationDate_err; ?> </span>
                                </div>
                            </div>
                               
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <div class="card-footer w-100 border d-flex justify-content-between">
                            <div class="m-1 w-100">
                                <a class="small btn btn-outline-danger w-100 fw-bold" href="./medicines.php">
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
