<?php

require '../../../conf/db.php';
session_start();
$_SESSION['page_start'] = 'Report_page';  
$user = $_SESSION['user'];
$adsql2 = "SELECT * FROM `users` WHERE user_id='$user'";
$adquery = mysqli_query($con, $adsql2);
$adsrow = mysqli_fetch_assoc($adquery);
$agent_admin = $adsrow['admin'];

$usersql2 = "SELECT * FROM `block_no` WHERE admin = $agent_admin";
$usersresult = mysqli_query($con, $usersql2);


?>
         <style>
            .active-yes {
  font-weight: 800;
  font-size: 10px;
  line-height: 15px;
  color: #229a16;
  background-color: #dcf1d7;
  padding: 5px 10px;
  border-radius: 9px;
}

            .active-no {
  font-weight: 800;
  font-size: 10px;
  line-height: 15px;
  color: #b72136;
  background-color: #ffe2e1;
  padding: 5px 10px;
  border-radius: 9px;
}

         </style>
                <div class="ml-5">
                    <!-- Layout Start -->
                    <div class="total-stats">
                    <div class="table-top">
            <a class="data_btn" href="#add-user" data-toggle="modal" data-target="#add-user">
                <i class="fa fa-plus-circle" aria-hidden="true"></i> Add Block
            </a>
        </div>
                    <div class="total-stats-table table-responsive">

                        <div class="container mt-4">
                          
  <table class="table my-table" id="example">
    <thead>
    <tr>
                    <th scope="col"><a href="#">Sr.</a></th>
                    <th scope="col"><a href="#">Block No.</a></th>
                    <th scope="col"><a href="#">Status</a></th>
                    <th scope="col"><a href="#">Date</a></th>
                    <th scope="col"><a href="#">Action</a></th>
                </tr>
    </thead>
    <tbody>
                <?php
                $sr = 1;
                while ($usersrow = mysqli_fetch_array($usersresult)) {
                    echo '<tr>';
                    echo '<td>' . $sr . '</td>';
                    echo '<td>' . $usersrow['block_no'] . '</td>';
                    echo '<td>';
                    if ($usersrow['status'] == '1') {
                        echo '<span class="active-no cursor_p activate-block" data-id="' . $usersrow['id'] . '" data-status="' . $usersrow['status'] . '" title="This number is blocked. If you click here, this number will be activated for calling.">Blocked</span>';
                    } else {
                        echo '<span class="active-yes cursor_p activate-block" data-id="' . $usersrow['id'] . '" data-status="' . $usersrow['status'] . '" title="This number is activated. If you click here, this number will be blocked for calling.">Active</span>';

                    }
                    echo '</td>';
                    echo '<td>' . $usersrow['ins_date'] . '</td>';
                    echo '<td>';
                    echo '<i class="fa fa-trash cursor_p text-danger mb-2 delete-block" style="font-size:20px;" data-id="' . $usersrow['id'] . '" title="Click here to delete this number."></i>';
                    echo '</td>';
                    echo '</tr>';
                    $sr++;
                }
                ?>
            </tbody>
  </table>
</div>
</div>
</div>
    

                    <!-- Layout End -->
                </div>


            </div>
    

            <div class="modal fade" id="add-user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Block No.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="myForm_data_block">
                <div class="modal-body">
                    <div class="my-input-with-help form-group my-input">
                        <label for="block_no">Block No.</label>
                        
                          <input type="text" class="form-control" id="block_no" name="block_no"
                                    aria-describedby="block_no" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    maxlength="12" required> 
                    </div>
 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="block_m_close">Close</button>
                    <button type="submit" name="add_block" class="btn btn-primary" onclick="block_num()">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
<script>
$(document).ready(function() {
    $('.delete-block').on('click', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'pages/dashboard/block_num_delete.php', // Keep it empty to target the same file
                    type: 'POST',
                    data: { delete_id: id },
                    success: function(response) {
                        console.log("Response from server: " + response); // Debugging line    
                                window.location.reload();    
                    },
                    error: function(xhr, status, error) {
                        console.log("AJAX error: " + error); // Debugging line
                        Swal.fire(
                            'Error!',
                            'Failed to delete Block No.',
                            'error'
                        );
                    }
                });
            }
        });
    });

    $('.activate-block').on('click', function() {
        var id = $(this).data('id');
        var status = $(this).data('status');
        // alert(id);
        // alert(status);
        $.ajax({
            url: 'pages/dashboard/block_num_act&ina.php', // Keep it empty to target the same file
            type: 'POST',
            data: { activate_id: id, status_id: status },
            success: function(response) {
                console.log("Response from server: " + response); // Debugging line
                    Swal.fire(
                        'Activated!',
                        'Block No. has been activated.',
                        'success'
                    ).then(() => {
                        window.location.reload();
                    });
               
            },
            error: function(xhr, status, error) {
                console.log("AJAX error: " + error); // Debugging line
                Swal.fire(
                    'Error!',
                    'Failed to activate Block No.',
                    'error'
                );
            }
        });
    });
});
</script>

