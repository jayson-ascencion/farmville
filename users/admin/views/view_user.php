<?php
    //page title
    $title = "Vaccination Details";
    
    //header
    include('../../includes/header.php');

    //connect to the database
    include('../../../config/database_connection.php');

    //store the id
    $id = $_REQUEST['id'];

    //statement to select the specific schedule to update
    $sql = "SELECT * FROM users WHERE user_ID = '$id'";
    $stmt = $conn->query($sql);
    if($stmt){
        if($stmt->rowCount() > 0){
            while($row = $stmt->fetch()){
            $user_ID = $row['user_ID'];
            $fname = $row['fname'];
            $lname = $row['lname'];
            $contact_num = $row['contact_num'];
            $role = $row['role'];
            $username = $row['username'];
            $status = $row['status'];
            }
            // Free result set
            unset($result);
        } else{
            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
        }
    } else{
    echo "Oops! Something went wrong. Please try again later.";
    }
    unset($stmt);
?>

<!-- content --> 
<div class="container-fluid px-4">
    <h1 class="mt-4"> Administrator Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a class="text-decoration-none" href="./medication_pending.php">Users</a>
        </li>
        <li class="breadcrumb-item active">View Details</li>
    </ol>


    <div class="row justify-content-center mt-2">
        <div class="col-sm-4">
            <div class="card bg-light shadow-lg mb-4 ">
                <div class="card-header text-center fw-bold d-flex justify-content-between p-3" style="background-color: #FFAF1A; color: #91452c">
                    <div>USER DETAILS</div>
                    <div>
                        <a class="small text-white" href="./users.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z"/>
                                <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                            </svg>
                        </a> 
                    </div>
                </div>
                <div class="card-body p-4">
                    <!-- USER ID -->
                    <div class="mb-3">
                        <p class="fw-bold">User ID: <span class="fw-normal ps-2"><?php echo $user_ID; ?></span></p>
                    </div>

                    <!-- FIRST NAME -->
                    <div class="mb-3">
                        <p class="fw-bold">First Name: <span class="fw-normal ps-2"><?php echo $fname; ?></span></p>
                    </div>

                    <!-- LAST NAME -->
                    <div class="mb-3">
                        <p class="fw-bold">Last Name: <span class="fw-normal ps-2"><?php echo $lname; ?></span></p>
                    </div>

                    <!-- CONTACT NUMEBER -->
                    <div class="mb-3">
                        <p class="fw-bold">Contact Number: <span class="fw-normal ps-2"><?php echo $contact_num; ?></span></p>
                    </div>

                    <!-- ROLE -->
                    <div class="mb-3">
                        <p class="fw-bold">Role: <span class="fw-normal ps-2"><?php echo $role; ?></span></p>
                    </div>

                    <!-- USERNAME -->
                    <div class="mb-3">
                        <p class="fw-bold">Username: <span class="fw-normal ps-2"><?php echo $username; ?></span></p>
                    </div>

                    <!-- STATUS -->
                    <div class="mb-3">
                        <p class="fw-bold">Status: <span class="fw-normal ps-2"><?php echo $status; ?></span></p>
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
