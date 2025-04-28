<?php
date_default_timezone_set('America/New_York'); // Set the timezone to Eastern Time

$sql="SELECT * FROM vicidial_lists";
$result=mysqli_query($conn,$sql);

if (isset($_POST['submit_list'])) {
    print_r($_POST);
}


?>

<div>
    <div class="show-users">

        <!-- this is where top navbar ends -->

        <!-- user list table start -->
        <div class="my-table mr-2" >
            
            <table id="employee_grid" class="table table-bordered">
                <thead>
                    <tr>
                    <th>ID</th>
        <th>Caller Name</th>
        <th>Caller Number</th>
        <th>Email</th>
        <th>Dialstatus </th>
        <th>Remark </th>
        <!-- <th>End time</th> -->
        <th>Date</th>

                    </tr>
                </thead>

            </table>
        </div>
        <!-- user list table ends -->
        <?php
include 'modals.php';
?>
    </div>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css" />
<script type="text/javascript" src="https://cdn.datatables.net/2.0.1/js/dataTables.min.js"></script>
<script type="text/javascript">
        $.noConflict();
        jQuery(document).ready(function($) {
            $('#employee_grid').DataTable({
                "pageLength": 100,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "pages/lists/datatables-ajax/ajaxfile.php", // PHP script that fetches data
                    "type": "POST",
                    "error": function() {
                        $("#employee_grid_processing").css("display", "none");
                    }
                },
                "columns": [
    { "data": "sr" },
    { "data": "name" },
    { "data": "phone_number" },
    { "data": "email" },
    { "data": "dialstatus" },
    { "data": "remark" },
    { "data": "ins_date" }
]
 
            });

        });


        function load_otherpage(page) {
            var user = '<?= $adminuser ?>';
            $.ajax({
                url: page,
                type: 'POST',
                dataType: 'html',
                data: {
                    user: user
                },
                success: function(data) {
                    $('#content').html(data);
                    localStorage.setItem('currentPage', page);
                },
                error: function(xhr, status, error) {
                    console.error('Error loading page:', error);
                    console.log('XHR:', xhr);
                }
            });
        }
    </script>
