<?php
    //page title
    $title ="Completed Medication Schedules";
    
    //header
    include('../../includes/header.php');

?>

<!-- content --> 
<div class="container-fluid px-4">
    <h1 class="mt-4"> Employee Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a class="text-decoration-none" href="./index.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item active"> Medication Schedules</li>
    </ol>

    <div class="wrapper">
        <div class="container">
            <div class="row mb-5">
                <div class="p-0">
                    <div class="card shadow-lg">
                        <div class="card-header" style="background-color: #f37e57;">
                            <div class="row justify-content-between">
                                <div class="col">
                                    <h4 class="pt-2 fs-5 fw-bold">Completed Medication Schedules</h4>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive m-1">
                                <?php
                                    // Include the file to display the table
                                    include('./query/medication_completed_records.php');
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
