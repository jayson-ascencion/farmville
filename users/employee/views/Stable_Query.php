<?php
    //title of the pge
    $title = "Chicken Production";

    //header
    include("../../includes/header.php");
    
    
    //connect to the database
    include('../../../config/database_connection.php');

    //statement get the today
    // $sql = "SELECT SUM(COALESCE(inStock, 0)) as instock, batchName, dateAcquired AS acquiredDate FROM chickenproduction WHERE dateAcquired = CURDATE()";                                
    $sql = "SELECT cp.chickenBatch_ID, cp.coopNumber, cp.batchName, cp.breedType, cp.startingQuantity, cp.inStock, cp.dateAcquired, COALESCE(SUM(cr.quantity),0) as totalReductions, COALESCE((cr.dateReduced),'0000-00-00') as dateReduced
     		FROM chickenproduction cp LEFT JOIN chickenreduction cr ON cp.chickenBatch_ID = cr.chickenBatch_ID
            WHERE dateAcquired = CURDATE()
     		GROUP BY cp.chickenBatch_ID, cp.coopNumber, cp.batchName, cp.breedType, cp.startingQuantity, cp.inStock";                                
    $stmt = $conn->query($sql);
     if($stmt){
         if($stmt->rowCount() > 0){
            $todaysDate = array();
            $todaysDataset = array();
            $todaysBatch = array();
            $todaysReductionDs = array();
            while($row = $stmt->fetch()){
                $todaysBatch[] = (is_null($row['batchName'])) ? 'no data' : $row['batchName'];
                $todaysDate[] = (is_null($row['dateAcquired'])) ? date('Y-m-d') : $row['dateAcquired'];
                $todaysDataset[] = (is_null($row['inStock'])) ? 0 : $row['inStock'];
                $todaysReductionDs[] = (is_null($row['totalReductions'])) ? 0 : $row['totalReductions'];
            }
            // Free result set
            unset($result);
        }
    }
    else{
        echo "Oops! Something went wrong. Please try again later.";
    }

   // statement get the last 7 days
    $oneweek = ['No Data'];
    $oneweekDataset = [0];
    $lastdaysBatch = ['No Data'];
    // $sql = "SELECT SUM(COALESCE(inStock, 0)) as instock, batchName, DATE_FORMAT(dateAcquired, '%M %d') AS acquiredDate FROM chickenproduction WHERE dateAcquired BETWEEN CURDATE() - INTERVAL 6 DAY AND CURDATE() GROUP BY acquiredDate";
    $sql = "SELECT cp.chickenBatch_ID, cp.coopNumber, cp.batchName, cp.breedType, cp.startingQuantity, SUM(COALESCE(cp.inStock, 0)) as instock, DATE_FORMAT(cp.dateAcquired, '%M %d') AS acquiredDate, COALESCE(SUM(cr.quantity),0) as totalReductions, COALESCE((cr.dateReduced),'0000-00-00') as dateReduced
    FROM chickenproduction cp LEFT JOIN chickenreduction cr ON cp.chickenBatch_ID = cr.chickenBatch_ID
    WHERE dateAcquired BETWEEN CURDATE() - INTERVAL 6 DAY AND CURDATE()
    GROUP BY acquiredDate";
    $stmt = $conn->query($sql);
        if($stmt){
            if($stmt->rowCount() > 0){
            $oneweek = array();
            $oneweekDataset = array();
            // $oneweekDatasetReductions = array();
            $lastdaysBatch = array();
            $oneweekReductionDs = array();
            while($row = $stmt->fetch()){
                $lastdaysBatch[] = (is_null($row['batchName'])) ? 'no data' : $row['batchName'];
                $oneweek[] = (is_null($row['acquiredDate'])) ? date('Y-m-d') : $row['acquiredDate'];
                $oneweekDataset[] = (is_null($row['instock'])) ? 0 : $row['instock'];
                $oneweekReductionDs[] = (is_null($row['totalReductions'])) ? 0 : $row['totalReductions'];
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
    $weekly = ['No Data'];
    $monthDay = ['No Data'];
    $weeklyTotalDataset = [0];
    $weeklyBatch = ['No Data'];
    $sql = "SELECT WEEK(dateAcquired,1) as weekNumber,
    DATE_FORMAT(dateAcquired, '%b %d,%Y') as monthDay,
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
    $monthYear = ['No Data'];
    $monthlyDataset = [0];
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
    $year = ['No Data'];
    $yearlyDataset = [0];
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

<!-- content --> 
<!-- <div id="content" class="container-fluid px-4">

    <h1 class="mt-4"> Employee Dashboard</h1>
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
                        <div class="card-header" style="background-color: #FFAF1A">

                            <div class="w-100 d-flex justify-content-between p-2">
                                <div>
                                    <h4 class="pt-2 fw-bold fs-5">Chicken Production and Reduction Reports</h4>
                                </div>
                            </div> 
                            
                        </div>
                        <div> 
                                                       
                                include("../../includes/loader.php");
                            ?>
                        </div>
                        <div class="card-body displayTable">
                            <div class="w-100">
                                <div class="chartCard">
                                    <div class="chartBox">
                                     <canvas id="bar_chart" > </canvas> 
                                        <canvas id="myChart" height="60"></canvas>
                                        <button onclick="timeFrame(this)" value="today">Today</button>
                                        <button onclick="timeFrame(this)" value="lastdays">Last 7 Days</button>
                                        <button onclick="timeFrame(this)" value="weekly">Weekly</button>
                                        <button onclick="timeFrame(this)" value="monthly">Monthly</button>
                                        <button onclick="timeFrame(this)" value="yearly">Yearly</button>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive m-1 mt-2">
                            <table id="chickenReport" class="table responsive border table-hover text-center rounded rounded-3 overflow-hidden" style="width: 100%">
                            <thead class='text-white' style='background-color: #2d4154'>
                                <tr>
                                    <th>Batch ID</th>
                                    <th>Coop Number</th>
                                    <th>Batch Name</th>
                                    <th>Breed Type</th>
                                    <th>Starting Quantity</th>
                                    <th>Date Acquired</th>
                                    <th>In Stock</th>
                                    <th>Total Reductions</th>
                                    <th>Date Reduced</th>
                                </tr>
                            </thead>
                            <tbody> </tbody>                         
                        </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>        
        </div>
    </div>

</div> -->
<div class="container-fluid">
            <h1 class="mt-2 mb-3 text-center text-primary">Date Range Filter in DataTable, Chart.js using Date Range Picker with PHP MySQL using Ajax</h1>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col col-sm-9">Sales Data</div>
                        <div class="col col-sm-3">
                            <input type="text" id="daterange_textbox" class="form-control" readonly />
                        </div>
                        <div class="col col-sm-3">
                            <select name="period" id="">
                                <option value="">Today</option>
                                <option value="">Yesterday</option>
                                <option value="">Last 7 Days</option>
                                <option value="">This Month</option>
                                <option value="">Last Month</option>
                                <option value="">Yearly</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="chart-container pie-chart">
                            <canvas id="bar_chart" height="40"> </canvas>
                        </div>
                        <table class="table table-striped table-bordered" id="order_table">
                            <thead>
                                <tr>
                                    <th>Order Number</th>
                                    <th>Order Value</th>
                                    <th>Order Date</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
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
    <script src="../../../assets/js/moment.js"></script>
    <script src="../../../assets/js/daterangepicker.js"></script>
    <script src="../../../assets/js/popper.min.js" async defer></script>
    <script src="../../../assets/js/datatables.min.js"></script>
    <script src="../../../assets/js/pdfmake.min.js"></script>
    <script src="../../../assets/js/vfs_fonts.js" async defer></script>
    <script src="../../../assets/js/chart.js"></script>
    <script src="../../../assets/js/chartjs-adapter-date-fns.bundle.min.js"></script>
        <script>
            //configuration for the CHICKEN PRODUCTION table
            // $(document).ready(function() {
            // $('#chickenReport').DataTable({
            //     columns: [ //this will define what columns are orderable
            //         { orderable: ['asc'] }, //1
            //         null, //2
            //         null,//3
            //         null,//4
            //         null,//5
            //         null,//6
            //         null,//7
            //     ],
                    
            //     });
            // } );
            
            $.extend($.fn.dataTable.defaults, {
                
                paging: false,
                responsive: true
            } );
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
            const { todaysDate, todaysDataset, todaysBatch, todaysReductionDs } = {
                todaysDate:  <?php echo json_encode($todaysDate);?>,
                todaysDataset:  <?php echo json_encode($todaysDataset);?>,
                todaysBatch:  <?php echo json_encode($todaysBatch)?>,
                todaysReductionDs:  <?php echo json_encode($todaysReductionDs)?>,
            };
            
            //const last 7 days
            const { oneweek, oneweekDataset, lastdaysBatch, oneweekReductionDs } = {
                oneweek:  <?php echo json_encode($oneweek);?>,
                oneweekDataset:  <?php echo json_encode($oneweekDataset);?>,
                lastdaysBatch:  <?php echo json_encode($lastdaysBatch)?>,
                oneweekReductionDs:  <?php echo json_encode($oneweekReductionDs)?>,
            };

            //const week
            const { weekly, monthDay, weeklyTotalDataset, weeklyBatch} = {
                weekly:  <?php echo json_encode($weekly);?>,
                monthDay:  <?php echo json_encode($monthDay);?>,
                weeklyTotalDataset:  <?php echo json_encode($weeklyTotalDataset);?>,
                weeklyBatch:  <?php echo json_encode($weeklyBatch);?>,
            };

            let weeklyLabel = [];
            for (let i = 0; i < weekly.length; i++) {
                weeklyLabel.push(weekly[i] + ' ' + monthDay[i]);
            }

            //const month
            const { monthYear, monthlyDataset} = {
                monthYear:  <?php echo json_encode($monthYear);?>,
                monthlyDataset:  <?php echo json_encode($monthlyDataset);?>,
            };
            
            //const year
            const { year, yearlyDataset} = {
                year:  <?php echo json_encode($year);?>,
                yearlyDataset:  <?php echo json_encode($yearlyDataset);?>,
            }

            //map the date
            const dates = oneweek.concat(weekly).concat(todaysDate).concat(monthYear).map(date => new Date(date));

            //setup block
            const data = {
                labels: todaysDate,
                datasets: [{
                    label: 'Total In Stock For Today',
                    data: todaysDataset,
                    backgroundColor: 'rgb(0, 255, 0)',
                    borderWidth: 1,
                    fill: false,
                    borderColor: 'rgb(0, 255, 0)',
                    tension: 0.1,
                    pointRadius: 5,
                    pointHoverRadius: 10,
                },
                {
                    label: 'Total Reductions For Today',
                    data: todaysReductionDs,
                    backgroundColor: 'rgb(255, 0, 0)',
                    borderWidth: 1,
                    fill: false,
                    borderColor: 'rgb(255, 0, 0)',
                    tension: 0.1,
                    pointRadius: 5,
                    pointHoverRadius: 10,
                }]
            };
            
            //config block
            const config = {
            type: 'line',
            data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
            };


            //render block
            const myChart = new Chart(
                document.getElementById('myChart'),
                config,
            );

            // function timeFrame(period){
            //     if(period.value === 'today'){
            //         // myChart.config.options.scales.x.time.unit = 'day';
            //         myChart.config.data.labels = todaysDate;
            //         myChart.config.data.datasets[0].label = 'Total For Today';
            //         myChart.config.data.datasets[0].data = todaysDataset;
            //         console.log(todaysDataset)
            //         // updateTable(todaysBatch, todaysDate, todaysDataset, todaysReductionDs);
            //     }
            //     if(period.value === 'lastdays'){
            //         // myChart.config.options.scales.x.time.unit = 'day';
            //         myChart.config.data.labels = oneweek;
            //         myChart.config.data.datasets[0].label = 'Total In Stock Last 7 Days';
            //         myChart.config.data.datasets[0].data = oneweekDataset;
            //         myChart.config.data.datasets[1].label = 'Total Reductions Last 7 Days';
            //         myChart.config.data.datasets[1].data = oneweekReductionDs;
            //         console.log(oneweekDataset)
            //         console.log(oneweekReductionDs)
            //         // updateTable(oneweek, oneweekDataset, lastdaysBatch, oneweekReductionDs);
            //     }
            //     if(period.value === 'weekly'){
            //         myChart.config.data.labels = weeklyLabel.map(week => 'Week ' + week);
            //         myChart.config.data.datasets[0].label = 'Total Per Week';
            //         myChart.config.data.datasets[0].data = weeklyTotalDataset;
            //         console.log(period.value)
            //         // console.log(weeklyBatch)
            //     }
            //     if(period.value === 'monthly'){
            //         // myChart.config.options.scales.x.time.unit = 'month';
            //         myChart.config.data.labels = monthYear;                    
            //         myChart.config.data.datasets[0].label = 'Total Per Month';
            //         myChart.config.data.datasets[0].data = monthlyDataset;
            //         console.log(period.value)
            //     }
            //     if(period.value === 'yearly'){
            //         // myChart.config.options.scales.x.time.unit = 'year';
            //         myChart.config.data.labels = year;
            //         myChart.config.data.datasets[0].label = 'Total Per Year';
            //         myChart.config.data.datasets[0].data = yearlyDataset;
            //         console.log(period.value)
            //     }
            //     myChart.update();
            //     // displayData(period.value);
            // }

            
$(document).ready(function(){

fetch_data();

var sale_chart;

function fetch_data(start_date = '', end_date = '')
{
    var dataTable = $('#order_table').DataTable({
        "processing" : true,
        "serverSide" : true,
        "order" : [],
        "ajax" : {
            url:"../action/reports_action.php",
            type:"POST",
            data:{action:'fetch', start_date:start_date, end_date:end_date}
        },
        "drawCallback" : function(settings)
        {
            var dateAcquired = [];
            var inStock = [];

            for(var count = 0; count < settings.aoData.length; count++)
            {
                dateAcquired.push(settings.aoData[count]._aData[2]);
                inStock.push(parseFloat(settings.aoData[count]._aData[1]));
            }

            var chart_data = {
                labels:dateAcquired,
                datasets:[
                    {
                        label : 'Sales',
                        backgroundColor : 'rgb(255, 205, 86)',
                        color : '#fff',
                        data:inStock
                    }
                ]   
            };

            var group_chart3 = $('#bar_chart');

            if(sale_chart)
            {
                sale_chart.destroy();
            }

            sale_chart = new Chart(group_chart3, {
                type:'line',
                data:chart_data
            });
        }
    });
}

    $('#daterange_textbox').daterangepicker({
        ranges:{
            'Today' : [moment(), moment()],
            'Yesterday' : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
            'Last 30 Days' : [moment().subtract(29, 'days'), moment()],
            'This Month' : [moment().startOf('month'), moment().endOf('month')],
            'Last Month' : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        format : 'YYYY-MM-DD'
    }, function(start, end){

        $('#order_table').DataTable().destroy();

        fetch_data(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));

    });

});

        </script>

    </body>
</html>
  
   