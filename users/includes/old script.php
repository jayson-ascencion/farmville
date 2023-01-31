        
        <script type="text/javascript" src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <script type="text/javascript" src="../../../assets/js/jquery-3.6.1.min.js"></script>
        <script type="text/javascript" src="../../../assets/js/bootstrap5.bundle.min.js" crossorigin="anonymous"></script>
        <script type="text/javascript" src="../../../assets/js/scripts.js"></script>
        <script type="text/javascript" src="../../../assets/js/popper.min.js"></script>
        <script type="text/javascript" src="../../../assets/js/datatables.min.js"></script>
        <script type="text/javascript" src="../../../assets/js/chart.js"></script>
        <script type="text/javascript" src="../../../assets/js/chartjs-adapter-date-fns.bundle.min.js"></script>
        <script>
            //default configuration for all the tables
            $.extend( $.fn.dataTable.defaults, {
                responsive: true,
                stateSave: true, //if the user is on the second page and opens the update form or any buttons on the action, this will allow the user to go back to previous page of the datatable 
                search: {
                    return: true, //if false, the search field will not wait for the user to hit the enter key.
                },
                columnDefs: [
                    {"className": "dt-center", "targets": "_all"} //center all text in the table
                ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            } );
          
            //configuration for the CHICKEN PRODUCTION table
            $(document).ready(function() {
                $('#chickenProduction').DataTable({
                    columns: [ //this will define what columns are orderable
                        { orderable: ['asc'] },
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        { orderable: false }, //notes is not orderable
                        { orderable: false, width: 100}, //action buttons are not orderable
                    ],
                });
            } );

            //configuration for the CHICKEN REDUCTION table
            $(document).ready(function() {
                $('#chickenReduction').DataTable({
                    columns: [ //this will define what columns are orderable
                        { orderable: ['asc'] },
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        { orderable: false }, //action buttons are not orderable
                    ],
                });
            } );

            //configuration for the EGG PRODUCTION table
            $(document).ready(function() {
                $('#eggProduction').DataTable({
                    columns: [ //this will define what columns are orderable
                        { orderable: ['asc'] },
                        null,
                        null,
                        null,
                        null,
                        //{ orderable: false, width: 200 }, //notes is not orderable
                        { orderable: false }, //action is not orderable
                    ],
                });
            } );

            //configuration for the EGG REDUCTION table
            $(document).ready(function() {
                $('#eggReduction').DataTable({
                    columns: [ //this will define what columns are orderable
                        { orderable: ['asc'] },
                        null,
                        null,
                        null,
                        null,
                        { orderable: false }, //notes is not orderable
                        { orderable: false }, //notes is not orderable
                    ],
                });
            } );

            //configuration for the MEDICINE TABLE
            $(document).ready(function() {
                $('#medicineRecords').DataTable({
                    columns: [ //this will define what columns are orderable
                        { orderable: ['asc'] },
                        null,
                        null,
                        null,
                        null,
                        { orderable: null, width: 100},
                        null,
                        null,
                        { orderable: ['asc','desc'] },
                        { orderable: false, width: 100}, //action buttons are not orderable
                    ],
                });
            } );

            //configuration for the MEDICINE TABLE
            $(document).ready(function() {
                $('#medicineReduction').DataTable({
                    columns: [ //this will define what columns are orderable
                        { orderable: ['asc'] },
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                    ],
                });
            } );

            //configuration for the FEED TABLE
            $(document).ready(function() {
            $('#feedRecords').DataTable({
                columns: [ //this will define what columns are orderable
                    { orderable: ['asc'] },
                    null,
                    null,
                    null,
                    null,
                    null,
                    { orderable: false },
                ],
                });
            } );

            //configuration for the FEED TABLE
            $(document).ready(function() {
            $('#feedReductions').DataTable({
                columns: [ //this will define what columns are orderable
                    { orderable: ['asc'] },
                    null,
                    null,
                    null,
                    null,
                    null,
                    { orderable: false },
                ],
                });
            } );

            //configuration for the SCHEDULES TABLE
            $(document).ready(function() {
            $('#medicationSchedules').DataTable({
                columns: [ //this will define what columns are orderable
                    { orderable: ['asc'] },
                    null,
                    null,
                    {orderable: null, width: 150},
                    null,
                    null,
                    null,
                    null,
                    { orderable: false },
                    { orderable: false, width: 100 },
                ],
                });
            } );

            //configuration for the SCHEDULES TABLE
            $(document).ready(function() {
            $('#vaccinationSchedules').DataTable({
                columns: [ //this will define what columns are orderable
                    { orderable: ['asc'] },
                    null,
                    null,
                    {orderable: null, width: 150},
                    null,
                    null,
                    null,
                    null,
                    { orderable: false },
                    { orderable: false, width: 100 },
                ],
                });
            } );

            //script for tooltip
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

            //script for getting the id and passing it to the modal
            // Get the button that opens the modal
            var btn = document.querySelector("button[data-bs-target='#archiveModal']");

            // Get the modal
            var modal = document.getElementById("archiveModal");

            // Get the span element that will display the ID
            var modalId = document.getElementById("modalId");

            // When the button is clicked, retrieve the ID from the data attribute and display it in the modal
            btn.addEventListener("click", function() {
                modalId.innerHTML = this.dataset.id;
            });
        </script>
    </body>
</html>