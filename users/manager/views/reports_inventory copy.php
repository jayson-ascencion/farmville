<?php
    //title of the pge
    $title = "Inventory Reports";

    //header
    include("../../includes/header.php");

?>


<div class="container-fluid px-4">
    
    <h1 class="mt-4"> Manager Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./index.php" style="text-decoration: none">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Inventory Reports</li>
    </ol>
    <div class="wrapper mb-5">
        <div class="container">
            <div class="row">
                <div class="p-0">
                    <div class="card shadow-lg">
                        <div class="card-header rounded rounded-3" style="background-color: #FFAF1A; color: #91452c">

                            <div class="row justify-content-between">
                                <div class="col-xl-6 col-md-6">
                                    <h4 class="pt-2 fs-5 fw-bold">Reports</h4>
                                </div>

                                <div class="col-xl-3 col-md-3 align-content-end">
                                    <div class="w-100 d-flex text-center  justify-content-end">
                                        <input type="text" id="daterange_textbox" class="form-control border-success bg-success text-center text-white fw-semibold bg-opacity-75"  readonly/>
                                        <div>
                                        <form id="download-form" action="../action/download_inventory.php" method="post">
                                            <input type="hidden" name="start_date" id="start_date_input">
                                            <input type="hidden" name="end_date" id="end_date_input">
                                            <button type="submit" class="btn btn-danger ms-1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM1.6 11.85H0v3.999h.791v-1.342h.803c.287 0 .531-.057.732-.173.203-.117.358-.275.463-.474a1.42 1.42 0 0 0 .161-.677c0-.25-.053-.476-.158-.677a1.176 1.176 0 0 0-.46-.477c-.2-.12-.443-.179-.732-.179Zm.545 1.333a.795.795 0 0 1-.085.38.574.574 0 0 1-.238.241.794.794 0 0 1-.375.082H.788V12.48h.66c.218 0 .389.06.512.181.123.122.185.296.185.522Zm1.217-1.333v3.999h1.46c.401 0 .734-.08.998-.237a1.45 1.45 0 0 0 .595-.689c.13-.3.196-.662.196-1.084 0-.42-.065-.778-.196-1.075a1.426 1.426 0 0 0-.589-.68c-.264-.156-.599-.234-1.005-.234H3.362Zm.791.645h.563c.248 0 .45.05.609.152a.89.89 0 0 1 .354.454c.079.201.118.452.118.753a2.3 2.3 0 0 1-.068.592 1.14 1.14 0 0 1-.196.422.8.8 0 0 1-.334.252 1.298 1.298 0 0 1-.483.082h-.563v-2.707Zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638H7.896Z"/>
                                        </svg></button>
                                        </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <!-- MEDICINES -->
                    <!-- <div class="card mt-3 shadow-lg">
                        <div class="card-header fw-bold fs-5" style="background-color: #FFAF1A; color: #91452c">
                            Medicine Inventory
                        </div>
                        <div class="card-body">
                            <div class="table-responsive m-1">
                                <h5 class="text-center" style="color: rgb(100, 100, 100)">Summary By Reduction Type</h5>
                                <div class="chart-container bar-chart">
                                    <canvas id="bar_chart" height="100"> </canvas>
                                </div>
                                <table class="table table-sm responsive border table-hover text-center rounde rounded-3 overflow-hidden" style="width: 100%" id="medicine_table">
                                    <thead class="text-white" style="background-color: #DC143C">
                                        <tr>
                                            <th>Reduction Type</th>
                                            <th>Reductions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> -->

                    <div class="card mt-3 shadow-lg">
                        <div class="card-body">
                            <div class="table-responsive m-1">
                                <h5 class="text-center" style="color: rgb(100, 100, 100)">Summary By Medicine Reduction Type</h5>
                                <div class="chart-container pie-chart">
                                    <canvas id="second_chart" height="100"> </canvas>
                                </div>
                                <table class="table table-sm responsive border table-hover text-center rounde rounded-3 overflow-hidden" style="width: 100%" id="second_table">
                                    <thead class="text-white" style="background-color: #DC143C">
                                        <tr>
                                            <th>Reduction Type</th>
                                            <th>Reductions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3 shadow-lg">
                        <div class="table-responsive m-1">
                            <div class="card-body">
                                <h5 class="text-center" style="color: rgb(100, 100, 100)">List of Medicines About To Expire</h5>
                                <table class="table table-sm responsive border table-hover text-center rounde rounded-3 overflow-hidden" style="width: 100%" id="list_medicines">
                                    <thead class="text-white" style="background-color: #DC143C">
                                        <tr>
                                            <!-- <th>Date Added</th> -->
                                            <th>Medicine Name</th>
                                            <th>Expiration Date</th>
                                            <!-- <th>Starting Quantity</th> -->
                                            <th>In Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3 shadow-lg">
                        <div class="table-responsive m-1">
                            <div class="card-body">
                                <h5 class="text-center" style="color: rgb(100, 100, 100)">List of Medicines Low In Stock</h5>
                                <table class="table table-sm responsive border table-hover text-center rounde rounded-3 overflow-hidden" style="width: 100%" id="low_stock">
                                    <thead class="text-white" style="background-color: #DC143C">
                                        <tr>
                                            <!-- <th>Date Added</th> -->
                                            <th>Medicine Name</th>
                                            <th>Expiration Date</th>
                                            <!-- <th>Starting Quantity</th> -->
                                            <th>In Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- <hr class="border mt-3 mb-3 border-dark border-3 opacity-75">  -->

                    <!-- FEEDS -->
                    <div class="card mt-3 shadow-lg">
                        <div class="card-header fw-bold fs-5" style="background-color: #FFAF1A; color: #91452c">
                            Feed Inventory
                        </div>
                        <!-- <div class="card-body">
                            <div class="table-responsive m-1">
                                <h5 class="text-center" style="color: rgb(100, 100, 100)">Feeds Report</h5>
                                <div class="chart-container bar-chart">
                                    <canvas id="feed_chart" height="100"> </canvas>
                                </div>
                                <table class="table table-sm responsive border table-hover text-center rounde rounded-3 overflow-hidden" style="width: 100%" id="feed_table">
                                    <thead class="text-white" style="background-color: #DC143C">
                                        <tr>
                                            <th>Date Purchased</th>
                                            <th>Feed Name</th>
                                            <th>Starting Quantity</th>
                                            <th>In Stock</th>
                                            <th>Reductions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div> -->
                    </div>

                    <div class="card mt-3 shadow-lg">
                        <div class="table-responsive m-1">
                            <div class="card-body">
                                <h5 class="text-center" style="color: rgb(100, 100, 100)">List of Feeds Low In Stock</h5>
                                <table class="table table-sm responsive border table-hover text-center rounde rounded-3 overflow-hidden" style="width: 100%" id="feeds_low_stock">
                                    <thead class="text-white" style="background-color: #DC143C">
                                        <tr>
                                            <!-- <th>Date Added</th> -->
                                            <th>Feed Name</th>
                                            <!-- <th>Expiration Date</th> -->
                                            <!-- <th>Starting Quantity</th> -->
                                            <th>In Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3 shadow-lg">
                        <div class="card-body">
                            <div class="table-responsive m-1">
                                <h5 class="text-center" style="color: rgb(100, 100, 100)">Summary By Feed Reduction Type</h5>
                                <div class="chart-container pie-chart">
                                    <canvas id="feed_chart" height="100"> </canvas>
                                </div>
                                <table class="table table-sm responsive border table-hover text-center rounde rounded-3 overflow-hidden" style="width: 100%" id="feed_table">
                                    <thead class="text-white" style="background-color: #DC143C">
                                        <tr>
                                            <th>Reduction Type</th>
                                            <th>Reductions</th>
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

