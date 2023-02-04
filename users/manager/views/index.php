<?php
    $title = "Manager Dashboard";
    //header
    include('../../includes/header.php');

    //database connection
    include('../../../config/database_connection.php');

    $sql = "SELECT cp.chickenBatch_ID, cp.coopNumber as cpCoop, cp.batchName, cp.breedType, cp.startingQuantity, SUM(COALESCE(cp.inStock, 0)) as instock, DATE_FORMAT(cp.dateAcquired, '%M %d') AS acquiredDate, DATE_FORMAT(COALESCE((cr.dateReduced),'0000-00-00'), '%M %d') as dateReduced, cr.coopNumber as crCoop, COALESCE(SUM(cr.quantity),0) as totalReductions
    FROM chickenproduction cp LEFT JOIN chickenreduction cr ON cp.chickenBatch_ID = cr.chickenBatch_ID
    WHERE dateAcquired BETWEEN CURDATE() - INTERVAL 6 DAY AND CURDATE() AND cp.archive = 'not archived' AND cr.archive = 'not archived'
    GROUP BY acquiredDate";
    //"SELECT SUM(COALESCE(inStock, 0)) as instock, batchName, DATE_FORMAT(dateAcquired, '%M-%d-%Y') AS acquiredDate FROM chickenproduction WHERE dateAcquired BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE() GROUP BY acquiredDate";
    $stmt = $conn->query($sql);
     if($stmt){
            $oneweek = array();
            $oneweekDataset = array();
            $oneweekDatasetReduction = array();
            $lastdaysBatch = array();
         if($stmt->rowCount() > 0){
            while($row = $stmt->fetch()){
                $oneweek[] = $row['acquiredDate'];
                $oneweekDataset[] = $row['instock'];
                $oneweekDatasetReduction[] = $row['totalReductions'];
                $lastdaysBatch[] = $row['batchName'];
                // $startingQ[] = $row['startingQuantity'];
            }
        }
        else{
                $oneweek[] = date('M d');
                $oneweekDataset[] = 0;
                $oneweekDatasetReduction[] = 0;
                $lastdaysBatch[] = 'no data';
        }
            // Free result set
            unset($stmt);
    }
    else{
        echo "Oops! Something went wrong. Please try again later.";
    }

    $sql = "WITH all_breedTypes AS ( SELECT 'Sussex' as breedType UNION SELECT 'Rhode Island Reds' UNION SELECT 'Leghorns' UNION SELECT 'Plymouth') 
            SELECT all_breedTypes.breedType, SUM(COALESCE(chickenproduction.inStock, 0)) as instock 
            FROM all_breedTypes LEFT JOIN chickenproduction ON all_breedTypes.breedType = chickenproduction.breedType 
            AND dateAcquired BETWEEN CURDATE() - INTERVAL 6 DAY AND CURDATE() AND chickenproduction.archive = 'not archived' GROUP BY all_breedTypes.breedType";
        // SELECT breedType, SUM(COALESCE(inStock, 0)) as instock
		// FROM chickenproduction 
        // WHERE dateAcquired BETWEEN CURDATE() - INTERVAL 6 DAY AND CURDATE()
        // GROUP BY breedType
    //"SELECT SUM(COALESCE(inStock, 0)) as instock, batchName, DATE_FORMAT(dateAcquired, '%M-%d-%Y') AS acquiredDate FROM chickenproduction WHERE dateAcquired BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE() GROUP BY acquiredDate";
    $stmt = $conn->query($sql);
     if($stmt){
         if($stmt->rowCount() > 0){
            $breed = array();
            // $instock = array();
            // $sussex = 0;
            // $rhode = 0;
            // $plymouth = 0;
            // $leghorns = 0;
            while($row = $stmt->fetch()){
                if($row['breedType'] == 'Sussex'){
                    $sussex = $row['instock'];
                    $breed['Sussex'] = $sussex;
                }
                else if($row['breedType'] == 'Rhode Island Reds'){
                    $rhode = $row['instock'];
                    $breed['Rhode Island Reds'] = $rhode;
                }
                else if($row['breedType'] == 'Plymouth'){
                    $plymouth = $row['instock'];
                    $breed['Plymouth'] = $plymouth;
                }
                else if($row['breedType'] == 'Leghorns'){
                    $leghorns = $row['instock'];
                    $breed['Leghorns'] = $leghorns;
                }
            }
        }
            // Free result set
            unset($stmt);
            // print_r($breed);
    }
    else{
        echo "Oops! Something went wrong. Please try again later.";
    }

    // $sql = "SELECT eggSize, SUM(COALESCE(quantity, 0)) as instock FROM eggproduction
    // WHERE collectionDate BETWEEN CURDATE() - INTERVAL 6 DAY AND CURDATE()
    // GROUP BY eggSize";
    $sql = "WITH all_egg_sizes AS ( SELECT 'XS' as eggSize UNION SELECT 'S' UNION SELECT 'M' UNION SELECT 'L' UNION SELECT 'XL' )
