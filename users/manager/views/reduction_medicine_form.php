<?php
    //page title
    $title = "Add Medicine Reduction";
    
    //header
    include('../../includes/header.php');

    include('../action/medicine_reduction.php'); 
    
?>

<!-- content --> 
<div class="container-fluid px-4">
    <h1 class="mt-4"> Manager Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./medicine_reduction.php" style="text-decoration: none">Medicine Reduction</a>
        </li>
        <li class="breadcrumb-item active">Add Medicine Reduction</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-xl-6 col-md-6">
            <div class="card bg-light shadow-lg mb-4 ">
                <div class="card-header text-center fw-bold p-3" style="background-color: #FFAF1A; color: #91452c">ADD MEDICINE REDUCTION</div>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" novalidate>
                        <div class="card-body p-4">
                            <!-- Medicine ID -->
                            <div class="form-group mb-3">
                                <label for="medicine_ID" class="mb-2 text-dark">Medicine ID</label>
                                <select class="form-select" name="medicine_ID" required>
                                    <?php

                                        //connect to the database
                                        include('../../../config/database_connection.php');

                                        //statement to select the all the medicine names
                                        $sql = "SELECT medicine_ID, medicineName FROM medicines WHERE archive='not archived'";
                                        $stmt = $conn->query($sql);
                                        if($stmt){
                                            // if($stmt->rowCount() > 0){
                                                if(empty($medicine_ID)){
                                                    echo '<option value="">- select a medicine id -</option>';
                                                }else{
                                                    ?>
                                                    <option value="<?php echo $medicine_ID; ?>"><?php echo $medicine_ID; ?></option>';
                                                    <?php
                                                }
                                                while($row = $stmt->fetch()){?>
                                                <option value="<?php echo $row['medicine_ID']; ?>"> <?php echo $row['medicine_ID'] . " - " . $row['medicineName']; ?> </option>
                                            <?php }
                                                // Free result set
                                                unset($result);
                                            // } else{
                                            //     echo '<option> - no medicines found - </option>';
                                            // }
                                        } else{
                                            echo "Oops! Something went wrong. Please try again later.";
                                        }
                                        unset($pdo);

                                    ?>
                                </select>
                                <span class="text-danger" style="font-size: small;"> <?php echo $medicine_ID_err; ?> </span>
                            </div>

                            <!-- Quantity -->
                            <div class="form-group mb-3">
                                <label for="quantity" class="mb-2 text-dark">Quantity</label>
                                <input type="number" name="quantity" class="form-control"value="<?php echo $quantity; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $quantity_err; ?> </span>
                            </div>                            

                            <!-- Reduction Type -->
                            <div class="form-group mb-3">
                                <label for="reductionType" class="mb-2 text-dark">Reduction Type</label>
                                <select class="form-select" name="reductionType" required>
                                    <?php
                                        if(empty($reductionType)){
                                            echo '<option value="">- select a reduction type -</option>';
                                        }else{
                                            ?>
                                                <option value="<?php echo $reductionType; ?>"><?php echo $reductionType; ?></option>';
                                            <?php
                                        }
                                    ?>
                                    <option value="Used">Used</option>
                                    <option value="Expired">Expired</option>
                                </select>
                                <span class="text-danger" style="font-size: 13px;"> <?php echo $reductionType_err; ?> </span>
                            </div>
                    
                            <!-- Date Reduced -->
                            <div class="form-group mb-3">
                                <label for="dateReduced" class="mb-2 text-dark">Date Reduced</label>
                                <input type="date" min="2022-01-01" max="<?php echo date('Y-m-d'); ?>" name="dateReduced" class="form-control"value="<?php echo $dateReduced; ?>" required>
                                <span class="text-danger" style="font-size: 13px;"> <?php echo $dateReduced_err; ?> </span>
                            </div>

                        </div>
                        <div class="card-footer w-100 border d-flex justify-content-end">
                            <div class="m-1 w-100">
                                <a class="small btn btn-outline-secondary w-100 fw-bold" href="./medicine_reduction.php">
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
