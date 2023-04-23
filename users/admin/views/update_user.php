<?php
    //page title
    $title = "Update Schedule";
    
    //header
    include('../../includes/header.php');

    //include the update script
    include('../action/update_user.php'); 
    
?>

<!-- content --> 
<div class="container-fluid px-4">
    <h1 class="mt-4"> Admin Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a class="text-decoration-none" href="./vaccination_pending.php">Users</a>
        </li>
        <li class="breadcrumb-item active">Update User</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-md-4">
            <div class="card bg-light shadow-lg mb-4">
                <div class="card-header text-center fw-bold p-3"  style="background-color: #FFAF1A; color: #91452c">UPDATE USER DETAILS</div>
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">

                        <?php
                            //connect to the database
                            include('../../../config/database_connection.php');

                            //store the id being pass from the prev page to the id var
                            $id = $_REQUEST['id'];
                            
                            //statement to select the specific schedule to update
                            $sql = "SELECT * FROM users WHERE user_ID = '$id'";
                            $stmt = $conn->query($sql);
                            if($stmt){
                                if($stmt->rowCount() > 0){
                                    while($row = $stmt->fetch()){
                                    $user_ID = $row['user_ID'];
                                    // $coopNumber = $row['coopNumber'];
                                    $fname = $row['fname'];
                                    $lname = $row['lname'];
                                    $contact_num = $row['contact_num'];
                                    $role = $row['role'];
                                    $username = $row['username'];
                                    $status = $row['status'];
                                    // $administeredBy = $row['administeredBy'];
                                    // $status = $row['status'];
                                    // $notes = $row['notes'];
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

                        <!-- USER ID -->
                        <div class="form-group w-100 mb-3">
                            <label for="user_ID" class="mb-2 text-dark">User ID</label>
                            <input type="number" name="user_ID" class="form-control" value="<?php echo $user_ID ?>" disabled>
                            <!-- <span class="text-danger" style="font-size: small;"> echo $dosage_err; ?> </span> -->
                        </div>

                        <!-- FNAME -->
                        <div class="form-group w-100 mb-3">
                            <label for="fname" class="mb-2 text-dark">First Name</label>
                            <input type="text" name="fname" class="form-control" value="<?php echo $fname ?>">
                            <span class="text-danger" style="font-size: small;"> <?php echo $fname_err; ?> </span>
                        </div>

                        <!-- LNAME -->
                        <div class="form-group w-100 mb-3">
                            <label for="lname" class="mb-2 text-dark">Last Name</label>
                            <input type="text" name="lname" class="form-control" value="<?php echo $lname ?>">
                            <span class="text-danger" style="font-size: small;"> <?php echo $lname_err; ?> </span>
                        </div>

                        <!-- CONTACTNUMBER -->
                        <div class="form-group w-100 mb-3">
                            <label for="new_contact_num" class="mb-2 text-dark">Contact Number</label>
                            <input type="text" name="new_contact_num" class="form-control" value="<?php echo $contact_num ?>">
                            <span class="text-danger" style="font-size: small;"> <?php echo $new_contact_num_err; ?> </span>
                        </div>

                        <!-- Role -->
                        <div class="form-group mb-3">
    <label for="role" class="mb-2 text-dark">Role</label>
    <select class="form-select" name="role">
        <option value=""> - select role - </option>
        <option value="1" <?php if($role == 1) echo "selected"; ?>>Manager</option>
        <option value="2" <?php if($role == 2) echo "selected"; ?>>Administrator</option>
        <option value="3" <?php if($role == 3) echo "selected"; ?>>Employee</option>
    </select>
    <span class="text-danger" style="font-size: small;"> <?php echo $role_err; ?> </span>
</div>


                        <!-- USERNAME -->
                        <div class="form-group w-100 mb-3">
                            <label for="new_username" class="mb-2 text-dark">Username</label>
                            <input type="text" name="new_username" class="form-control" value="<?php echo $username ?>">
                            <span class="text-danger" style="font-size: small;"> <?php echo $new_username_err; ?> </span>
                        </div>

                        <!-- STATUS -->
                        <div class="form-group mb-3">
                            <label for="status" class="mb-2 text-dark">Status</label>
                            <select name="status" class="form-control">
                                <option value="active" <?php if($status == 'active') {echo 'selected';} ?>>Activate</option>
                                <option value="disabled" <?php if($status == 'disabled') {echo 'selected';} ?>>Disable</option>
                            </select>
                            <span class="text-danger" style="font-size: small;"> <?php echo $status_err; ?> </span>
                        </div>

                        
                    </div>

                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>

                    <div class="card-footer w-100 border d-flex justify-content-end">
                        <div class="m-1 w-100">
                            <a class="btn btn-outline-secondary fw-bold w-100" href="./users.php"> Cancel </a> 
                        </div>
                        <div class="m-1 w-100">
                            <button type="submit" name="submit" class="btn btn-outline-success fw-bold w-100">
                                Update
                            </button>                             
                        </div>
                    </div>
                </form>
                
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
