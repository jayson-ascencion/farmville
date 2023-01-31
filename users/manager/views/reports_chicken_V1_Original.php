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

                                //statement get the today
                                $sql = "SELECT SUM(COALESCE(inStock, 0)) as instock, batchName, dateAcquired AS acquiredDate FROM chickenproduction WHERE dateAcquired = CURDATE()";                                
                                $stmt = $conn->query($sql);
                                 if($stmt){
                                     if($stmt->rowCount() > 0){
                                        $todaysDate = array();
                                        $todayDataset = array();
                                        $todaysBatch = array();
                                        while($row = $stmt->fetch()){
                                            // $todaysDate[] = $row['acquiredDate'];
                                            // $todayDataset[] = $row['instock'];
                                            // $todaysBatch[] = $row['batchName'];
                                            $todaysBatch[] = (is_null($row['batchName'])) ? 'no data' : $row['batchName'];
                                            $todaysDate[] = (is_null($row['acquiredDate'])) ? date('Y-m-d') : $row['acquiredDate'];
                                            $todayDataset[] = (is_null($row['instock'])) ? 0 : $row['instock'];

                                        }
                                        print_r($todaysDate);
                                        print_r($todayDataset);
                                        // Free result set
                                        unset($result);
                                    }
                                }
                                else{
                                    echo "Oops! Something went wrong. Please try again later.";
                                }

                                //statement get the last 7 days
                                $sql = "SELECT inStock, batchName, dateAcquired AS acquiredDate FROM chickenproduction WHERE dateAcquired BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()";
                                $stmt = $conn->query($sql);
                                 if($stmt){
                                     if($stmt->rowCount() > 0){
                                        $oneweek = array();
                                        $oneweekDataset = array();
                                        // $lastdaysBatch = array();
                                        while($row = $stmt->fetch()){
                                            $oneweek[] = $row['acquiredDate'];
                                            $oneweekDataset[] = $row['inStock'];
                                            // $lastdaysBatch[] = $row['batchName'];
                                        }
                                        // Free result set
                                        unset($result);
                                    }
                                }
                                else{
                                    echo "Oops! Something went wrong. Please try again later.";
                                }

                                //statement get the weekly the whole year
                                $sql = "SELECT WEEK(dateAcquired) as weekNumber, SUM(inStock) as totalInStock, batchName
                                FROM chickenproduction
                                WHERE YEAR(dateAcquired) = 2022
                                GROUP BY weekNumber";
                                $stmt = $conn->query($sql);
                                 if($stmt){
                                     if($stmt->rowCount() > 0){
                                        $weekly = array();
                                        $weeklyTotalDataset = array();
                                        // $weeklyBatch = array();
                                        while($row = $stmt->fetch()){
                                            $weekly[] = $row['weekNumber'];
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
                                $sql = "SELECT * FROM chickenproduction";
                                $stmt = $conn->query($sql);
                                 if($stmt){
                                     if($stmt->rowCount() > 0){
                                        $dateAcquired = array();
                                        while($row = $stmt->fetch()){
                                            $dateAcquired[] = $row['dateAcquired'];
                                        }
                                        // Free result set
                                        unset($result);
                                    }
                                }
                                else{
                                    echo "Oops! Something went wrong. Please try again later.";
                                }

                                //statement get the yearly
                                $sql = "SELECT * FROM chickenproduction";
                                $stmt = $conn->query($sql);
                                 if($stmt){
                                     if($stmt->rowCount() > 0){
                                        $dateAcquired = array();
                                        while($row = $stmt->fetch()){
                                            $dateAcquired[] = $row['dateAcquired'];
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
                                        <canvas id="myChart"></canvas>
                                        <button onclick="timeFrame(this)" value="day">Today</button>
                                        <button onclick="timeFrame(this)" value="lastdays">Last 7 Days</button>
                                        <button onclick="timeFrame(this)" value="weekly">Weekly</button>
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
            //const month
            //const year

            //const today
            const todaysDate = <?php echo json_encode($todaysDate);?>;
            const todayDataset = <?php echo json_encode($todayDataset);?>;
            const todaysBatch = <?php echo json_encode($todaysBatch);?>;

            // console.log(todaysBatch)

            //const last 7 days
            const oneweek = <?php echo json_encode($oneweek);?>;
            const oneweekDataset = <?php echo json_encode($oneweekDataset);?>;
            // const lastdaysBatch = php echo json_encode($lastdaysBatch);?>;
            // console.log(lastdaysBatch)
            //const week
            const weekly = <?php echo json_encode($weekly);?>;
            const weeklyTotalDataset = <?php echo json_encode($weeklyTotalDataset);?>;
            const weeklyBatch = <?php echo json_encode($weeklyBatch);?>;
                
            // Convert date strings to Date objects
            // const dates = oneweek.map(date => Date.parse(date));
            // const dates = oneweek.map(date => new Date(date));
            const dates = oneweek.concat(todaysDate).concat(weekly).map(date => new Date(date));
            // const batchNames = todaysBatch.concat(lastdaysBatch).concat(weeklyBatch).map(batch => batch.batchName);

            
            
           

            //setup block(dateToday.length == null) ? ['no data'] : (todayDataset.length == 0) ? [0] : 
            const data = {
                labels: todaysDate, 
                datasets: [{
                    label: 'todaysBatch',
                    data: todayDataset,
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
                    ]
                },
                // {
                //     label: batchName,
                //     data: startingQuantity,
                //     borderWidth: 1
                // }
                ]
            };
            
            const plugin = {
                id: 'emptyChart',
                afterDraw(myChart, args, options) {
                    console.log(afterDraw);
                    const { datasets } = myChart.data;
                    let hasData = false;

                    for (let dataset of datasets) {
                        //set this condition according to your needs
                        // if (dataset.data.length > 0 && !dataset.data.some(item => item == 0 || item == null)) {
                        //     hasData = true;
                        //     break;
                        // }
                        if (dataset.data.length === 0 || dataset.data.some(item => item == 0 || item == null)) {
                        hasData = false;
                        break;
                        } else {
                        hasData = true;
                        break;
                        }

                    }

                    if (!hasData) {
                    //type of ctx is CanvasRenderingContext2D
                    //https://developer.mozilla.org/en-US/docs/Web/API/CanvasRenderingContext2D
                    //modify it to your liking
                    const { ctx } = myChart;
                    const centerX = myChart.chartArea.left + myChart.chartArea.right / 2;
                    const centerY = myChart.chartArea.top + myChart.chartArea.bottom / 2;

                    myChart.clear();
                    ctx.save();
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.fillText('No data to display', centerX, centerY);
                    ctx.restore();
                    }
                }
            };

            Chart.plugins.register({
  id: 'emptyChart',
  // ...
});

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
                plugins: [plugin]
                }
            };

            //render block
            const myChart = new Chart(
                document.getElementById('myChart'),
                config,
            );

            function timeFrame(period){
                if(period.value === 'day'){
                    myChart.config.options.scales.x.time.unit = period.value;
                    myChart.config.data.labels = todaysDate; 
                    // myChart.config.data.datasets[0].label = todaysBatch;
                    myChart.config.data.datasets[0].data = todayDataset;
                    console.log(period.value)
                }
                if(period.value === 'lastdays'){
                    myChart.config.options.scales.x.time.unit = 'day';
                    myChart.config.data.labels = oneweek;
                    // myChart.config.data.datasets[0].label = lastdaysBatch;
                    myChart.config.data.datasets[0].data = oneweekDataset;
                    console.log(period.value)
                }
                if(period.value === 'weekly'){
                    myChart.config.options.scales.x.time.unit = 'week';
                    myChart.config.data.labels = weekly.map(week => 'Week ' + week);//  weeklyBatch
                    // myChart.config.data.datasets[0].label =;
                    myChart.config.data.datasets[0].data = weeklyTotalDataset;
                    console.log(period.value)
                    // console.log(weeklyBatch)
                }
                if(period.value === 'monthly'){
                    myChart.config.options.scales.x.time.unit = period.value;
                    myChart.config.data.labels = oneweek;
                    myChart.config.data.datasets[0].data = oneweek;
                    console.log(period.value)
                }
                if(period.value === 'yearly'){
                    myChart.config.options.scales.x.time.unit = period.value;
                    myChart.config.data.labels = oneweek;
                    myChart.config.data.datasets[0].data = oneweek;
                    console.log(period.value)
                }
                myChart.update();
            }

            //////////////////////////////////////////////////

            function timeFrame(period) {

var period = period.value;
console.log(period)
function updateTable(tableId, data) {
$(tableId).DataTable({
paging: tableId === "#productionReport" || tableId === "#reductionReport"
}).rows.add(data).draw().destroy();
}

$.ajax({
    url: '../action/reports_action.php',
    type: 'POST',
    data: { action: 'fetch', period: period },
    dataType: 'json',
    success: function (data) {
        
        $.extend($.fn.dataTable.defaults, {
            lengthChange: false,
            responsive: true,
            columnDefs: [
                    {"className": "dt-center", "targets": "_all"} //center all text in the table
                ],
            filter: false
        } );
        

        var production = JSON.parse(data.production);
        var reduction = JSON.parse(data.reduction);

        switch(period){
            case 'lastdays': {
                
                // code to execute when period is "lastdays"
                $('#productionReport thead').empty();
                // code to execute when period is "lastdays"
                var prodRow = $('<tr></tr>');
                var dateAcquired = $('<th>Date Acquired</th>');
                var batchID = $('<th>Batch ID</th>');
                var coopNumber = $('<th>Coop Number</th>');
                var startingQuantity = $('<th>Starting Quantity</th>');
                var inStock = $('<th>In Stock</th>');
                var reductions = $('<th>Reductions</th>');
                prodRow.append(dateAcquired, batchID, coopNumber, startingQuantity, inStock, reductions);
                $('#productionReport thead').append(prodRow);

                //clears the table before appending the new data
                $('#productionReport tbody').empty();
                // append data to table
                production.forEach(function(row) {
                    var dateCell = $('<td></td>').text(row[0]);
                    var chickenIDcell = $('<td></td>').text(row[1]);
                    var coopNumberCell = $('<td></td>').text(row[2]);
                    var startingCell = $('<td></td>').text(row[3]);
                    var inStockCell = $('<td></td>').text(row[4]);
                    var reductionCell = $('<td></td>').text(row[5]);
                    var prodRow = $('<tr></tr>').append(dateCell, chickenIDcell, coopNumberCell, startingCell, inStockCell, reductionCell);
                    $('#productionReport tbody').append(prodRow); 
                });

                $('#reductionReport thead').empty();
                // code to execute when period is "lastdays"
                var redRow = $('<tr></tr>');
                var dateReduced = $('<th>Date Reduced</th>');
                var batchID = $('<th>Batch ID</th>');
                var coopNumber = $('<th>Coop Number</th>');
                var reductions = $('<th>Reductions</th>');
                redRow.append(dateReduced, batchID, coopNumber, reductions);
                $('#reductionReport thead').append(redRow);

                $('#reductionReport tbody').empty();
                // append data to table
                reduction.forEach(function(row) {
                    if(row[2]!=null){
                        var dateCell = $('<td></td>').text(row[0]);
                        var chickenIDcell = $('<td></td>').text(row[1]);
                        var coopNumberCell = $('<td></td>').text(row[2]);
                        var reductionCell = $('<td></td>').text(row[3]);
                        var redRow = $('<tr></tr>').append(dateCell, chickenIDcell, coopNumberCell, reductionCell);
                        $('#reductionReport tbody').append(redRow); 
                    }
                });

        updateTable("#productionReport", production);
updateTable("#reductionReport", reduction);
updateTable("#typeReport", reduction);
updateTable("#purposeReport", production);
                break;
            }
            case 'weekly': {
                // code to execute when period is "weekly"
                  // code to execute when period is "lastdays"
                  $('#productionReport thead').empty();
                // code to execute when period is "lastdays"
                var prodRow = $('<tr></tr>');
                var week = $('<th>Week</th>');
                var monthDay = $('<th>Date</th>');
                var inStock = $('<th>In Stock</th>');
                var reductions = $('<th>Reductions</th>');
                prodRow.append(week, monthDay, inStock, reductions);
                $('#productionReport thead').append(prodRow);
                
                //clears the table before appending the new data
                $('#productionReport tbody').empty();
                // append data to table
                production.forEach(function(row) {
                    var week = $('<td></td>').text(row[0]);
                    var monthDay = $('<td></td>').text(row[1]);
                    var inStockCell = $('<td></td>').text(row[2]);
                    var reductionCell = $('<td></td>').text(row[3]);
                    var prodRow = $('<tr></tr>').append(week, monthDay, inStockCell, reductionCell);
                    $('#productionReport tbody').append(prodRow); 
                });

                $('#reductionReport thead').empty();
                // code to execute when period is "lastdays"
                var redRow = $('<tr></tr>');
                var dateReduced = $('<th>Date Reduced</th>');
                var batchID = $('<th>Batch ID</th>');
                var coopNumber = $('<th>Coop Number</th>');
                var reductions = $('<th>Reductions</th>');
                redRow.append(dateReduced, batchID, coopNumber, reductions);
                $('#reductionReport thead').append(redRow);

                $('#reductionReport tbody').empty();
                // append data to table
                reduction.forEach(function(row) {
                    if(row[2]!=null){
                        var dateCell = $('<td></td>').text(row[0]);
                        var chickenIDcell = $('<td></td>').text(row[1]);
                        var coopNumberCell = $('<td></td>').text(row[2]);
                        var reductionCell = $('<td></td>').text(row[3]);
                        var redRow = $('<tr></tr>').append(dateCell, chickenIDcell, coopNumberCell, reductionCell);
                        $('#reductionReport tbody').append(redRow); 
                    }
                });
                break;
            }
            default: {
                // code to execute when period doesn't match any of the cases
            }
        }

        // update chart
        chart_data.datasets[0].data = data;
        chart.update();
    },
    error: function (request, error) {
        console.log(arguments);
        alert("Can't do because: " + error);
    }
});
}

function timeFrame(period) {

var period = period.value;

$.post({
    url: '../action/reports_action.php',
    type: 'POST',
    data: { action: 'fetch', period: period },
    dataType: 'json',
    success: function (data) {
        
        //acceprts the data from the script and parse it and store it to the variable
        var production = JSON.parse(data.production);
        var reduction = JSON.parse(data.reduction);
        
        switch(period){
            case 'lastdays': {
                
                // code to execute when period is "lastdays"
                $('#productionReport thead').empty();
                // code to execute when period is "lastdays"
                var prodRow = $('<tr></tr>');
                var dateAcquired = $('<th>Date Acquired</th>');
                var batchID = $('<th>Batch ID</th>');
                var coopNumber = $('<th>Coop Number</th>');
                var startingQuantity = $('<th>Starting Quantity</th>');
                var inStock = $('<th>In Stock</th>');
                var reductions = $('<th>Reductions</th>');
                prodRow.append(dateAcquired, batchID, coopNumber, startingQuantity, inStock, reductions);
                $('#productionReport thead').append(prodRow);

                //clears the table before appending the new data
                $('#productionReport tbody').empty();
                // append data to table
                production.forEach(function(row) {
                    var dateCell = $('<td></td>').text(row[0]);
                    var chickenIDcell = $('<td></td>').text(row[1]);
                    var coopNumberCell = $('<td></td>').text(row[2]);
                    var startingCell = $('<td></td>').text(row[3]);
                    var inStockCell = $('<td></td>').text(row[4]);
                    var reductionCell = $('<td></td>').text(row[5]);
                    var prodRow = $('<tr></tr>').append(dateCell, chickenIDcell, coopNumberCell, startingCell, inStockCell, reductionCell);
                    $('#productionReport tbody').append(prodRow); 
                });

                $('#reductionReport thead').empty();
                // code to execute when period is "lastdays"
                var redRow = $('<tr></tr>');
                var dateReduced = $('<th>Date Reduced</th>');
                var batchID = $('<th>Batch ID</th>');
                var coopNumber = $('<th>Coop Number</th>');
                var reductions = $('<th>Reductions</th>');
                redRow.append(dateReduced, batchID, coopNumber, reductions);
                $('#reductionReport thead').append(redRow);

                $('#reductionReport tbody').empty();
                // append data to table
                reduction.forEach(function(row) {
                    if(row[2]!=null){
                        var dateCell = $('<td></td>').text(row[0]);
                        var chickenIDcell = $('<td></td>').text(row[1]);
                        var coopNumberCell = $('<td></td>').text(row[2]);
                        var reductionCell = $('<td></td>').text(row[3]);
                        var redRow = $('<tr></tr>').append(dateCell, chickenIDcell, coopNumberCell, reductionCell);
                        $('#reductionReport tbody').append(redRow); 
                    }
                });

                //calls the function adn passed the table id and the data
                updateTable("#productionReport", production);
                updateTable("#reductionReport", reduction);
                updateTable("#typeReport", reduction);
                updateTable("#purposeReport", production);
                break;
            }
            case 'weekly': {
                // code to execute when period is "weekly"
                  // code to execute when period is "lastdays"
                  $('#productionReport thead').empty();
                // code to execute when period is "lastdays"
                var prodRow = $('<tr></tr>');
                var week = $('<th>Week</th>');
                var monthDay = $('<th>Date</th>');
                var inStock = $('<th>In Stock</th>');
                var reductions = $('<th>Reductions</th>');
                prodRow.append(week, monthDay, inStock, reductions);
                $('#productionReport thead').append(prodRow);
                
                //clears the table before appending the new data
                $('#productionReport tbody').empty();
                // append data to table
                production.forEach(function(row) {
                    var week = $('<td></td>').text(row[0]);
                    var monthDay = $('<td></td>').text(row[1]);
                    var inStockCell = $('<td></td>').text(row[2]);
                    var reductionCell = $('<td></td>').text(row[3]);
                    var prodRow = $('<tr></tr>').append(week, monthDay, inStockCell, reductionCell);
                    $('#productionReport tbody').append(prodRow); 
                });

                $('#reductionReport thead').empty();
                // code to execute when period is "lastdays"
                var redRow = $('<tr></tr>');
                var dateReduced = $('<th>Date Reduced</th>');
                var batchID = $('<th>Batch ID</th>');
                var coopNumber = $('<th>Coop Number</th>');
                var reductions = $('<th>Reductions</th>');
                redRow.append(dateReduced, batchID, coopNumber, reductions);
                $('#reductionReport thead').append(redRow);

                $('#reductionReport tbody').empty();
                // append data to table
                reduction.forEach(function(row) {
                    if(row[2]!=null){
                        var dateCell = $('<td></td>').text(row[0]);
                        var chickenIDcell = $('<td></td>').text(row[1]);
                        var coopNumberCell = $('<td></td>').text(row[2]);
                        var reductionCell = $('<td></td>').text(row[3]);
                        var redRow = $('<tr></tr>').append(dateCell, chickenIDcell, coopNumberCell, reductionCell);
                        $('#reductionReport tbody').append(redRow); 
                    }
                });

                
                updateTable("#productionReport", production);
                updateTable("#reductionReport", reduction);
                updateTable("#typeReport", reduction);
                updateTable("#purposeReport", production);
                break;
            }
            default: {
                // code to execute when period doesn't match any of the cases
            }
        }

        // update chart
        chart_data.datasets[0].data = data;
        chart.update();
    },
    error: function (request, error) {
        console.log(arguments);
        alert("Can't do because: " + error);
    }
});
}
        </script>

    </body>
</html>
  
   