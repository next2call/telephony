<?php
session_start();
$_SESSION['page_start'] = 'Report_page';
include "../../../conf/db.php";
include "../../../conf/url_page.php";
include "../../../conf/Get_time_zone.php";

$user = $_SESSION['user'];
$list_id = $_REQUEST['list_id'];
$_SESSION['Get_list_id'] = $list_id;
$user_level = $_SESSION['user_level'];
$level_condition = "";
if ($user_level == 2 || $user_level == 6 || $user_level == 7) {
  $user = $_SESSION['admin'];
  $new_user = $_SESSION['user'];
  $user_campaigns_id = $_SESSION['campaign_id'];
  $level_condition = "AND campaigns_id = '$user_campaigns_id'";
}

$ucam = "SELECT * FROM `lists` WHERE LIST_ID='$list_id'";
$uque = mysqli_query($con, $ucam);
$ucrow = mysqli_fetch_assoc($uque);
$camp_id = $ucrow['CAMPAIGN'];

//==================== new code start 


if (isset($_POST["import"])) {
    $fileTempPath = $_FILES["excel"]["tmp_name"];
    echo $file_name = $_FILES["excel"]["name"];
    $user_name = $_POST["users"];
    $ins_date = date("d-m-Y");

    // Check if the file was uploaded without error
    if ($_FILES["excel"]["error"] !== UPLOAD_ERR_OK) {
        echo "File upload error. Error Code: " . $_FILES["excel"]["error"];
        exit;
    }
    
    $fileTempPath = $_FILES["excel"]["tmp_name"];
    if (!file_exists($fileTempPath)) {
        echo "Temporary file does not exist: " . $fileTempPath;
        exit;
    }
    
    echo "File uploaded successfully: " . $fileTempPath;
    die();
}


//========================submit code

?>


<div class="ml-5">
  <!-- Layout Start -->
  <div class="total-stats">
    <div>
      <h3 class="ml-5">Total Upload Data</h3>
      <div class="select">
        <!-- <select name="cars" id="cars">
                                <option value="today">Today</option>
                                <option value="tommorrow">Tommorrow</option>
                                <option value="yesterday">Yesterday</option>
                            </select> -->
        <!-- Button for auto dial -->


        <!-- <button class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">Auto Dial</button> -->
        <button class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">Upload</button>
        <button class="btn btn-success" id="delete_this_data_one">Export Data</button>
        <button class="btn btn-danger " id="delete_this_data">Delete All</button>
        <a class="btn btn-info go_to_nextpage">
          Dialed Data</a>


      </div>
    </div>
    <script>
      async function uploaddata() {
        const { value: file } = await Swal.fire({
          title: "Upload Contact file",
          input: "file",
          inputAttributes: {
            "accept": "csv/*",
            "aria-label": "Upload your Contact data"
          }
        });

        if (file) {
          const formData = new FormData();
          formData.append("excel", file);

          try {
            const response = await fetch("upload.php", {
              method: "POST",
              body: formData
            });

            const result = await response.json();

            if (result.success) {
              Swal.fire({
                title: "Success",
                text: "Your file has been uploaded successfully.",
                icon: "success",
                confirmButtonText: "OK"
              });
            } else {
              Swal.fire({
                title: "Error",
                text: "Failed to upload the file.",
                icon: "error",
                confirmButtonText: "OK"
              });
            }
          } catch (error) {
            console.error("Error:", error);
            Swal.fire({
              title: "Error",
              text: "An unexpected error occurred.",
              icon: "error",
              confirmButtonText: "OK"
            });
          }
        }
      }
    </script>

    <div class="total-stats-table table-responsive">

      <div class="container mt-4">

        <!-- ################################################### -->
        <div class="ml-2">
          <table id="employee_grid" class="table table-bordered">
            <thead>
              <tr>
                <th>Sr.</th>
                <th>Name</th>
                <th> Number</th>
                <th>Email</th>
                <th>Company Name</th>
                <!-- <th scope="col">End time</th> -->
                <th>Industry</th>
                <th>Status</th>
                <th>Allocate Agent</th>
              </tr>
            </thead>
          </table>
        </div>
        <!-- ################################################### -->
      </div>
    </div>
  </div>


  <!-- Layout End -->
</div>


</div>


