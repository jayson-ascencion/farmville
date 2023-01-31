<?php
    //title of the pge
    $title = "Chicken Production";

    //header
    include("../../includes/header.php");
    
?>

<!-- content --> 
<div id="content" class="container-fluid px-4">

    <h1 class="mt-4"> Manager Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./index.php" style="text-decoration: none">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Chicken Production</li>
    </ol>

    <div class="wrapper">
        <div class="container">
            <div class="row mb-5">
                <div class="p-0">
                    <div class="card bg-light shadow-sm">
                        <div class="card-header" style="background-color: #f37e57">
                        <div class="row justify-content-between">
                                <div class="col-xl-8 col-md-6">
                                    <h4 class="pt-2 fs-5 fw-bold">Chicken Production and Reduction Reports</h4>
                                </div>

                                <div class="col-xl-4 col-md-4 align-content-end">
                                    <div class="w-100 d-flex justify-content-end">
                                        <div class="m-1 w-100 float-end">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Select Time Frame
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <button class="dropdown-item" onclick="timeFrame(this)" value="lastdays">Last 7 Days</button>
                                                    <button class="dropdown-item" onclick="timeFrame(this)" value="weekly">Weekly</button>
                                                    <button class="dropdown-item" onclick="timeFrame(this)" value="monthly">Monthly</button>
                                                    <button class="dropdown-item" onclick="timeFrame(this)" value="yearly">Yearly</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-1 w-100 float-end">
                                            <a href="add_chicken_form.php" class="btn btn-outline-success shadow-sm w-100 fw-bold">Print Report</a>
                                        </div>
                                        
                                        <!-- <div class="m-1 w-100">
                                            <a href="#" class="btn btn-outline-danger shadow-sm w-100 fw-bold">Archives</a>                                 
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="w-100 d-flex justify-content-between p-2">
                                <div>
                                    <h4 class="pt-2 fw-bold fs-5">Chicken Production</h4>
                                </div>

                                <div>
                                    <a href="add_chicken_form.php" class="btn btn-primary pt-2">Add Chicken</a>
                                </div>
                            </div> -->
                            <!-- <div class="row justify-content-between">
                                <div>
                                    <h4 class="pt-2 fs-5 fw-bold"></h4>
                                </div>
                                <div>
                                    <h4 class="pt-2 fs-5 fw-bold">Chicken Production and Reduction Reports</h4>
                                </div>
                            </div> -->
                        </div>
                        <div>
                            <?php 
                                include("../../includes/loader.php");

                                //connect to the database
                                include('../../../config/database_connection.php');

                                // //statement get the today
                                // $sql = "SELECT SUM(COALESCE(inStock, 0)) as instock, batchName, dateAcquired AS acquiredDate FROM chickenproduction WHERE dateAcquired = CURDATE()";                                
                                // $stmt = $conn->query($sql);
                                //  if($stmt){
                                //      if($stmt->rowCount() > 0){
                                //         $todaysDate = array();
                                //         $todayDataset = array();
                                //         $todaysBatch = array();
                                //         while($row = $stmt->fetch()){
                                //             // $todaysDate[] = $row['acquiredDate'];
                                //             // $todayDataset[] = $row['instock'];
                                //             // $todaysBatch[] = $row['batchName'];
                                //             $todaysBatch[] = (is_null($row['batchName'])) ? 'no data' : $row['batchName'];
                                //             $todaysDate[] = (is_null($row['acquiredDate'])) ? date('Y-m-d') : $row['acquiredDate'];
                                //             $todayDataset[] = (is_null($row['instock'])) ? 0 : $row['instock'];

                                //         }
                                //         // Free result set
                                //         unset($result);
                                //     }
                                // }
                                // else{
                                //     echo "Oops! Something went wrong. Please try again later.";
                                // }

                                //statement get the last 7 days
                                $sql = "SELECT cp.chickenBatch_ID, cp.coopNumber as cpCoop, cp.batchName, cp.breedType, cp.startingQuantity, SUM(COALESCE(cp.inStock, 0)) as instock, DATE_FORMAT(cp.dateAcquired, '%M %d') AS acquiredDate, DATE_FORMAT(COALESCE((cr.dateReduced),'0000-00-00'), '%M %d') as dateReduced, cr.coopNumber as crCoop, COALESCE(SUM(cr.quantity),0) as totalReductions
                                FROM chickenproduction cp LEFT JOIN chickenreduction cr ON cp.chickenBatch_ID = cr.chickenBatch_ID
                                WHERE dateAcquired BETWEEN CURDATE() - INTERVAL 6 DAY AND CURDATE()
                                GROUP BY acquiredDate";
                                //"SELECT SUM(COALESCE(inStock, 0)) as instock, batchName, DATE_FORMAT(dateAcquired, '%M-%d-%Y') AS acquiredDate FROM chickenproduction WHERE dateAcquired BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE() GROUP BY acquiredDate";
                                $stmt = $conn->query($sql);
                                 if($stmt){
                                     if($stmt->rowCount() > 0){
                                        $oneweek = array();
                                        $oneweekDataset = array();
                                        $lastdaysBatch = array();
                                        while($row = $stmt->fetch()){
                                            // $oneweek[] = $row['acquiredDate'];
                                            $oneweek[] = (is_null($row['acquiredDate'])) ? date('M d') : $row['acquiredDate'];
                                            $oneweekDataset[] = $row['instock'];
                                            $oneweekDatasetReduction[] = $row['totalReductions'];
                                            $lastdaysBatch[] = $row['batchName'];
                                            $startingQ[] = $row['startingQuantity'];
                                        }
                                    }
                                        // Free result set
                                        unset($stmt);
                                }
                                else{
                                    echo "Oops! Something went wrong. Please try again later.";
                                }

                                //statement the reductions by type
                                $sql = "WITH all_reduction_types AS ( SELECT 'Culled' as reductionType UNION SELECT 'Sold' UNION SELECT 'Death' UNION SELECT 'Lost/Stolen' ) SELECT all_reduction_types.reductionType, SUM(COALESCE(chickenreduction.quantity, 0)) as reductions FROM all_reduction_types LEFT JOIN chickenreduction ON all_reduction_types.reductionType = chickenreduction.reductionType 
                                AND dateReduced BETWEEN CURDATE() - INTERVAL 6 DAY AND CURDATE() GROUP BY all_reduction_types.reductionType";
                                
                                $stmt = $conn->query($sql);
                                 if($stmt){
                                     if($stmt->rowCount() > 0){
                                        // $culled = array();
                                        // $sold = array();
                                        // $lost = array();
                                        // $death = array();
                                        while($row = $stmt->fetch()){
                                            if($row['reductionType'] == 'Culled'){
                                                $culled = $row['reductions'];
                                            }
                                            else if($row['reductionType'] == 'Sold'){
                                                $sold = $row['reductions'];
                                            }else if($row['reductionType'] == 'Death'){
                                                $death = $row['reductions'];
                                            }else if($row['reductionType'] == 'Lost/Stolen'){
                                                $lost = $row['reductions'];
                                            }
                                        }
                                    }
                                        // Free result set
                                        unset($stmt);
                                }
                                else{
                                    echo "Oops! Something went wrong. Please try again later.";
                                }
                                //statement get the weekly the whole year
                                // $sql = "SELECT WEEK(dateAcquired) as weekNumber, MONTH(dateAcquired) as month, DAY(dateAcquired) as day, SUM(inStock) as totalInStock, batchName
                                // FROM chickenproduction
                                // WHERE YEAR(dateAcquired) = 2022
                                // GROUP BY weekNumber";
                                $sql = "SELECT WEEK(dateAcquired,1) as weekNumber,
                                DATE_FORMAT(dateAcquired, '%M-%d-%Y') as monthDay,
                                SUM(COALESCE(inStock,0)) as totalInStock,
                                SUM(startingQuantity) as totalSQ,
                                batchName
                                FROM chickenproduction
                                WHERE YEAR(dateAcquired) >= 2022
                                GROUP BY weekNumber, MONTH(dateAcquired)
                                ORDER BY MONTH(dateAcquired)";
                                $stmt = $conn->query($sql);
                                 if($stmt){
                                     if($stmt->rowCount() > 0){
                                        $weekly = array();
                                        $monthDay = array();
                                        $weeklyTotalDataset = array();
                                        $weeklyBatch = array();
                                        $weeklyReductions = array();
                                        $weeklyTotalSQ = array();
                                        while($row = $stmt->fetch()){
                                            $weekly[] = $row['weekNumber'];
                                            $monthDay[] = $row['monthDay'];
                                            $weeklyTotalDataset[] = $row['totalInStock'];
                                            $weeklyBatch[] = $row['batchName'];
                                        }
                                        // Free result set
                                        unset($result);
                                    }
                                }
                                else{
                                    echo "Oops! Something went wrong. Please try again later.";
                                }

                                //statement get the monthly
                                $sql = "SELECT DATE_FORMAT(dateAcquired, '%M-%Y') as monthYear,
                                SUM(inStock) as totalInStock
                                FROM chickenproduction
                                WHERE YEAR(dateAcquired) >= 2022
                                GROUP BY DATE_FORMAT(dateAcquired, '%M')
                                ORDER BY YEAR(dateAcquired) ASC, MONTH(dateAcquired) ASC";
                                $stmt = $conn->query($sql);
                                 if($stmt){
                                     if($stmt->rowCount() > 0){
                                        $monthYear = array();
                                        $monthlyDataset = array();
                                        while($row = $stmt->fetch()){
                                            $monthYear[] = $row['monthYear'];
                                            $monthlyDataset[] = $row['totalInStock'];
                                        }
                                        
                                        // Free result set
                                        unset($result);
                                    }
                                }
                                else{
                                    echo "Oops! Something went wrong. Please try again later.";
                                }

                                //statement get the yearly
                                $sql = "SELECT YEAR(dateAcquired) as year,
                                SUM(inStock) as totalInStock
                                FROM chickenproduction
                                WHERE YEAR(dateAcquired) >= 2022
                                GROUP BY YEAR(dateAcquired)
                                ORDER BY YEAR(dateAcquired) ASC";
                                $stmt = $conn->query($sql);
                                 if($stmt){
                                     if($stmt->rowCount() > 0){
                                        $year = array();
                                        $yearlyDataset = array();
                                        while($row = $stmt->fetch()){
                                            $year[] = $row['year'];
                                            $yearlyDataset[] = $row['totalInStock'];
                                        }
                                        // Free result set
                                        unset($result);
                                    }
                                }
                                else{
                                    echo "Oops! Something went wrong. Please try again later.";
                                }
                            ?>
                        </div>
                        <div class="card-body displayTable">
                            <div>
                                <div id="charttitle" class="text-center fw-bold mb-1 fs-5" style="color: #747474"></div>
                                <div class="chart-container">
                                    <canvas id="myChart" height="100"></canvas>
                                </div>
                                
                                <!-- <button onclick="timeFrame(this)" value="day">Today</button> -->
                                <!-- <div class="mt-3 m-2"> class="m-3 ms-5 me-5 mb-0"
                                    <button onclick="timeFrame(this)" value="lastdays">Last 7 Days</button>
                                    <button onclick="timeFrame(this)" value="weekly">Weekly</button>
                                    <button onclick="timeFrame(this)" value="monthly">Monthly</button>
                                    <button onclick="timeFrame(this)" value="yearly">Yearly</button>
                                </div> -->
                            </div>

                            <!--  -->
                            <!-- <div id="reductiontype" >
                                <div class="row p-3 text-center">
                                    <div class="col-sm">
                                        <div class="card bg-primary text-white mb-2">
                                            <div class="card-header">Sold: 
                                                <span id="sold" class="fw-bold fs-6" > </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="card bg-primary text-white mb-2">
                                            <div class="card-header">Culled: 
                                                <span class="fw-bold fs-6" id="culled"> </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="card bg-primary text-white mb-2">
                                            <div class="card-header">Death: 
                                                <span class="fw-bold fs-6" id="death"> </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="card bg-primary text-white mb-2">
                                            <div class="card-header">Lost / Stolen: 
                                                <span class="fw-bold fs-6" id="lost"> </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <!--  -->
                            <!--  -->
                            <div class="wrapper">
                                <div class="row p-3 text-center table-responsive">
                                    <div class="col col-xs-2">
                                                <p id="samplehuhu"></p>
                                        <div class="card text-white">
                                            <!-- <div class="card-header bg-secondary">Production: <span class="fw-bold fs-6"> </span></div> -->
                                                <!-- <div class="mt-5 table-responsive col-xl-8 col-sm-2"> -->
                                                <table id="productionTable" class="table table-borderless table-hover text-center rounded rounded-3 overflow-hidden">
                                                    <thead id="prodHeader"class="bg-dark text-white">
                                                    </thead>
                                                    <tbody id="prodBody">
                                                    </tbody>
                                                </table>
                                        </div>
                                    </div>
                                    <div class="col">
                                                <p id="samplehuhu"></p>
                                        <div class=" text-white mb-5">
                                            <!-- <div class="card-header bg-secondary">Production: <span class="fw-bold fs-6"> </span></div> -->
                                                <!-- <div class="mt-5 table-responsive col-xl-8 col-sm-2"> -->
                                                <table id="reductionTable" class="table table-borderless table-hover text-center rounded rounded-3 overflow-hidden">
                                                    <!-- <thead class="bg-dark text-white">
                                                        <th>Reduction Type</th>
                                                        <th>Total Reductions</th>
                                                    </thead> -->
                                                    <tbody>
                                                        <tr>
                                                            <td>Sold</td>
                                                            <td id="sold"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Culled</td>
                                                            <td id="culled"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Death</td>
                                                            <td id="death"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Lost/Stolen</td>
                                                            <td id="lost"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--  -->
                            
  
                        </div>
                    </div>
                </div>
            </div>        
        </div>
    </div>

