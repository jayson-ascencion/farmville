        
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"  ></script>
        <script src="../../../assets/js/jquery-3.6.1.min.js"></script>
        <script src="../../../assets/js/bootstrap5.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../../../assets/js/scripts.js"></script>
        <script src="../../../assets/js/popper.min.js"  ></script>
        <script src="../../../assets/js/datatables.min.js"></script>
        <script src="../../../assets/js/pdfmake.min.js"></script>
        <script src="../../../assets/js/vfs_fonts.js"  ></script>
        <script src="../../../assets/js/chart.js"></script>
        <script src="../../../assets/js/chartjs-adapter-date-fns.bundle.min.js" async defer></script>
        <!-- <script src="../../../assets/js/filterDropDown.min.js" async defer></script> -->
        <script>
            
            //this will be use to print the date in words when exporting the pdf
            const options = { month: 'long', day: 'numeric', year: 'numeric' };

            //default configuration for all the tables
            $.extend( $.fn.dataTable.defaults, {
                language: {
                    emptyTable: "No records found" //message to display if there is no data in the database
                },
                "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                responsive: true,
                pagingType: 'numbers',
                // caseInsensitive: false,
                stateSave: true, //if the user is on the second page and opens the update form or any buttons on the action, this will allow the user to go back to previous page of the datatable 
                search: {
                    return: false, //if false, the search field will not wait for the user to hit the enter key.
                    // "caseInsensitive": true,
                },
                columnDefs: [
                    {"className": "dt-center", "targets": "_all"} //center all text in the table
                ],
                // dom: "<'row mb-2'<'ps-0'B>>" +
                //     "<'row'<'col-sm-12 col-md-2 mb-1 mb-md-0'l><'col-sm-6 col-md-2 mb-1 mb-md-0'f><'col-md-12 col-md-4'<'#filterbuttons'>>>" +
                //     "<'row'<'col-sm-12'tr>>" +
                //     "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                //stabke originl dom"<'row mb-2'<'ps-0'B>>"+
                dom: "<'row align-items-center'<'col-sm-12 col-md-6 mt-1 mb-1 mb-md-0'l><'col-sm-12 col-md-4 mt-1 mb-1 mb-md-0 p-0'f><'col-sm-12 col-md-2 float-end mb-1 mb-md-0 me-0 d-flex justify-content-center'B>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>", //layout of the buttons, export buttons, length filter, search filter, table, info, pagination
                buttons: [
                    // {   //copy button
                    //     extend: 'copy',
                    //     //copy icon
                    //     text: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10 1.5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-1Zm-5 0A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5v1A1.5 1.5 0 0 1 9.5 4h-3A1.5 1.5 0 0 1 5 2.5v-1Zm-2 0h1v1A2.5 2.5 0 0 0 6.5 5h3A2.5 2.5 0 0 0 12 2.5v-1h1a2 2 0 0 1 2 2V14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V3.5a2 2 0 0 1 2-2Z"/></svg>',
                    //     //styling bootstrap class
                    //     className: 'btn btn-secondary rounded',
                    //     exportOptions: {
                    //         columns: ':not(:last-child)' //will not include the action column
                    //     }
                    // },
                    {   //excel button
                        extend: 'excel',
                        title: document.title,
                        //excel icon
                        text: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-spreadsheet-fill" viewBox="0 0 16 16"><path d="M12 0H4a2 2 0 0 0-2 2v4h12V2a2 2 0 0 0-2-2zm2 7h-4v2h4V7zm0 3h-4v2h4v-2zm0 3h-4v3h2a2 2 0 0 0 2-2v-1zm-5 3v-3H6v3h3zm-4 0v-3H2v1a2 2 0 0 0 2 2h1zm-3-4h3v-2H2v2zm0-3h3V7H2v2zm4 0V7h3v2H6zm0 1h3v2H6v-2z"/></svg>',
                        //styling bootstrap class
                        className: 'btn btn-success m-1 rounded',
                        exportOptions: {
                            columns: ':not(:last-child)' //will not include the action column
                        },
                        titleAttr: 'Download Excel',
                        
                    },
                    {   //pdf button
                        extend: 'pdf',
                        //header of the document
                        title: document.title, //title depends on the page title
                        //text genereated on under the header
                        message: 'Generated on ' + new Date().toLocaleDateString('en-US', options), 
                        //function to customize the document
                        customize: function(doc) {
                            // this var will hold the value if landscape or portrait
                            var orientation = '';
                            var count = 0; //this will hold the count value of the columns
                            //this will count the number of visible columns in the table
                            $("table.dataTable").find('thead tr:first-child th').each(function () {
                                count++;
                            });
                            if (count > 7) {
                                orientation = 'landscape'; //if column coount is greater tha 7 then the orientation will be set to landscape
                            } else {
                                orientation = 'portrait'; //if column coount is lesser than 7, orientation is portrait
                            }
                            doc.pageOrientation = orientation, //sets the page orientation

                            // Here's where you can control the cell padding
                             
                            doc.styles.tableBodyEven.margin = [5, 5, 5, 5];
                            
                            //this will set the table width to 100%
                            doc.content[2].table.widths =Array(doc.content[2].table.body[0].length + 1).join('*').split('');
                            doc.defaultStyle.alignment = 'center';
                            doc.styles.tableHeader.alignment = 'center';

                            //this will position the arlin logo, logo is in base64 converted online
                            doc.content.splice( 1, 0, {
                            margin: [ 0, 0, 200, 5 ], // , bottom, , 
                            absolutePosition: [100, 50],
                            width: 100,
                            height: 100,
                            image: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASMAAAEaCAYAAABaVTFIAAAACXBIWXMAAAsTAAALEwEAmpwYAAAFFmlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNi4wLWMwMDIgNzkuMTY0NDYwLCAyMDIwLzA1LzEyLTE2OjA0OjE3ICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgMjEuMiAoV2luZG93cykiIHhtcDpDcmVhdGVEYXRlPSIyMDIyLTEwLTA5VDIxOjI0OjAxKzA4OjAwIiB4bXA6TW9kaWZ5RGF0ZT0iMjAyMi0xMC0wOVQyMToyNTowNyswODowMCIgeG1wOk1ldGFkYXRhRGF0ZT0iMjAyMi0xMC0wOVQyMToyNTowNyswODowMCIgZGM6Zm9ybWF0PSJpbWFnZS9wbmciIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJzUkdCIElFQzYxOTY2LTIuMSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDozNzQxNjBlMC00NDMyLTE5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'
                            } );

                        },
                        //pdf icon
                        text: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM1.6 11.85H0v3.999h.791v-1.342h.803c.287 0 .531-.057.732-.173.203-.117.358-.275.463-.474a1.42 1.42 0 0 0 .161-.677c0-.25-.053-.476-.158-.677a1.176 1.176 0 0 0-.46-.477c-.2-.12-.443-.179-.732-.179Zm.545 1.333a.795.795 0 0 1-.085.38.574.574 0 0 1-.238.241.794.794 0 0 1-.375.082H.788V12.48h.66c.218 0 .389.06.512.181.123.122.185.296.185.522Zm1.217-1.333v3.999h1.46c.401 0 .734-.08.998-.237a1.45 1.45 0 0 0 .595-.689c.13-.3.196-.662.196-1.084 0-.42-.065-.778-.196-1.075a1.426 1.426 0 0 0-.589-.68c-.264-.156-.599-.234-1.005-.234H3.362Zm.791.645h.563c.248 0 .45.05.609.152a.89.89 0 0 1 .354.454c.079.201.118.452.118.753a2.3 2.3 0 0 1-.068.592 1.14 1.14 0 0 1-.196.422.8.8 0 0 1-.334.252 1.298 1.298 0 0 1-.483.082h-.563v-2.707Zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638H7.896Z"/></svg>',
                        //styling bootstrap class
                        className: 'btn btn-danger m-1 rounded',
                        exportOptions: {
                            columns: ':not(:last-child)',//exclude the action column
                        },
                        
                        // bondpaper size
                        pageSize: 'LEGAL',
                        titleAttr: 'Download PDF',
                        
                    },
                    {
                        //print button
                        extend: 'print',
                        //print icon
                        text: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16"><path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/><path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/></svg>',
                        //styling bootstrap class
                        className: 'btn btn-dark m-1 rounded',
                        exportOptions: {
                            columns: ':not(:last-child)' //excludes the action column
                        },
                        titleAttr: 'View Table',
                    },
                ],
                buttonStyling: true,

                //this will show the export buttons if role is manager and admin, hide if role is employee
                initComplete: function(settings, json) {
                    // Check the user's role and show or hide the export buttons
                    <?php
                    // Get the current user's role
                    $user_role = $_SESSION['role'];

                    // Set a variable based on the role
                    if ($user_role == '1' || $user_role == '2') {
                        ?>
                        this.api().buttons().container().show();
                        <?php
                    } else {
                        ?>
                        this.api().buttons().container().hide();
                        <?php
                    }
                    ?>
                }
        
            } );
            
            //configuration for the CHICKEN PRODUCTION table
            $(document).ready(function() {
                
                //this code will prevent the table from going back to page 1 when the user is in page 2 ang opens another function and then exits the page.
                var pageReloading = false;
                $(window).on('beforeunload', function(){
                pageReloading = true;
                });

                //this will reset the filter
                $('#reset-btn').click(function() {
                if (!pageReloading) {
                    $('#filtertable select').val('');
                    $('#chickenProduction').DataTable().columns().search('').draw();
                }
                });

                //this will reset the filter
                $('#reset-btn-allocation').click(function() {
                if (!pageReloading) {
                    $('#filterAllocation select').val('');
                    $('#chickenAllocation').DataTable().columns().search('').draw();
                }
                });

                //this will reset the filter
                $('#reset-btn').click(function() {
                if (!pageReloading) {
                    $('#filtertable select').val('');
                    $('#chickenProduction_Delete').DataTable().columns().search('').draw();
                }
                });

                //table initialization
                $('#chickenProduction').DataTable({
                    columns: [ //this will define what columns are orderable
                        { orderable: ['asc'] }, //1
                        null, //2
                        null,//3
                        null,//4
                        null,//5
                        null,//6
                        null,//7
                        null,//8
                        null,//9
                        { orderable: false, width: 100}, //action buttons are not orderable 10
                    ],
                    //this code if for the filter buttons
                    initComplete: function () {
                        this.api().columns([2,3,6]).every( function (d) {
                            var column = this;
                            var theadname = $('#chickenProduction th').eq([d]).text();
                            var select = $('<select class="mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1"><option value="">'+theadname+': All</option></select>')
                                .appendTo( '#filtertable' )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    if (val === '') {
                                        column.search('').draw();
                                    } else {
                                        column
                                            .search( '^'+val+'$', true, false )
                                            .draw();
                                    }
                                } );
                            select.find('option[value=""]').attr("selected", true);
                            column.data().unique().sort().each( function ( d, j ) {
                                var val = $('<div/>').html(d).text();
                                select.append( '<option value="'+val+'">'+val+'</option>' )
                            } );
                        } );
                    }
                });

                //table initialization
                $('#chickenAllocation').DataTable({
                    columns: [ //this will define what columns are orderable
                        { orderable: ['asc'] }, //1
                        null, //2
                        null,//3
                        null,//4
                        null,//5
                        null,//6
                        // null,//7
                        // null,//8
                        // null,//9
                        { orderable: false, width: 100}, //action buttons are not orderable 10
                    ],
                    //this code if for the filter buttons
                    initComplete: function () {
                        this.api().columns([1,3]).every( function (d) {
                            var column = this;
                            var theadname = $('#chickenAllocation th').eq([d]).text();
                            var select = $('<select class="mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1"><option value="">'+theadname+': All</option></select>')
                                .appendTo( '#filterAllocation' )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    if (val === '') {
                                        column.search('').draw();
                                    } else {
                                        column
                                            .search( '^'+val+'$', true, false )
                                            .draw();
                                    }
                                } );
                            select.find('option[value=""]').attr("selected", true);
                            column.data().unique().sort().each( function ( d, j ) {
                                var val = $('<div/>').html(d).text();
                                select.append( '<option value="'+val+'">'+val+'</option>' )
                            } );
                        } );
                    }
                });

                //table initialization for DELET TABLE
                $('#chickenProduction_Delete').DataTable({
                    columns: [ //this will define what columns are orderable
                        { orderable: ['asc'] }, //1
                        null, //2
                        null,//3
                        null,//4
                        null,//5
                        null,//6
                        null,//7
                        null,//8
                        null,//9
                        { orderable: false, width: 100}, //action buttons are not orderable 10
                    ],
                    dom: "<'row align-items-center'<'col-sm-12 col-md-6 mt-1 mb-1 mb-md-0'l><'col-sm-12 col-md-6 mt-1 mb-1 mb-md-0 p-0'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    //this code if for the filter buttons
                    initComplete: function () {
                        this.api().columns([3,4,8]).every( function (d) {
                            var column = this;
                            var theadname = $('#chickenProduction_Delete th').eq([d]).text();
                            var select = $('<select class="mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1"><option value="">'+theadname+': All</option></select>')
                                .appendTo( '#filtertable' )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    if (val === '') {
                                        column.search('').draw();
                                    } else {
                                        column
                                            .search( '^'+val+'$', true, false )
                                            .draw();
                                    }
                                } );
                            select.find('option[value=""]').attr("selected", true);
                            column.data().unique().sort().each( function ( d, j ) {
                                var val = $('<div/>').html(d).text();
                                select.append( '<option value="'+val+'">'+val+'</option>' )
                            } );
                        } );
                    }
                });
            } );


            //configuration for the CHICKEN REDUCTION table
            $(document).ready(function() {

                //this code will prevent the table from going back to page 1 when the user is in page 2 ang opens another function and then exits the page.
                var pageReloading = false;
                $(window).on('beforeunload', function(){
                pageReloading = true;
                });

                //this will reset the filter
                $('#reset-btn').click(function() {
                if (!pageReloading) {
                    $('#filtertable select').val('');
                    $('#chickenReduction').DataTable().columns().search('').draw();
                }
                });

                //table initialization
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
                    //this code is for the filter buttons
                    initComplete: function () {
                        this.api().columns([1,3,5]).every( function (d) {
                            var column = this;
                            var theadname = $('#chickenReduction th').eq([d]).text();
                            var select = $('<select class="mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1"><option value="">'+theadname+': All</option></select>')
                                .appendTo( '#filtertable' )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    if (val === '') {
                                        column.search('').draw();
                                    } else {
                                        column
                                            .search( '^'+val+'$', true, false )
                                            .draw();
                                    }
                                } );
                            select.find('option[value=""]').attr("selected", true);
                            column.data().unique().sort().each( function ( d, j ) {
                                var val = $('<div/>').html(d).text();
                                select.append( '<option value="'+val+'">'+val+'</option>' )
                            } );
                        } );
                    }
                });

                //table initialization for DELETE TABLE
                // $('#chickenReduction_DELETE').DataTable({
                //     columns: [ //this will define what columns are orderable
                //         { orderable: ['asc'] },
                //         null,
                //         null,
                //         null,
                //         null,
                //         null,
                //         null,
                //         { orderable: false }, //action buttons are not orderable
                //     ],
                //     //this code is for the filter buttons
                //     initComplete: function () {
                //         this.api().columns([5,6]).every( function (d) {
                //             var column = this;
                //             var theadname = $('#chickenReduction_DELETE th').eq([d]).text();
                //             var select = $('<select class="mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1"><option value="">'+theadname+': All</option></select>')
                //                 .appendTo( '#filtertable' )
                //                 .on( 'change', function () {
                //                     var val = $.fn.dataTable.util.escapeRegex(
                //                         $(this).val()
                //                     );

                //                     if (val === '') {
                //                         column.search('').draw();
                //                     } else {
                //                         column
                //                             .search( '^'+val+'$', true, false )
                //                             .draw();
                //                     }
                //                 } );
                //             select.find('option[value=""]').attr("selected", true);
                //             column.data().unique().sort().each( function ( d, j ) {
                //                 var val = $('<div/>').html(d).text();
                //                 select.append( '<option value="'+val+'">'+val+'</option>' )
                //             } );
                //         } );
                //     }
                // });
            } );

            //configuration for the EGG PRODUCTION table
            $(document).ready(function() {

                //this code will prevent the table from going back to page 1 when the user is in page 2 ang opens another function and then exits the page.
                var pageReloading = false;
                $(window).on('beforeunload', function(){
                pageReloading = true;
                });

                //this will reset the filter
                $('#reset-btn').click(function() {
                if (!pageReloading) {
                    $('#filtertable select').val('');
                    $('#eggProduction').DataTable().columns().search('').draw();
                }
                });

                //this will reset the filter
                $('#reset-btn').click(function() {
                if (!pageReloading) {
                    $('#filtertable select').val('');
                    $('#eggProduction_Delete').DataTable().columns().search('').draw();
                }
                });

                //table initialization
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
                    //for filter buttons
                    initComplete: function () {
                        this.api().columns([1,3]).every( function (d) {
                            var column = this;
                            var theadname = $('#eggProduction th').eq([d]).text();
                            var select = $('<select class="mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1"><option value="">'+theadname+': All</option></select>')
                                .appendTo( '#filtertable' )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    if (val === '') {
                                        column.search('').draw();
                                    } else {
                                        column
                                            .search( '^'+val+'$', true, false )
                                            .draw();
                                    }
                                } );
                            select.find('option[value=""]').attr("selected", true);
                            column.data().unique().sort().each( function ( d, j ) {
                                var val = $('<div/>').html(d).text();
                                select.append( '<option value="'+val+'">'+val+'</option>' )
                            } );
                        } );
                    }
                });

                //table initialization for DELETE TABLE
                $('#eggProduction_Delete').DataTable({
                    columns: [ //this will define what columns are orderable
                        { orderable: ['asc'] },
                        null,
                        null,
                        null,
                        null,
                        //{ orderable: false, width: 200 }, //notes is not orderable
                        { orderable: false }, //action is not orderable
                    ],
                    dom: "<'row align-items-center'<'col-sm-12 col-md-6 mt-1 mb-1 mb-md-0'l><'col-sm-12 col-md-6 mt-1 mb-1 mb-md-0 p-0'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    //for filter buttons
                    initComplete: function () {
                        this.api().columns([1,3]).every( function (d) {
                            var column = this;
                            var theadname = $('#eggProduction_Delete th').eq([d]).text();
                            var select = $('<select class="mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1"><option value="">'+theadname+': All</option></select>')
                                .appendTo( '#filtertable' )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    if (val === '') {
                                        column.search('').draw();
                                    } else {
                                        column
                                            .search( '^'+val+'$', true, false )
                                            .draw();
                                    }
                                } );
                            select.find('option[value=""]').attr("selected", true);
                            column.data().unique().sort().each( function ( d, j ) {
                                var val = $('<div/>').html(d).text();
                                select.append( '<option value="'+val+'">'+val+'</option>' )
                            } );
                        } );
                    }
                });
            } );

            //configuration for the EGG REDUCTION table
            $(document).ready(function() {

                //this code will prevent the table from going back to page 1 when the user is in page 2 ang opens another function and then exits the page.
                var pageReloading = false;
                $(window).on('beforeunload', function(){
                pageReloading = true;
                });

                //this will reset the filter
                $('#reset-btn').click(function() {
                if (!pageReloading) {
                    $('#filtertable select').val('');
                    $('#eggReduction').DataTable().columns().search('').draw();
                }
                });

                //table initialization
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
                    //for filter buttons
                    initComplete: function () {
                        this.api().columns([2,4]).every( function (d) {
                            var column = this;
                            var theadname = $('#eggReduction th').eq([d]).text();
                            var select = $('<select class="mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1"><option value="">'+theadname+': All</option></select>')
                                .appendTo( '#filtertable' )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    if (val === '') {
                                        column.search('').draw();
                                    } else {
                                        column
                                            .search( '^'+val+'$', true, false )
                                            .draw();
                                    }
                                } );
                            select.find('option[value=""]').attr("selected", true);
                            column.data().unique().sort().each( function ( d, j ) {
                                var val = $('<div/>').html(d).text();
                                select.append( '<option value="'+val+'">'+val+'</option>' )
                            } );
                        } );
                    }
                });
            } );

            //configuration for the MEDICINE TABLE
            $(document).ready(function() {
                //this code will prevent the table from going back to page 1 when the user is in page 2 ang opens another function and then exits the page.
                var pageReloading = false;
                $(window).on('beforeunload', function(){
                pageReloading = true;
                });

                //this will reset the filter
                $('#reset-btn').click(function() {
                if (!pageReloading) {
                    $('#filtertable select').val('');
                    $('#medicineRecords').DataTable().columns().search('').draw();
                }
                });

                //this will reset the filter
                $('#reset-btn-filter').click(function() {
                if (!pageReloading) {
                    $('#filterReplenishment select').val('');
                    $('#medicine_replenishment').DataTable().columns().search('').draw();
                }
                });

                //this will reset the filter
                $('#reset-btn').click(function() {
                if (!pageReloading) {
                    $('#filtertable select').val('');
                    $('#medicineRecords_Delete').DataTable().columns().search('').draw();
                }
                });

                //table initialization
                $('#medicineRecords').DataTable({
                    columns: [ //this will define what columns are orderable
                        { orderable: ['asc'] },
                        null,
                        null,
                        null,
                        null,
                        // { orderable: null, width: 100},
                        // null,
                        // null,
                        { orderable: ['asc','desc'] },
                        { orderable: false, width: 100}, //action buttons are not orderable
                    ],
                    //for filter buttons
                    initComplete: function () {
                        this.api().columns([1,3]).every( function (d) {
                            var column = this;
                            var theadname = $('#medicineRecords th').eq([d]).text();
                            var select = $('<select class="mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1"><option value="">'+theadname+': All</option></select>')
                                .appendTo( '#filtertable' )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    if (val === '') {
                                        column.search('').draw();
                                    } else {
                                        column
                                            .search( '^'+val+'$', true, false )
                                            .draw();
                                    }
                                } );
                            select.find('option[value=""]').attr("selected", true);
                            column.data().unique().sort().each( function ( d, j ) {
                                var val = $('<div/>').html(d).text();
                                select.append( '<option value="'+val+'">'+val+'</option>' )
                            } );
                        } );
                    }
                });

                //table initialization
                $('#medicine_replenishment').DataTable({
                    columns: [ //this will define what columns are orderable
                        { orderable: ['asc'] },
                        null,
                        // null,
                        // null,
                        null,
                        // { orderable: null, width: 100},
                        // null,
                        // null,
                        { orderable: ['asc','desc'] },
                        { orderable: ['asc','desc'] },
                        { orderable: false, width: 100}, //action buttons are not orderable
                    ],
                    //for filter buttons
                    initComplete: function () {
                        this.api().columns([1,3]).every( function (d) {
                            var column = this;
                            var theadname = $('#medicine_replenishment th').eq([d]).text();
                            var select = $('<select class="mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1"><option value="">'+theadname+': All</option></select>')
                                .appendTo( '#filterReplenishment' )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    if (val === '') {
                                        column.search('').draw();
                                    } else {
                                        column
                                            .search( '^'+val+'$', true, false )
                                            .draw();
                                    }
                                } );
                            select.find('option[value=""]').attr("selected", true);
                            column.data().unique().sort().each( function ( d, j ) {
                                var val = $('<div/>').html(d).text();
                                select.append( '<option value="'+val+'">'+val+'</option>' )
                            } );
                        } );
                    }
                });

                //table initialization for DELETE TABLE
                $('#medicineRecords_Delete').DataTable({
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
                    dom: "<'row align-items-center'<'col-sm-12 col-md-6 mt-1 mb-1 mb-md-0'l><'col-sm-12 col-md-6 mt-1 mb-1 mb-md-0 p-0'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    //for filter buttons
                    initComplete: function () {
                        this.api().columns([1,3,4]).every( function (d) {
                            var column = this;
                            var theadname = $('#medicineRecords_Delete th').eq([d]).text();
                            var select = $('<select class="mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1"><option value="">'+theadname+': All</option></select>')
                                .appendTo( '#filtertable' )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    if (val === '') {
                                        column.search('').draw();
                                    } else {
                                        column
                                            .search( '^'+val+'$', true, false )
                                            .draw();
                                    }
                                } );
                            select.find('option[value=""]').attr("selected", true);
                            column.data().unique().sort().each( function ( d, j ) {
                                var val = $('<div/>').html(d).text();
                                select.append( '<option value="'+val+'">'+val+'</option>' )
                            } );
                        } );
                    }
                });
            } );

            //configuration for the MEDICINE TABLE
            $(document).ready(function() {
                //this code will prevent the table from going back to page 1 when the user is in page 2 ang opens another function and then exits the page.
                var pageReloading = false;
                $(window).on('beforeunload', function(){
                pageReloading = true;
                });

                //this will reset the filter
                $('#reset-btn').click(function() {
                if (!pageReloading) {
                    $('#filtertable select').val('');
                    $('#medicineReduction').DataTable().columns().search('').draw();
                }
                });
                
                //table initialization
                $('#medicineReduction').DataTable({
                    columns: [ //this will define what columns are orderable
                        { orderable: ['asc'] },
                        null,
                        null,
                        null,
                        null,
                        null,
                        // null,
                    ],
                    //for filter buttons
                    initComplete: function () {
                        this.api().columns([1,3]).every( function (d) {
                            var column = this;
                            var theadname = $('#medicineReduction th').eq([d]).text();
                            var select = $('<select class="mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1"><option value="">'+theadname+': All</option></select>')
                                .appendTo( '#filtertable' )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    if (val === '') {
                                        column.search('').draw();
                                    } else {
                                        column
                                            .search( '^'+val+'$', true, false )
                                            .draw();
                                    }
                                } );
                            select.find('option[value=""]').attr("selected", true);
                            column.data().unique().sort().each( function ( d, j ) {
                                var val = $('<div/>').html(d).text();
                                select.append( '<option value="'+val+'">'+val+'</option>' )
                            } );
                        } );
                    }
                });
            } );

            //configuration for the FEED TABLE
            $(document).ready(function() {
                //this code will prevent the table from going back to page 1 when the user is in page 2 ang opens another function and then exits the page.
                var pageReloading = false;
                $(window).on('beforeunload', function(){
                pageReloading = true;
                });

                //this will reset the filter
                $('#reset-btn').click(function() {
                if (!pageReloading) {
                    $('#filtertable select').val('');
                    $('#feedRecords').DataTable().columns().search('').draw();
                }
                });

                //this will reset the filter
                $('#reset-btn').click(function() {
                if (!pageReloading) {
                    $('#filtertable select').val('');
                    $('#feedRecords_Delete').DataTable().columns().search('').draw();
                }
                });

                //this will reset the filter
                $('#reset-btn-replenishment').click(function() {
                if (!pageReloading) {
                    $('#filtertable_replenishment select').val('');
                    $('#feedReplenishment').DataTable().columns().search('').draw();
                }
                });

                //table initialization
                $('#feedRecords').DataTable({
                    columns: [ //this will define what columns are orderable
                        { orderable: ['asc'] },
                        { orderable: ['asc'] },
                        // { orderable: ['asc'] },
                        null,
                        // null,
                        { orderable: false },
                    ],
                    //table initialization
                    initComplete: function () {
                        this.api().columns([1,2]).every( function (d) {
                            var column = this;
                            var theadname = $('#feedRecords th').eq([d]).text();
                            var select = $('<select class="mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1"><option value="">'+theadname+': All</option></select>')
                                .appendTo( '#filtertable' )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    if (val === '') {
                                        column.search('').draw();
                                    } else {
                                        column
                                            .search( '^'+val+'$', true, false )
                                            .draw();
                                    }
                                } );
                            select.find('option[value=""]').attr("selected", true);
                            column.data().unique().sort().each( function ( d, j ) {
                                var val = $('<div/>').html(d).text();
                                select.append( '<option value="'+val+'">'+val+'</option>' )
                            } );
                        } );
                    }
                });

                //table initialization
                $('#feedReplenishment').DataTable({
                    columns: [ //this will define what columns are orderable
                        { orderable: ['asc'] },
                        { orderable: ['asc'] },
                        // { orderable: ['asc'] },
                        null,
                        null,
                        { orderable: false },
                    ],
                    //table initialization
                    initComplete: function () {
                        this.api().columns([1,2]).every( function (d) {
                            var column = this;
                            var theadname = $('#feedReplenishment th').eq([d]).text();
                            var select = $('<select class="mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1"><option value="">'+theadname+': All</option></select>')
                                .appendTo( '#filtertable_replenishment' )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    if (val === '') {
                                        column.search('').draw();
                                    } else {
                                        column
                                            .search( '^'+val+'$', true, false )
                                            .draw();
                                    }
                                } );
                            select.find('option[value=""]').attr("selected", true);
                            column.data().unique().sort().each( function ( d, j ) {
                                var val = $('<div/>').html(d).text();
                                select.append( '<option value="'+val+'">'+val+'</option>' )
                            } );
                        } );
                    }
                });

                //table initialization for DELETE TABLE
                $('#feedRecords_Delete').DataTable({
                    columns: [ //this will define what columns are orderable
                        { orderable: ['asc'] },
                        null,
                        null,
                        null,
                        null,
                        null,
                        { orderable: false },
                    ],
                    dom: "<'row align-items-center'<'col-sm-12 col-md-6 mt-1 mb-1 mb-md-0'l><'col-sm-12 col-md-6 mt-1 mb-1 mb-md-0 p-0'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    //table initialization
                    initComplete: function () {
                        this.api().columns([2]).every( function (d) {
                            var column = this;
                            var theadname = $('#feedRecords_Delete th').eq([d]).text();
                            var select = $('<select class="mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1"><option value="">'+theadname+': All</option></select>')
                                .appendTo( '#filtertable' )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    if (val === '') {
                                        column.search('').draw();
                                    } else {
                                        column
                                            .search( '^'+val+'$', true, false )
                                            .draw();
                                    }
                                } );
                            select.find('option[value=""]').attr("selected", true);
                            column.data().unique().sort().each( function ( d, j ) {
                                var val = $('<div/>').html(d).text();
                                select.append( '<option value="'+val+'">'+val+'</option>' )
                            } );
                        } );
                    }
                });
            } );

            //configuration for the FEED TABLE
            $(document).ready(function() {

                //this code will prevent the table from going back to page 1 when the user is in page 2 ang opens another function and then exits the page.
                var pageReloading = false;
                $(window).on('beforeunload', function(){
                pageReloading = true;
                });

                //this will reset the filter
                $('#reset-btn').click(function() {
                if (!pageReloading) {
                    $('#filtertable select').val('');
                    $('#feedReductions').DataTable().columns().search('').draw();
                }
                });

                //table initialization
                $('#feedReductions').DataTable({
                    columns: [ //this will define what columns are orderable
                        { orderable: ['asc'] },
                        { orderable: ['asc'] },
                        null,
                        null,
                        null,
                        { orderable: false },
                    ],
                    //for filter buttons
                    initComplete: function () {
                        this.api().columns([0,2]).every( function (d) {
                            var column = this;
                            var theadname = $('#feedReductions th').eq([d]).text();
                            var select = $('<select class="mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1"><option value="">'+theadname+': All</option></select>')
                                .appendTo( '#filtertable' )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    if (val === '') {
                                        column.search('').draw();
                                    } else {
                                        column
                                            .search( '^'+val+'$', true, false )
                                            .draw();
                                    }
                                } );
                            select.find('option[value=""]').attr("selected", true);
                            column.data().unique().sort().each( function ( d, j ) {
                                var val = $('<div/>').html(d).text();
                                select.append( '<option value="'+val+'">'+val+'</option>' )
                            } );
                        } );
                    }
                });
            } );

            //configuration for the SCHEDULES TABLE
            $(document).ready(function() {
                var userRole = '<?php $_SESSION['role']; ?>';//WALA NAKO KAHINUMDUM PARA ASA NI HAHAHAHA PERO FEEL NAKO WALA RA PERO DI SA LANG NAKO IERASE
                
                //this code will prevent the table from going back to page 1 when the user is in page 2 ang opens another function and then exits the page.
                var pageReloading = false;
                $(window).on('beforeunload', function(){
                pageReloading = true;
                });

                //this will reset the filter
                $('#reset-btn').click(function() {
                if (!pageReloading) {
                    $('#filtertable select').val('');
                    $('#medicationSchedules').DataTable().columns().search('').draw();
                }
                });

                //this will reset the filter
                $('#reset-btn').click(function() {
                if (!pageReloading) {
                    $('#filtertable select').val('');
                    $('#schedules').DataTable().columns().search('').draw();
                }
                });

                //this will reset the filter
                $('#reset-btn').click(function() {
                if (!pageReloading) {
                    $('#filtertable select').val('');
                    $('#schedules_Delete').DataTable().columns().search('').draw();
                }
                });

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
                    //for filter buttons
                    initComplete: function () {
                        this.api().columns([3,4,7]).every( function (d) {
                            var column = this;
                            var theadname = $('#medicationSchedules th').eq([d]).text();
                            var select = $('<select class="mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1"><option value="">'+theadname+': All</option></select>')
                                .appendTo( '#filtertable' )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    if (val === '') {
                                        column.search('').draw();
                                    } else {
                                        column
                                            .search( '^'+val+'$', true, false )
                                            .draw();
                                    }
                                } );
                            select.find('option[value=""]').attr("selected", true);
                            column.data().unique().sort().each( function ( d, j ) {
                                var val = $('<div/>').html(d).text();
                                select.append( '<option value="'+val+'">'+val+'</option>' )
                            } );
                        } );
                    }
                });

                $('#medicationSchedules_Employee').DataTable({
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
                    dom: "<'row align-items-center'<'col-sm-12 col-md-6 mt-1 mb-1 mb-md-0'l><'col-sm-12 col-md-6 mt-1 mb-1 mb-md-0 p-0'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    //for filter buttons
                    initComplete: function () {
                        this.api().columns([3,4,7]).every( function (d) {
                            var column = this;
                            var theadname = $('#medicationSchedules_Employee th').eq([d]).text();
                            var select = $('<select class="mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1"><option value="">'+theadname+': All</option></select>')
                                .appendTo( '#filtertable' )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    if (val === '') {
                                        column.search('').draw();
                                    } else {
                                        column
                                            .search( '^'+val+'$', true, false )
                                            .draw();
                                    }
                                } );
                            select.find('option[value=""]').attr("selected", true);
                            column.data().unique().sort().each( function ( d, j ) {
                                var val = $('<div/>').html(d).text();
                                select.append( '<option value="'+val+'">'+val+'</option>' )
                            } );
                        } );
                    }
                });

                // scchedules
                $('#schedules').DataTable({
                    columns: [ //this will define what columns are orderable
                        null,
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
                    //for filter buttons
                    initComplete: function () {
                        this.api().columns([0,2,4,5]).every( function (d) {
                            var column = this;
                            var theadname = $('#schedules th').eq([d]).text();
                            var select = $('<select class="mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1"><option value="">'+theadname+': All</option></select>')
                                .appendTo( '#filtertable' )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    if (val === '') {
                                        column.search('').draw();
                                    } else {
                                        column
                                            .search( '^'+val+'$', true, false )
                                            .draw();
                                    }
                                } );
                            select.find('option[value=""]').attr("selected", true);
                            column.data().unique().sort().each( function ( d, j ) {
                                var val = $('<div/>').html(d).text();
                                select.append( '<option value="'+val+'">'+val+'</option>' )
                            } );
                        } );
                    }
                });

                // scchedules for DELETE TABLE
                $('#schedules_Delete').DataTable({
                    columns: [ //this will define what columns are orderable
                        null,
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
                    dom: "<'row align-items-center'<'col-sm-12 col-md-6 mt-1 mb-1 mb-md-0'l><'col-sm-12 col-md-6 mt-1 mb-1 mb-md-0 p-0'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    //for filter buttons
                    initComplete: function () {
                        this.api().columns([0,2,4,5]).every( function (d) {
                            var column = this;
                            var theadname = $('#schedules_Delete th').eq([d]).text();
                            var select = $('<select class="mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1"><option value="">'+theadname+': All</option></select>')
                                .appendTo( '#filtertable' )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    if (val === '') {
                                        column.search('').draw();
                                    } else {
                                        column
                                            .search( '^'+val+'$', true, false )
                                            .draw();
                                    }
                                } );
                            select.find('option[value=""]').attr("selected", true);
                            column.data().unique().sort().each( function ( d, j ) {
                                var val = $('<div/>').html(d).text();
                                select.append( '<option value="'+val+'">'+val+'</option>' )
                            } );
                        } );
                    }
                });
            } );

            //configuration for the SCHEDULES TABLE
            $(document).ready(function() {                
                //this code will prevent the table from going back to page 1 when the user is in page 2 ang opens another function and then exits the page.
                var pageReloading = false;
                $(window).on('beforeunload', function(){
                pageReloading = true;
                });

                //this will reset the filter
                $('#reset-btn').click(function() {
                if (!pageReloading) {
                    $('#filtertable select').val('');
                    $('#vaccinationSchedules').DataTable().columns().search('').draw();
                }
                });

                
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
                    //for filter buttons
                    initComplete: function () {
                        this.api().columns([3,4]).every( function (d) {
                            var column = this;
                            var theadname = $('#vaccinationSchedules th').eq([d]).text();
                            var select = $('<select class="mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1"><option value="">'+theadname+': All</option></select>')
                                .appendTo( '#filtertable' )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    if (val === '') {
                                        column.search('').draw();
                                    } else {
                                        column
                                            .search( '^'+val+'$', true, false )
                                            .draw();
                                    }
                                } );
                            select.find('option[value=""]').attr("selected", true);
                            column.data().unique().sort().each( function ( d, j ) {
                                var val = $('<div/>').html(d).text();
                                select.append( '<option value="'+val+'">'+val+'</option>' )
                            } );
                        } );
                    }
                });
                
                $('#vaccinationSchedules_Employee').DataTable({
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
                    dom: "<'row align-items-center'<'col-sm-12 col-md-6 mt-1 mb-1 mb-md-0'l><'col-sm-12 col-md-6 mt-1 mb-1 mb-md-0 p-0'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    //for filter buttons
                    initComplete: function () {
                        this.api().columns([3,4]).every( function (d) {
                            var column = this;
                            var theadname = $('#vaccinationSchedules_Employee th').eq([d]).text();
                            var select = $('<select class="mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1"><option value="">'+theadname+': All</option></select>')
                                .appendTo( '#filtertable' )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    if (val === '') {
                                        column.search('').draw();
                                    } else {
                                        column
                                            .search( '^'+val+'$', true, false )
                                            .draw();
                                    }
                                } );
                            select.find('option[value=""]').attr("selected", true);
                            column.data().unique().sort().each( function ( d, j ) {
                                var val = $('<div/>').html(d).text();
                                select.append( '<option value="'+val+'">'+val+'</option>' )
                            } );
                        } );
                    }
                });
            } );

             //configuration for the users table
             $(document).ready(function() {
                //this code will prevent the table from going back to page 1 when the user is in page 2 ang opens another function and then exits the page.
                var pageReloading = false;
                $(window).on('beforeunload', function(){
                pageReloading = true;
                });

                //this will reset the filter
                $('#reset-btn').click(function() {
                if (!pageReloading) {
                    $('#filtertable select').val('');
                    $('#users_disabled').DataTable().columns().search('').draw();
                }
                });

                //table initialization
                $('#users_disabled').DataTable({
                    columns: [ //this will define what columns are orderable
                        { orderable: ['asc'] },
                        null,
                        null,
                        null,
                        null,
                        null,
                        { orderable: false },
                        { orderable: false },
                    ],
                    //table initialization
                    initComplete: function () {
                        this.api().columns([4,6]).every( function (d) {
                            var column = this;
                            var theadname = $('#users_disabled th').eq([d]).text();
                            var select = $('<select class="mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1"><option value="">'+theadname+': All</option></select>')
                                .appendTo( '#filtertable' )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    if (val === '') {
                                        column.search('').draw();
                                    } else {
                                        column
                                            .search( '^'+val+'$', true, false )
                                            .draw();
                                    }
                                } );
                            select.find('option[value=""]').attr("selected", true);
                            column.data().unique().sort().each( function ( d, j ) {
                                var val = $('<div/>').html(d).text();
                                select.append( '<option value="'+val+'">'+val+'</option>' )
                            } );
                        } );
                    }
                });

            } );

              //configuration for the MEDICINE DASHBOARD
              $(document).ready(function() {
                $('#medicineDashboard').DataTable({
                    columns: [ //this will define what columns are orderable
                        { orderable: ['asc'] },
                        null,
                        null,
                    ],
                    dom: 'Bfrtip', // this will remove the export buttons
                    buttons: [], // this will remove the export buttons,
                    filter: false,
                    pagingType: 'numbers',
                    info: false

                });
            } );

              //configuration for the MEDICINE DASHBOARD
              $(document).ready(function() {
                $('#medicineExpireDashboard').DataTable({
                    columns: [ //this will define what columns are orderable
                        { orderable: ['asc'] },
                        null,
                        null,
                        // null,
                    ],
                    dom: 'Bfrtip', // this will remove the export buttons
                    buttons: [], // this will remove the export buttons,
                    filter: false,
                    pagingType: 'numbers',
                    info: false

                });
            } );

              //configuration for the FEED DASHABORD
              $(document).ready(function() {
                $('#feedDashboard').DataTable({
                    columns: [ //this will define what columns are orderable
                        { orderable: ['asc'] },
                        null,
                        // null,
                    ],
                    dom: 'Bfrtip', // this will remove the export buttons
                    buttons: [], // this will remove the export buttons,
                    filter: false,
                    pagingType: 'numbers',
                    info: false

                });
            } );

            //script for tooltip
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
            
             // Close the alert after 3 seconds
            function closeAlert() {
            setTimeout(function() {
                document.getElementsByClassName('successAlert')[0].classList.add('animate__fadeOut');
            }, 3000);
            }
            // Call the closeAlert function when the page is loaded
            closeAlert();

            // //for loader
            // window.onload = function() {
            //     // Hide the loading icon when the page finishes loading
            //     document.querySelector('.loader-container').style.display = 'none';
            //     // Show the content when the page finishes loading
            //     document.querySelector('.displayTable').style.display = 'block';
            // };

            window.onload = function() {
            // Hide the loading icon when the page finishes loading
            // document.querySelector('.loader-container').style.display = 'none';
            var loaderContainers = document.querySelectorAll('.loader-container');
            for (var i = 0; i < loaderContainers.length; i++) {
                loaderContainers[i].style.display = 'none';
            }
            // };

            // Show the content when the page finishes loading
            var displayTables = document.querySelectorAll('.displayTable');
            for (var i = 0; i < displayTables.length; i++) {
                displayTables[i].style.display = 'block';
            }
            };


        </script>

    </body>
</html>