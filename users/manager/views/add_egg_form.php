<?php
    //page title
    $title = "Add Collected Eggs";
    
    //header
    include('../../includes/header.php');

    //save egg action
    include('../action/save_egg.php'); 
    
 
?>

<!-- content --> 
<div class="container-fluid px-4">
    <h1 class="mt-4"> Manager Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./egg_production.php" style="text-decoration: none">Egg Production</a>
        </li>
        <li class="breadcrumb-item active">Add New Collection</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-xl-6 col-md-6">
            <div class="card  bg-light shadow-lg mb-4">
                <div class="card-header text-center fw-bold p-3" style="background-color: #FFAF1A; color: #91452c">ADD COLLECTED EGGS</div>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" novalidate>
                        <div class="card-body p-4">
                            <!-- egg Size -->
                            <div class="form-group mb-3">
                                <label for="eggSize_ID" class="mb-2 text-dark">Egg Size</label>
                                <select class="form-select" name="eggSize_ID" required>
                                    <option value="<?php echo $eggSize_ID; ?>">
                                        <?php
                                        if(!empty($eggSize_ID)){
                                            echo $eggSize_ID;
                                        }else{
                                            echo "- select an egg size -";
                                        }
                                        ?>
                                    </option>
                                    <?php

                                        //connect to the database
                                        include('../../../config/database_connection.php');
                                        $selectedID = "";
                                        //statement to select the all the medicine names
                                        $sql = "SELECT eggSize, eggSize_ID FROM eggproduction";
                                        $stmt = $conn->query($sql);
                                        if($stmt){
                                            if($stmt->rowCount() > 0){
                                                while($row = $stmt->fetch()){?>
                                                <option value="<?php echo $row['eggSize_ID']; ?>"> <?php echo $row["eggSize"];?> </option>
                                            <?php }
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
                                </select>
                                <span class="text-danger" style="font-size: small;"> <?php echo $eggSize_ID_err; ?> </span>
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
                                <select class="form-select" name="collectionType" required>
                                    <?php
                                        if(empty($collectionType)){
                                            echo '<option value="">- select a collection type -</option>';
                                        }else{
                                            ?>
                                                <option value="<?php echo $collectionType; ?>"><?php echo $collectionType; ?></option>';
                                            <?php
                                        }
                                    ?>
                                    <option value="Collected">Collected</option>
                                    <option value="Returned">Returned</option>
                                </select>
                                <span class="text-danger" style="font-size: 13px;"> <?php echo $collectionType_err; ?> </span>
                            </div>

                            
                            <!-- Collection Date -->
                            <div class="form-group mb-3">
                                <label for="collectionDate" class="mb-2 text-dark">Collection Date</label>
                                <input type="date" min="2022-01-01" max="<?php echo date('Y-m-d'); ?>" name="collectionDate" class="form-control" value="<?php echo $collectionDate; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $collectionDate_err; ?> </span>
                            </div>
                               
                            <!-- Note -->
                            <div class="form-group mb-3">
                                <label for="note" class="mb-2 text-dark">Note <span style="font-size: 13px">(optional)</span></label>
                                <textarea class="form-control" name="note" rows="3" value="<?php echo $note; ?>"><?php echo $note; ?></textarea>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $note_err; ?> </span>
                            </div>

                        </div>
                        <div class="card-footer w-100 border d-flex justify-content-between">
                            <div class="w-100 m-1">
                                <a class="btn  btn-outline-secondary fw-bold w-100" href="./egg_production.php">
                                    Cancel
                                </a> 
                            </div>
                            <div class="w-100 m-1">
                                <button type="submit" name="submit" class="btn  btn-outline-success fw-bold w-100">
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