SELECT all_egg_sizes.eggSize, SUM(COALESCE(eggproduction.quantity, 0)) as instock FROM all_egg_sizes
LEFT JOIN eggproduction ON all_egg_sizes.eggSize = eggproduction.eggSize
AND collectionDate BETWEEN CURDATE() - INTERVAL 6 DAY AND CURDATE() AND eggproduction.archive = 'not archived'
GROUP BY all_egg_sizes.eggSize";
    //"SELECT SUM(COALESCE(inStock, 0)) as instock, batchName, DATE_FORMAT(dateAcquired, '%M-%d-%Y') AS acquiredDate FROM chickenproduction WHERE dateAcquired BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE() GROUP BY acquiredDate";
    $stmt = $conn->query($sql);
    if($stmt){
        if($stmt->rowCount() > 0){
            $size = array();
            // $quantity = array();
            while($row = $stmt->fetch()){
                if($row['eggSize'] == 'XS'){
                    $xsmall = $row['instock'];
                    $size['XS'] = $xsmall;
                }else if($row['eggSize'] == 'S'){
                    $small = $row['instock'];
                    $size['S'] = $small;
                }else if($row['eggSize'] == 'M'){
                    $medium = $row['instock'];
                    $size['M'] = $medium;
                }else if($row['eggSize'] == 'L'){
                    $large = $row['instock'];
                    $size['L'] = $large;
                }else if($row['eggSize'] == 'XL'){
                    $xlarge = $row['instock'];
                    $size['XL'] = $xlarge;
                }
            }
        }
            // Free result set
            unset($stmt);
    }
    else{
        echo "Oops! Something went wrong. Please try again later.";
    }

    $sql = "SELECT DATE_FORMAT(ep.collectionDate, '%M %d') AS collectionDate, ep.eggSize, SUM(COALESCE(ep.quantity,0)) as totalQuantity, SUM(COALESCE(er.quantity,0)) as totalReductions 
		FROM eggproduction ep 
		LEFT JOIN eggreduction er ON ep.eggBatch_ID = er.eggBatch_ID 
        WHERE collectionDate BETWEEN CURDATE() - INTERVAL 6 DAY AND CURDATE() AND ep.archive = 'not archived' AND er.archive = 'not archived'
        GROUP BY ep.eggBatch_ID, ep.collectionDate";
    //"SELECT SUM(COALESCE(inStock, 0)) as instock, batchName, DATE_FORMAT(dateAcquired, '%M-%d-%Y') AS acquiredDate FROM chickenproduction WHERE dateAcquired BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE() GROUP BY acquiredDate";
    $stmt = $conn->query($sql);
    if($stmt){
        if($stmt->rowCount() > 0){
            $collectionDate = array();
            $totalQuantity = array();
            $totalReductions = array();
            while($row = $stmt->fetch()){
                $collectionDate[] = $row['collectionDate'];
                $totalQuantity[] = $row['totalQuantity'];
                $totalReductions[] = $row['totalReductions'];
            }
        }
        else{
            $collectionDate[] = '';
                $totalQuantity[] = '';
                $totalReductions[] = '';
        }
            // Free result set
            unset($stmt);
    }
    else{
        echo "Oops! Something went wrong. Please try again later.";
    }

