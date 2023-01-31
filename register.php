<?php
    //include header located in the includes directory //session is already started in the header section
    include('includes/header.php');

    //include database connection configuration located in the config directory
    include('config/database_connection.php');

    //include registration action to process data 
    include('action/register_action.php');
?>

    <div class="container">
        <div class="row vh-100 justify-content-center">
            <div class="position-relative">
                <div class="card border border-light custom-margin custom-width col-md-4 shadow-lg position-absolute top-50 start-50 translate-middle">
                    <!-- card title - Register a user -->
                    <div class="card-header shadow-sm border-dark">
                        <h4 class="text-center p-2">Farmville | Register User</h4>
                    </div>

                    <!-- card body - it contains the form -->
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
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                            <div class="d-flex flex-column flex-sm-column flex-lg-row gap-2">
                                <div>
                                <!-- First Name -->
                                    <div class="form-group mb-3">
                                        <label for="fname" class="mb-2 text-dark">First Name</label>
                                        <input type="text" name="fname" class="form-control" placeholder="Juan" value="<?php echo $fname; ?>" required>
                                        <span class="input-error-msg"> <?php echo $fname_err; ?> </span>
                                    </div>
                                </div>
                                <div>
                                    <!-- Last Name -->
                                    <div class="form-group mb-3">
                                        <label for="lname" class="mb-2 text-dark">Last Name</label>
                                        <input type="text" name="lname" class="form-control" placeholder="Dela Cruz" value="<?php echo $lname; ?>" required>
                                        <span class="input-error-msg"> <?php echo $lname_err; ?> </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Contact Number -->
                            <div class="form-group mb-3">
                                <label for="contact_num" class="mb-2 text-dark">Contact Number</label>
                                <input type="text" name="contact_num" class="form-control" placeholder="09123456789" value="<?php echo $contact_num; ?>" required>
                                <span class="input-error-msg">  <?php echo $contact_num_err; ?> </span>
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
                                <span class="input-error-msg"> <?php echo $role_err; ?> </span>
                            </div>

                            <!-- Username -->
                            <div class="form-group mb-3">
                                <label for="username" class="mb-2 text-dark">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="username" value="<?php echo $username; ?>" required>
                                <span class="input-error-msg"> <?php echo $username_err; ?> </span>
                            </div>

                            <div class="d-flex flex-column flex-sm-column flex-lg-row gap-2">
                                <div>
                                    <!-- Password -->
                                    <div class="form-group mb-3">
                                        <label for="password" class="mb-2 text-dark">Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="******" required>
                                        <span class="input-error-msg"> <?php echo $password_err; ?> </span>
                                    </div>
                                </div>
                                <div>
                                    <!-- Confirm Password -->
                                    <div class="form-group mb-3">
                                        <label for="confirm_password" class="mb-2 text-dark">Confirm Password</label>
                                        <input type="password" name="confirm_password" class="form-control" placeholder="******" required>
                                        <span class="input-error-msg"> <?php echo $confirm_password_err; ?> </span>
                                    </div>
                                    
                                </div>
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="form-group mb-3">
                                <button type="submit" name="submit" class="btn btn-primary float-end px-4">Register</button>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
//include footer file located in the includes directory
include('includes/footer.php');
?>