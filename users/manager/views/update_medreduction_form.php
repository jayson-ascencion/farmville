<?php
    //page title
    $title = "Update Medicine Reduction";
    
    //header
    include('../../includes/header.php');

    include('../action/update_medicine_reduction.php'); 
    
 
?>

<!-- content --> 
<div class="container-fluid px-4">
    <h1 class="mt-4"> Manager Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./medicine_reduction.php" style="text-decoration: none">Medicines Reduction</a>
        </li>
        <li class="breadcrumb-item active">Update Medicine Reduction</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-xl-6 col-md-6">
            <div class="card bg-light shadow-lg mb-4 ">
                <div class="card-header text-center fw-bold p-3" style="background-color: #f37e57">UPDATE MEDICINE REDUCTION</div>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">

                        <!-- retrieves the data from the database based on the id -->
                        <?php
                            //connect to the database
                            include('../../../config/database_connection.php');

                            $id = $_REQUEST['id'];
                            
                            //statement to select the specific schedule to update
                            $sql = "SELECT * FROM medicinereduction WHERE reduction_ID = '$id'";
                            $stmt = $conn->query($sql);
                            if($stmt){
                                if($stmt->rowCount() > 0){
                                    while($row = $stmt->fetch()){
                                        $reduction_ID = $row['reduction_ID'];
                                        $medicine_ID = $row['medicine_ID'];
                                        $medicineName = $row['medicineName'];
                                        $quantity = $row['quantity'];
                                        $reductionType = $row['reductionType'];
                                        $dateReduced = $row['dateReduced'];
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
                        <div class="card-body p-4">
                            <!-- Medicine ID -->
                            <div class="form-group mb-3">
                                <label for="medicine_ID" class="mb-2 text-dark">Medicine ID</label>
                                <select class="form-select" name="medicine_ID" disabled>
                                    <?php

                                        //connect to the database
                                        include('../../../config/database_connection.php');

                                        //statement to select the all the medicine names
                                        $sql = "SELECT medicine_ID, medicineName FROM medicines";
                                        $stmt = $conn->query($sql);
                                        if($stmt){
                                            if($stmt->rowCount() > 0){
                                                echo '<option value="' . $medicine_ID . '">' . $medicine_ID .'</option>';
                                                while($row = $stmt->fetch()){
                                                    if($row['medicine_ID'] != $medicine_ID){?>
                                                <option value="<?php echo $row['medicine_ID']; ?>"> <?php echo $row['medicine_ID'] . " - " . $row['medicineName']; ?> </option>
                                            <?php }}
                                                // Free result set
                                                unset($result);
                                            } else{
                                                echo '<option> - no medicines found - </option>';
                                            }
                                        } else{
                                            echo "Oops! Something went wrong. Please try again later.";
                                        }
                                        unset($stmt);

                                    ?>
                                </select>
                                <span class="text-danger" style="font-size: small;"> <?php echo $medicine_ID_err; ?> </span>
                            </div>                            

                            <!-- Medicine Name -->
                            <div class="form-group mb-3">
                                <label for="medicineName" class="mb-2 text-dark">Medicine Name</label>
                                <input type="text" name="medicineName" class="form-control"value="<?php echo $medicineName;  ?>" disabled>
                            </div>
                    
                            <!-- Quantity -->
                            <div class="form-group mb-3">
                                <label for="updateQuantity" class="mb-2 text-dark">Quantity</label>
                                <input type="number" name="updateQuantity" class="form-control"value="<?php echo $quantity; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $updateQuantity_err; ?> </span>
                            </div>      

                            <!-- Reduction Type -->
                            <div class="form-group mb-3">
                                <label for="reductionType" class="mb-2 text-dark">Reduction Type</label>
                                <select class="form-select" name="reductionType">
                                    <option value="<?php echo $reductionType; ?>"> <?php if(!empty($reductionType)){
                                        echo $reductionType;
                                    }else{
                                        echo "- select a reduction type - ";
                                    } ?></option>
                                    <!-- <option value="Used">Used</option>
                                    <option value="Expired">Expired</option> -->
                                    <?php if($reductionType != "Used") { ?>
                                        <option value="Used">Used</option>
                                    <?php } ?>
                                    <?php if($reductionType != "Expired") { ?>
                                        <option value="Expired">Expired</option>
                                    <?php } ?>
                                </select>
                                <span class="text-danger" style="font-size: 13px;"> <?php echo $reductionType_err; ?> </span>
                            </div>
                            
                            <!-- Date Reduced -->
                            <div class="form-group w-100 mb-3">
                                <label for="dateReduced" class="mb-2 text-dark">Date Reduced</label>
                                <input type="date" name="dateReduced" class="form-control" value="<?php echo $dateReduced;?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $dateReduced_err; ?> </span>
                            </div>
                               
                        </div>
                        <input type="hidden" name="medicine_ID" value="<?php echo $medicine_ID; ?>"/>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <div class="card-footer w-100 border d-flex justify-content-end">
                            <div class="m-1 w-100">
                                <a class="small btn btn-outline-danger w-100 fw-bold" href="./medicine_reduction.php">
                                    Cancel
                                </a>                                 
                            </div>
                            <div class="m-1 w-100">
                                <button type="submit" name="submit" class="btn btn-outline-success w-100 fw-bold">
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
