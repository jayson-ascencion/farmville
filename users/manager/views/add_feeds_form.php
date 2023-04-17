<?php
    //page title
    $title = "Add Feed";
    
    //header
    include('../../includes/header.php');

    //save feed action
    include('../action/save_feed.php'); 
    
 
?>

<!-- content --> 
<div class="container-fluid px-4">
    <h1 class="mt-4"> Manager Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./medicines.php" style="text-decoration: none">Feeds Inventory</a>
        </li>
        <li class="breadcrumb-item active">Add Feed</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-xl-6 col-md-6">
            <div class="card  bg-light shadow mb-4">
                <div class="card-header text-center fw-bold p-3" style="background-color: #FFAF1A; color: #91452c">ADD NEW FEED INVENTORY </div>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" novalidate>
                        <div class="card-body p-4">
                            <!-- Feed Name -->
                            <div class="form-group mb-3">
                                <label for="feedName" class="mb-2 text-dark">Feed Name </label>
                                <input type="text" name="feedName" class="form-control"value="<?php echo $feedName;  ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $feedName_err; ?> </span>
                            </div>

                            <!-- Brand -->
                            <div class="form-group mb-3">
                                <label for="brand" class="mb-2 text-dark">Feed Brand</label>
                                <input type="text" name="brand" class="form-control"value="<?php echo $brand; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $brand_err; ?> </span>
                            </div>                            

                            <!-- Starting Quantity -->
                            <div class="form-group mb-3">
                                <label for="startingQuantity" class="mb-2 text-dark">Starting Quantity</label>
                                <input type="number" name="startingQuantity" class="form-control"value="<?php echo $startingQuantity; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $startingQuantity_err; ?> </span>
                            </div>

                            <!-- In Stock -->
                            <div class="form-group mb-3">
                                <label for="inStock" class="mb-2 text-dark">In Stock</label>
                                <input type="number" name="inStock" class="form-control"value="<?php echo $inStock; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $inStock_err; ?> </span>
                            </div>

                            <!-- Date Purchased -->
                            <div class="form-group mb-3">
                                <label for="datePurchased" class="mb-2 text-dark">Date Purchased </label>
                                <input type="date" min="2022-01-01" name="datePurchased" class="form-control" value="<?php echo $datePurchased; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $datePurchased_err; ?> </span>
                            </div>
                        
                        </div>
                        <div class="card-footer w-100 border d-flex justify-content-between">
                            <div class="m-1 w-100">
                                <a class="small btn btn-outline-secondary w-100 fw-bold" href="./feeds.php">
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
