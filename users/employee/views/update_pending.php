<?php
    //page title
    $title = "Update Status";
    
    //header
    include('../../includes/header.php');

    include('../action/update_action.php'); 
    
 
?>

<!-- content --> 
<div class="container-fluid px-4">
    <h1 class="mt-4"> Employee Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./pending_schedules.php">Pending Schedules</a>
        </li>
        <li class="breadcrumb-item active">Update Schedule</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-xl-6 col-md-6">
            <div class="card bg-light shadow-lg mb-4">
                <div class="card-header text-center"> Update Status</div>
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
                                    $medicineName = $row['medicineName'];
                                    $dosage = $row['dosage'];
                                    $schedule = $row['administrationSched'];
                                    $status = $row['status'];
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

                        <div class="form-group mb-3">
                            <label for="contact_num" class="mb-2 text-dark">Chicken Batch ID</label>
                            <input type="text" name="contact_num" class="form-control" placeholder="09123456789" value="<?php echo $chickenBatch_ID; ?>" disabled>
                        </div>

                        <div class="form-group mb-3">
                            <label for="contact_num" class="mb-2 text-dark">Coop Number</label>
                            <input type="text" name="contact_num" class="form-control" placeholder="09123456789" value="<?php echo $coopNumber; ?>" disabled>
                        </div>

                        <div class="form-group mb-3">
                            <label for="contact_num" class="mb-2 text-dark">Medicine Name</label>
                            <input type="text" name="contact_num" class="form-control" placeholder="09123456789" value="<?php echo $medicineName; ?>" disabled>
                        </div>

                        <div class="form-group mb-3">
                            <label for="contact_num" class="mb-2 text-dark">Dosage</label>
                            <input type="text" name="contact_num" class="form-control" placeholder="09123456789" value="<?php echo $dosage; ?>" disabled>
                        </div>

                        <div class="form-group mb-3">
                            <label for="contact_num" class="mb-2 text-dark">Administration Schedule</label>
                            <input type="text" name="contact_num" class="form-control" placeholder="09123456789" value="<?php echo $schedule; ?>" disabled>
                        </div>
                        
                        <?php
                        if(empty($success)){
                            ?>
                            <div class="form-group mb-3">
                            <label for="contact_num" class="mb-2 text-dark">Status</label>
                            <select class="form-select" name="status">
                                <option value="<?php echo $status; ?>" selected disabled> <?php echo $status; ?></option>
                                <option value="completed">completed</option>
                            </select>
                            <span class="text-danger" style="font-size: small;"> <?php echo $status_err; ?> </span>
                        </div>
                            <?php
                        }else{
                            ?>
                            <div class="form-group mb-3">
                            <label for="contact_num" class="mb-2 text-dark">Status</label>
                            <select class="form-select" name="status" disabled>
                                <option value="" selected> <?php echo $status; ?></option>
                                <option value="completed">completed</option>
                            </select>
                            <span class="text-danger" style="font-size: small;"> <?php ?> </span>
                        </div>
                            <?php
                        }

                        ?>
                        
                        
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <div class="card-footer w-100 border d-flex justify-content-end">
                    <div>
                    <a class="small text-white btn btn-outline-secondary" href="./pending_schedules.php">
                        
                            Cancel
                        
                    </a> 
                        
                        <button type="submit" name="updateStatus" class="btn btn-primary">
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