?>

<!-- content --> 
<div class="container-fluid px-4">
    <h1 class="mt-4"> Manager Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active" style="text-decoration: none">Dashboard</li>
    </ol>
    <!-- CHICKEN DASHBOARD -->
    <div class="row mb-2">
        <div class="col-xl-3 col-md-6 col-sm-6 mb-2">
            <div class="card bg-white rounded border-danger h-100 rounded-3 shadow">
                <div class="card-body m-2">
                    <div class="fs-3 fw-bold float-end">
                        <?php echo $sussex?>
                    </div>
                    <div>
                        <h5 class="card-subtitle text-muted">Sussex</h5>
                    </div>
                    <a href="./reports_chicken.php" class="card-link text-decoration-none pt-5 opacity-75" style="font-size: 15px">View More In Report
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6 mb-2">
            <div class="card bg-white border-danger h-100  rounded rounded-3 shadow">
                <div class="card-body m-2 ">
                    <div class="fs-3 fw-bold float-end">
                        <?php echo $rhode?>
                    </div>
                    <div>
                        <h5 class="card-subtitle text-muted">Rhode Island Reds</h5>
                    </div>
                    <a href="./reports_chicken.php" class="card-link text-decoration-none pt-5 opacity-75" style="font-size: 15px">View More In Report
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6 mb-2">
            <div class="card bg-white border-danger h-100  rounded rounded-3 shadow ">
                <div class="card-body m-2">
                    <div class="fs-3 fw-bold float-end">
                        <?php echo $leghorns?>
                    </div>
                    <div>
                        <h5 class="card-subtitle text-muted">Leghorns</h5>
                    </div>
                    <a href="./reports_chicken.php" class="card-link text-decoration-none pt-5 opacity-75" style="font-size: 15px">View More In Report
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6 mb-2">
            <div class="card bg-white border-danger  h-100 rounded rounded-3 shadow ">
                <div class="card-body m-2">
                    <div class="fs-3 fw-bold float-end">
                        <?php echo $plymouth?>
                    </div>
                    <div>
                        <h5 class="card-subtitle text-muted">Plymouth</h5> 
                    </div>
                    <a href="./reports_chicken.php" class="card-link text-decoration-none pt-5 opacity-75" style="font-size: 15px">View More In Report
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                        </svg>
                    </a>
                </div>
                
            </div>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col">
            <div class="card border-danger bg-white shadow rounded rounded-3">
                <div class="card-body text-center">
                    <h5 class="card-title">Chicken Production and Reduction</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Last 7 Days</h6>
                    <div class="chart-container bar-chart mb-0">
                        <canvas id="chicken_chart" height="200"></canvas>
                    </div>
                    <div class="float-center p-0 mt-1">
                        <a href="./reports_chicken.php" class="card-link text-decoration-none p-0 opacity-75" style="font-size: 15px">View More In Report
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- EGG EGG EGG EGG -->
    <div class="row mb-2 mt-3">
        <div class="col-xl-4 col-md-6 mb-2">
            <div class="card border-warning bg-white shadow rounded rounded-3">
                <div class="card-body text-center">
                    <h5 class="card-title">Eggs In Stock By Size</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Last 7 Days</h6>
                    <div class="mb-2">
                        <canvas id="eggSize_chart" height="200"></canvas>
                    </div>
                    <div class="float-center p-0 mt-1">
                        <a href="./reports_chicken.php" class="card-link text-decoration-none p-0 opacity-75" style="font-size: 15px">View More In Report
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-8 col-md-6 mb-2">
            <div class="card border-warning bg-white shadow rounded rounded-3">
                <div class="card-body text-center">
                    <h5 class="card-title">Egg Production and Reduction</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Last 7 Days</h6>
                    <div class="mb-2">
                        <canvas id="egg_chart" height="200"></canvas>
                    </div>
                    <div class="float-center p-0 mt-1">
                        <a href="./reports_chicken.php" class="card-link text-decoration-none p-0 opacity-75" style="font-size: 15px">View More In Report
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2 mb-2">
        <div class="col-xl-4 col-md-6 mb-2">
            <div class="card border-primary shadow">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-0">
                        Medicines Low In Stock
                    </h5>
                    <?php
                    // Select all medicine administration schedules where status is pending and order by ascending
                        $sql = "SELECT * FROM medicines WHERE archive='not archived' AND inStock < 10 ORDER BY medicine_ID ASC";
                        $stmt = $conn->query($sql);
                        if($stmt){
                            if($stmt->rowCount() > 0){
                                echo '<table id="medicineDashboard" class="table table-sm responsive mt-0 border table-hover text-center rounded rounded-3 overflow-hidden" style="width: 100%">';
                                    echo "<thead class='text-white' style='background-color: #2d4154'>";
                                        echo "<tr>";
                                            echo "<th>Medicine ID</th>";
                                            echo "<th>Name</th>";
                                            echo "<th>In Stock</th>";
                                        echo "</tr>";
                                    echo "</thead>";
                                    echo "<tbody>";
                                    while($row = $stmt->fetch()){
                                        echo "<tr>";
                                            echo "<td>" . $row['medicine_ID'] . "</td>";
                                            echo "<td>" . $row['medicineName'] . "</td>";
                                            if($row['inStock'] < 10){
                                                echo "<td>" . $row['inStock'] . '<span data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="Low In Stock"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-arrow-down-short" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L7.5 10.293V4.5A.5.5 0 0 1 8 4z"/>
                                            </svg></span>' . "</td>";
                                            }else{
                                                echo "<td>" . $row['inStock'] . '<span data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="In Stock"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-arrow-up-short" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 12a.5.5 0 0 0 .5-.5V5.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 5.707V11.5a.5.5 0 0 0 .5.5z"/>
                                            </svg></span>' . "</td>";
                                            }
                                        echo "</tr>";
                                    }
                                    echo "</tbody>";                            
                                echo "</table>";
                                // Free stmt set
                                unset($stmt);
                            } else{
                                echo '<table id="medicineDashboard" class="table table-sm responsive border table-hover text-center rounded rounded-3 overflow-hidden" style="width: 100%">';
                                    echo "<thead class='text-white' style='background-color: #2d4154'>";
                                        echo "<tr>";
                                            echo "<th>Medicine ID</th>";
                                            echo "<th>Name</th>";
                                            echo "<th>In Stock</th>";
                                        echo "</tr>";
                                    echo "</thead>";
                                    echo "<tbody>";
                                    while($row = $stmt->fetch()){
                                        
                                    }
                                    echo "</tbody>";                            
                                echo "</table>";
                            }
                        } else{
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                        
                        
                    ?>
                    <div class="float-center text-center p-0 mt-1">
                        <a href="./medicines.php" class="card-link text-decoration-none p-0 opacity-75" style="font-size: 15px">View More In Inventory
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-2">
            <div class="card border-primary shadow">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-0">
                        Medicines About To Expire
                    </h5>
                    <?php
                    // Select all medicine administration schedules where status is pending and order by ascending
                        $sql = "SELECT * FROM medicines WHERE archive='not archived' AND DATEDIFF(expirationDate, NOW()) <=60 ORDER BY medicine_ID ASC";
                        $stmt = $conn->query($sql);
                        if($stmt){
                            if($stmt->rowCount() > 0){
                                echo '<table id="medicineExpireDashboard" class="table table-sm responsive mt-0 border table-hover text-center rounded rounded-3 overflow-hidden" style="width: 100%">';
                                    echo "<thead class='text-white' style='background-color: #2d4154'>";
                                        echo "<tr>";
                                            // echo "<th>Date Added</th>";
                                            echo "<th>Name</th>";
                                            echo "<th>Expiry Date</th>";
                                            echo "<th>In Stock</th>";
                                        echo "</tr>";
                                    echo "</thead>";
                                    echo "<tbody>";
                                    while($row = $stmt->fetch()){
                                        //get dates from the row
                                        $dateAdded = $row['dateAdded'];
                                        $expirationDate = $row['expirationDate'];

                                        //store the expiration date inside another variable and user strotime
                                        $expDateSort = strtotime($row['expirationDate']);
                                        $dateAddedSort = strtotime($row['dateAdded']);
                                        //format the date
                                        $expDateFormatted = date("M. d, Y", $expDateSort);
                                        $dateAddedFormatted = date("M. d, Y", $dateAddedSort);

                                        //date_create is used to create DateTime object  https://blog.devgenius.io/how-to-find-the-number-of-days-between-two-dates-in-php-1404748b1e84?gi=f10f685035f3 / https://stackoverflow.com/questions/2040560/finding-the-number-of-days-between-two-dates
                                        $today = date_create(date('Y-m-d')); //generates current date
                                        $expD = date_create($expirationDate);

                                        //$newD = date('Y-m-d', strtotime($dateAdded. ' + 10 days'));
                                        //calculates the difference between the two dates
                                        $diff = date_diff($today,$expD);

                                        //store the calculated days, %r -> used to include sign and if the number is positive it will be empty, %a -> total number of days as a result from the date_diff https://www.php.net/manual/en/dateinterval.format.php
                                        $days = $diff->format('%r%a');

                                        echo "<tr>";
                                            // echo "<td data-sort='". $dateAddedSort ."'>" . $dateAddedFormatted . "</td>"; //display format of date, doesnt affect the database
                                            echo "<td>" . $row['medicineName'] . "</td>";
                                            //if days is lesser than or equals to zero, then the medicine is expired
                                            if($days < 1){
                                                echo "<td data-sort='". $expDateSort ."'>" . $expDateFormatted .
                                                        '<span data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="Medicine is expired."> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-exclamation-circle-fill" viewBox="0 0 16 16">
                                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                                                            </svg> 
                                                        </span>' .
                                                    "</td>"; 
                                            }
                                            else if($days < 60){ //if days is lesser than 60 then the medicine is about to expire
                                                echo "<td data-sort='". $expDateSort ."'>" . $expDateFormatted  .
                                                        '<span data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="Medicine is about to expire."> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="orange" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                            <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                                                        </svg> </span>' .
                                                    "</td>"; 
                                            }
                                            else if($days >= 60){ //if days is greater than 60 to zero, then the medicine not expired or not about to expire
                                                echo "<td data-sort='". $expDateSort ."'>" . $expDateFormatted  .
                                                        '<span data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="Good."> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-check-circle" viewBox="0 0 16 16">
                                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                            <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                                                        </svg><span>' .
                                                    "</td>"; 
                                            }

                                            if($row['inStock'] < 10){
                                                echo "<td>" . $row['inStock'] . '<span data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="Low In Stock"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-arrow-down-short" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L7.5 10.293V4.5A.5.5 0 0 1 8 4z"/>
                                            </svg></span>' . "</td>";
                                            }else{
                                                echo "<td>" . $row['inStock'] . '<span data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="In Stock"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-arrow-up-short" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 12a.5.5 0 0 0 .5-.5V5.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 5.707V11.5a.5.5 0 0 0 .5.5z"/>
                                            </svg></span>' . "</td>";
                                            }
                                        echo "</tr>";
                                    }
                                    echo "</tbody>";                            
                                echo "</table>";
                                // Free stmt set
                                unset($stmt);
                            } else{
                                echo '<table id="medicineExpireDashboard" class="table table-sm responsive border table-hover text-center rounded rounded-3 overflow-hidden" style="width: 100%">';
                                    echo "<thead class='text-white' style='background-color: #2d4154'>";
                                        echo "<tr>";
                                            // echo "<th>Date Added</th>";
                                            echo "<th>Name</th>";
                                            echo "<th>Expiry Date</th>";
                                            echo "<th>In Stock</th>";
                                        echo "</tr>";
                                    echo "</thead>";
                                    echo "<tbody>";
                                    while($row = $stmt->fetch()){
                                        
                                    }
                                    echo "</tbody>";                            
                                echo "</table>";
                            }
                        } else{
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                        
                        
                    ?>
                    <div class="float-center text-center p-0 mt-1">
                        <a href="./medicines.php" class="card-link text-decoration-none p-0 opacity-75" style="font-size: 15px">View More In Inventory
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-2">
            <div class="card border-primary shadow">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-0">
                        Feeds Low In Stock
                    </h5>
                    <?php
                        $sql = "SELECT * FROM feeds WHERE archive='not archived' AND inStock < 10 ORDER BY feed_ID ASC";
                        $stmt = $conn->query($sql);
                        if($stmt){
                            if($stmt->rowCount() > 0){
                                echo '<table id="feedDashboard" class="table table-sm responsive border table-hover text-center rounded rounded-3 overflow-hidden" style="width: 100%">';
                                    echo "<thead class='text-white' style='background-color: #2d4154'>";
                                        echo "<tr>";
                                            echo "<th>Feed ID</th>";
                                            echo "<th>Feed Name</th>";
                                            echo "<th>In Stock</th>";
                                        echo "</tr>";
                                    echo "</thead>";
                                    echo "<tbody>";
                                    while($row = $stmt->fetch()){
                                        //get dates from the row
                                        $datePurchased = $row['datePurchased'];

                                        //store the expiration date inside another variable and user strotime
                                        $dataSortExpD = strtotime($row['datePurchased']);
                                        //format the date
                                        $expDateFormatted = date("M. d, Y", $dataSortExpD);

                                        echo "<tr>";
                                            echo "<td>" . $row['feed_ID'] . "</td>";
                                            echo "<td>" . $row['feedName'] . "</td>";
                                            if($row['inStock'] < 10){
                                                echo "<td>" . $row['inStock'] . '<span data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="Low In Stock"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-arrow-down-short" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L7.5 10.293V4.5A.5.5 0 0 1 8 4z"/>
                                            </svg></span>' . "</td>";
                                            }else{
                                                echo "<td>" . $row['inStock'] . '<span data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="In Stock"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-arrow-up-short" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 12a.5.5 0 0 0 .5-.5V5.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 5.707V11.5a.5.5 0 0 0 .5.5z"/>
                                            </svg></span>' . "</td>";
                                            }
                                        echo "</tr>";
                                    }
                                    echo "</tbody>";                            
                                echo "</table>";
                                // Free stmt set
                                unset($stmt);
                            } else{
                                echo '<table id="feedDashboard" class="table table-sm responsive border table-hover text-center rounded rounded-3 overflow-hidden" style="width: 100%">';
                                echo "<thead class='text-white' style='background-color: #2d4154'>";
                                    echo "<tr>";
                                        echo "<th>Feed ID</th>";
                                        echo "<th>Feed Name</th>";
                                        echo "<th>In Stock</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = $stmt->fetch()){
                                    
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            }
                        } else{
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                        // Close connection
                        unset($conn);
                    ?>
                    <div class="float-center text-center p-0 mt-1">
                        <a href="./feeds.php" class="card-link text-decoration-none p-0 opacity-75" style="font-size: 15px">View More In Inventory
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                            </svg>
                        </a>
                    </div>
                </div>
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
    //const last 7 days
    const { oneweek, lastdaysBatch, oneweekDataset, oneweekDatasetReduction  } = {
        oneweek: <?php echo json_encode($oneweek);?>,
        lastdaysBatch: <?php echo json_encode($lastdaysBatch);?>,
        oneweekDataset: <?php echo json_encode($oneweekDataset);?>,
        oneweekDatasetReduction: <?php echo json_encode($oneweekDatasetReduction)?>,
        // startingQ:  echo json_encode($startingQ)?>startingQ
    };
    const oneweeklabel = lastdaysBatch.map((batch, index) => `${batch} ${oneweek[index]}`);

    const {size} = {
        size: <?php echo json_encode($size);?>,
    };
    var eggSizes = Object.keys(size);
    var eggInstock = Object.values(size);

    console.log(eggInstock)
    const {collectionDate, totalQuantity, totalReductions} = {
        collectionDate: <?php echo json_encode($collectionDate);?>,
        totalQuantity: <?php echo json_encode($totalQuantity);?>,
        totalReductions: <?php echo json_encode($totalReductions);?>
    };
    console.log(collectionDate)
    console.log(oneweeklabel)
    const ctx = document.getElementById('chicken_chart');
    new Chart(ctx, {
        type: 'bar',
        data: {
        labels: oneweek,
        datasets: [{
                    label: 'In Stock',
                    data: oneweekDataset,
                    borderWidth: 1,
                    backgroundColor: [
                    'rgb(34, 139, 134)',
                    ]
                },
                {
                    label: 'Reductions',
                    data: oneweekDatasetReduction,
                    borderWidth: 1,
                    backgroundColor: [
                    'rgb(255, 99, 132)',
                    ]
                }]
        },
        options: {
        scales: {
            y: {
            beginAtZero: true
            }
        },
        responsive: true,
        maintainAspectRatio: false
        },
        plugins: [{
            afterDatasetsDraw: ((chart, args, plugins) => {
            const {ctx, data, chartArea: {top, bottom, left, right, width, height}} = chart;

            ctx.save();
            
            if (data.datasets.length > 0) {
                console.log(data.datasets.length)
                console.log(data.datasets[0].data)
              if (data.datasets[0].data.every(item => Number(item) === 0) && data.datasets[1].data.every(item => Number(item) === 0)) {
                ctx.fillStyle = 'rgba(255, 255, 255, 1)';
                ctx.fillRect(left, top, width, height);

                ctx.font = '20px sans-serif';
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.fillText('No Data Available', left + width / 2, top + height / 2);
              }
            }

            })
        }]
    });

    const ctx2 = document.getElementById('eggSize_chart');
    // ctx2.canvas.width = 200;
    // ctx2.canvas.height = 200;.getContext("2d"
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
        labels: eggSizes,
        datasets: [{
                    label: 'In Stock',
                    data: eggInstock,
                    borderWidth: 1,
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(153, 51, 255)',
                        'rgb(153, 255, 255)',
                    ]
                }]
        },
        options: {
        // scales: {
        //     y: {
        //     beginAtZero: true
        //     }
        // },  
        maintainAspectRatio: false,
        responsive: true,
    // maintainAspectRatio: true
        },
        plugins: [{
            afterDatasetsDraw: ((chart, args, plugins) => {
            const {ctx, data, chartArea: {top, bottom, left, right, width, height}} = chart;

            ctx.save();
            
            if (data.datasets.length > 0) {
                console.log(data.datasets.length)
                console.log(data.datasets[0].data)
              if (data.datasets[0].data.every(item => Number(item) === 0)) {
                ctx.fillStyle = 'rgba(255, 255, 255, 1)';
                ctx.fillRect(left, top, width, height);

                ctx.font = '20px sans-serif';
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.fillText('No Data Available', left + width / 2, top + height / 2);
              }
            }

        })
        }]
    });

    const ctx3 = document.getElementById('egg_chart');
    new Chart(ctx3, {
        type: 'bar',
        data: {
        labels: collectionDate,
        datasets: [{
                    label: 'In Stock',
                    data: totalQuantity,
                    borderWidth: 1,
                    backgroundColor: [
                    'rgb(34, 139, 134)',
                    ]
                },
                {
                    label: 'Reductions',
                    data: totalReductions,
                    borderWidth: 1,
                    backgroundColor: [
                    'rgb(255, 99, 132)',
                    ]
                }]
        },
        options: {
        scales: {
            y: {
            beginAtZero: true
            }
        },
        maintainAspectRatio: false,
        },
        plugins: [{
            afterDatasetsDraw: ((chart, args, plugins) => {
            const {ctx, data, chartArea: {top, bottom, left, right, width, height}} = chart;

            ctx.save();
            
            if (data.datasets.length > 0) {
                console.log(data.datasets.length)
                console.log(data.datasets[0].data)
              if (data.datasets[0].data.every(item => Number(item) === 0) && data.datasets[1].data.every(item => Number(item) === 0)) {
                ctx.fillStyle = 'rgba(255, 255, 255, 1)';
                ctx.fillRect(left, top, width, height);

                ctx.font = '20px sans-serif';
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.fillText('No Data Available', left + width / 2, top + height / 2);
              }
            }

        })
        }]
    });
</script>