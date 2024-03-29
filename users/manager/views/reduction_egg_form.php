<?php
    //page title
    $title = "Egg Reduction Form";
    
    //header
    include('../../includes/header.php');

    include('../action/egg_reduction.php'); 
    
 
?>

<!-- content --> 
<div class="container-fluid px-4">
    <h1 class="mt-4"> Manager Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./egg_reduction.php" style="text-decoration: none">Egg Reduction</a>
        </li>
        <li class="breadcrumb-item active">Add Egg Reduction</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-xl-6 col-md-6">
            <div class="card bg-light  shadow-lg mb-4">
                <div class="card-header text-center fw-bold p-3" style="background-color: #FFAF1A; color: #91452c">ADD EGG REDUCTION</div>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" novalidate>
                        <div class="card-body p-4">
                            <!-- ID  -->
                            
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
                                        $sql = "SELECT eggSize, eggSize_ID FROM eggproduction WHERE inStock <> 0 ";
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

                            <div class="d-flex flex-column flex-sm-column flex-lg-row gap-2">
                                <!-- Available Quantity -->
                                <div class="form-group w-100 mb-3">
                                    <label for="dateAdded" class="mb-2 text-dark">Available Quantity</label>
                                    <div >
                                        <input type="number" class="form-control" id="availableQuantityWrapper" readonly>
                                    </div>
                                    <!-- <span class="text-danger" style="font-size: 13px;"> <?php echo $quantity_err; ?> </span> -->
                                </div>
                                
                                <!-- Reduction Quantity -->
                                <div class="form-group w-100 mb-3">
                                    <label for="expirationDate" class="mb-2 text-dark">Reduction Quantity</label>
                                    <!-- <input type="date" min="2022-01-01" name="expirationDate" class="form-control" value=" echo $expirationDate; ?>" required> -->
                                    <input type="number" name="quantity" class="form-control" value="<?php echo $quantity; ?>" required>
                                    <span class="text-danger" style="font-size: 13px;"> <?php echo $quantity_err; ?> </span>
                                </div>
                            </div>

                            <!-- Reduction Type -->
                            <div class="form-group mb-3">
                                <label for="reductionType" class="mb-2 text-dark">Reduction Type</label>
                                <select class="form-select" name="reductionType">
                                    <option value="<?php echo $reductionType; ?>">
                                        <?php
                                            if(empty($reductionType)){
                                                echo "- select reduction type -";
                                            }else{
                                                echo $reductionType;
                                            }
                                        ?>
                                    </option>
                                    <?php if($reductionType != "Distributed to Customer") { ?>
                                        <option value="Distributed to Customer">Distributed to Customer</option>
                                    <?php } ?>
                                    <?php if($reductionType != "Personal Consumption") { ?>
                                        <option value="Personal Consumption">Personal Consumption</option>
                                    <?php } ?>
                                    <?php if($reductionType != "Spoiled") { ?>
                                        <option value="Spoiled">Spoiled</option>
                                    <?php } ?>
                                    <!-- <option value="Distributed to Customer">Distributed to Customer</option>
                                    <option value="Consumed">Personal Consumption</option>
                                    <option value="Spoiled">Spoiled</option> -->
                                </select>
                                <span class="text-danger" style="font-size: 13px;"> <?php echo $reductionType_err; ?> </span>
                            </div>
                            
                            <!-- Date Reduced -->
                            <div class="form-group mb-3">
                                <label for="dateReduced" class="mb-2 text-dark">Date Reduced</label>
                                <input type="date" min="2022-01-01" max="<?php echo date('Y-m-d'); ?>" name="dateReduced" class="form-control" value="<?php echo $dateReduced; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $dateReduced_err; ?> </span>
                            </div>
    

                        </div>
                        <div class="card-footer w-100 border d-flex justify-content-between">
                            <div class="w-100 m-1">
                                <a class="small btn btn-outline-secondary fw-bold w-100" href="./egg_reduction.php">
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

<script>

    $(document).ready(function() {
        $('select[name="eggSize_ID"]').on('change', function() {
            var eggSize_ID = $(this).val();
            // Make an AJAX request to fetch the quantity for the selected eggSize_ID
            $.ajax({
                url: '../action/get_quantity.php', // Replace with the URL of your PHP script
                type: 'POST',
                data: { eggSize_ID: eggSize_ID },
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        // Update the "Available Quantity" input element with the fetched quantity
                        $('#availableQuantityWrapper').val(response.inStock);
                    } else {
                        console.log(response.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        });
        // Trigger the event handler when the page is loaded or refreshed
        $('select[name="eggSize_ID"]').trigger('change');
    });

</script>
