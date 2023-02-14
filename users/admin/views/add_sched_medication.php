<?php
    //page title
    $title ="Medication Schedule";
    
    //header
    include('../../includes/header.php');

    //include save script
    include('../action/save_medication.php');
?>

<!-- content --> 
<div class="container-fluid px-4">
    <h1 class="mt-4"> Admin Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a class="text-decoration-none" href="medication_pending.php">Medication Schedules</a>
        </li>
        <li class="breadcrumb-item active">Add New Schedule</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-xl-6 col-md-6">
            <div class="card bg-light shadow-lg mb-4">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                    <div class="card-header text-center fw-bold p-3"  style="background-color: #FFAF1A; color: #91452c"> ADD MEDICATION SCHEDULE </div>
                    <div class="card-body">
                        <!-- CHICKEN BATCH ID -->
                        <div class="form-group mb-3">
                            <label for="chickenBatch_ID" class="mb-2 text-dark">Chicken Batch ID</label>
                            <select class="form-select" name="chickenBatch_ID">
                                <option value="<?php echo $chickenBatch_ID; ?>">
                                    <?php
                                        if(!empty($chickenBatch_ID)){
                                            echo $chickenBatch_ID;
                                        }else{
                                            echo "- select a batch id -";
                                        }
                                    ?>
                                </option>
                                <?php

                                    //connect to the database
                                    include('../../../config/database_connection.php');

                                    //statement to select the all the medicine names
                                    $sql = "SELECT chickenBatch_ID FROM chickenproduction";
                                    $stmt = $conn->query($sql);
                                    if($stmt){
                                        if($stmt->rowCount() > 0){
                                            while($row = $stmt->fetch()){?>
                                             <option value="<?php echo $row['chickenBatch_ID']; ?>"> <?php echo $row['chickenBatch_ID']; ?> </option>
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
                            <span class="text-danger" style="font-size: small;"> <?php echo $chickenBatch_err; ?> </span>
                        </div>

                        <!-- MEDICINE ID / NAME -->
                        <div class="form-group mb-3">
                            <label for="medicine_ID" class="mb-2 text-dark">Medicine Name</label>
                            <select class="form-select" name="medicine_ID" required>
                                <option value="<?php echo $medicine_ID; ?>">
                                    <?php
                                    if(!empty($medicine_ID)){
                                        echo $medicineName;
                                    }else{
                                        echo "- select a medicine name -";
                                    }
                                    ?>
                                </option>
                                <?php

                                    //connect to the database
                                    include('../../../config/database_connection.php');

                                    //statement to select the all the medicine names
                                    $sql = "SELECT medicineName, medicine_ID FROM medicines";
                                    $stmt = $conn->query($sql);
                                    if($stmt){
                                        if($stmt->rowCount() > 0){
                                            while($row = $stmt->fetch()){?>
                                            <option value="<?php echo $row['medicine_ID']; ?>"> <?php echo $row["medicineName"];?> </option>
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
                            <span class="text-danger" style="font-size: small;"> <?php echo $medicine_ID_err; ?> </span>
                        </div>

                        <!-- MEDICATION TYPE -->
                        <div class="form-group w-100 mb-3">
                            <label for="methodType" class="mb-2 text-dark">Method Type</label>
                            <select class="form-select" name="methodType">
                                <option value="<?php echo $methodType; ?>">
                                    <?php
                                    if(!empty($methodType)){
                                        echo $methodType;
                                    }else{
                                        echo "- select a medication type  -";
                                    }
                                    ?>
                                <option value="Diluted in Water"> Diluted in Water</option>
                                <option value="Handfed">Handfed</option>
                                <option value="Injected"> Injected</option>
                            </select>
                            <span class="text-danger" style="font-size: small;"> <?php echo $methodType_err; ?> </span>
                        </div>

                        <!-- DOSAGE -->
                        <div class="form-group w-100 mb-3">
                            <label for="dosage" class="mb-2 text-dark">Dosage</label>
                            <input type="number" name="dosage" class="form-control" value="<?php echo $dosage ?>">
                            <span class="text-danger" style="font-size: small;"> <?php echo $dosage_err; ?> </span>
                        </div>

                        <!-- NUMBER OF HEADS -->
                        <div class="form-group w-100 mb-3">
                            <label for="numberHeads" class="mb-2 text-dark">Number of Heads</label>
                            <input type="number" name="numberHeads" class="form-control" value="<?php echo $numberHeads ?>">
                            <span class="text-danger" style="font-size: small;"> <?php echo $numberHeads_err; ?> </span>
                        </div>

                        <!-- DATE OF VACCINATION -->
                        <div class="form-group mb-3">
                            <label for="administrationSched" class="mb-2 text-dark">Administration Schedule</label>
                            <input type="date" name="administrationSched" class="form-control" value="<?php echo $administrationSched ?>">
                            <span class="text-danger" style="font-size: small;"> <?php echo $administrationSched_err; ?> </span>
                        </div>

                        <!-- ADMINISTERED BY -->
                        <div class="form-group mb-3">
                            <label for="administeredBy" class="mb-2 text-dark">Administered By</label>
                            <select class="form-select" name="administeredBy" required>
                                <option value="<?php echo $administeredBy; ?>">
                                    <?php
                                    if(!empty($administeredBy)){
                                        echo $administeredBy;
                                    }else{
                                        echo "- select an employee  -";
                                    }
                                    ?>
                                </option>
                                <?php

                                    //connect to the database
                                    include('../../../config/database_connection.php');
                                    
                                    //statement to select the all the  employees
                                    $sql = "SELECT user_ID, username FROM users WHERE role='3'";
                                    $stmt = $conn->query($sql);
                                    if($stmt){
                                        if($stmt->rowCount() > 0){
                                            while($row = $stmt->fetch()){?>
                                            <option value="<?php echo $row['user_ID']; ?>"> <?php echo $row["username"];?> </option>
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
                            <span class="text-danger" style="font-size: small;"> <?php echo $administeredBy_err; ?> </span>
                        </div>

                        <!-- NOTES -->
                        <div class="form-group mb-3">
                            <label for="notes" class="mb-2 text-dark">Note <span style="font-size: 13px">(optional)</span></label>
                            <textarea class="form-control" name="notes" rows="3" value="<?php echo $notes; ?>"><?php echo $notes; ?></textarea>
                            <span class="text-danger" style="font-size: 13px;">  <?php echo $notes_err; ?> </span>
                        </div>

                        <!-- STATUS
                        <div class="form-group mb-3">
                            <label for="status" class="mb-2 text-dark">Status</label>
                            <select class="form-select" name="status">
                                <option value=" echo $status; ?>">
                                    
                                    if(!empty($status)){
                                        echo $status;
                                    }else{
                                        echo "- select a status  -";
                                    }
                                ?>
                                <option value="completed">completed</option>
                                <option value="pending">pending</option>
                            </select>
                            <span class="text-danger" style="font-size: small;">  echo $status_err; ?> </span>
                        </div> -->
                        <input type="hidden" value="pending" name="status">
                    </div>   
                    
                    <div class="card-footer w-100 d-flex justify-content-between">
                        <div class="m-1 w-100">
                            <a href="medication_pending.php" class="btn fw-bold btn-outline-secondary w-100"> Cancel</a>
                        </div>
                        <div class="m-1 w-100">
                            <button class="btn btn-outline-success fw-bold ml-1 w-100" type="submit" name="submit">Save</button>
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