<?php
    //title of the pge
    $title = "Delete Reduction";

    include("../../includes/header.php");

    //database connection, located in the config directory
    include('../../../config/database_connection.php');
    $id = $_REQUEST['id'];

    //this will hold the quantity before update
    $chickenBatch_ID = $coopNumber = $batchName = $quantity = $reductionType = $dateReduced = "";

     //statement to get the old quantity
     $sql = "SELECT * FROM chickentransaction WHERE transaction_ID = '$id'";
     $stmt = $conn->query($sql);
 
     if($stmt){
         if($stmt->rowCount() > 0){
             while($row = $stmt->fetch()){
                 //collect data from the form
                 $chickenBatch_ID = $row['chickenBatch_ID'];
                 $coopNumber = $row['coopNumber'];
                 $batchName = $row['batchName'];
                 $quantity = $row['quantity'];
                 $reductionType = $row['dispositionType'];
                 $note = $row['note'];
                 $sex = $row['sex'];
                 $dateString = strtotime($row['transactionDate']);
                 $dateReduced = date('F d, Y',$dateString); //$row['dateReduced'];
             }
             // Free result set
             unset($result);
         } else{
             echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
         }
     } else{
         echo "Oops! Something went wrong. Please try again later.";
     }

    try{
        
        //processing the data from the form submitted
        if(isset($_POST['archiveRecord'])){
            $id = $_POST['id'];
            // $archived = 'archived';

            if($sex =='Male'){
                // Prepare an insert statement
                $sql = "BEGIN;
                UPDATE chickenproduction SET inStock = inStock + $quantity, male = male + $quantity WHERE chickenBatch_ID = '$chickenBatch_ID';
                DELETE FROM chickentransaction WHERE transaction_ID = '$id';
                COMMIT;";
            }else{
                // Prepare an insert statement
                $sql = "BEGIN;
                UPDATE chickenproduction SET inStock = inStock + $quantity, female = female + $quantity WHERE chickenBatch_ID = '$chickenBatch_ID';
                DELETE FROM chickentransaction WHERE transaction_ID = '$id';
                COMMIT;";
            }
            
            
            if($stmt = $conn->prepare($sql))
            {
                // Bind variables to the prepared statement as parameters
                // $stmt->bindParam(":archived", $param_archived, PDO::PARAM_STR);
                
                // Set parameters
                // $param_archived = $archived;

                // Attempt to execute the prepared statement
                if($stmt->execute())
                {
                    $_SESSION['status'] = "Chicken Reduction Data is Successfully Deleted.";
                    header("Location: chicken_reduction.php");
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

<div class="container-fluid px-4">
    <h1 class="mt-4"> Employee Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./egg_production.php" style="text-decoration: none">Chicken Reduction</a>
        </li>
        <li class="breadcrumb-item active">Chicken Reduction Details</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-sm-4">
            <div class="card bg-light shadow-lg mb-4 ">
                <div class="card-header text-center fw-bold p-3" style="background-color: #FFAF1A; color: #91452c"><div class=" text-center ">Are you sure you want to delete this record?</div> </div>
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                        <div class="card-body p-4">
                               <!-- egg Size -->
                               <div class="mb-3">
                                <p class="fw-bold">Coop Number: <span class="fw-normal ps-2"><?php echo $coopNumber; ?></span></p>
                            </div>
                    
                            <!-- Batch Name -->
                            <div class="mb-3">
                                <p class="fw-bold">Batch Name: <span class="fw-normal ps-2"><?php echo $batchName; ?></span></p>
                            </div>
                    
                            <!-- Quantity -->
                            <div class="mb-3">
                                <p class="fw-bold">Sex: <span class="fw-normal ps-2"><?php echo $sex; ?></span></p>
                            </div>
                    
                            <!-- Quantity -->
                            <div class="mb-3">
                                <p class="fw-bold">Quantity: <span class="fw-normal ps-2"><?php echo $quantity; ?></span></p>
                            </div>

                            <!-- Collection Type -->
                            <div class="mb-3">
                                <p class="fw-bold">Reduction Type: <span class="fw-normal ps-2"><?php echo $reductionType; ?></span></p>
                            </div>

                            
                            <!-- Collection Date -->
                            <div class="mb-3">
                                <p class="fw-bold">Date Reduced: <span class="fw-normal ps-2"><?php echo $dateReduced; ?></span></p>
                            </div>

                            <!-- Collection Date -->
                            <div class="mb-3">
                                <p class="fw-bold">Note: <span class="fw-normal ps-2"><?php echo $note; ?></span></p>
                            </div>


                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <!-- <div class="card-footer w-100 border d-flex justify-content-between">
                            <div class="w-100 m-1">
                                <a class="btn  btn-outline-secondary fw-bold w-100" href="./chicken_reduction.php">
                                    Cancel
                                </a> 
                            </div>
                            <div class="w-100 m-1">
                                <button type="submit" name="archiveRecord" class="btn  btn-outline-danger fw-bold w-100">
                                    Delete
                                </button>                                    
                            </div>
                        </div> -->

                        <div class="card-footer w-100 border d-flex justify-content-between">
                            <div class="w-100 m-1">
                                <a class="small btn btn-outline-secondary fw-bold w-100" href="./chicken_reduction.php">
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
                                <div class="modal-body"> Once a record is deleted, it cannot be restored or retrieved. The corresponding quantity will revert back to the inventory in stock.
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
    include("../../includes/footer.php");
    
    include("../../includes/scripts.php");
    

?>