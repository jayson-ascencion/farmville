<div id="layoutSidenav_nav">

    <!-- this will get the current page ex. example.php -->
    <?php $page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'],"/")+1); ?>

    <nav class="sb-sidenav accordion sb-sidenav-dark shadow" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <!-- buttons for manager,  will not show when the role is not equals to 1 -->
                <?php
                    if($_SESSION['role']==1){
                ?>

                    <!-- Dashboard -->
                    <div class="sb-sidenav-menu-heading">Home</div>
                    <a class="nav-link <?= $page == 'index.php' ? 'active' : '' ?>" href="index.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>

                    <!-- Chicken Production -->
                    <div class="sb-sidenav-menu-heading">Chicken</div>
                    <a class="nav-link collapsed <?= $page == 'chicken_production.php' || $page == 'chicken_reduction.php' || $page == 'add_chicken_form.php' || $page == 'update_chick_form.php' ? 'tc' : '' ?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapseChicken" aria-expanded="false" aria-controls="collapseChicken">
                        <div class="sb-nav-link-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="24" height="24" fill="currentColor"><path d="M20.46,45.67c.51.36,1,.69,1.55,1,.26.16.51.3.77.44s.52.29.77.41l.78.38c.51.23,1,.45,1.54.64l.28.1c.07.13.12.24.18.36s.18.37.28.53c.21.37.41.72.62,1s.36.54.54.79l.15.19c.09.11.17.22.26.32a5.07,5.07,0,0,0,2,1.47h0V56h-1a1,1,0,0,0,0,2h10a1,1,0,0,0,0-2h-3V52.79a5.61,5.61,0,0,0,2.45-3,18.49,18.49,0,0,1-1.81.71,13.63,13.63,0,0,1-.68,1.26,9.07,9.07,0,0,1-.9,1.23h0a6,6,0,0,1-1,1v2h-2V52.82a2.11,2.11,0,0,0,.34-.16,1,1,0,0,0,.26-.16h0l0,0,.08,0a2.23,2.23,0,0,0,.24-.19h0a.05.05,0,0,0,0,0l.08-.08a2.23,2.23,0,0,0,.27-.26,6.28,6.28,0,0,0,.87-1.16l0,0h0l.06-.09.1-.17a7.39,7.39,0,0,0,.47-.93l.06-.13,0-.07a.83.83,0,0,1,.07-.13s0,0,0,0,.1-.25.13-.36l.43-.11.12,0,.38-.12.44-.16.34-.13c.31-.11.59-.24.86-.36l.68-.35c.22-.11.42-.23.61-.34l.27-.17,0,0h0c.35-.22.64-.43.86-.58l.23-.17.09-.08a11.17,11.17,0,0,0,1.14-1l.49-.51c.18-.19.37-.4.55-.63l.22-.27a18.68,18.68,0,0,0,1.36-1.88,20.25,20.25,0,0,0,1.34-2.46c.13-.3.25-.61.37-.92s.23-.63.34-1a17.89,17.89,0,0,0,.5-2c0-.23.07-.47.1-.71.07-.47.13-1,.17-1.45s.07-.79.09-1.19a.34.34,0,0,0,0-.1c0-.33,0-.65,0-1s0-.92,0-1.37c0-.23,0-.46,0-.69s0-.45,0-.67c0-.88-.06-1.71-.11-2.45,0-.28,0-.54-.05-.79,0-.59-.1-1.1-.14-1.5,0-.09,0-.17,0-.25a.09.09,0,0,1,0-.05A3.19,3.19,0,0,0,49,22.75a2.22,2.22,0,0,0,.54-.56,3.27,3.27,0,0,0,.34-2.5,8.13,8.13,0,0,0-.7-2v0l.11-.05.2-.12.34-.14a2.71,2.71,0,0,0,.45-.23,2.19,2.19,0,0,0,.33-.25l.11-.11a1,1,0,0,0,.21-.24l0-.06a2.15,2.15,0,0,0,.19-.37c.05-.13.08-.26.12-.39a1.75,1.75,0,0,0,0-.64,1,1,0,0,0,0-.25,1.46,1.46,0,0,0-.12-.41s0-.1-.06-.16L51,14.13a1.86,1.86,0,0,0-.19-.37c0-.07-.08-.14-.12-.22l-.12-.19L50.33,13c-.06-.08-.12-.17-.2-.26a2.3,2.3,0,0,0-.17-.2l-.27-.29A7.33,7.33,0,0,0,48.13,11a3.18,3.18,0,0,0,.17-2.19,1.49,1.49,0,0,0-.17-.44C47.61,7.47,46.52,7,44.91,7h0a10.15,10.15,0,0,0-6.78,2.29,2.78,2.78,0,0,0-.95,1.53h0a1.84,1.84,0,0,0-.05.25A3.83,3.83,0,0,0,38,13.82c-.05.12-.09.25-.13.38s-.15.5-.23.77c-.11.44-.17.86-.24,1.33-.05.32-.1.67-.19,1.09l-.11.48c0,.25-.12.52-.2.82s-.11.35-.17.53-.19.63-.32,1c-.06.18-.13.36-.2.56-.28.78-.64,1.67-1.09,2.73-.11.26-.22.5-.34.73s-.17.3-.26.44a4.58,4.58,0,0,1-.31.49l-.21.29a1.71,1.71,0,0,1-.22.25,1.13,1.13,0,0,1-.21.24,2.39,2.39,0,0,1-.22.23,5.47,5.47,0,0,1-.46.4,4.51,4.51,0,0,1-.72.48,4,4,0,0,1-.5.26l-.26.11a4.4,4.4,0,0,1-.51.18l-.22.07-.32.08a5.27,5.27,0,0,1-.52.1,2.87,2.87,0,0,1-.5.07L29,28l-.49,0h-.27c-.64,0-1.27,0-1.89,0-.32,0,0,0-.27,0a4.26,4.26,0,0,1-.63,0l-.53-.11a2.3,2.3,0,0,1-.34-.12,1.19,1.19,0,0,1-.26-.11A1.11,1.11,0,0,1,24,27.5a1.19,1.19,0,0,1-.25-.13,4.07,4.07,0,0,1-.49-.31,8.28,8.28,0,0,1-.89-.67L21.93,26h0l-.54-.46a7.11,7.11,0,0,0-1.8-1.14,3.77,3.77,0,0,0-3.47-.11l-.26.17a2.31,2.31,0,0,0-.24.2,2.2,2.2,0,0,0-.2.23,0,0,0,0,0,0,0l-.15.21s-.05,0-.05.07a3.15,3.15,0,0,0-.27.59,3.37,3.37,0,0,0-.1.34c0,.11-.05.23-.07.35a6.33,6.33,0,0,1-.15.64C12.62,35.4,14.59,41.64,20.46,45.67Zm1.16-6.84a1,1,0,1,1,1.1-1.66C27,40,30.45,40.82,33.08,39.61c4.24-2,5.09-8.66,5.1-8.73a1,1,0,1,1,2,.24c0,.32-1,7.88-6.24,10.3a7.93,7.93,0,0,1-3.4.73C27.91,42.15,24.93,41,21.62,38.83ZM44.67,15a.5.5,0,1,1,.5-.5A.5.5,0,0,1,44.67,15Z" data-name="Layer 4"/></svg></div>
                        Chicken Production
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse <?= $page == 'archive_chicken_reduction.php' || $page == 'archive_chicken.php' || $page == 'viewChickReduction.php' || $page == 'viewChick.php' || $page == 'update_chickreduction_form.php' || $page == 'chicken_production.php' || $page == 'chicken_reduction.php' || $page == 'add_chicken_form.php' || $page == 'update_chick_form.php' || $page == 'reduction_chicken_form.php' || $page == 'update_chick_form.php' ? 'show' : '' ?>" id="collapseChicken" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion"> 
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link <?= $page == 'archive_chicken.php' || $page == 'viewChick.php' || $page == 'chicken_production.php' || $page == 'update_chicken_form.php' || $page == 'add_chicken_form.php' || $page == 'update_chick_form.php' ? 'active' : '' ?>" href="chicken_production.php">Production</a>
                            <a class="nav-link <?= $page == 'archive_chicken_reduction.php' || $page == 'viewChickReduction.php' || $page == 'update_chickreduction_form.php' || $page == 'chicken_reduction.php' || $page == 'reduction_chicken_form.php' ? 'active' : '' ?>" href="chicken_reduction.php">Reduction</a>
                        </nav>
                    </div>

                    <!-- Egg Production -->
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseEgg" aria-expanded="false" aria-controls="collapseEgg">
                        <div class="sb-nav-link-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-egg-fill" viewBox="0 0 16 16">
                            <path d="M14 10a6 6 0 0 1-12 0C2 5.686 5 0 8 0s6 5.686 6 10z"/>
                            </svg></div>
                        Egg Production
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse <?= $page == 'archive_egg_reduction.php' || $page == 'archive_egg.php' || $page == 'viewEggReduction.php' || $page == 'viewEggProd.php' || $page == 'reduction_egg_form.php' || $page == 'update_eggreduction_form.php' || $page == 'egg_production.php' || $page == 'egg_reduction.php' || $page == 'add_egg_form.php' || $page == 'update_egg_form.php' ? 'show' : '' ?>" id="collapseEgg" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link <?= $page == 'archive_egg.php' || $page == 'viewEggProd.php' || $page == 'egg_production.php' || $page == 'add_egg_form.php' || $page == 'update_egg_form.php' ? 'active' : '' ?>" href="egg_production.php">Production</a>
                            <a class="nav-link <?= $page == 'archive_egg_reduction.php' || $page == 'viewEggReduction.php' || $page == 'reduction_egg_form.php' || $page == 'egg_reduction.php' || $page == 'update_eggreduction_form.php' ? 'active' : '' ?>" href="egg_reduction.php">Reduction</a>
                        </nav>
                    </div>

                    <!-- Inventory -->
                    <div class="sb-sidenav-menu-heading">Inventory</div>
                    <!-- Medicines -->
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseMedicine" aria-expanded="false" aria-controls="collapseChicken">
                        <div class="sb-nav-link-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-capsule-pill" viewBox="0 0 16 16">
                            <path d="M11.02 5.364a3 3 0 0 0-4.242-4.243L1.121 6.778a3 3 0 1 0 4.243 4.243l5.657-5.657Zm-6.413-.657 2.878-2.879a2 2 0 1 1 2.829 2.829L7.435 7.536 4.607 4.707ZM12 8a4 4 0 1 1 0 8 4 4 0 0 1 0-8Zm-.5 1.042a3 3 0 0 0 0 5.917V9.042Zm1 5.917a3 3 0 0 0 0-5.917v5.917Z"/>
                        </svg></div>
                        Medicines Inventory
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse <?= $page == 'archive_medicine_reduction.php' || $page == 'archive_medicine.php' || $page == 'viewMedReduction.php' || $page == 'viewMedicine.php' || $page == 'update_medreduction_form.php' || $page == 'reduction_medicine_form.php' || $page == 'medicines.php' || $page == 'medicine_reduction.php' || $page == 'update_med_form.php' || $page == 'add_medicine_form.php' ? 'show' : '' ?>" id="collapseMedicine" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link <?= $page == 'archive_medicine.php' ||  $page == 'viewMedicine.php' || $page == 'medicines.php' ||  $page == 'update_med_form.php' || $page == 'add_medicine_form.php' ? 'active' : '' ?>" href="medicines.php">Purchased</a>
                            <a class="nav-link <?=  $page == 'archive_medicine_reduction.php' || $page == 'viewMedReduction.php' || $page == 'update_medreduction_form.php' || $page == 'reduction_medicine_form.php' || $page == 'medicine_reduction.php' ? 'active' : '' ?>" href="medicine_reduction.php">Reduction</a>
                        </nav>
                    </div>
                    <!-- Feeds Inventory -->
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseFeeds" aria-expanded="false" aria-controls="collapseChicken">
                        <div class="sb-nav-link-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" width="16" height="16" ><path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 6 4 1 2-3 2.05 3L21 6l-3 5v1l4.75 3.18A4 4 0 0 1 24 17.23l2 7.53A1 1 0 0 1 25 26H5a1 1 0 0 1-1-1.24l2-7.53a4 4 0 0 1 1.29-2.05L12 12v-1ZM11 11h8"/></svg>
                        </div>
                        Feeds Inventory
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse <?= $page == 'archive_feeds_reduction.php' || $page == 'archive_feeds.php' || $page == 'update_feedreduction_form.php' || $page == 'reduction_feeds_form.php' || $page == 'add_feeds_form.php' || $page == 'update_feed_form.php' || $page == 'feed_reduction.php' || $page == 'viewFeedsReduction.php' || $page == 'viewFeeds.php' || $page == 'feeds.php' || $page == 'feeds_reduction.php' ? 'show' : '' ?>" id="collapseFeeds" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link <?= $page == 'archive_feeds.php' ||  $page == 'add_feeds_form.php' || $page == 'update_feed_form.php' || $page == 'viewFeeds.php' || $page == 'feeds.php' ? 'active' : '' ?>" href="feeds.php">Purchased</a>
                            <a class="nav-link <?= $page == 'archive_feeds_reduction.php' || $page == 'update_feedreduction_form.php' || $page == 'reduction_feeds_form.php' || $page == 'viewFeedsReduction.php' || $page == 'feed_reduction.php' ? 'active' : '' ?>" href="feed_reduction.php">Reduction</a>
                        </nav>
                    </div>

                    <!--Reports-->
                    <div class="sb-sidenav-menu-heading">Reports</div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseReports" aria-expanded="false" aria-controls="collapseReports">
                        <div class="sb-nav-link-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bar-chart-line-fill" viewBox="0 0 16 16">
  <path d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1V2z"/>
</svg></div>
                        Generate Reports
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse <?=  $page == 'reports_inventory.php' || $page == 'reports_chicken.php' || $page == 'reports_egg.php' ? 'show' : '' ?>" id="collapseReports" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link <?= $page == 'reports_chicken.php' ? 'active' : '' ?>" href="reports_chicken.php">Chicken Reports</a>
                            <a class="nav-link <?= $page == 'reports_egg.php' ? 'active' : '' ?>" href="reports_egg.php">Egg Reports</a>
                            <a class="nav-link <?= $page == 'reports_inventory.php' ? 'active' : '' ?>" href="reports_inventory.php">Inventory Reports</a>
                        </nav>
                    </div>

                <!-- buttons for admin, will not show when the role is not equals to 2 -->
                <?php
                    }else if($_SESSION['role']==2){
                ?>


                    <!-- Dashboard -->
                    <div class="sb-sidenav-menu-heading">Home</div>
                    <a class="nav-link <?= $page == 'index.php' ? 'active' : '' ?>" href="index.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>

                    <!-- Medicine Administration -->
                    <div class="sb-sidenav-menu-heading">Medicine Administration</div>
                    <!-- Medication -->
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#medication" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-pills"></i>
                        </div>
                        Medication
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse <?= $page == 'update_medication_completed.php' || $page == 'update_medication_pending.php' || $page == 'archive_medication_pending.php' || $page == 'archive_medication_completed.php' || $page == 'add_sched_medication.php' || $page == 'medication_pending.php' || $page == 'medication_pending_form.php' || $page == 'view_pending_med.php' || $page == 'medication_completed.php' || $page == 'medication_completed_form.php' || $page == 'view_completed_med.php'  ? 'show' : '' ?>" id="medication" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link <?= $page == 'update_medication_pending.php' || $page == 'archive_medication_pending.php' || $page == 'add_sched_medication.php' || $page == 'medication_pending.php' || $page == 'medication_pending_form.php' || $page == 'view_pending_med.php' ? 'active' : '' ?>" href="medication_pending.php">Pending Schedules</a>
                            <a class="nav-link <?= $page == 'update_medication_completed.php' ||  $page == 'archive_medication_completed.php' || $page == 'medication_completed.php' || $page == 'medication_completed_form.php' || $page == 'view_completed_med.php' ? 'active' : '' ?>" href="medication_completed.php">Completed Schedules</a>
                        </nav>
                    </div>

                    <!-- Vaccination -->
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#vaccination" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class='fas fa-syringe'></i>
                        </div>
                        Vaccination
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse <?= $page == 'archive_vaccination_completed.php' || $page == 'archive_vaccination_pending.php' || $page == 'add_sched_vaccination.php' || $page == 'vaccination_pending.php' || $page == 'update_vaccination_pending.php' || $page == 'view_pending_vac.php' || $page == 'view_completed_vac.php' || $page == 'vaccination_completed.php' || $page == 'update_vaccination_completed.php'  ? 'show' : '' ?>" id="vaccination" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link <?= $page == 'archive_vaccination_pending.php' || $page == 'add_sched_vaccination.php' || $page == 'vaccination_pending.php' || $page == 'update_vaccination_pending.php' || $page == 'view_pending_vac.php' ? 'active' : '' ?>" href="vaccination_pending.php">Pending Schedules</a>
                            <a class="nav-link <?= $page == 'archive_vaccination_completed.php' || $page == 'vaccination_completed.php' || $page == 'update_vaccination_completed.php' || $page == 'view_completed_vac.php' ? 'active' : '' ?>" href="vaccination_completed.php">Completed Schedules</a>
                        </nav>
                    </div>

                    <!-- Deleted Records -->
                    <div class="sb-sidenav-menu-heading"> Records</div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#deletedRecords" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-text-fill" viewBox="0 0 16 16">
  <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM5 4h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1zm0 2h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1z"/>
</svg>
                    </div>
                    Deleted Records
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse <?= $page == 'delete_schedules.php' || $page == 'delete_feeds.php' || $page == 'delete_medicine.php' || $page == 'delete_egg.php' || $page == 'delete_chicken.php' || $page == 'restore_schedules.php' || $page == 'schedules.php' || $page == 'restore_medicine.php' || $page == 'restore_feeds.php' || $page == 'restore_egg.php' || $page == 'restore_chicken.php' || $page == 'chicken_production.php' || $page == 'egg_production.php' || $page == 'medicines.php' || $page == 'feeds.php'  ? 'show' : '' ?>" id="deletedRecords" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link <?= $page == 'delete_chicken.php' || $page == 'restore_chicken.php' || $page == 'chicken_production.php' ? 'active' : '' ?>" href="./chicken_production.php">Chicken Production</a>
                            <a class="nav-link <?= $page == 'delete_egg.php' || $page == 'restore_egg.php' || $page == 'egg_production.php' ? 'active' : '' ?>" href="./egg_production.php">Egg Production</a>
                            <a class="nav-link <?= $page == 'delete_medicine.php' || $page == 'restore_medicine.php' || $page == 'medicines.php' ? 'active' : '' ?>" href="./medicines.php">Medicine Inventory</a>
                            <a class="nav-link <?= $page == 'delete_feeds.php' || $page == 'restore_feeds.php' || $page == 'feeds.php' ? 'active' : '' ?>" href="./feeds.php">Feeds Inventory</a>
                            <a class="nav-link <?= $page == 'delete_schedules.php' || $page == 'schedules.php' || $page == 'restore_schedules.php' ? 'active' : '' ?>" href="./schedules.php">Schedules</a>
                        </nav>
                    </div>

                <!-- buttons for employee, will not show when the role is not equals to 3-->
                <?php
                    }else if($_SESSION['role']==3){
                ?>
                    <!-- Dashboard -->                
                    <div class="sb-sidenav-menu-heading">Home</div>
                    <a class="nav-link" href="index.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>

                    <!-- Medicine Administration -->
                    <div class="sb-sidenav-menu-heading">Medicine Administration</div>
                    <!-- Medication -->
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#medication" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-pills"></i>
                        </div>
                        Medication
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse <?= $page == 'update_medication_completed.php' || $page == 'update_medication_pending.php' || $page == 'add_sched_medication.php' || $page == 'medication_pending.php' || $page == 'medication_pending_form.php' || $page == 'view_pending_med.php' || $page == 'medication_completed.php' || $page == 'medication_completed_form.php' || $page == 'view_completed_med.php'  ? 'show' : '' ?>" id="medication" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link <?= $page == 'update_medication_pending.php' || $page == 'add_sched_medication.php' || $page == 'medication_pending.php' || $page == 'medication_pending_form.php' || $page == 'view_pending_med.php' ? 'active' : '' ?>" href="medication_pending.php">Pending Schedules</a>
                            <a class="nav-link <?= $page == 'update_medication_completed.php' || $page == 'medication_completed.php' || $page == 'medication_completed_form.php' || $page == 'view_completed_med.php' ? 'active' : '' ?>" href="medication_completed.php">Completed Schedules</a>
                        </nav>
                    </div>

                    <!-- Vaccination -->
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#vaccination" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class='fas fa-syringe'></i>
                        </div>
                        Vaccination
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse <?= $page == 'add_sched_vaccination.php' || $page == 'vaccination_pending.php' || $page == 'update_vaccination_pending.php' || $page == 'view_pending_vac.php' || $page == 'view_completed_vac.php' || $page == 'vaccination_completed.php' || $page == 'update_vaccination_completed.php' ? 'show' : '' ?>" id="vaccination" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link <?= $page == 'add_sched_vaccination.php' || $page == 'vaccination_pending.php' || $page == 'update_vaccination_pending.php' || $page == 'view_pending_vac.php' ? 'active' : '' ?>" href="vaccination_pending.php">Pending Schedules</a>
                            <a class="nav-link <?= $page == 'vaccination_completed.php' || $page == 'update_vaccination_completed.php' || $page == 'view_completed_vac.php' ? 'active' : '' ?>" href="vaccination_completed.php">Completed Schedules</a>
                        </nav>
                    </div>

                <?php
                    }

                ?>

            </div>
        </div>
<!--         
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            Start Bootstrap
        </div> -->
    </nav>
</div>