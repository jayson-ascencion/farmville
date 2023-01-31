<?php
    //page title
    $title = "Update Egg Details";
    
    //header
    include('../../includes/header.php');

    include('../action/update_egg.php'); 
    
 
?>

<!-- content --> 
<div class="container-fluid px-4">
    <h1 class="mt-4"> Manager Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./egg_production.php" style="text-decoration: none">Egg Production</a>
        </li>
        <li class="breadcrumb-item active">Update Egg Production</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-xl-6 col-md-6">
            <div class="card bg-light shadow-lg mb-4 ">
                <div class="card-header text-center fw-bold p-3"  style="background-color: #f37e57;">UPDATE EGG PRODUCTION DETAILS</div>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">

                        <!-- retrieves the data from the database based on the id -->
                        <?php
                            //connect to the database
                            include('../../../config/database_connection.php');

                            $id = $_REQUEST['id'];
                            
                            //statement to select the specific schedule to update
                            $sql = "SELECT * FROM eggproduction WHERE eggBatch_ID = '$id'";
                            $stmt = $conn->query($sql);
                            if($stmt){
                                if($stmt->rowCount() > 0){
                                    while($row = $stmt->fetch()){
                                        $eggBatch_ID = $row['eggBatch_ID'];
                                        $eggSize = $row['eggSize'];
                                        $quantity = $row['quantity'];
                                        $collectionType = $row['collectionType'];
                                        $collectionDate = $row['collectionDate'];
                                        $note = $row['note'];
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
                            <!-- Egg Batch ID -->
                            <div class="form-group mb-3">
                                <label for="eggBatch_ID" class="mb-2 text-dark">Egg Batch ID</label>
                                <input type="text" name="eggBatch_ID" class="form-control"value="<?php echo $eggBatch_ID; ?>" disabled required>
                            </div>

                            <!-- egg Size -->
                            <div class="form-group mb-3">
                                <label for="eggSize" class="mb-2 text-dark">Egg Size</label>
                                <select class="form-select" name="eggSize">
                                    <option value="<?php echo $eggSize; ?>"><?php echo $eggSize; ?></option>
                                    <!-- <option value="XS">XS</option>
                                    <option value="S">S</option>
                                    <option value="M">M</option>
                                    <option value="L">L</option>
                                    <option value="XL">XL</option> -->
                                    <?php if($eggSize != "XS") { ?>
                                        <option value="XS">XS</option>
                                    <?php } ?>
                                    <?php if($eggSize != "S") { ?>
                                        <option value="S">S</option>
                                    <?php } ?>
                                    <?php if($eggSize != "M") { ?>
                                        <option value="M">M</option>
                                    <?php } ?>
                                    <?php if($eggSize != "L") { ?>
                                        <option value="L">L</option>
                                    <?php } ?>
                                    <?php if($eggSize != "XL") { ?>
                                        <option value="XL">XL</option>
                                    <?php } ?>
                                </select>
                                <span class="text-danger" style="font-size: 13px;"> <?php echo $eggSize_err; ?> </span>
                            </div>                          

                            <!-- Quantity -->
                            <div class="form-group mb-3">
                                <label for="quantity" class="mb-2 text-dark">Quantity</label>
                                <input type="number" name="quantity" class="form-control" value="<?php echo $quantity; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $quantity_err; ?> </span>
                            </div>

                            <!-- Collection Type -->
                            <div class="form-group mb-3">
                                <label for="collectionType" class="mb-2 text-dark">Collection Type</label>
                                <select class="form-select" name="collectionType">
                                    <option value="<?php echo $collectionType;?>"><?php echo $collectionType;?></option>
                                    <!-- <option value="collected">collected</option>
                                    <option value="returned">returned</option> -->
                                    <?php if($collectionType != "collected") { ?>
                                        <option value="collected">collected</option>
                                    <?php } ?>
                                    <?php if($collectionType != "returned") { ?>
                                        <option value="returned">returned</option>
                                    <?php } ?>
                                </select>
                                <span class="text-danger" style="font-size: 13px;"> <?php echo $collectionType_err; ?> </span>
                            </div>

                            <!-- Collection Date -->
                            <div class="form-group mb-3">
                                <label for="collectionDate" class="mb-2 text-dark">Collection Date</label>
                                <input type="date" name="collectionDate" class="form-control" value="<?php echo $collectionDate; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $collectionDate_err; ?> </span>
                            </div>

                            <!-- Note -->
                            <div class="form-group mb-3">
                                <label for="note" class="mb-2 text-dark">Note <span style="font-size: 13px">(optional)</span></label>
                                <textarea class="form-control" name="note" rows="3"><?php echo $note; ?></textarea>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $note_err; ?> </span>
                            </div>
                               
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <div class="card-footer w-100 border d-flex justify-content-end">
                            <div class="w-100 m-1">
                                <a class="small btn btn-outline-danger fw-bold w-100" href="./egg_production.php">
                                    Cancel
                                </a> 
                            </div>
                            <div class="w-100 m-1">
                                <button type="submit" name="submit" class="btn btn-outline-success fw-bold w-100">
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
