<?php
    //page title
    $title = "Update Medicine";
    
    //header
    include('../../includes/header.php');

    include('../action/update_medicine_replenishment.php'); 
    
 
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
                <div class="card-header text-center fw-bold p-3" style="background-color: #FFAF1A; color: #91452c">UPDATE MEDICINE DETAILS</div>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" novalidate>

                        <!-- retrieves the data from the database based on the id -->
                        <?php
                            //connect to the database
                            include('../../../config/database_connection.php');

                            $id = $_REQUEST['id'];
                            
                            //statement to select the specific schedule to update
                            $sql = "SELECT * FROM medicinetransaction WHERE transaction_ID = '$id'";
                            $stmt = $conn->query($sql);
                            if($stmt){
                                if($stmt->rowCount() > 0){
                                    while($row = $stmt->fetch()){
                                        $medicine_ID = $row['medicine_ID'];
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
                            unset($stmt);
                        ?>
                        <div class="card-body p-4">

                        <div class="form-group mb-3">
                                <label for="medicine_ID" class="mb-2 text-dark">Medicine Name</label>
                                <select class="form-select" name="medicine_ID" required>
                                    <option value="<?php echo $medicine_ID; ?>">
                                        <?php
                                        if(!empty($medicine_ID)){
                                            $sql = "SELECT * FROM medicines WHERE medicine_ID = $medicine_ID";
                                            $stmt = $conn->query($sql);
                                            if($stmt){
                                                if($stmt->rowCount() > 0){
                                                    while($row = $stmt->fetch()){
                                                        $medicineName = $row['medicineName'];
                                                    }
                                                }
                                            }
                                            echo $medicineName;
                                        }else{
                                            echo "- select a medicine -";
                                        }
                                        ?>
                                    </option>
                                    <?php

                                        //connect to the database
                                        include('../../../config/database_connection.php');
                                        $selectedID = "";
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

                            <!-- Quantity -->
                            <div class="form-group mb-3">
                                <label for="quantity" class="mb-2 text-dark">Quantity</label>
                                <input type="number" name="quantity" class="form-control" value="<?php echo $quantity; ?>" required>
                                <span class="text-danger" style="font-size: 13px;"> <?php  echo $quantity_err; ?> </span>
                            </div>

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
                                    <input type="date" name="expirationDate" min="<?php echo date('Y-m-d'); ?>" class="form-control" value="<?php echo $expirationDate; ?>" required>
                                    <span class="text-danger" style="font-size: 13px;"> <?php echo $expirationDate_err; ?> </span>
                                </div>
                            </div>
                               
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <div class="card-footer w-100 border d-flex justify-content-between">
                            <div class="m-1 w-100">
                                <a class="small btn btn-outline-secondary w-100 fw-bold" href="./medicines.php">
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
