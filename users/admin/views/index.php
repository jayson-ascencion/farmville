<?php
    $title = "Admin Dashboard";
    //header
    include('../../includes/header.php');

?>

<!-- content --> 
<div class="container-fluid px-4">
    <h1 class="mt-4"> Administrator Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-white border-success mb-4 shadow">
                <div class="card-body m-2">
                    <div class="fs-3 fw-bold float-end">
                        <?php
                            //connect to the database
                            include('../../../config/database_connection.php');

                            //to count how many schedules are completed
                            $sql = "SELECT COUNT(status) as 'total' FROM schedules WHERE scheduleType = 'medication' AND status = 'completed' AND archive = 'not archived'";
                            $stmt = $conn->query($sql);
                            $stmt->execute();
                            print_r($stmt->fetchColumn());

                            // Close connection
                            unset($conn);
                        ?>
                    </div>
                    <div>
                        <h5 class="card-subtitle text-muted fs-6"><strong> Completed <span class="text-dark">Medication </span> </strong>  Schedules:</h5>
                    </div>
                    <a href="./medication_completed.php" class="card-link text-decoration-none pt-5 opacity-75" style="font-size: 15px">View More
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-white border-danger  mb-4 shadow">
                <div class="card-body m-2">
                    <div class="fs-3 fw-bold float-end">
                        <?php
                            //connect to the database
                            include('../../../config/database_connection.php');

                            //to count how many schedules are pending
                            $sql = "SELECT COUNT(status) as 'total' FROM schedules WHERE scheduleType = 'medication' AND status = 'pending' AND archive = 'not archived'";
                            $stmt = $conn->query($sql);
                            $stmt->execute();
                            print_r($stmt->fetchColumn());

                            // Close connection
                            unset($conn);
                        ?>
                    </div>
                    <div>
                        <h5 class="card-subtitle text-muted fs-6"><strong> Pending <span class="text-dark">Medication </span></strong>  Schedules:</h5>
                    </div>
                    <a href="./medication_pending.php" class="card-link text-decoration-none pt-5 opacity-75" style="font-size: 15px">View More
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-white border-success mb-4 shadow">
                <div class="card-body m-2">
                    <div class="fs-3 fw-bold float-end">
                        <?php
                            //connect to the database
                            include('../../../config/database_connection.php');

                            //to count how many schedules are completed
                            $sql = "SELECT COUNT(status) as 'total' FROM schedules WHERE scheduleType = 'vaccination' AND status = 'completed' AND archive = 'not archived'";
                            $stmt = $conn->query($sql);
                            $stmt->execute();
                            print_r($stmt->fetchColumn());

                            // Close connection
                            unset($conn);
                        ?>
                    </div>
                    <div>
                        <h5 class="card-subtitle text-muted fs-6"><strong> Completed <span class="text-dark"> Vaccination</span></strong>  Schedules:</h5>
                    </div>
                    <a href="./vaccination_completed.php" class="card-link text-decoration-none pt-5 opacity-75" style="font-size: 15px">View More
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-white border-danger mb-4 shadow">
                <div class="card-body m-2">
                    <div class="fs-3 fw-bold float-end">
                        <?php
                            //connect to the database
                            include('../../../config/database_connection.php');

                            //to count how many schedules are pending
                            $sql = "SELECT COUNT(status) as 'total' FROM schedules WHERE scheduleType = 'vaccination' AND status = 'pending' AND archive = 'not archived'";
                            $stmt = $conn->query($sql);
                            $stmt->execute();
                            print_r($stmt->fetchColumn());

                            // Close connection
                            unset($conn);
                        ?>
                    </div>
                    <div>
                       <h5 class="card-subtitle text-muted fs-6"> <strong> Pending <span class="text-dark"> Vaccination</span></strong> Schedules:</h5>
                    </div>
                    <a href="./vaccination_pending.php" class="card-link text-decoration-none pt-5 opacity-75" style="font-size: 15px">View More
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                        </svg>
                    </a>
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