<script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous" async defer></script>
<script src="../../../assets/js/jquery-3.6.1.min.js"></script>
<script src="../../../assets/js/bootstrap5.bundle.min.js" crossorigin="anonymous"></script>
<script src="../../../assets/js/scripts.js"></script>
<script src="../../../assets/js/moment.js"></script>
<script src="../../../assets/js/popper.min.js"></script>
<script src="../../../assets/js/datatables.min.js"></script>
<script src="../../../assets/js/daterangepicker.js"></script>
<script src="../../../assets/js/pdfmake.min.js"></script>
<script src="../../../assets/js/pdf.min.js"></script>
<script src="../../../assets/js/vfs_fonts.js"></script>
<script src="../../../assets/js/chart.js"></script>
<script src="../../../assets/js/chartjs-adapter-date-fns.bundle.min.js"></script>
<script src="../../../assets/js/chartjs-plugin-datalabels.min.js"></script> 
<script>
    //To register it globally to all charts
    Chart.register(ChartDataLabels);

    $.extend( $.fn.dataTable.defaults, {
        // "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        // "lengthMenu": [[-1, 10, 25, 50, 100], ["All", 10, 25, 50, 100]],
        "pageLength": -1,
        responsive: true,
        stateSave: true,
        columnDefs: [
            {"className": "dt-center", "targets": "_all"} //center all text in the table
        ],
    });
    $(document).ready(function(){


    var production_chart;
    var second_chart;
    var feed_chart;

    //declare start_date and end_date
    start_date = '';
    end_date = '';

    //call fetch data function and pass todays date as parameters
    fetch_data(moment().format('YYYY-MM-DD'), moment().format('YYYY-MM-DD'));

    //function to fetch data
    function fetch_data(start, end)
    {
        //store the date in the start_date and end_date
        start_date = start;
        end_date = end;
        // console.log(start)
        document.getElementById("start_date_input").value = start_date;
        document.getElementById("end_date_input").value = end_date;
        //creates the table
         //second table
         var dataTable = $('#second_table').DataTable({
                info: false,
                paging: false,
                filter: false,
                stateSave: true,
                "processing" : true,
                "serverSide" : true, //serverside
                "order" : [], //enables table ordering
                "ajax" : {
                    url:"../action/reports_action.php",
                    type:"POST",
                    data:{action:'medicinereduction', start_date:start_date, end_date:end_date}
                },
                "drawCallback" : function(settings)
                {
                    
                    var reductionType = [];
                    var reductions = [];
                    
                    for(var count = 0; count < settings.aoData.length; count++)
                    {
                        reductionType.push(settings.aoData[count]._aData[0]);
                        reductions.push(parseFloat(settings.aoData[count]._aData[1]));
                    }

                    var chart_data = {
                        labels: reductionType,
                        datasets: [
                            {
                                label: 'Reduction Type',
                                backgroundColor: [
                                    'rgba(153, 102, 255)', 
                                    'rgba(255, 99, 132)', 
                                    'rgba(255, 159, 64)', 
                                    'rgba(255, 205, 86)', 
                                    'rgba(75, 192, 192)'
                                ],
                                color: '#fff',
                                data: reductions
                            }
                        ],

                    };
                    
                    var group_chart3 = $('#second_chart');

                    if(second_chart)
                    {
                        second_chart.destroy();
                    }

                    second_chart = new Chart(group_chart3, {
                        type:'bar',
                        data:chart_data,
                        options: {
                            maintainAspectRatio: true,
                            responsive: true,
                            plugins: {
                                datalabels: { // This code is used to display data values
                                    color: 'black',
                                    anchor: 'auto',
                                    align: 'top',
                                    formatter: Math.round,
                                    //                                     formatter: function(value, context) {
                                    //   return context.dataset.label + ': ' + value + '%';
                                    // },
                                    font: {
                                        weight: 'normal',
                                        size: 12
                                    },
                                    minRotation: 0,
                                    maxRotation: 90,
                                }
                            }
                        },
                        plugins: [{
                            afterDatasetsDraw: ((chart, args, plugins) => {
                                const {ctx, data, chartArea: {top, bottom, left, right, width, height}} = chart;
                                    // console.log(data)
                                ctx.save();
                                
                                if (reductions.length === 0) {
                                    // console.log('ahah')
                                    chart.options.scales.y.display = false;
                                    ctx.fillStyle = 'rgba(255, 255, 255, 1)';
                                    ctx.fillRect(left, top, width, height);

                                    ctx.font = '20px sans-serif';
                                    ctx.fillStyle = 'black';
                                    ctx.textAlign = 'center';
                                    ctx.fillText('No Data Available', left + width / 2, top + height / 2);
                                }

                            })
                        }] 
                    });
                }
            });

            //feeed table
            var dataTable = $('#feed_table').DataTable({
                info: false,
                paging: false,
                filter: false,
                stateSave: true,
                "processing" : true,
                "serverSide" : true, //serverside
                "order" : [], //enables table ordering
                "ajax" : {
                    url:"../action/reports_action.php",
                    type:"POST",
                    data:{action:'feedreduction', start_date:start_date, end_date:end_date}
                },
                "drawCallback" : function(settings)
                {
                    
                    var reductionType = [];
                    var reductions = [];
                    
                    for(var count = 0; count < settings.aoData.length; count++)
                    {
                        reductionType.push(settings.aoData[count]._aData[0]);
                        reductions.push(parseFloat(settings.aoData[count]._aData[1]));
                    }

                    var chart_data = {
                        labels: reductionType,
                        datasets: [
                            {
                                label: 'Reduction Type',
                                backgroundColor: [
                                    'rgba(153, 102, 255)', 
                                    'rgba(255, 99, 132)', 
                                    'rgba(255, 159, 64)', 
                                    'rgba(255, 205, 86)', 
                                    'rgba(75, 192, 192)'
                                ],
                                color: '#fff',
                                data: reductions
                            }
                        ],

                    };
                    
                    var group_chart3 = $('#feed_chart');

                    if(feed_chart)
                    {
                        feed_chart.destroy();
                    }

                    feed_chart = new Chart(group_chart3, {
                        type:'bar',
                        data:chart_data,
                        options: {
                            maintainAspectRatio: true,
                            responsive: true,
                            plugins: {
                                datalabels: { // This code is used to display data values
                                    color: 'black',
                                    anchor: 'auto',
                                    align: 'top',
                                    formatter: Math.round,
                                    //                                     formatter: function(value, context) {
                                    //   return context.dataset.label + ': ' + value + '%';
                                    // },
                                    font: {
                                        weight: 'normal',
                                        size: 12
                                    },
                                    minRotation: 0,
                                    maxRotation: 90,
                                }
                            }
                        },
                        plugins: [{
                            afterDatasetsDraw: ((chart, args, plugins) => {
                                const {ctx, data, chartArea: {top, bottom, left, right, width, height}} = chart;
                                    // console.log(data)
                                ctx.save();
                                
                                if (reductions.length === 0) {
                                    // console.log('ahah')
                                    chart.options.scales.y.display = false;
                                    ctx.fillStyle = 'rgba(255, 255, 255, 1)';
                                    ctx.fillRect(left, top, width, height);

                                    ctx.font = '20px sans-serif';
                                    ctx.fillStyle = 'black';
                                    ctx.textAlign = 'center';
                                    ctx.fillText('No Data Available', left + width / 2, top + height / 2);
                                }

                            })
                        }] 
                    });
                }
            });

        //production table
        var dataTable = $('#medicine_table').DataTable({
            pagingType: 'numbers',
            "columnDefs": [
                // {
                //     "targets": [0,2],
                //     "render": function (data, type, row) {
                //         var date = new Date(data);
                //         var options = {year: 'numeric', month: 'short', day: 'numeric' };
                //         return date.toLocaleDateString('en-US', options);
                //     },
                   
                // },
                {
                    "className": "dt-center", "targets": "_all"
                }
            ],
            "processing" : true,
            "serverSide" : true, //serverside
            "order" : [], //enables table ordering
            "ajax" : {
                url:"../action/reports_action.php",
                type:"POST",
                data:{action:'medicine', start_date:start_date, end_date:end_date}
            },
            "drawCallback" : function(settings)
            {
                // var dateAdded = [];
                // var expirationDate = [];
                // var instock = [];
                // var reductions = [];
                // var startingQuantity = [];
                // var medicineName = [];
                var reductionType = [];
                var quantity = [];

                for(var count = 0; count < settings.aoData.length; count++)
                {
                    //$order_column = array('dateAdded','medicineName','expirationDate','startingQuantity','instock','reductions');
                    // var dA = new Date(settings.aoData[count]._aData[0]);
                    // var eD = new Date(settings.aoData[count]._aData[2]);
                    // var options = {year: 'numeric', month: 'short', day: 'numeric' };
                    // dateAdded.push(dA.toLocaleDateString('en-US', options));
                    // expirationDate.push(eD.toLocaleDateString('en-US', options));
                    // // eggSize.push(settings.aoData[count]._aData[1]);
                    // medicineName.push(settings.aoData[count]._aData[1]);
                    // startingQuantity.push(parseFloat(settings.aoData[count]._aData[3]));
                    // instock.push(parseFloat(settings.aoData[count]._aData[4]));
                    // reductions.push(parseFloat(settings.aoData[count]._aData[5]));
                    reductionType.push(settings.aoData[count]._aData[0]);
                    quantity.push(parseFloat(settings.aoData[count]._aData[1]));
                }
                // console.log(dateAdded)
                var chart_data = {
                    labels:reductionType,
                    datasets:[
                        {
                            label : 'Reduction Type',
                            backgroundColor : 'rgb(65,105,225)',
                            color : '#fff',
                            data:quantity
                        },
                        // {
                        //     label : 'Total In Stock',
                        //     backgroundColor : 'rgb(34, 139, 134)',
                        //     color : '#fff',
                        //     data:instock
                        // },
                        // {
                        //     label : 'Quantity Reduced',
                        //     backgroundColor : 'rgb(205,92,92)',
                        //     color : '#fff',
                        //     data:reductions
                        // }
                    ]   
                };

                var group_chart3 = $('#bar_chart');

                if(production_chart)
                {
                    production_chart.destroy();
                }

                const bgColor = {
                    id: 'bgColor',
                    beforeDraw: (chart, options) => {
                        const { ctx, width, height} = chart;
                        ctx.fillStyle = 'white';
                        ctx.fillRect(0,0, width, height);
                        ctx.restore();
                    }
                }

                production_chart = new Chart(group_chart3, {
                    type:'bar',
                    data:chart_data,
                    options: {
                        maintainAspectRatio: true,
                        responsive: true,
                        plugins: {
                            datalabels: { // This code is used to display data values
                                color: 'black',
                                anchor: 'auto',
                                align: 'top',
                                formatter: Math.round,
                                //                                     formatter: function(value, context) {
                                //   return context.dataset.label + ': ' + value + '%';
                                // },
                                font: {
                                    weight: 'normal',
                                    size: 12
                                },
                                minRotation: 0,
                                maxRotation: 90,
                            }
                        }
                    },
                    plugins: [
                        {   bgColor,
                            afterDatasetsDraw: ((chart, args, plugins) => {
                                const {ctx, data, chartArea: {top, bottom, left, right, width, height}} = chart;
                                    // console.log(data)
                                ctx.save();
                                
                                if (quantity.length === 0) {
                                    // console.log('ahah')
                                    ctx.fillStyle = 'rgba(255, 255, 255, 1)';
                                    ctx.fillRect(left, top, width, height);

                                    ctx.font = '20px sans-serif';
                                    ctx.fillStyle = 'black';
                                    ctx.textAlign = 'center';
                                    ctx.fillText('No Data Available', left + width / 2, top + height / 2);
                                }

                            })
                        }
                    ]
                });
            }
        });

        //list of medicines
        var dataTable = $('#list_medicines').DataTable({
            pagingType: 'numbers',
            "columnDefs": [
                {
                    "targets": [1],
                    "render": function (data, type, row) {
                        var date = new Date(data);
                        var options = {year: 'numeric', month: 'short', day: 'numeric' };
                        return date.toLocaleDateString('en-US', options);
                    },
                   
                },
                {
                    "className": "dt-center", "targets": "_all"
                }
            ],
            "processing" : true,
            "serverSide" : true, //serverside
            "order" : [], //enables table ordering
            "ajax" : {
                url:"../action/reports_action.php",
                type:"POST",
                data:{action:'toexpire', start_date:start_date, end_date:end_date}
            }
        });

        //low stock of medicines
        var dataTable = $('#low_stock').DataTable({
            pagingType: 'numbers',
            "columnDefs": [
                {
                    "targets": [1],
                    "render": function (data, type, row) {
                        var date = new Date(data);
                        var options = {year: 'numeric', month: 'short', day: 'numeric' };
                        return date.toLocaleDateString('en-US', options);
                    },
                   
                },
                {
                    "className": "dt-center", "targets": "_all"
                }
            ],
            "processing" : true,
            "serverSide" : true, //serverside
            "order" : [], //enables table ordering
            "ajax" : {
                url:"../action/reports_action.php",
                type:"POST",
                data:{action:'lowstock', start_date:start_date, end_date:end_date}
            },
            
        });

        //low stock of medicines
        var dataTable = $('#feeds_low_stock').DataTable({
            pagingType: 'numbers',
            "columnDefs": [
                // {
                //     "targets": [1],
                //     "render": function (data, type, row) {
                //         var date = new Date(data);
                //         var options = {year: 'numeric', month: 'short', day: 'numeric' };
                //         return date.toLocaleDateString('en-US', options);
                //     },
                   
                // },
                {
                    "className": "dt-center", "targets": "_all"
                }
            ],
            "processing" : true,
            "serverSide" : true, //serverside
            "order" : [], //enables table ordering
            "ajax" : {
                url:"../action/reports_action.php",
                type:"POST",
                data:{action:'feeds_lowstock', start_date:start_date, end_date:end_date}
            },
            
        });

        // var dataTable = $('#feed_table').DataTable({
        //     pagingType: 'numbers',
        //     "columnDefs": [
        //         {
        //             "targets": [0],
        //             "render": function (data, type, row) {
        //                 var date = new Date(data);
        //                 var options = {year: 'numeric', month: 'short', day: 'numeric' };
        //                 return date.toLocaleDateString('en-US', options);
        //             },
                   
        //         },
        //         {
        //             "className": "dt-center", "targets": "_all"
        //         }
        //     ],
        //     "processing" : true,
        //     "serverSide" : true, //serverside
        //     "order" : [], //enables table ordering
        //     "ajax" : {
        //         url:"../action/reports_action.php",
        //         type:"POST",
        //         data:{action:'feeds', start_date:start_date, end_date:end_date}
        //     },
        //     "drawCallback" : function(settings)
        //     {
        //         var datePurchased = [];
        //         var brand = [];
        //         var instock = [];
        //         var reductions = [];
        //         var startingQuantity = [];
        //         var feedName = [];

        //         for(var count = 0; count < settings.aoData.length; count++)
        //         {
        //             //$order_column = array('datePurchased','feedName','brand','startingQuantity','inStock','reductions');
        //             var dA = new Date(settings.aoData[count]._aData[0]);
        //             var options = {year: 'numeric', month: 'short', day: 'numeric' };
        //             datePurchased.push(dA.toLocaleDateString('en-US', options));
        //             // eggSize.push(settings.aoData[count]._aData[1]);
        //             feedName.push(settings.aoData[count]._aData[1]);
        //             startingQuantity.push(parseFloat(settings.aoData[count]._aData[2]));
        //             instock.push(parseFloat(settings.aoData[count]._aData[3]));
        //             reductions.push(parseFloat(settings.aoData[count]._aData[4]));
        //         }
        //         // console.log(datePurchased)
        //         var chart_data = {
        //             labels:datePurchased,
        //             datasets:[
        //                 {
        //                     label : 'Total Quantity',
        //                     backgroundColor : 'rgb(65,105,225)',
        //                     color : '#fff',
        //                     data:startingQuantity
        //                 },
        //                 {
        //                     label : 'Total In Stock',
        //                     backgroundColor : 'rgb(34, 139, 134)',
        //                     color : '#fff',
        //                     data:instock
        //                 },
        //                 {
        //                     label : 'Quantity Reduced',
        //                     backgroundColor : 'rgb(205,92,92)',
        //                     color : '#fff',
        //                     data:reductions
        //                 }
        //             ]   
        //         };

        //         var group_chart3 = $('#feed_chart');

        //         if(feed_chart)
        //         {
        //             feed_chart.destroy();
        //         }

        //         const bgColor = {
        //             id: 'bgColor',
        //             beforeDraw: (chart, options) => {
        //                 const { ctx, width, height} = chart;
        //                 ctx.fillStyle = 'white';
        //                 ctx.fillRect(0,0, width, height);
        //                 ctx.restore();
        //             }
        //         }
        //         feed_chart = new Chart(group_chart3, {
        //             type:'bar',
        //             data:chart_data,
        //                 options: {
        //                     maintainAspectRatio: true,
        //                     responsive: true,
        //                     plugins: {
        //                         datalabels: { // This code is used to display data values
        //                             color: 'black',
        //                             anchor: 'auto',
        //                             align: 'top',
        //                             formatter: Math.round,
        //                             //                                     formatter: function(value, context) {
        //                             //   return context.dataset.label + ': ' + value + '%';
        //                             // },
        //                             font: {
        //                                 weight: 'normal',
        //                                 size: 12
        //                             },
        //                             minRotation: 0,
        //                             maxRotation: 90,
        //                         }
        //                     }
        //                 },
        //             plugins: [{
        //                 bgColor,
        //                 afterDatasetsDraw: ((chart, args, plugins) => {
        //                     const {ctx, data, chartArea: {top, bottom, left, right, width, height}} = chart;
        //                         // console.log(data)
        //                     ctx.save();
                            
        //                     if (startingQuantity.length === 0 && instock.length === 0 && reductions.length === 0) {
        //                         // console.log('ahah')
        //                         ctx.fillStyle = 'rgba(255, 255, 255, 1)';
        //                         ctx.fillRect(left, top, width, height);

        //                         ctx.font = '20px sans-serif';
        //                         ctx.fillStyle = 'black';
        //                         ctx.textAlign = 'center';
        //                         ctx.fillText('No Data Available', left + width / 2, top + height / 2);
        //                     }

        //                 })
        //             }]
        //         });
        //     }
        // });
    }
    
    $('#daterange_textbox').daterangepicker({
        
        ranges:{
            'Today' : [moment(), moment()],
            // 'Yesterday' : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
            // 'Last 30 Days' : [moment().subtract(29, 'days'), moment()],
            'This Month' : [moment().startOf('month'), moment().endOf('month')],
            // 'Last Month' : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            // 'Last 12 Months': [moment().subtract(11, 'months').startOf('month'), moment().endOf('month')],
            'This Year': [moment().startOf('year'), moment().endOf('year')],
            // 'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
        },
        format : 'YYYY-MM-DD',
        }, function(start, end){

            $('#medicine_table').DataTable().destroy();
            $('#list_medicines').DataTable().destroy();
            $('#low_stock').DataTable().destroy();
            $('#feed_table').DataTable().destroy();
            $('#second_table').DataTable().destroy();
            $('#feeds_low_stock').DataTable().destroy();
            fetch_data(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));

        });


    });
    // https://www.webslesson.info/2022/03/php-ajax-advance-date-range-filter-in-datatables-chartjs-using-date-range-picker.html

 
    document.getElementById("download-form").addEventListener("submit", function(e) {
        e.preventDefault(); // prevent form from submitting
        document.getElementById("download-form").submit(); // manually submit form
    });
    
</script>