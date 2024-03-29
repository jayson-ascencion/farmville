<?php
    //page title
    $title = "Archive Schedule";
    
    //header
    include('../../includes/header.php');

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

    try{
        
        //processing the data from the form submitted
        if(isset($_POST['archiveRecord'])){
            $id = $_POST['id'];
            $archived = 'archived';

            // Prepare an insert statement
            $sql = "UPDATE schedules SET archive=:archived WHERE administration_ID = '$id'";
            
            if($stmt = $conn->prepare($sql))
            {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":archived", $param_archived, PDO::PARAM_STR);
                
                // Set parameters
                $param_archived = $archived;

                // Attempt to execute the prepared statement
                if($stmt->execute())
                {
                    $_SESSION['status'] = "Vaccination Schedule Successfully Archived."; 
                    header("Location: vaccination_completed.php");
                } 
                else
                {
                echo "Something went wrong. Please try again later.";
                }

                // Close statement
                unset($stmt);
            }
            
        
        }
        

    }catch(PDOException $e){
        echo ("Error: " . $e->getMessage());
    }

?>

<!-- content --> 
<div class="container-fluid px-4">
    <h1 class="mt-4"> Administrator Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a class="text-decoration-none" href="./vaccination_pending.php">Vaccination Schedules</a>
        </li>
        <li class="breadcrumb-item active">Archive Schedule</li>
    </ol>


    <div class="row justify-content-center mt-2">
        <div class="col-sm-4">
            <div class="card bg-light shadow-lg mb-4 ">
                <div class="card-header text-center fw-bold p-3"  style="background-color: #FFAF1A; color: #91452c">
                <div>Are you sure you want to Archive this record?</div>
            </div>
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                        <div class="card-body p-4">
                            <!-- CHICKEN BATCH ID -->
                            <div class="mb-3">
                                <p class="fw-bold">Chicken Batch ID: <span class="fw-normal ps-2"><?php echo $chickenBatch_ID; ?></span></p>
                            </div>

                            <!-- COOP NUMBER -->
                            <div class="mb-3">
                                <p class="fw-bold">Coop Number: <span class="fw-normal ps-2"><?php echo $coopNumber; ?></span></p>
                            </div>

                            <!-- MEDICINE ID -->
                            <div class="mb-3">
                                <p class="fw-bold">Medicine ID: <span class="fw-normal ps-2"><?php echo $medicine_ID; ?></span></p>
                            </div>

                            <!-- MEDICINE NAME -->
                            <div class="mb-3">
                                <p class="fw-bold">Medicine Name: <span class="fw-normal ps-2"><?php echo $medicineName; ?></span></p>
                            </div>

                            <!-- MEDICATION TYPE -->
                            <div class="mb-3">
                                <p class="fw-bold">Vaccination Type: <span class="fw-normal ps-2"><?php echo $methodType; ?></span></p>
                            </div>

                            <!-- DOSAGE -->
                            <div class="mb-3">
                                <p class="fw-bold">Dosage: <span class="fw-normal ps-2"><?php echo $dosage; ?></span></p>
                            </div>

                            <!-- NUMBER HEADS -->
                            <div class="mb-3">
                                <p class="fw-bold">Number of Heads: <span class="fw-normal ps-2"><?php echo $numberHeads; ?></span></p>
                            </div>

                            <!-- ADMINISTRATION SCHED -->
                            <div class="mb-3">
                                <p class="fw-bold">Schedule: <span class="fw-normal ps-2"><?php echo $administrationSched; ?></span></p>
                            </div>
                            <?php   
                            //statement to select the all the medicine names
                            $sql = "SELECT username FROM users WHERE user_ID = '$administeredBy'";
                            $stmt = $conn->query($sql);

                            if($stmt){
                                if($stmt->rowCount() > 0){
                                    while($row = $stmt->fetch()){
                                        $employee = $row['username'];
                                    }
                                    // Free result set
                                    unset($stmt);
                                } else{
                                    echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                                }
                            } else{
                                echo "Oops! Something went wrong. Please try again later.";
                            }
                            ?>
                            <!-- ADMINISTERED BY -->
                            <div class="mb-3">
                                <p class="fw-bold">Administered By: <span class="fw-normal ps-2"><?php echo $employee; ?></span></p>
                            </div>

                            <!-- STATUS -->
                            <div class="mb-3">
                                <p class="fw-bold">Status: <span class="fw-normal ps-2"><?php echo $status; ?></span></p>
                            </div>

                            <!-- NOTES -->
                            <div class="mb-3">
                                <p class="fw-bold">Notes: <span class="fw-normal ps-2"><?php echo $notes; ?></span></p>
                            </div>

                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <!-- <div class="card-footer w-100 border d-flex justify-content-between">
                            <div class="w-100 m-1">
                                <a class="small btn btn-outline-secondary fw-bold w-100" href="./vaccination_completed.php">
                                    Cancel
                                </a> 
                            </div>
                            <div class="w-100 m-1">
                                <button type="submit" name="archiveRecord" class="btn btn-outline-danger fw-bold w-100">
                                    Archive
                                </button>                                    
                            </div>
                        </div> -->

                        <div class="card-footer w-100 border d-flex justify-content-between">
                            <div class="w-100 m-1">
                                <a class="small btn btn-outline-secondary fw-bold w-100" href="./vaccination_completed.php">
                                    Cancel
                                </a> 
                            </div>
                            <div class="w-100 m-1">
                                <button type="button" name="archiveRecord" class="btn  btn-outline-danger  fw-bold w-100" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Archive
                                </button>                                    
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="orange" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                    </svg>
                                    <h1 class="modal-title fs-6 ms-1" id="exampleModalLabel">Archive Record?</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body"> Once archived, only the administrator can restore the record.
                                </div>
                                <div class="modal-footer">
                                    <div class="w-100    d-flex justify-content-between">
                                        <div class="w-100 m-1">
                                            <button type="button" class="btn w-100 fw-bold btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                        <div class="w-100 m-1">
                                            <button type="submit" name="archiveRecord" class="btn  btn-outline-danger fw-bold w-100" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            Yes
                                            </button>                                    
                                        </div>
                                    </div>
                                </div>
                                </div>
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
