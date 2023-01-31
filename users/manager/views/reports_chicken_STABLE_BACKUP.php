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

                            <!-- <div class="w-100 d-flex justify-content-between p-2">
                                <div>
                                    <h4 class="pt-2 fw-bold fs-5">Chicken Production</h4>
                                </div>

                                <div>
                                    <a href="add_chicken_form.php" class="btn btn-primary pt-2">Add Chicken</a>
                                </div>
                            </div> -->
                            <div class="row justify-content-between">
                                <div>
                                    <h4 class="pt-2 fs-5 fw-bold">Chicken Production and Reduction Reports</h4>
                                </div>
                            </div>
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
                                $sql = "SELECT SUM(COALESCE(inStock, 0)) as instock, batchName, DATE_FORMAT(dateAcquired, '%M-%d-%Y') AS acquiredDate FROM chickenproduction WHERE dateAcquired BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE() GROUP BY acquiredDate";
                                $stmt = $conn->query($sql);
                                 if($stmt){
                                     if($stmt->rowCount() > 0){
                                        $oneweek = array();
                                        $oneweekDataset = array();
                                        $lastdaysBatch = array();
                                        while($row = $stmt->fetch()){
                                            $oneweek[] = $row['acquiredDate'];
                                            $oneweekDataset[] = $row['instock'];
                                            $lastdaysBatch[] = $row['batchName'];
                                        }
                                        // Free result set
                                        unset($result);
                                    }
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
                                SUM(inStock) as totalInStock,
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
                            <div class="col-md-8 col-sm-4">
                                <div class="chartCard">
                                    <div class="chartBox">
                                        <canvas id="myChart" class="h-50 w-20"></canvas>
                                        <!-- <button onclick="timeFrame(this)" value="day">Today</button> -->
                                        <button onclick="timeFrame(this)" value="lastdays" id="lastdays">Last 7 Days</button>
                                        <button onclick="timeFrame(this)" value="weekly" id="weekly">Weekly</button>
                                        <button onclick="timeFrame(this)" value="monthly">Monthly</button>
                                        <button onclick="timeFrame(this)" value="yearly">Yearly</button>
                                    </div>
                                </div>
                            </div>
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
        <script src="../../../assets/js/popper.min.js" async defer></script>
        <!-- <script src="../../../assets/js/datatables.min.js"></script> -->
        <script src="../../../assets/js/pdfmake.min.js"></script>
        <script src="../../../assets/js/vfs_fonts.js" async defer></script>
        <script src="../../../assets/js/chart.js"></script>
        <script src="../../../assets/js/chartjs-adapter-date-fns.bundle.min.js"></script>
        <script>

            //script for tooltip
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        
            //for loader
            window.onload = function() {
                // Hide the loading icon when the page finishes loading
                document.querySelector('.loader-container').style.display = 'none';
                // Show the content when the page finishes loading
                document.querySelector('.displayTable').style.display = 'block';
            };

            document.onreadystatechange = function() {
            if (document.readyState !== 'complete') {
                // Hide the displayTable while the page is still loading
                document.querySelector('.displayTable').style.display = 'none';
            }
            };

            //trial for chart https://youtube.com/playlist?list=PLc1g3vwxhg1Xr2r2VodhuthKo0GClc7V8

            //const last 7 days
            const oneweek = <?php echo json_encode($oneweek);?>;
            const oneweekDataset = <?php echo json_encode($oneweekDataset);?>;
            const lastdaysBatch = <?php echo json_encode($lastdaysBatch)?>;
            let oneweeklabel = [];
            for (let i = 0; i < lastdaysBatch.length; i++) {
                oneweeklabel.push(lastdaysBatch[i] + ' ' + oneweek[i]);
            }

            console.log(oneweeklabel)
            //const week
            const weekly = <?php echo json_encode($weekly);?>;
            const monthDay = <?php echo json_encode($monthDay);?>;
            const weeklyTotalDataset = <?php echo json_encode($weeklyTotalDataset);?>;
            const weeklyBatch = <?php echo json_encode($weeklyBatch);?>;
            let weeklyLabel = [];
            for (let i = 0; i < weekly.length; i++) {
                weeklyLabel.push(weekly[i] + ' ' + monthDay[i]);
            }

            //const month
            const monthYear = <?php echo json_encode($monthYear);?>;
            const monthlyDataset = <?php echo json_encode($monthlyDataset);?>;
            console.log(monthYear)
            // Convert date strings to Date objects
            
            //const year
            const year = <?php echo json_encode($year);?>;
            const yearlyDataset = <?php echo json_encode($yearlyDataset);?>;
            console.log(year)

            // const dates = oneweek.map(date => Date.parse(date));
            // const dates = oneweek.map(date => new Date(date));
            const dates = oneweek.concat(weekly).concat(monthYear).map(date => new Date(date));

            // const batchNames = todaysBatch.concat(lastdaysBatch).concat(weeklyBatch).map(batch => batch.batchName);

            //setup block(dateToday.length == null) ? ['no data'] : (todayDataset.length == 0) ? [0] : 
            const data = {
                labels: oneweeklabel,
                datasets: [{
                    label: 'Total',
                    data: oneweekDataset,
                    borderWidth: 1,
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 200)',
                        'rgb(255, 205, 40)',
                        'rgb(255, 99, 100)',
                        'rgb(54, 162, 150)',
                        'rgb(255, 205, 80)',
                        'rgb(255, 99, 140)',
                        'rgb(54, 162, 200)',
                        'rgb(255, 205, 99)',
                        'rgb(255, 99, 120)',
                        'rgb(54, 162, 233)',
                        'rgb(255, 205, 103)',
                    ],
                    hoverOffset: 4
                },
                // {
                //     label: oneweeklabel,
                //     data: oneweekDataset,
                //     borderWidth: 1
                // }
                ]
            };
            
            //config block
            const config = {
                type: 'pie', 
                data,
                options: {
                    scales: {
                        x: {
                            // min: '2015-01-01',  
                            // max: '2022-12-31',
                            type: 'time',
                            time: {
                                unit: 'day'
                            },
                            grid: {
                                display: false
                            },
                            display: false
                        },
                        y: {
                            // beginAtZero: false,
                            grid: {
                                display: false
                            },
                            display: false
                        }
                    },
                }
            };

            //render block
            const myChart = new Chart(
                document.getElementById('myChart'),
                config,
            );

            function timeFrame(period){
                if(period.value === 'lastdays'){
                    myChart.config.options.scales.x.time.unit = 'day';
                    myChart.config.data.labels = oneweeklabel;
                    myChart.config.data.datasets[0].label = 'Total';
                    myChart.config.data.datasets[0].data = oneweekDataset;
                    console.log(period.value)
                }
                if(period.value === 'weekly'){
                    myChart.config.options.scales.x.time.unit = 'week';
                    myChart.config.data.labels = weeklyLabel.map(week => 'Week ' + week);//weekly.map(week => 'Week ' + week);//  weeklyBatch
                    myChart.config.data.datasets[0].label = 'Total Per Week';
                    myChart.config.data.datasets[0].data = weeklyTotalDataset;
                    console.log(period.value)
                    // console.log(weeklyBatch)
                }
                if(period.value === 'monthly'){
                    myChart.config.options.scales.x.time.unit = 'month';
                    myChart.config.data.labels = monthYear;                    
                    myChart.config.data.datasets[0].label = 'Total Per Month';
                    myChart.config.data.datasets[0].data = monthlyDataset;
                    console.log(period.value)
                }
                if(period.value === 'yearly'){
                    myChart.config.options.scales.x.time.unit = 'year';
                    myChart.config.data.labels = year;
                    myChart.config.data.datasets[0].data = yearlyDataset;
                    console.log(period.value)
                }
                myChart.update();
            }
        </script>

    </body>
</html>
  
   