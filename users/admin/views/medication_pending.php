<?php
    //page title
    $title ="Pending Medication Schedules";
    
    //header
    include('../../includes/header.php');
?>

<!-- content --> 
<div class="container-fluid px-4">

    <h1 class="mt-4"> Administrator Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a class="text-decoration-none" href="./index.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Pending Medication Schedules</li>
    </ol>

    <div class="wrapper">
        <div class="container">
            <div class="row mb-5">
                <div class="p-0">
                    <div class="card shadow-lg">
                        <div class="card-header" style="background-color: #f37e57;">

                            <div class="row justify-content-between">
                                <div class="col-xl-4 col-md-6">
                                    <h4 class="pt-2 fs-5 fw-bold">Pending Medication Schedules</h4>
                                </div>

                                <div class="col-xl-2 col-md-4 align-content-end">
                                    <div class="w-100 d-flex justify-content-end">
                                        <div class="m-1 w-100 float-end">
                                            <a href="add_sched_medication.php" class="btn btn-success shadow-sm w-100 fw-bold">Add Schedule</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        </div>

                        <div class="card-body">
                            <div class="table-responsive m-1">
                                <?php
                                    // Include the script to display the table
                                    include('./query/medication_pending_records.php');
                                ?>
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
    //header
    include('../../includes/footer.php');

    //scripts
    include('../../includes/scripts.php');
?>
