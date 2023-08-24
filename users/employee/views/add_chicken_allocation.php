<?php
    //page title
    $title = "Add Chicken Batch";
    
    //header
    include('../../includes/header.php');

    //save chicken action
    include('../action/save_chicken_allocation.php'); 
    
 
?>

<!-- content --> 
<div class="container-fluid px-4">
    <h1 class="mt-4"> Employee Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./chicken_production.php" style="text-decoration: none">Chicken Production</a>
        </li>
        <li class="breadcrumb-item active">Add New Chicken Batch</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-xl-6 col-md-6">
            <div class="card bg-light shadow-lg mb-4 ">
                <div class="card-header text-center fw-bold p-3" style="background-color: #FFAF1A; color: #91452c">ADD CHICKEN BATCH</div>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" novalidate>
                        <div class="card-body p-4">
                             <!-- Age -->
                             <!-- <div class="form-group mb-3">
                                <label for="age" class="mb-2 text-dark">Age</label>
                                <input type="number" name="age" class="form-control" value="<?php echo $age; ?>">
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $age_err; ?> </span>
                            </div> -->

                            <!-- Coop Number -->
                            <!-- <div class="form-group mb-3">
                                <label for="coopNumber" class="mb-2 text-dark">Coop Number</label>
                                <input type="number" name="coopNumber" class="form-control" value="<?php echo $coopNumber; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $coopNumber_err; ?> </span>
                            </div> -->

                            <div class="form-group mb-3">
                                <label for="coopNumber" class="mb-2 text-dark">Coop Number</label>
                                <select class="form-select" name="coopNumber" required>
                                    <option value="<?php echo $coopNumber; ?>">
                                        <?php
                                        if(!empty($coopNumber)){
                                            echo $coopNumber;
                                        }else{
                                            echo "- select a coop number -";
                                        }
                                        ?>
                                    </option>
                                    <?php

                                        //connect to the database
                                        include('../../../config/database_connection.php');
                                        $selectedID = "";
                                        //statement to select the all the medicine names
                                        $sql = "SELECT batchName, coopNumber FROM chickenproduction";
                                        $stmt = $conn->query($sql);
                                        if($stmt){
                                            if($stmt->rowCount() > 0){
                                                while($row = $stmt->fetch()){?>
                                                <option value="<?php echo $row['coopNumber']; ?>"> <?php echo $row["coopNumber"];?> </option>
                                            <?php }
                                                // Free result set
                                                unset($result);
                                            } else{

                                                echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                                            }
                                        } else{
                                            echo "Oops! Something went wrong. Please try again later.";
                                        }
                                        unset($pdo);

                                    ?>
                                </select>
                                <span class="text-danger" style="font-size: small;"> <?php echo $coopNumber_err; ?> </span>
                            </div>

                            <!-- Batch Name -->
                            <!-- <div class="form-group mb-3">
                                <label for="batchName" class="mb-2 text-dark">Batch Name</label>
                                <input type="text" name="batchName" class="form-control"value="<?php echo $batchName; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $batchName_err; ?> </span>
                            </div>        -->
                            
                            <!-- <div class="form-group mb-3">
                                <label for="breedType" class="mb-2 text-dark">BREED PLEASE</label>
                                    
                                <input type="text" list="cars" name="breedType" class="form-control" />
                                <datalist id="cars">
                                <option>Volvo</option>
                                <option>Saab</option>
                                <option>Mercedes</option>
                                <option>Audi</option>
                                </datalist>
                            </div> -->

                            <!-- BREED TYPE -->
                            <!-- <div class="form-group mb-3">
                                <label for="batchName" class="mb-2 text-dark">Breed Type</label>
                                <select name="breedType" class="form-control"
                                    onchange="if(this.options[this.selectedIndex].value=='customOption'){
                                        toggleField(this,this.nextSibling);
                                        this.selectedIndex='0';
                                    }">
                                        <option value="">- select breed type -</option>
                                        <option>Sussex</option>
                                        <option>Rhode Island Reds</option>
                                        <option>Plymouth</option>
                                        <option>Leghorns</option>
                                        <option value="customOption">Other</option>
                                </select><input name="breedType" class="form-control" style="display:none;" disabled="disabled" 
                                    onblur="if(this.value==''){toggleField(this,this.previousSibling);}">
                            </div>   -->
                            <!-- <div id="billdesc" class="form-group mb-3">
                                <select id="test" class="form-select">
                                <option class="non" value="option1">Option1</option>
                                <option class="non" value="option2">Option2</option>
                                <option class="editable" value="other">Other</option>
                                </select>
                                <input class="editOption" style="display:none;" placeholder="Text juaj"></input>
                            </div> -->

                            <!-- Breed Type
                            <div class="form-group mb-3">
                                <label for="breedType" class="mb-2 text-dark">Breed Type</label>
                                <select class="form-select" name="breedType">
                                    <?php
                                        if(empty($breedType)){
                                            echo '<option value="" selected>- select a breed type -</option>';
                                        }else{
                                            ?>
                                                <option value="<?php echo $breedType; ?>"selected><?php echo $breedType; ?></option>';
                                            <?php
                                        }
                                    ?>
                                    <option value="Leghorns">Leghorns</option>
                                    <option value="Rhode Island Reds">Rhode Island Reds</option>
                                    <option value="Sussex">Sussex</option>
                                    <option value="Plymouth">Plymouth</option>
                                <option value="Other">Other</option>
                                                        </select>
                                                        <span class="text-danger" style="font-size: 13px;"> <?php echo $breedType_err; ?> </span>
                                                    </div> -->
                                            <!-- Other Breed Type -->
                            <!-- <div class="form-group mb-3" id="otherBreedType" style="display: none;">
                                <label for="otherBreedType" class="mb-2 text-dark">Other Breed Type</label>
                                <input type="text" class="form-control" name="otherBreedType">
                            </div> -->
                            <!-- Batch Purpose -->
                            <!-- <div class="form-group mb-3">
                                <label for="batchPurpose" class="mb-2 text-dark">Reduction Type</label>
                                <select class="form-select" name="batchPurpose">
                                    <?php
                                        if(empty($batchPurpose)){
                                            echo '<option value="" selected>- select a batch purpose -</option>';
                                        }else{
                                            ?>
                                                <option value="<?php echo $batchPurpose; ?>"selected><?php echo $batchPurpose; ?></option>';
                                            <?php
                                        }
                                    ?>
                                    <option value="Culled">Culled</option>
                                    <option value="Layers">Layers</option>
                                    <option value="Breeding">Breeding</option>
                                </select>
                                <span class="text-danger" style="font-size: 13px;"> <?php echo $batchPurpose_err; ?> </span>
                            </div> -->
 
                            <!-- quantity -->

                            <div class="d-flex flex-column flex-sm-column flex-lg-row gap-2">
                                <!-- Available Quantity -->
                                <div class="form-group w-100 mb-3">
                                    <label for="sex" class="mb-2 text-dark">Sex</label>
                                    <!-- <input type="number" name="sex" class="form-control" value="<?php echo $sex; ?>" required> -->
                                    <!-- <select name="sex" class="form-select">
                                        
                                    </select> -->
                                    <!-- <div class="form-group mb-3"> -->
                                        <!-- <label for="sex" class="mb-2 text-dark">Reduction Type</label> -->
                                        <select class="form-select" name="sex">
                                            
                                                <?php
                                                    if(empty($sex)){
                                                        echo '<option value="">- select a sex -</option>';
                                                        echo '<option value="Male">Male</option>';
                                                        echo '<option value="Female">Female</option>';
                                                    }else{
                                                        echo '"<option value="'. $sex .'">" ' . $sex .' "</option>"';
                                                    }
                                                ?>
                                            
                                            
                                            <!-- <option value="Distributed to Customer">Distributed to Customer</option>
                                            <option value="Consumed">Personal Consumption</option>
                                            <option value="Spoiled">Spoiled</option> -->
                                        </select>
                                        <!-- <span class="text-danger" style="font-size: 13px;"> <?php echo $reductionType_err; ?> </span>
                                    </div> -->

                                    <span class="text-danger" style="font-size: 13px;"> <?php echo $sex_err; ?> </span>
                                </div>
                                
                                <!-- Reduction Quantity -->
                                <div class="form-group w-100 mb-3">
                                    <label for="quantity" class="mb-2 text-dark">Quantity </label>
                                    <!-- <input type="date" min="2022-01-01" name="expirationDate" class="form-control" value=" echo $expirationDate; ?>" required> -->
                                    <input type="number" name="quantity" class="form-control" value="<?php echo $quantity; ?>" required>
                                    <span class="text-danger" style="font-size: 13px;"> <?php echo $quantity_err; ?> </span>
                                </div>
                            </div>
                            
                            <!-- Date Acquired -->
                            <div class="form-group mb-3">
                                <label for="dateAcquired" class="mb-2 text-dark">Allocation Date</label>
                                <input type="date" min="2022-01-01" max="<?php echo date('Y-m-d'); ?>" name="dateAcquired" class="form-control" value="<?php echo $dateAcquired; ?>" required>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $dateAcquired_err; ?> </span>
                            </div>

                            <!-- Acquisition Type-->
                            <!-- <div class="form-group mb-3">
                                <label for="acquisitionType" class="mb-2 text-dark">Acquisition Type</label>
                                <select class="form-select" name="acquisitionType">
                                    <?php
                                        if(empty($acquisitionType)){
                                            echo '<option value="" selected>- select an acquisition type -</option>';
                                        }else{
                                            ?>
                                                <option value="<?php echo $acquisitionType; ?>"selected><?php echo $acquisitionType; ?></option>';
                                            <?php
                                        }
                                    ?>
                                    <option value="Hatched on Farm">Hatched on Farm</option>
                                    <option value="Purchased">Purchased</option>
                                </select>
                                <span class="text-danger" style="font-size: 13px;"> <?php echo $acquisitionType_err; ?> </span>
                            </div> -->
                               
                            <!-- Note -->
                            <div class="form-group mb-3">
                                <label for="note" class="mb-2 text-dark">Note <span style="font-size: 13px">(optional)</span></label>
                                <textarea class="form-control" name="note" rows="3"><?php echo $note; ?></textarea>
                                <span class="text-danger" style="font-size: 13px;">  <?php echo $note_err; ?> </span>
                            </div>

                        </div>
                        <div class="card-footer w-100 border d-flex justify-content-between">
                            <div class="w-100 m-1">
                                <a class="btn  btn-outline-secondary fw-bold w-100" href="./chicken_production.php">
                                    Cancel
                                </a> 
                            </div>
                            <div class="w-100 m-1">
                                <button type="submit" name="submit" class="btn  btn-outline-success fw-bold w-100">
                                    Save
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

<script>
    // Show/hide the Other Breed Type field based on the selected value
    var breedTypeSelect = document.getElementById("breedType");
    var otherBreedTypeDiv = document.getElementById("otherBreedType");
    breedTypeSelect.addEventListener("change", function() {
        if (breedTypeSelect.value == "Other") {
            otherBreedTypeDiv.style.display = "block";
        } else {
            otherBreedTypeDiv.style.display = "none";
        }
    });

    var initialText = $('.editable').val();
$('.editOption').val(initialText);

$('#test').change(function(){
var selected = $('option:selected', this).attr('class');
var optionText = $('.editable').text();

if(selected == "editable"){
  $('.editOption').show();

  
  $('.editOption').keyup(function(){
      var editText = $('.editOption').val();
      $('.editable').val(editText);
      $('.editable').html(editText);
  });

}else{
  $('.editOption').hide();
}
});

function toggleField(hideObj,showObj){
 hideObj.disabled=true;		
 hideObj.style.display='none';
 showObj.disabled=false;	
 showObj.style.display='inline';
 showObj.focus();
}
</script>
