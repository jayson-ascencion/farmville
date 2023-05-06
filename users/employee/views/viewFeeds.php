<?php
    //title of the pge
    $title = "Feed Details";

    include("../../includes/header.php");

    //database connection, located in the config directory
    include('../../../config/database_connection.php');
    $id = $_REQUEST['id'];

    //this will hold the brand before update
    $feed_ID = $feedName = $brand = $startingQuantity = $inStock = $datePurchased = "";

    //statement to get the old brand
    $sql = "SELECT * FROM feedtransaction WHERE transaction_ID = '$id'";
    $stmt = $conn->query($sql);

    if($stmt){
        if($stmt->rowCount() > 0){
            while($row = $stmt->fetch()){
                $feed_ID = $row['feed_ID'];
                $feedName = $row['feedName'];
                // $brand = $row['brand'];
                // $startingQuantity = $row['startingQuantity'];
                $quantity = $row['quantity'];
                $dateString = strtotime($row['transactionDate']);
                $datePurchased = date("F d, Y",$dateString); 
            }
            // Free result set
            unset($result);
        } else{
            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
        }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }
?>

<div class="container-fluid px-4">
    <h1 class="mt-4"> Employee Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./feeds.php" style="text-decoration: none">Feed Inventory</a>
        </li>
        <li class="breadcrumb-item active">Feed Details</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-sm-4">
            <div class="card bg-light shadow-lg mb-4 ">
                <div class="card-header text-center fw-bold d-flex justify-content-between p-3" style="background-color: #FFAF1A; color: #91452c"><div>FEED INVENTORY DETAILS</div> <div>
                    <a class="small text-white" href="./feeds.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z"/>
                    <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                    </svg>
                    </a> 
                </div></div>
                <div class="card-body p-4">
                    <!-- Feed ID -->
                    <div class="mb-3">
                        <p class="fw-bold">Feed ID: <span class="fw-normal ps-2"><?php echo $feed_ID; ?></span></p>
                    </div>

                    <!-- Feed Name -->
                    <div class="mb-3">
                        <p class="fw-bold">Feed Name: <span class="fw-normal ps-2"><?php echo $feedName; ?></span></p>
                    </div>
            
                    <!-- Feed Brand
                    <div class="mb-3">
                        <p class="fw-bold">Feed Brand: <span class="fw-normal ps-2"><?php echo $brand; ?></span></p>
                    </div> -->

                    <!-- Starting Quantity
                    <div class="mb-3">
                        <p class="fw-bold">Starting Quantity: <span class="fw-normal ps-2"><?php echo $startingQuantity; ?></span></p>
                    </div> -->

                    
                    <!-- In Stock -->
                    <div class="mb-3">
                        <p class="fw-bold">Quantity: <span class="fw-normal ps-2"><?php echo $quantity; ?></span></p>
                    </div>
                        
                    <!-- Date Purchased -->
                    <div class="mb-3">
                        <p class="fw-bold">Date Purchased: <span class="fw-normal ps-2"><?php echo $datePurchased; ?></span></p>
                    </div>

                </div>
                    
            </div>
        </div>
    </div>
</div>
<!-- end of content -->
<?php
    include("../../includes/footer.php");
    
    include("../../includes/scripts.php");
?> 