</div>
<!-- end of content -->
<?php
    include("../../includes/footer.php");
?>

<script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous" async defer></script>
        <script src="../../../assets/js/jquery-3.6.1.min.js"></script>
        <script src="../../../assets/js/bootstrap5.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../../../assets/js/scripts.js"></script>
        <script src="../../../assets/js/popper.min.js"></script>
        <script src="../../../assets/js/datatables.min.js"></script>
        <script src="../../../assets/js/pdfmake.min.js"></script>
        <script src="../../../assets/js/vfs_fonts.js"></script>
        <script src="../../../assets/js/chart.js"></script>
        <script src="../../../assets/js/chartjs-adapter-date-fns.bundle.min.js"></script>
        <script>

            // $('#productionTable').DataTable({
            //     paging: true,
            //     order: 0
            // });
            //script for tooltip
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        
            //for loader
            window.onload = function() {
                // Hide the loading icon when the page finishes loading
                document.querySelector('.loader-container').style.display = 'none';
                // Show the content when the page finishes loading
                document.querySelector('.displayTable').style.display = 'block';
                timeFrame({value:'lastdays'});
            };

            document.onreadystatechange = function() {
            if (document.readyState !== 'complete') {
                // Hide the displayTable while the page is still loading
                document.querySelector('.displayTable').style.display = 'none';
            }
            };

            //trial for chart https://youtube.com/playlist?list=PLc1g3vwxhg1Xr2r2VodhuthKo0GClc7V8

            //const last 7 days
            const { oneweek, lastdaysBatch, oneweekDataset, oneweekDatasetReduction, startingQ } = {
                oneweek: <?php echo json_encode($oneweek);?>,
                lastdaysBatch: <?php echo json_encode($lastdaysBatch);?>,
                oneweekDataset: <?php echo json_encode($oneweekDataset);?>,
                oneweekDatasetReduction: <?php echo json_encode($oneweekDatasetReduction)?>,
                startingQ: <?php echo json_encode($startingQ)?>
            };
            const oneweeklabel = lastdaysBatch.map((batch, index) => `${batch} ${oneweek[index]}`);
            
            //const week
            const { weekly, monthDay, weeklyTotalDataset, weeklyBatch } = {
                weekly: <?php echo json_encode($weekly);?>,
                monthDay: <?php echo json_encode($monthDay);?>,
                weeklyTotalDataset: <?php echo json_encode($weeklyTotalDataset);?>,
                weeklyBatch: <?php echo json_encode($weeklyBatch);?>
            }
            const weeklyLabel = weekly.map((week, index) => `${week} ${monthDay[index]}`);
           
            //const month
            const { monthYear, monthlyDataset } = {
                monthYear: <?php echo json_encode($monthYear);?>,
                monthlyDataset: <?php echo json_encode($monthlyDataset);?>,
            }

            var { sold, culled, death, lost } = {
                sold: <?php echo $sold;?>,
                culled: <?php echo $culled;?>,
                death: <?php echo $death;?>,
                lost: <?php echo $lost;?>,
            }
            console.log(sold)
            
            // Convert date strings to Date objects
            
            //const year
            const { year, yearlyDataset} = {
                year: <?php echo json_encode($year);?>,
                yearlyDataset: <?php echo json_encode($yearlyDataset);?>,
            }
            console.log(year)

            // const dates = oneweek.map(date => Date.parse(date));
            // const dates = oneweek.map(date => new Date(date));
            const dates = oneweek.concat(weekly).concat(monthYear).map(date => new Date(date));

            // const batchNames = todaysBatch.concat(lastdaysBatch).concat(weeklyBatch).map(batch => batch.batchName);

            //setup block(dateToday.length == null) ? ['no data'] : (todayDataset.length == 0) ? [0] : 
            const data = {
                labels: [],
                datasets: []
            };
            
            //config block STABLE TEMPORARY COMMENT
            // const config = {
            //     type: 'pie', 
            //     data,
            //     options: {
            //         scales: {
            //             x: {
            //                 // min: '2015-01-01',  
            //                 // max: '2022-12-31',
            //                 type: 'time',
            //                 time: {
            //                     unit: 'day'
            //                 },
            //                 grid: {
            //                     display: false
            //                 },
            //                 display: false
            //             },
            //             y: {
            //                 // beginAtZero: false,
            //                 grid: {
            //                     display: false
            //                 },
            //                 display: false
            //             }
            //         },
            //     }
            // };

            const config = {
                type: 'bar',
                data,
                options: {
                    scales: {
                    y: {
                        beginAtZero: true
                    }
                    }
                },
            };

            //render block
            const myChart = new Chart(
                document.getElementById('myChart'),
                config,
            );

            $('#productionTable').DataTable({
                info: true
            });
            function timeFrame(period){
                const prodHeader = document.getElementById("prodHeader");
                const prodBody = document.getElementById("prodBody");
                const redHeader = document.getElementById("redHeader");
                const redBody = document.getElementById("redBody");

                //color
                const blue = 'rgba(54, 162, 235, 0.7)';
                const green = 'rgba(75, 192, 192, 0.7)';
                const red = 'rgba(255, 99, 132, 0.7)';

                if(period.value === 'lastdays'){
                    
                    document.getElementById("charttitle").innerHTML = 'Last 7 Days Report';
                    // reductiontype.style.display = 'block';
                    // console.log(sold);
                    document.getElementById("sold").innerHTML = sold;
                    document.getElementById("culled").innerHTML = culled;
                    document.getElementById("death").innerHTML = death;
                    document.getElementById("lost").innerHTML = lost;
                    let periodDatasets = [
                        {
                            label: 'Starting Quantity',
                            data: startingQ,
                            borderWidth: 1,
                            backgroundColor: blue,
                            hoverOffset: 4
                        },
                        {
                            label: 'Total In Stock',
                            data: oneweekDataset,
                            borderWidth: 1,
                            backgroundColor: green,
                            hoverOffset: 4
                        },
                        {
                            label: 'Total Reductions',
                            data: oneweekDatasetReduction,
                            borderWidth: 1,
                            backgroundColor: red,
                            hoverOffset: 4
                        },
                    ];
                    // myChart.config.options.scales.x.time.unit = 'day';
                    myChart.config.data.labels = oneweeklabel;
                    myChart.config.data.datasets = periodDatasets;
                    // myChart.config.data.datasets[0].label = 'Starting Quantity';
                    // myChart.config.data.datasets[0].data = startingQ;
                    // myChart.config.data.datasets[1].label = 'Total In Stock';
                    // myChart.config.data.datasets[1].data = oneweekDataset;
                    // myChart.config.data.datasets[2].label = 'Total In Reductions';
                    // myChart.config.data.datasets[2].data = oneweekDatasetReduction;
                    console.log(period.value)
                    myChart.update();

                    // $(`#productionTable thead`).empty();
                    // oneWeekBtn.click();
                    prodHeader.innerHTML = "";
                    prodBody.innerHTML = ""; //clear existing data
                    let row = prodHeader.insertRow();
                    let dateCell = row.insertCell(0);
                    // let batchNameCell = row.insertCell(1);
                    let startingCell = row.insertCell(1);
                    let inStockCell = row.insertCell(2);
                    let reductionCell = row.insertCell(3);
                    dateCell.innerHTML = "Date";
                    // batchNameCell.innerHTML = "Batch";
                    startingCell.innerHTML = "Starting Quantity";
                    inStockCell.innerHTML = "In Stock";
                    reductionCell.innerHTML = "Reductions";

                    for(let i = 0; i < oneweek.length; i++) {
                    let row = prodBody.insertRow();
                    let dateCell = row.insertCell(0);
                    // let batchNameCell = row.insertCell(1);
                    let startingCell = row.insertCell(1);
                    let inStockCell = row.insertCell(2);
                    let reductionCell = row.insertCell(3);
                    dateCell.innerHTML = oneweek[i];
                    // batchNameCell.innerHTML = lastdaysBatch[i];
                    startingCell.innerHTML = startingQ[i];
                    inStockCell.innerHTML = oneweekDataset[i];
                    reductionCell.innerHTML = oneweekDatasetReduction[i];
                    }
                    // redHeader.innerHTML = "";
                    // redBody.innerHTML = ""; //clear existing data
                    // let newrow = redHeader.insertRow();
                    // let datecell2 = newrow.insertCell(0);
                    // let instockcell2 = newrow.insertCell(1);
                    // datecell2.innerHTML = "Date";
                    // instockcell2.innerHTML = "In Stock";

                    // for(let i = 0; i < oneweek.length; i++) {
                    // let row = redBody.insertRow();
                    // let datecell2 = row.insertCell(0);
                    // let instockcell2 = row.insertCell(1);
                    // datecell2.innerHTML = oneweek[i];
                    // instockcell2.innerHTML = oneweekDataset[i];
                    // }
                }
                if(period.value === 'weekly'){
                    document.getElementById("charttitle").innerHTML = 'Weekly Report';
                    reductiontype.style.display = 'none';
                    // myChart.config.options.scales.x.time.unit = 'week';
                    // summ.style.display = 'grid';
                    // xs.innerHTML = '1';
                    // s.innerHTML = '2';
                    // m.innerHTML = '3';
                    // l.innerHTML = '4';
                    // xl.innerHTML = '5';
                    let periodDatasets = [
                        {
                            label: 'Total Per Week',
                            data: weeklyTotalDataset,
                            borderWidth: 1,
                            backgroundColor: blue,
                            hoverOffset: 4
                        }
                    ];
                    myChart.config.data.labels = weeklyLabel.map(week => 'Week ' + week);//weekly.map(week => 'Week ' + week);//  weeklyBatch
                    // myChart.config.data.datasets.label = 'Total Per Week';
                    myChart.config.data.datasets = periodDatasets;
                    // myChart.config.data.datasets.splice(1);
                    console.log(period.value)
                    myChart.update();
                 

                    prodHeader.innerHTML = "";
                    prodBody.innerHTML = ""; //clear existing data
                    let row = prodHeader.insertRow();
                    let dateCell = row.insertCell(0);
                    let inStockCell = row.insertCell(1);
                    dateCell.innerHTML = "Date";
                    inStockCell.innerHTML = "Weekly In Stock";

                    for(let i = 0; i < weekly.length; i++) {
                    let row = prodBody.insertRow();
                    let dateCell = row.insertCell(0);
                    let inStockCell = row.insertCell(1);
                    dateCell.innerHTML = monthDay[i];
                    inStockCell.innerHTML = weeklyTotalDataset[i];
                    }
                    console.log(weeklyBatch)

                    // redHeader.innerHTML = "";
                    // redBody.innerHTML = ""; //clear existing data
                    // let newrow = redHeader.insertRow();
                    // let datecell2 = newrow.insertCell(0);
                    // let instockcell2 = newrow.insertCell(1);
                    // datecell2.innerHTML = "Date";
                    // instockcell2.innerHTML = "In Stock";

                    // for(let i = 0; i < oneweek.length; i++) {
                    // let row = redBody.insertRow();
                    // let datecell2 = row.insertCell(0);
                    // let instockcell2 = row.insertCell(1);
                    // datecell2.innerHTML = oneweek[i];
                    // instockcell2.innerHTML = oneweekDataset[i];
                    // }
                }
                if(period.value === 'monthly'){
                    document.getElementById("charttitle").innerHTML = 'Monthly Report';
                    reductiontype.style.display = 'none';
                    let periodDatasets = [
                        {
                            label: 'Total Per Month',
                            data: monthlyDataset,
                            borderWidth: 1,
                            backgroundColor: blue,
                            hoverOffset: 4
                        }
                    ];
                    // myChart.config.options.scales.x.time.unit = 'month';
                    myChart.config.data.labels = monthYear;                    
                    // myChart.config.data.datasets.label = 'Total Per Month';
                    myChart.config.data.datasets = periodDatasets;
                    myChart.config.data.datasets.splice(1);
                    console.log(period.value)
                    myChart.update();
                }
                if(period.value === 'yearly'){
                    document.getElementById("charttitle").innerHTML = 'Yearly Report';
                    reductiontype.style.display = 'none';
                    let periodDatasets = [
                        {
                            label: 'Total Per Year',
                            data: yearlyDataset,
                            borderWidth: 1,
                            backgroundColor: blue,
                            hoverOffset: 4
                        }
                    ];
                    // myChart.config.options.scales.x.time.unit = 'year';
                    myChart.config.data.labels = year;
                    myChart.config.data.datasets = periodDatasets;
                    myChart.config.data.datasets.splice(1);
                    console.log(period.value)
                    myChart.update();
                }
                // myChart.update();
                
            }
        </script>

    </body>
</html>
  
   