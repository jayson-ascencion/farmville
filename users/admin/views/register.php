<?php
    $title = "Add User";
    //header
    include('../../includes/header.php');

    //include save script
    include('../action/register_action.php');
?>

    <div class="container">
        <h1 class="mt-4"> Admin Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="medication_pending.php">Add User</a>
            </li>
            <li class="breadcrumb-item active">Add New User</li>
        </ol>

        <div class="row justify-content-center mt-2">
            <div class="col-md-4">
                <div class="card bg-light shadow-lg mb-4">
                    
                        <div class="card-header text-center fw-bold p-3"  style="background-color: #FFAF1A; color: #91452c"> ADD USER </div>
                        <div class="card-body">
                            <!-- card to display success message after creating a user -->
                        <?php
                        if(!empty($success)){?>
                            <div>
                                <span class="alert alert-success d-flex align-items-center justify-content-center" role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                    </svg>                                            
                                    <div class="text-center ml-5">
                                        <?php echo $success ?>
                                    </div>
                                </span>
                            </div>
                        <?php
                        }
                        ?>

                        <!-- form to register a user -->
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" novalidate>
                            <div class="d-flex flex-column flex-sm-column flex-lg-row gap-2">
                                <div>
                                <!-- First Name -->
                                    <div class="form-group mb-3">
                                        <label for="fname" class="mb-2 text-dark">First Name</label>
                                        <input type="text" name="fname" class="form-control" placeholder="Juan" value="<?php echo $fname; ?>" required>
                                        <span class="text-danger" style="font-size: small;"> <?php echo $fname_err; ?> </span>
                                    </div>
                                </div>
                                <div>
                                    <!-- Last Name -->
                                    <div class="form-group mb-3">
                                        <label for="lname" class="mb-2 text-dark">Last Name</label>
                                        <input type="text" name="lname" class="form-control" placeholder="Dela Cruz" value="<?php echo $lname; ?>" required>
                                        <span class="text-danger" style="font-size: small;"> <?php echo $lname_err; ?> </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Contact Number -->
                            <div class="form-group mb-3">
                                <label for="contact_num" class="mb-2 text-dark">Contact Number</label>
                                <input type="number" name="contact_num" class="form-control" placeholder="09123456789" value="<?php echo $contact_num; ?>" required>
                                <span class="text-danger" style="font-size: small;">  <?php echo $contact_num_err; ?> </span>
                            </div>

                            <!-- Role -->
                            <div class="form-group mb-3">
                                <label for="role" class="mb-2 text-dark">Role</label>
                                <select class="form-select" name="role">
                                    <option value=""> - select role - </option>
                                    <option value="1">Manager</option>
                                    <option value="2">Administrator</option>
                                    <option value="3">Employee</option>
                                </select>
                                <span class="text-danger" style="font-size: small;"> <?php echo $role_err; ?> </span>
                            </div>

                            <!-- Username -->
                            <div class="form-group mb-3">
                                <label for="username" class="mb-2 text-dark">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="username" value="<?php echo $username; ?>" required>
                                <span class="text-danger" style="font-size: small;"> <?php echo $username_err; ?> </span>
                            </div>

                            <div class="d-flex flex-column flex-sm-column flex-lg-row gap-2">
                                <div>
                                    <!-- Password -->
                                    <div class="form-group mb-3">
                                        <label for="password" class="mb-2 text-dark">Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="******" required>
                                        <span class="text-danger" style="font-size: small;"> <?php echo $password_err; ?> </span>
                                    </div>
                                </div>
                                <div>
                                    <!-- Confirm Password -->
                                    <div class="form-group mb-3">
                                        <label for="confirm_password" class="mb-2 text-dark">Confirm Password</label>
                                        <input type="password" name="confirm_password" class="form-control" placeholder="******" required>
                                        <span class="text-danger" style="font-size: small;"> <?php echo $confirm_password_err; ?> </span>
                                    </div>
                                    
                                </div>
                            </div>
                            
                            <!-- Submit Button
                            <div class="form-group mb-3">
                                <button type="submit" name="submit" class="btn btn-primary float-end px-4">Add</button>
                            </div> -->
                            
                        </div>   
                        
                            <div class="card-footer w-100 d-flex justify-content-between">
                                <div class="m-1 w-100">
                                    <a href="users.php" class="btn fw-bold btn-outline-secondary w-100"> Cancel</a>
                                </div>
                                <div class="m-1 w-100">
                                    <button class="btn btn-outline-success fw-bold ml-1 w-100" type="submit" name="submit">Save</button>
                                </div>
                            </div>
                        </form>
                    
                </div>
            </div>
        </div>        
    </div>


    <?php
    //header
    include('../../includes/footer.php');

    //scripts
    include('../../includes/scripts.php');
?>