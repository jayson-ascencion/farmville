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

                            <div class="w-100 d-flex justify-content-between p-2">
                                <div>
                                    <h4 class="pt-2 fw-bold fs-5">Chicken Production and Reduction Reports</h4>
                                </div>
                            </div> 
                            
                        </div>
                        <div class="card-body displayTable">
                        <div>
                            <?php include("../../includes/loader.php"); ?>
                        </div>
                            <div class="w-100">
                                <div class="chartCard">
                                    <div class="chartBox">
                                     <canvas id="bar_chart" > </canvas> 
                                        <canvas id="myChart" height="60"></canvas>
                                        <div>
                                            <button onclick="timeFrame(this)" value="lastdays">Last 7 Days</button>
                                            <button onclick="timeFrame(this)" value="weekly">Weekly</button>
                                            <button onclick="timeFrame(this)" value="monthly">Monthly</button>
                                            <button onclick="timeFrame(this)" value="yearly">Yearly</button>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="card mt-4">
                                <div class="card-header fw-bold fs-5 bg-success">
                                    Production Reports
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive m-1">
                                        <p class="mb-0">Production Summary By Purpose</p>
                                        <table id="purposeReport" data-options='{"destroy": true, "filter": true, "info": true, "lengthChange": false, "paging": true, "columnDefs":[{"className": "dt-center", "targets": "_all"}]}' class="table responsive border table-hover text-center rounded rounded-3 overflow-hidden" style="width: 100%">
                                            <thead class='text-white bg-secondary'>
                                                <tr>
                                                    <th>Purpose</th>
                                                    <th>Total In Stock</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <td>Meat</td>
                                                <td>500</td>
                                            </tbody>                         
                                        </table>
                                    </div>      

                                    <div  class="table-responsive m-1 mt-4">
                                        <p class="mb-0">Production Summary By Batch</p>
                                        <table id="productionReport" data-options='{"destroy": true, "filter": true, "info": true, "lengthChange": false, "paging": true, "columnDefs":[{"className": "dt-center", "targets": "_all"}]}' class="table responsive border table-hover text-center rounded rounded-3 overflow-hidden" style="width: 100%">
                                            <thead class='text-white bg-secondary'>
                                                
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>                         
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="card mt-4">
                                <div class="card-header fw-bold fs-5 bg-danger">
                                    Reduction Reports
                                </div>
                                <div class="card-body">
                                    <div  class="table-responsive m-1">
                                        <p class="mb-0">Reduction Summary By Reduction Type</p>
                                        <table id="typeReport" data-options='{"destroy": true, "filter": true, "info": true, "lengthChange": false, "paging": true, "columnDefs":[{"className": "dt-center", "targets": "_all"}]}' class="table responsive border table-hover text-center rounded rounded-3 overflow-hidden" style="width: 100%">
                                            <thead class='text-white bg-secondary'>
                                                <tr>
                                                    <th>Reduction Type</th>
                                                    <th>Total Reductions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <td>Death</td>
                                                <td>20</td>
                                            </tbody>                         
                                        </table>
                                    </div>
                                    
                                    <div  class="table-responsive m-1 mt-4">
                                        <p class="mb-0">Reduction Summary By Batch</p>
                                        <table id="reductionReport" data-options='{"destroy": true, "filter": true, "info": true, "lengthChange": false, "paging": true, "columnDefs":[{"className": "dt-center", "targets": "_all"}]}' class="table responsive border table-hover text-center rounded rounded-3 overflow-hidden" style="width: 100%">
                                            <thead class='text-white bg-secondary'>
                                                <tr>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>                         
                                        </table>
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

