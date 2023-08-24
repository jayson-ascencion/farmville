<?php
    //page title
    $title = "Reduce Chicken";
    
    //header
    include('../../includes/header.php');

    include('../action/chicken_reduction.php'); 
  
?>
 
<!-- content --> 
<div class="container-fluid px-4">
    <h1 class="mt-4"> Employee Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./chicken_reduction.php" style="text-decoration: none">Chicken Reduction</a>
        </li>
        <li class="breadcrumb-item active">Add Chicken Reduction</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-xl-6 col-md-6">
            <div class="card bg-light  shadow-lg mb-4">
                <div class="card-header text-center p-3 fw-bold" style="background-color: #FFAF1A; color: #91452c">ADD CHICKEN REDUCTION</div>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" novalidate id="myForm">
                        <div class="card-body p-4">
                            <!-- Coop Number -->
                            <!-- <div class="form-group mb-3">
                                <label for="coopNumber" class="mb-2 text-dark">Coop Number</label>
                                <select class="form-select" name="coopNumber" required>
                                    <?php
                                        if(empty($coopNumber)){
                                            echo '<option value="" selected>- select a coop number -</option>';
                                        }else{
                                            ?>
                                                <option value="<?php echo $coopNumber; ?>"selected><?php echo $coopNumber; ?></option>';
                                            <?php
                                        }
                                    ?>
                                    <?php

                                        //connect to the database
                                        include('../../../config/database_connection.php');

                                        //statement to select the all the medicine names
                                        $sql = "SELECT coopNumber FROM chickenproduction WHERE archive='not archived'";
                                        $stmt = $conn->query($sql);
                                        if($stmt){
                                            if($stmt->rowCount() > 0){
                                                while($row = $stmt->fetch()){?>
                                                <option value="<?php echo $row['coopNumber']; ?>"> <?php echo $row['coopNumber']?> </option>
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
                                <span class="text-danger" style="font-size: small;"> <?php echo $coopNumber_err; ?> </span>
                            </div> -->

                            <div class="d-flex flex-column flex-sm-column flex-lg-row gap-2">
                                <!-- Available Quantity -->
                                <div class="form-group w-100 mb-3">
                                    <label for="coopNumber" class="mb-2 text-dark">Coop Number</label>
                                    <select class="form-select" name="coopNumber" required>
                                    <?php
                                        if(empty($coopNumber)){
                                            echo '<option value="" selected>- select a coop number -</option>';
                                        }else{
                                            ?>
                                                <option value="<?php echo $coopNumber; ?>"selected><?php echo $coopNumber; ?></option>';
                                            <?php
                                        }
                                    ?>
                                    <?php

                                        //connect to the database
                                        include('../../../config/database_connection.php');

                                        //statement to select the all the medicine names
                                        $sql = "SELECT coopNumber FROM chickenproduction WHERE archive='not archived'";
                                        $stmt = $conn->query($sql);
                                        if($stmt){
                                            if($stmt->rowCount() > 0){
                                                while($row = $stmt->fetch()){?>
                                                <option value="<?php echo $row['coopNumber']; ?>"> <?php echo $row['coopNumber']?> </option>
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
                                <span class="text-danger" style="font-size: small;"> <?php echo $coopNumber_err; ?> </span>
                                </div>
                                
                                <!-- Reduction Quantity -->
                                <div class="form-group w-100 mb-3">
                                    <label for="sex" class="mb-2 text-dark">Sex</label>
                                    <!-- <input type="date" min="2022-01-01" name="expirationDate" class="form-control" value=" echo $expirationDate; ?>" required> -->
                                    <select class="form-select" name="sex">
                                            
                                            <option value="<?php echo $sex; ?>">
                                                <?php
                                                    if(empty($sex)){
                                                        echo "- select a sex -";
                                                    }else{
                                                        echo $sex;
                                                    }
                                                ?>
                                            </option>
                                            <?php if($sex != "Male") { ?>
                                                <option value="Male">Male</option>
                                            <?php } ?>
                                            <?php if($sex != "Female") { ?>
                                                <option value="Female">Female</option>
                                            <?php } ?>
                                            
                                        </select>

                                    <span class="text-danger" style="font-size: 13px;"> <?php echo $sex_err; ?> </span>
                                </div>
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
                                    <?php
                                        if(empty($reductionType)){
                                            echo '<option value="" selected>- select a reduction type -</option>';
                                        }else{
                                            ?>
                                                <option value="<?php echo $reductionType; ?>"selected><?php echo $reductionType; ?></option>';
                                            <?php
                                        }
                                    ?>
                                    <option value="Culled">Culled</option>
                                    <option value="Sold">Sold</option>
                                    <option value="Death">Death</option>
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
                        <div class="card-footer w-100 border d-flex justify-content-between">
                            <div class="w-100 m-1">
                                <a class="btn  btn-outline-secondary fw-bold w-100" href="./chicken_reduction.php">
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

<script>
    // $(document).ready(function() {
    //     $('select[name="coopNumber"]').on('change', function() {
    //         var coopNumber = $(this).val();
    //         console.log(coopNumber)
    //         // Make an AJAX request to fetch the quantity for the selected coopNumber
    //         $.ajax({
    //             url: '../action/get_quantity.php', // Replace with the URL of your PHP script
    //             type: 'POST',
    //             data: { coopNumber: coopNumber },
    //             dataType: 'json',
    //             success: function(response) {
    //                 console.log(response);
    //                 if (response.status == 'success') {
    //                     // Update the "Available Quantity" input element with the fetched quantity
    //                     // document.getElementById("availableQuantityWrapper").innerText = response.instock;
    //                     console.log(response.instock);
    //                     $('#availableQuantityWrapper').val(response.instock);
    //                     // console.log($('#availableQuantityWrapper').val());

    //                 } else {
    //                     console.log(response.message);
    //                 }
    //             },
    //             error: function(jqXHR, textStatus, errorThrown) {
    //                 console.log(errorThrown);
    //             }
    //         });
    //     });
    // });

    // $(document).ready(function() {
    //     $('select[name="coopNumber"]').on('change', function() {
    //         var coopNumber = $(this).val();
    //         // Make an AJAX request to fetch the quantity for the selected coopNumber
    //         $.ajax({
    //             url: '../action/get_quantity.php', // Replace with the URL of your PHP script
    //             type: 'POST',
    //             data: { coopNumber: coopNumber },
    //             dataType: 'json',
    //             success: function(response) {
    //                 if (response.status == 'success') {
    //                     // Console log the value of the input element
    //                     // console.log($('#availableQuantityWrapper'));
    //                     // Update the "Available Quantity" input element with the fetched quantity
    //                     $('#availableQuantityWrapper').val(response.inStock);
    //                 } else {
    //                     console.log(response.message);
    //                 }
    //             },
    //             error: function(jqXHR, textStatus, errorThrown) {
    //                 console.log(errorThrown);
    //             }
    //         });
    //     });
    // });

    // $(document).ready(function() {
    //     $('select[name="coopNumber"]').on('change', function() {
    //         var coopNumber = $(this).val();
    //         console.log(coopNumber);
    //         // Make an AJAX request to fetch the quantity for the selected coopNumber
    //         $.ajax({
    //             url: '../action/get_quantity.php', // Replace with the URL of your PHP script
    //             type: 'POST',
    //             data: { coopNumber: coopNumber },
    //             dataType: 'json',
    //             success: function(response) {
    //                 if (response.status == 'success') {
    //                     // Check if the form is valid before updating the "Available Quantity" field
    //                     if ($('#myForm')[0].checkValidity()) {
    //                         console.log($('#availableQuantityWrapper'));
    //                         // Update the "Available Quantity" input element with the fetched quantity
    //                         $('#availableQuantityWrapper').val(response.inStock);
    //                     }
    //                 } else {
    //                     console.log(response.message);
    //                 }
    //             },
    //             error: function(jqXHR, textStatus, errorThrown) {
    //                 console.log(errorThrown);
    //             }
    //         });
    //     });
    // });

    $(document).ready(function() {
        $('select[name="coopNumber"]').on('change', function() {
            var coopNumber = $(this).val();
            // Make an AJAX request to fetch the quantity for the selected coopNumber
            $.ajax({
                url: '../action/get_quantity.php', // Replace with the URL of your PHP script
                type: 'POST',
                data: { coopNumber: coopNumber },
                dataType: 'json',
                success: function(response) {
                    console.log(response.inStock)
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

            $('select[name="sex"]').on('change', function() {
                var sex = $(this).val();
                // Make an AJAX request to fetch the quantity for the selected sex
                $.ajax({
                    url: '../action/get_sex_quantity.php', // Replace with the URL of your PHP script
                    type: 'POST',
                    data: { coopNumber: coopNumber, sex: sex },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response.inStock)
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
        });

        // Trigger the event handler when the page is loaded or refreshed
        $('select[name="coopNumber"]').trigger('change');
        $('select[name="sex"]').trigger('change');
        
    });

</script>
