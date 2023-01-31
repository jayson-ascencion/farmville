<?php
    //page title
    $title ="Employee Dashboard";
    
    //header
    include('../../includes/header.php');

    //update php code
    include('./query/update_query.php');

    $title = "Update Status";
?>

<!-- content --> 
<div class="container-fluid px-4">
    <h1 class="mt-4"> Employee Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./completed_schedules.php">Completed Schedules</a>
        </li>
        <li class="breadcrumb-item active">Update Schedule</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-xl-6 col-md-6">
            <div class="card bg-light shadow-lg mb-4">
                <div class="card-header text-center"> Update Status</div>
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" id="updateForm">

                        <!-- card to display success message after creating a user -->
                        <?php
                        if(!empty($success)){?>
                            <div>
                                <span class="alert alert-success d-flex align-items-center justify-content-center" role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                    </svg>                                            
                                    <div class="text-center ml-5">
                                        <?php echo $success ?>
                                    </div>
                                </span>
                            </div>
                        <?php
                        }
                        ?>

                        <?php
                            //connect to the database
                            include('../../../config/dbconfig.php');

                            $id = $_REQUEST['id'];
                            
                            //statement to select the specific schedule to update
                            $sql = "SELECT * FROM medicineadministration WHERE administration_ID = '$id'";
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
                        
                        <div class="form-group mb-3">
                            <label for="contact_num" class="mb-2 text-dark">Status</label>
                            <select class="form-select" name="status">
                                <option value="" selected disabled> <?php echo $status; ?></option>
                                <option value="pending">pending</option>
                            </select>
                            <span class="text-danger" style="font-size: small;"> <?php ?> </span>
                        </div>
                        
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <div class="card-footer w-100 border d-flex justify-content-end">
                    <div>
                    <a class="small text-white btn btn-outline-danger" onclick="history.back()">
                        
                            Cancel
                        
                    </a>
                        
                        <button type="submit" form="updateForm" name="updateStatus" class="btn btn-primary">
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
