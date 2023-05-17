<?php
    //title of the pge
    $title = "Delete Medicine";

    include("../../includes/header.php");

    //database connection, located in the config directory
    include('../../../config/database_connection.php');

    $id = $_REQUEST['id'];
    
    //statement to select the specific schedule to update
    $sql = "SELECT * FROM medicinetransaction WHERE transaction_ID = '$id'";
    $stmt = $conn->query($sql);
    if($stmt){
        if($stmt->rowCount() > 0){
            while($row = $stmt->fetch()){
                // $medicineType = $row['medicineType'];
                $medicineName = $row['medicineName'];
                $quantity = $row['quantity'];
                $dateAdded = $row['transactionDate'];
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
    unset($pdo);

    try{
        
        //processing the data from the form submitted
        if(isset($_POST['archiveRecord'])){
            $id = $_POST['id'];
                // $archived = 'not archived';

            // Prepare an insert statement
            $sql = "BEGIN;
            DELETE FROM medicinetransaction WHERE transaction_ID = '$id';
            COMMIT;
            ";
            
            if($stmt = $conn->prepare($sql))
            {

                // Attempt to execute the prepared statement
                if($stmt->execute())
                {
                    $_SESSION['status'] = "Record Successfully Deleted";
                    header("Location: medicines.php");
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
    <h1 class="mt-4"> Manager Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./medicines.php" style="text-decoration: none">Medicine Inventory</a>
        </li>
        <li class="breadcrumb-item active">Medicine Details</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-sm-4">
            <div class="card bg-light shadow-lg mb-4 ">
                <div class="card-header text-center fw-bold p-3" style="background-color: #FFAF1A; color: #91452c">
                    <div class="text-center">Are you sure you want to restore this record?</div>
                </div>

                <div class="card-body p-4">
                    <!-- egg batch id -->
                    <div class="mb-3">
                        <p class="fw-bold">Medicine Name: <span class="fw-normal ps-2"><?php echo $medicineName; ?></span></p>
                    </div>
                    
                    <!-- Note -->
                    <div class="mb-3">
                        <p class="fw-bold">In Stock: <span class="fw-normal ps-2"><?php echo $quantity; ?></span></p>
                    </div>

                        <!-- Note -->
                    <div class="mb-3">
                        <p class="fw-bold">Date Added: <span class="fw-normal ps-2"><?php echo $dateAdded; ?></span></p>
                    </div>

                        <!-- Note -->
                    <div class="mb-3">
                        <p class="fw-bold">Expiration Date: <span class="fw-normal ps-2"><?php echo $expirationDate; ?></span></p>
                    </div>

                </div>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <div class="card-footer w-100 border d-flex justify-content-between">
                        <div class="w-100 m-1">
                            <a class="small btn btn-outline-secondary fw-bold w-100" href="./medicines.php">
                                Cancel
                            </a> 
                        </div>
                        <div class="w-100 m-1">
                            <button type="button" name="archiveRecord" class="btn  btn-outline-danger  fw-bold w-100" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Delete
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
                                <h1 class="modal-title fs-6 ms-1" id="exampleModalLabel">Permanently Delete Record?</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body"> Once deleted, the record cannot be retrieved or restored.
                            </div>
                            <div class="modal-footer">
                                <div class="w-100    d-flex justify-content-between">
                                    <div class="w-100 m-1">
                                        <button type="button" class="btn fw-bold w-100 btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
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