<script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <script src="../../../assets/js/jquery-3.6.1.min.js"></script>
    <script src="../../../assets/js/bootstrap5.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../../../assets/js/scripts.js"></script>
    <script src="../../../assets/js/moment.js"></script>
    <script src="../../../assets/js/daterangepicker.js"></script>
    <script src="../../../assets/js/popper.min.js" async defer></script>
    <script src="../../../assets/js/datatables.min.js"></script>
    <script src="../../../assets/js/pdfmake.min.js"></script>
    <script src="../../../assets/js/vfs_fonts.js"></script>
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
            
            timeFrame({value: 'lastdays'});

        };

        document.onreadystatechange = function() {
        if (document.readyState !== 'complete') {
            // Hide the displayTable while the page is still loading
            document.querySelector('.displayTable').style.display = 'none';
        }
        };
    
        
        //this function will be called once a button is clicekd
        function timeFrame(period) { 
            var period = period.value;
            console.log(period);
            fetchData(period); //function to fetch data with a period parameter
        }
        
        //this function will fetch the data from the reports action located in the action folder
        function fetchData(period) {
            var productionTable = $("#productionReport").DataTable({
            ajax: {
                url: '../action/reports_action.php',
                type: 'POST',
                data: { action: 'fetch', period: period }
            },
            filter: true,
            info: true,
            lengthChange: false,
            paging: true,
            columnDefs: [
                {"className": "dt-center", "targets": "_all"}
            ],
        });

        var reductionTable = $("#reductionReport").DataTable({
            ajax: {
                url: '../action/reports_action.php',
                type: 'POST',
                data: { action: 'fetch', period: period }
            },
            filter: true,
            info: true,
            lengthChange: false,
            paging: true,
            columnDefs: [
                {"className": "dt-center", "targets": "_all"}
            ],
        }); 
         var typeTable = $("#typeReport").DataTable({
            ajax: {
                url: '../action/reports_action.php',
                type: 'POST',
                data: { action: 'fetch', period: period }
            },
            filter: true,
            info: true,
            lengthChange: false,
            paging: true,
            columnDefs: [
                {"className": "dt-center", "targets": "_all"}
            ],
        });  
        var purposeTable = $("#purposeReport").DataTable({
            ajax: {
                url: '../action/reports_action.php',
                type: 'POST',
                data: { action: 'fetch', period: period }
            },
            filter: true,
            info: true,
            lengthChange: false,
            paging: true,
            columnDefs: [
                {"className": "dt-center", "targets": "_all"}
            ],
        });
              // set the data property of the ajax object within the DataTable initialization
    productionTable.ajax.data = { action: 'fetch', period: period };
    reductionTable.ajax.data = { action: 'fetch', period: period };
    typeTable.ajax.data = { action: 'fetch', period: period };
    purposeTable.ajax.data = { action: 'fetch', period: period };

    // reload the table
    productionTable.ajax.reload();
    reductionTable.ajax.reload();
    typeTable.ajax.reload();
    purposeTable.ajax.reload();

            $.post({
                url: '../action/reports_action.php',
                type: 'POST',
                data: { action: 'fetch', period: period },
                dataType: 'json',
                success: function (data) {
                    
                    var production = JSON.parse(data.production);
                    var reduction = JSON.parse(data.reduction);
                    updateTableHeaders(period);
                    updateTableRows(production, reduction, period);
                    console.log(production)
                    console.log(reduction)
//                     productionTable.rows.add(production).draw();
// reductionTable.rows.add(reduction).draw();
// typeReport.rows.add(type).draw();
// purposeReport.rows.add(purpose).draw();

//                     productionTable.clear().destroy();
// reductionTable.clear().destroy();
// typeReport.clear().destroy();
// purposeReport.clear().destroy();
 
// productionTable.ajax.reload();
// reductionTable.ajax.reload();
// typeReport.ajax.reload();
// purposeReport.ajax.reload();


                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data: ", error);
                    alert("An error occurred while fetching the data. Please try again later.");
                }
            });
        }

        //this function is called after a success data fetch
        function updateTableHeaders(period) {
            switch(period) {
                case 'lastdays':
                    //this is for the production table
                    var prodRow = $('<tr></tr>');
                    var dateAcquired = $('<th>Date Acquired</th>');
                    var batchID = $('<th>Batch ID</th>');
                    var coopNumber = $('<th>Coop Number</th>');
                    var startingQuantity = $('<th>Starting Quantity</th>');
                    var inStock = $('<th>In Stock</th>');
                    var reductions = $('<th>Reductions</th>');
                    prodRow.append(dateAcquired, batchID, coopNumber, startingQuantity, inStock, reductions);
                    $('#productionReport thead').empty().append(prodRow);

                    //this is for the reduction table
                    var redRow = $('<tr></tr>');
                    var dateReduced = $('<th>Date Reduced</th>');
                    var batchID = $('<th>Batch ID</th>');
                    var coopNumber = $('<th>Coop Number</th>');
                    var reductions = $('<th>Reductions</th>');
                    redRow.append(dateReduced, batchID, coopNumber, reductions);
                    $('#reductionReport thead').empty().append(redRow);
                    break;
                case 'weekly':
                    var prodRow = $('<tr></tr>');
                    var week = $('<th>Week</th>');
                    var coopNumber = $('<th>Coop Number</th>');
                    var startingQuantity = $('<th>Starting Quantity</th>');
                    var inStock = $('<th>In Stock</th>');
                    prodRow.append(week, coopNumber, startingQuantity, inStock);
                    $('#productionReport thead').empty().append(prodRow);

                    //this is for the reduction table
                    var redRow = $('<tr></tr>');
                    var dateReduced = $('<th>Date Reduced</th>');
                    var batchID = $('<th>Batch ID</th>');
                    var coopNumber = $('<th>Coop Number</th>');
                    var reductions = $('<th>Reductions</th>');
                    redRow.append(dateReduced, batchID, coopNumber, reductions);
                    $('#reductionReport thead').empty().append(redRow);
                    break;
                case 'monthly':
                    var prodRow = $('<tr></tr>');
                    var month = $('<th>Month</th>');
                    var coopNumber = $('<th>Coop Number</th>');
                    var startingQuantity = $('<th>Starting Quantity</th>');
                    var inStock = $('<th>In Stock</th>');
                    var reductions = $('<th>Reductions</th>');
                    prodRow.append(month, coopNumber, startingQuantity, inStock, reductions);
                    $('#productionReport thead').empty().append(prodRow);
                    break;
                case 'yearly':
                    var prodRow = $('<tr></tr>');
                    var year = $('<th>Year</th>');
                    var coopNumber = $('<th>Coop Number</th>');
                    var startingQuantity = $('<th>Starting Quantity</th>');
                    var inStock = $('<th>In Stock</th>');
                    var reductions = $('<th>Reductions</th>');
                    prodRow.append(year, coopNumber, startingQuantity, inStock, reductions);
                    $('#productionReport thead').empty().append(prodRow);
                    break;
                default:
                    console.error("Invalid period: ", period);
                    break;
            }
        }

        //this function is called after updateing the header and used to appedn data to the table
        function updateTableRows(production, reduction, period) {
            switch(period) {
                case 'lastdays':
                    // clear the table before appending new data
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
                    break;
                case 'weekly':
                    // clear the table before appending new data
                    $('#productionReport tbody').empty();
                    // append data to table
                    production.forEach(function(row) {
                        var weekCell = $('<td></td>').text(row[0]);
                        var coopNumberCell = $('<td></td>').text(row[1]);
                        var startingCell = $('<td></td>').text(row[2]);
                        var inStockCell = $('<td></td>').text(row[3]);
                        var prodRow = $('<tr></tr>').append(weekCell, coopNumberCell, startingCell, inStockCell);
                        $('#productionReport tbody').append(prodRow); 
                    });
                    break;
                case 'monthly':
                    // clear the table before appending new data
                    $('#productionReport tbody').empty();
                    // append data to table
                    production.forEach(function(row) {
                        var monthCell = $('<td></td>').text(row[0]);
                        var coopNumberCell = $('<td></td>').text(row[1]);
                        var startingCell = $('<td></td>').text(row[2]);
                        var inStockCell = $('<td></td>').text(row[3]);
                        var reductionCell = $('<td></td>').text(row[4]);
                        var prodRow = $('<tr></tr>').append(monthCell, coopNumberCell, startingCell, inStockCell, reductionCell);
                        $('#productionReport tbody').append(prodRow); 
                    });
                    break;
                case 'yearly':
                    // clear the table before appending new data
                    $('#productionReport tbody').empty();
                    // append data to table
                    production.forEach(function(row) {
                        var monthCell = $('<td></td>').text(row[0]);
                        var coopNumberCell = $('<td></td>').text(row[1]);
                        var startingCell = $('<td></td>').text(row[2]);
                        var inStockCell = $('<td></td>').text(row[3]);
                        var reductionCell = $('<td></td>').text(row[4]);
                        var prodRow = $('<tr></tr>').append(monthCell, coopNumberCell, startingCell, inStockCell, reductionCell);
                        $('#productionReport tbody').append(prodRow); 
                    });
                break;
            }
        }

        //
       // var chicken_chart;
        // function timeFrame(period) {

        //     var period = period.value;
        //     console.log(period)
            
        //     //this function will be called in the switch case, this will be use to reinitialized the table and append new data to it. this function accepts tabled id and the data to be appended
        //     //if table is production and reduction report, enabled search/filter and info
        //     function updateTable(tableId, data) {
        //     $(tableId).DataTable({
        //         destroy: true,
        //         paging: tableId === "#productionReport" || tableId === "#reductionReport",
        //         info: tableId === "#productionReport" || tableId === "#reductionReport",
        //         columnDefs: [
        //                 {"className": "dt-center", "targets": "_all"} //center all text in the table
        //             ],
        //     }).clear().rows.add(data).draw(); 
        //     }

        //     $.ajax({
        //         url: '../action/reports_action.php',
        //         type: 'POST',
        //         data: { action: 'fetch', period: period },
        //         dataType: 'json',
        //         success: function (data) {
                    
        //             //default configurations for the table
        //             $.extend($.fn.dataTable.defaults, {
        //                 lengthChange: false,
        //                 responsive: true,
        //                 columnDefs: [
        //                         {"className": "dt-center", "targets": "_all"} //center all text in the table
        //                     ],
        //                 filter: false,
        //                 info: false

        //             } );

        //             //acceprts the data from the script and parse it and store it to the variable
        //             var production = JSON.parse(data.production);
        //             var reduction = JSON.parse(data.reduction);
                    
        //             switch(period){
        //                 case 'lastdays': {
                            
        //                     // code to execute when period is "lastdays"
        //                     $('#productionReport thead').empty();
        //                     // code to execute when period is "lastdays"
        //                     var prodRow = $('<tr></tr>');
        //                     var dateAcquired = $('<th>Date Acquired</th>');
        //                     var batchID = $('<th>Batch ID</th>');
        //                     var coopNumber = $('<th>Coop Number</th>');
        //                     var startingQuantity = $('<th>Starting Quantity</th>');
        //                     var inStock = $('<th>In Stock</th>');
        //                     var reductions = $('<th>Reductions</th>');
        //                     prodRow.append(dateAcquired, batchID, coopNumber, startingQuantity, inStock, reductions);
        //                     $('#productionReport thead').append(prodRow);

        //                     //clears the table before appending the new data
        //                     $('#productionReport tbody').empty();
        //                     // append data to table
        //                     production.forEach(function(row) {
        //                         var dateCell = $('<td></td>').text(row[0]);
        //                         var chickenIDcell = $('<td></td>').text(row[1]);
        //                         var coopNumberCell = $('<td></td>').text(row[2]);
        //                         var startingCell = $('<td></td>').text(row[3]);
        //                         var inStockCell = $('<td></td>').text(row[4]);
        //                         var reductionCell = $('<td></td>').text(row[5]);
        //                         var prodRow = $('<tr></tr>').append(dateCell, chickenIDcell, coopNumberCell, startingCell, inStockCell, reductionCell);
        //                         $('#productionReport tbody').append(prodRow); 
        //                     });

        //                     $('#reductionReport thead').empty();
        //                     // code to execute when period is "lastdays"
        //                     var redRow = $('<tr></tr>');
        //                     var dateReduced = $('<th>Date Reduced</th>');
        //                     var batchID = $('<th>Batch ID</th>');
        //                     var coopNumber = $('<th>Coop Number</th>');
        //                     var reductions = $('<th>Reductions</th>');
        //                     redRow.append(dateReduced, batchID, coopNumber, reductions);
        //                     $('#reductionReport thead').append(redRow);

        //                     $('#reductionReport tbody').empty();
        //                     // append data to table
        //                     reduction.forEach(function(row) {
        //                         if(row[2]!=null){
        //                             var dateCell = $('<td></td>').text(row[0]);
        //                             var chickenIDcell = $('<td></td>').text(row[1]);
        //                             var coopNumberCell = $('<td></td>').text(row[2]);
        //                             var reductionCell = $('<td></td>').text(row[3]);
        //                             var redRow = $('<tr></tr>').append(dateCell, chickenIDcell, coopNumberCell, reductionCell);
        //                             $('#reductionReport tbody').append(redRow); 
        //                         }
        //                     });

        //                     //calls the function adn passed the table id and the data
        //                     updateTable("#productionReport", production);
        //                     updateTable("#reductionReport", reduction);
        //                     updateTable("#typeReport", reduction);
        //                     updateTable("#purposeReport", production);
        //                     break;
        //                 }
        //                 case 'weekly': {
        //                     // code to execute when period is "weekly"
        //                       // code to execute when period is "lastdays"
        //                       $('#productionReport thead').empty();
        //                     // code to execute when period is "lastdays"
        //                     var prodRow = $('<tr></tr>');
        //                     var week = $('<th>Week</th>');
        //                     var monthDay = $('<th>Date</th>');
        //                     var inStock = $('<th>In Stock</th>');
        //                     var reductions = $('<th>Reductions</th>');
        //                     prodRow.append(week, monthDay, inStock, reductions);
        //                     $('#productionReport thead').append(prodRow);
                            
        //                     //clears the table before appending the new data
        //                     $('#productionReport tbody').empty();
        //                     // append data to table
        //                     production.forEach(function(row) {
        //                         var week = $('<td></td>').text(row[0]);
        //                         var monthDay = $('<td></td>').text(row[1]);
        //                         var inStockCell = $('<td></td>').text(row[2]);
        //                         var reductionCell = $('<td></td>').text(row[3]);
        //                         var prodRow = $('<tr></tr>').append(week, monthDay, inStockCell, reductionCell);
        //                         $('#productionReport tbody').append(prodRow); 
        //                     });

        //                     $('#reductionReport thead').empty();
        //                     // code to execute when period is "lastdays"
        //                     var redRow = $('<tr></tr>');
        //                     var dateReduced = $('<th>Date Reduced</th>');
        //                     var batchID = $('<th>Batch ID</th>');
        //                     var coopNumber = $('<th>Coop Number</th>');
        //                     var reductions = $('<th>Reductions</th>');
        //                     redRow.append(dateReduced, batchID, coopNumber, reductions);
        //                     $('#reductionReport thead').append(redRow);

        //                     $('#reductionReport tbody').empty();
        //                     // append data to table
        //                     reduction.forEach(function(row) {
        //                         if(row[2]!=null){
        //                             var dateCell = $('<td></td>').text(row[0]);
        //                             var chickenIDcell = $('<td></td>').text(row[1]);
        //                             var coopNumberCell = $('<td></td>').text(row[2]);
        //                             var reductionCell = $('<td></td>').text(row[3]);
        //                             var redRow = $('<tr></tr>').append(dateCell, chickenIDcell, coopNumberCell, reductionCell);
        //                             $('#reductionReport tbody').append(redRow); 
        //                         }
        //                     });

                            
        //                     updateTable("#productionReport", production);
        //                     updateTable("#reductionReport", reduction);
        //                     updateTable("#typeReport", reduction);
        //                     updateTable("#purposeReport", production);
        //                     break;
        //                 }
        //                 default: {
        //                     // code to execute when period doesn't match any of the cases
        //                 }
        //             }

        //             // update chart
        //             chart_data.datasets[0].data = data;
        //             chart.update();
        //         },
        //         error: function (request, error) {
        //             console.log(arguments);
        //             alert("Can't do because: " + error);
        //         }
        //     });
        // }

        </script>

    </body>
</html>
  
   