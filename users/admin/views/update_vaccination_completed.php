<?php
    //page title
    $title = "Update Schedule";
    
    //header
    include('../../includes/header.php');

    //include the update script
    include('../action/update_vaccination.php'); 
    
?>

<!-- content --> 
<div class="container-fluid px-4">
    <h1 class="mt-4"> Administrator Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a class="text-decoration-none" href="./vaccination_pending.php">Vaccination Schedules</a>
        </li>
        <li class="breadcrumb-item active">Update Schedule</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-xl-6 col-md-6">
            <div class="card bg-light shadow-lg mb-4">
                <div class="card-header text-center fw-bold p-3"  style="background-color: #FFAF1A; color: #91452c">UPDATE VACCINATION SCHEDULE</div>
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">

                        <?php
                            //connect to the database
                            include('../../../config/database_connection.php');

                            //store the id apss to the id var
                            $id = $_REQUEST['id'];
                            
                            //statement to select the specific schedule to update
                            $sql = "SELECT * FROM schedules WHERE administration_ID = '$id'";
                            $stmt = $conn->query($sql);
                            if($stmt){
                                if($stmt->rowCount() > 0){
                                    while($row = $stmt->fetch()){
                                    $chickenBatch_ID = $row['chickenBatch_ID'];
                                    $coopNumber = $row['coopNumber'];
                                    $medicine_ID = $row['medicine_ID'];
                                    $medicineName = $row['medicineName'];
                                    $methodType = $row['methodType'];
                                    $dosage = $row['dosage'];
                                    $numberHeads = $row['numberHeads'];
                                    $administrationSched = $row['administrationSched'];
                                    $administeredBy = $row['administeredBy'];
                                    $status = $row['status'];
                                    $notes = $row['notes'];
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

                            $sql = "SELECT username FROM users WHERE user_ID = '$administeredBy'";
                            $stmt = $conn->query($sql);
                            if($stmt){
                                if($stmt->rowCount() > 0){
                                    while($row = $stmt->fetch()){
                                        $employee = $row['username'];
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
                                    unset($pdo);

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
                                    unset($pdo);

                                ?>
                            </select>
                            <span class="text-danger" style="font-size: small;"> <?php echo $medicine_ID_err; ?> </span>
                        </div>

                        <!-- VACCINATION TYPE -->
                        <div class="form-group w-100 mb-3">
                            <label for="methodType" class="mb-2 text-dark">Vaccination Type</label>
                            <select class="form-select" name="methodType">
                                <option value="<?php echo $methodType; ?>">
                                    <?php
                                    if(!empty($methodType)){
                                        echo $methodType;
                                    }else{
                                        echo "- select a schedules type  -";
                                    }
                                    ?>
                                <option value="Injection"> Injection</option>
                                <option value="Eye Drop">Eye Drop</option>
                                <option value="Nose Drop">Nose Drop</option>
                                <option value="Spray"> Spray</option>
                            </select>
                            <span class="text-danger" style="font-size: small;"> <?php echo $methodType_err; ?> </span>
                        </div>

                        <!-- DOSAGE -->
                        <div class="form-group w-100 mb-3">
                            <label for="dosage" class="mb-2 text-dark">Number of Heads</label>
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
                                        echo $employee;
                                    }else{
                                        echo "- select an employee  -";
                                    }
                                    ?>
                                </option>
                                <?php

                                    //connect to the database
                                    include('../../../config/database_connection.php');
                                    
                                    //statement to select the all the medicine names
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
                                    unset($pdo);

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

                        <!-- STATUS -->
                        <div class="form-group mb-3">
                            <label for="status" class="mb-2 text-dark">Status</label>
                            <select class="form-select" name="status">
                                <option value="<?php echo $status; ?>">
                                    <?php
                                    if(!empty($status)){
                                        echo $status;
                                    }else{
                                        echo "- select an employee  -";
                                    }
                                ?>
                                <!-- <option value="completed">completed</option>
                                <option value="pending">pending</option> -->
                                <?php if($status != "completed") { ?>
                                    <option value="completed">completed</option>
                                <?php } ?>
                                <?php if($status != "pending") { ?>
                                    <option value="pending">pending</option>
                                <?php } ?>
                            </select>
                            <span class="text-danger" style="font-size: small;"> <?php echo $status_err; ?> </span>
                        </div>
                        
                         
                    </div>

                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <input type="hidden" name="update_type" value="completed"/>

                    <div class="card-footer w-100 border d-flex justify-content-end">
                        <div class="m-1 w-100">
                            <a class="btn btn-outline-secondary fw-bold w-100" href="./vaccination_completed.php"> Cancel </a> 
                        </div>
                        <div class="m-1 w-100">
                            <button type="submit" name="updateVaccination" class="btn btn-outline-success fw-bold w-100">
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
