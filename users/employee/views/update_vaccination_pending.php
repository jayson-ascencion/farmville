<?php
    //page title
    $title = "Update Vaccination";
    
    //header
    include('../../includes/header.php');

    include('../action/update_vaccination_pending.php'); 
    
 
?>

<!-- content --> 
<div class="container-fluid px-4">
    <h1 class="mt-4"> Employee Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a class="text-decoration-none" href="./vaccination_pending.php">Vaccination Schedules</a>
        </li>
        <li class="breadcrumb-item active">Update Schedule</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-xl-6 col-md-6">
            <div class="card bg-light shadow-lg mb-4">
                <div class="card-header text-center fw-bold p-3" style="background-color: #f37e57;">UPDATE VACCINATION STATUS</div>
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">

                        

                        <?php
                            //connect to the database
                            include('../../../config/database_connection.php');

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
                        ?>

                            <!-- CHICKEN BATCH ID -->
                            <div class="form-group mb-3">
                            <label for="chickenBatch_ID" class="mb-2 text-dark">Chicken Batch ID</label>
                            <select class="form-select" name="chickenBatch_ID" disabled>
                                <option value="<?php echo $chickenBatch_ID; ?>">
                                    <?php
                                        if(!empty($chickenBatch_ID)){
                                            echo $chickenBatch_ID;
                                        }else{
                                            echo "- select a batch id -";
                                        }
                                    ?>
                                </option>
                            </select>
                        </div>

                        <!-- MEDICINE ID / NAME -->
                        <div class="form-group mb-3">
                            <label for="medicine_ID" class="mb-2 text-dark">Medicine Name</label>
                            <select class="form-select" name="medicine_ID" disabled>
                                <option value="<?php echo $medicine_ID; ?>">
                                    <?php
                                    if(!empty($medicine_ID)){
                                        echo $medicineName;
                                    }else{
                                        echo "- select a medicine name -";
                                    }
                                    ?>
                                </option>
                            </select>
                        </div>

                        <!-- VACCINATION TYPE -->
                        <div class="form-group w-100 mb-3">
                            <label for="methodType" class="mb-2 text-dark">Vaccination Type</label>
                            <select class="form-select" name="methodType" disabled>
                                <option value="<?php echo $methodType; ?>">
                                    <?php
                                    if(!empty($methodType)){
                                        echo $methodType;
                                    }else{
                                        echo "- select a vaccination type  -";
                                    }
                                    ?>
                            </select>
                        </div>

                        <!-- DOSAGE -->
                        <div class="form-group w-100 mb-3">
                            <label for="dosage" class="mb-2 text-dark">Dosage</label>
                            <input type="number" name="dosage" class="form-control" value="<?php echo $dosage ?>" disabled>
                        </div>

                        <!-- NUMBER OF HEADS -->
                        <div class="form-group w-100 mb-3">
                            <label for="numberHeads" class="mb-2 text-dark">Number of Heads</label>
                            <input type="number" name="numberHeads" class="form-control" value="<?php echo $numberHeads ?>" disabled>
                        </div>

                        <!-- DATE OF VACCINATION -->
                        <div class="form-group mb-3">
                            <label for="administrationSched" class="mb-2 text-dark">Administration Schedule</label>
                            <input type="date" name="administrationSched" class="form-control" value="<?php echo $administrationSched ?>" disabled>
                        </div>

                        <!-- NOTES -->
                        <div class="form-group mb-3">
                            <label for="notes" class="mb-2 text-dark">Note <span style="font-size: 13px">(optional)</span></label>
                            <textarea class="form-control" name="notes" rows="3" value="<?php echo $notes; ?>" disabled><?php echo $notes; ?></textarea>
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
                                <option value="completed">completed</option>
                            </select>
                            <span class="text-danger" style="font-size: small;"> <?php echo $status_err; ?> </span>
                        </div>
                        
                        
                    </div>

                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>

                    <div class="card-footer w-100 border d-flex justify-content-end">
                        <div class="m-1 w-100">
                            <a class="btn btn-outline-danger fw-bold w-100" href="./vaccination_pending.php"> Cancel </a> 
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