<!-- add disposition open form  -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="" method='post' enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" onclick="upload" id="exampleModalLabel">Upload Execel file<span
              id='contact_des_c'></span>.</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-6">
              <label for="">Select User for Upload data</label>
              <select name="users" id="" class="form-control" required>
                <!-- <option value="">---Please Select Agent --</option> -->
                <option value=" ">--All--</option>
                <?php
                $sel1 = "SELECT * FROM `users` WHERE admin='$user' AND user_type = '1' $level_condition";
                $query1 = mysqli_query($con, $sel1);
                while ($row1 = mysqli_fetch_array($query1)) {
                  ?>
                  <option value="<?= $row1['user_id']; ?>"><?= $row1['full_name']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-sm-6">
              <label for="">Upload Contact file</label>
              <input type="file" name="excel" accept=".csv" class="form-control submit_list">

            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" name="import" class="btn btn-primary">Save </button>
          <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->

        </div>
      </form>
    </div>

  </div>
</div>

<!-- add assign open form  -->
<div class="modal fade" id="editAgentModal_one" tabindex="-1" aria-labelledby="exampleModalLabel_new"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel_new">Update Disposition Selected Lead</h5>
        <button type="button" class="close close_btn" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="new_submite_data">
          <div class="row">
            <div class="mb-3 col-6">
              <label for="old_disposition" class="form-label">Select Current Status</label>
              <select class="form-control" name="old_disposition" id="old_disposition">
                <option value="">-----Select Current Status----</option>
                <option>NEW</option>
                <option>ANSWER</option>
                <option>CANCEL</option>
                <option>BUSY</option>
                <?php
                $new_tfnsel = "SELECT status FROM vicidial_statuses WHERE selectable='Y'";
                $data_nhj = mysqli_query($conn, $new_tfnsel);
                while ($row = mysqli_fetch_array($data_nhj)) { ?>
                  <!-- <option value="<?= $row['status'] ?>"><?= $row['status'] ?></option> -->
                <?php }
                ?>
              </select>
            </div>
            <div class="mb-3 col-6">
              <label for="new_disposition" class="form-label">Select New Status for Update</label>
              <select class="form-control" name="new_disposition" id="new_disposition">
                <option value="">-----Select New Status----</option>
                <option>NEW</option>
                <option>ANSWER</option>
                <option>CANCEL</option>
                <option>BUSY</option>
                <?php
                $new_tfnsel = "SELECT status FROM vicidial_statuses WHERE selectable='Y'";
                $data_nhj = mysqli_query($conn, $new_tfnsel);
                while ($row = mysqli_fetch_array($data_nhj)) { ?>
                  <!-- <option value="<?= $row['status'] ?>"><?= $row['status'] ?></option> -->
                <?php }
                ?>
              </select>
            </div>
          </div>
          <button type="submit" class="btn btn-success">Update Status</button>
        </form>


      </div>
    </div>
  </div>
</div>
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.1/js/dataTables.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css" />

<script type="text/javascript">
  $.noConflict();
  jQuery(document).ready(function ($) {

    $('#employee_grid').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
        url: "pages/dashboard/datatables-ajax/ajax_upload_data.php", // PHP script that fetches data
        type: "post",  // method used for sending data to the server
        error: function () {  // error handling
          $("#employee_grid_processing").css("display", "none");
        }
      },
      "columns": [  // define columns to be displayed
        { "data": "sr" },  // "id" should match with the key in your JSON response
        { "data": "name" },  // "record_url" should match with the key in your JSON response     
        { "data": "phone_number" },  // "record_url" should match with the key in your JSON response   
        { "data": "email" },  // "status" should match with the key in your JSON response
        { "data": "company_name" },  // "start_time" should match with the key in your JSON response
        { "data": "industry" },  // "dur" should match with the key in your JSON response
        {
          "data": "dial_status",
          "render": function (data, type, row) {
            if (data) {
              var html = '<div>';
              html += data;
              html += '&nbsp; &nbsp; <a href="pages/new_action/data_remove.php?id=' + row.id + '">';
              html += '<span class="badge bg-danger cursor_p text-white contact_add" title="Click here and remove the Data">Remove</span>';
              html += '</a>';
              html += '</div>';
              return html;
            } else {
              return '';
            }
          }
        },  // "record_url" should match with the key in your JSON response   
        { "data": "username" },  // "record_url" should match with the key in your JSON response     

      ]
    });
  });
</script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
  $(document).ready(function () {
    $('#delete_this_data').on('click', function () {
      // alert('ok');

      Swal.fire({
        title: "Are you sure?",
        text: "Do you want to delete your uploaded data?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete"
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "pages/new_action/contact_remove.php?dial_status=NEW"; // Redirect with the ID query string
        }
      });
    });
  });
</script>
<script>
  $(document).ready(function () {
    $(document).on("click", ".go_to_nextpage", function () { 
      var list_id = '<?= $_REQUEST['list_id'] ?>'; 
      window.location.href = "?c=dashboard&v=data_churning&list_id=" + list_id;
    });
  });
</script>

<script>
  $(document).ready(function () {
    $('#delete_this_data_one').on('click', function () {
      // alert('ok');
      Swal.fire({
        position: "top-end",
        icon: "success",
        title: "Export Your data success",
        showConfirmButton: false,
        timer: 1500
      }).then((result) => {
        window.location.href = "pages/new_action/contact_export.php"; // Redirect with the ID query string
      });
    });
  });
</script>

<script>
  $(document).ready(function () {
    $('#new_submite_data').on('submit', function (e) {
      e.preventDefault();
      var formData = $(this).serialize();
      $.ajax({
        url: 'pages/dashboard/update_bulk_disposition.php', // URL of the PHP script
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            $(".close_btn").click();
            const Toast = Swal.mixin({
              toast: true,
              position: "top-end",
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true,
              didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
              }
            });
            Toast.fire({
              icon: "success",
              title: "Status updated successfully!"
            });
            setTimeout(function () {
              location.reload(); // Reload the page after toast message
            }, 3000); // Match the delay with the toast timer
          } else {
            const Toast = Swal.mixin({
              toast: true,
              position: "top-end",
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true,
              didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
              }
            });
            Toast.fire({
              icon: "error",
              title: response.message
            });
          }
        },
        error: function (xhr, status, error) {
          console.error('AJAX Error:', status, error);
          alert('An error occurred while updating disposition.');
        }
      });
    });
  });
</script>