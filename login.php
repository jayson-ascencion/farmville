<?php
    //title of the page
    $title = "Farmville Login";

    //include the header file located in the includes directory
    include('includes/header.php');

    //if the user is already loggedin and try to access the login page, he will be redirected to his dashboard/index
    if(isset($_SESSION['role'])){
        if($_SESSION['role']===1){
            header("Location: users/manager/views/index.php");
        }else if($_SESSION['role']===2){
            header("Location: users/admin/views/index.php");
        }else if($_SESSION['role']===3){
            header("Location: users/employee/views/index.php");
        }

    }

    //include authentication file to validate login details
    include('action/login_action.php');
?>

    <div class="container">
        <div class="row vh-100 justify-content-center">
            <div class="position-relative">
                <div class="position-absolute top-50 start-50 translate-middle col-sm-4">
                    
                    <img src="assets/images/favicon.png" alt="" class="rounded mx-auto d-block">
                        
                    <div class="card shadow col mt-2" style="border-color: rgb(239, 81, 46)">
                        <div class="card-header shadow-sm" style="border-color: rgb(239, 81, 46)">
                            <h4 class="text-center p-2 pb-0 fw-bold">Farmville Login</h4>
                        </div>
                        <div class="card-body mx-2">
                            <!-- LOGIN FORM -->
                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                                <!-- Username -->
                                <div class="form-group mb-3">
                                    <label for="username" class="mb-2">Username</label>
                                    <input type="text" name="username" placeholder="Enter Username" class="form-control" style="border-color: rgb(239, 81, 46)">
                                    <span class="input-error-msg"> <?php echo $username_err;  echo $login_err; ?> </span> <!-- login_err will display error message when username and password does not match -->
                                </div>

                                <!-- Password -->
                                <div class="form-group mb-3">
                                    <label for="password" class="mb-2">Password</label>
                                    <input type="password" name="password" placeholder="Enter Password" class="form-control" style="border-color: rgb(239, 81, 46)"                                          >
                                    <span class="input-error-msg"> <?php echo $password_err; echo $login_err; ?> </span> <!-- login_err will display error message when username and password does not match -->
                                </div>

                                <div class="form-group mb-3">
                                    <button type="submit" name="submit" class="btn btn-outline-primary float-end px-4">Login</button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
//include footer located in the includes directory
include('includes/footer.php');
?>