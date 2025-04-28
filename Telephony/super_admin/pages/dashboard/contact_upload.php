<?php
session_start();
$_SESSION['page_start'] = 'Report_page';  
include "../../../conf/db.php";
include "../../../conf/url_page.php";

$user = $_SESSION['user'];
 $list_id = $_REQUEST['list_id'];
 $_SESSION['Get_list_id'] = $list_id;


$ucam = "SELECT * FROM `lists` WHERE LIST_ID='$list_id'"; 
$uque = mysqli_query($con, $ucam);
$ucrow = mysqli_fetch_assoc($uque);
$camp_id = $ucrow['CAMPAIGN'];

//==================== new code start 
if(isset($_POST["import"])){



     $fileName = $_FILES["excel"]["name"];  
     $user_name = $_POST["users"];
// die();
    $fileExtension = explode('.', $fileName);
    $fileExtension = strtolower(end($fileExtension));
    $newFileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;
    $ins_date = date("d-m-Y");
    $targetDirectory = "pages/dashboard/uploads/" . $newFileName;
    // die();
     move_uploaded_file($_FILES['excel']['tmp_name'], $targetDirectory);
    //     echo "<script>alert('data uploade in Folder Success')</script>";
    //  }else{
    //     echo "<script>alert('data not uploade in Folder')</script>";
    //  }
  
    // error_reporting(0);
    // ini_set('display_errors', 0);
  
    require 'excelReader/excel_reader2.php';
    require 'excelReader/SpreadsheetReader.php';
  
    $reader = new SpreadsheetReader($targetDirectory);
    foreach($reader as $key => $row){
      $company_name = $row[0];
      $employee_size = $row[1];
      $industry = $row[2];
      $country = $row[3];
      $city = $row[4];
      $department = $row[5];
      $designation = $row[6];
      $email = $row[7];
      $name = $row[8];
      $phone_number = $row[9];
      $phone2 = $row[10];
      $phone3 = $row[11];
      $phone_code = '0';
    //  if (!empty($company_name) && !empty($phone_number)) {
      if (!empty($company_name) && !empty($phone_number) && $company_name != 'company_name') {

    // $tfnsnjkj = "SELECT * FROM upload_data WHERE phone_number='$phone_number' AND ins_date='$ins_date'";
    // $njnkkmkj = mysqli_query($con, $tfnsnjkj);

    // if (mysqli_num_rows($njnkkmkj) == 0) {
        
         $insert = "INSERT INTO `upload_data`(`company_name`, `employee_size`, `industry`, `country`, `city`, `department`, `designation`, `email`, `name`, `phone_number`, `phone_2`, `phone_3`, `phone_code`, `username`, `admin`, `ins_date`, `dial_status`, `list_id`, `campaign_Id`) VALUES ('$company_name', '$employee_size', '$industry', '$country', '$city', '$department', '$designation', '$email', '$name', '$phone_number', '$phone2', '$phone3', '$phone_code', '$user_name', '$user', '$ins_date', 'NEW', '$list_id', '$camp_id')";
        
// die();
        $queryy = mysqli_query($con, $insert);
    //  } 
   }                 //========================check soource code for already insert
}     //========================for each loop code cond

if($queryy){
  echo '
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
  
  <script>
  // var username = document.getElementById("floatingInput1").value;
  window.onload = function() {
    Swal.fire({
      title: "Success",
      text: "Your data is Uploaded !",
      icon: "success",
      confirmButtonText: "OK"
    });
  }
  </script>'; 
    // echo "<script>alert('Okay, your file has been uploaded successfully.')</script>";
  }else{
    echo '
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
    
    <script>
    // var username = document.getElementById("floatingInput1").value;
    window.onload = function() {
      Swal.fire({
        title: "Failed",
        text: "Your is not Uploaded !",
        icon: "error",
        confirmButtonText: "OK"
      });
    }
    </script>';
  }                    
}         //========================submit code

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
                            <!-- <button class="btn btn-danger delete_this_data" >Delete All</button> -->
                            <!-- <span class="badge bg-danger cursor_p text-white delete_this_data" data-id="<?Php echo $usersrow['id']; ?>" title="You can click here to see why users take breaks">Remove</span> -->
                            <!-- <a href="pages/new_action/contact_export.php"> -->
                              <button class="btn btn-success" id="delete_this_data_one">Export Data</button>
                            <button class="btn btn-danger " id="delete_this_data">Delete All</button>
                            <!-- <button class="btn btn-primary" onclick="uploaddata()" data-target="#staticBackdrop">Upload</button> -->

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
          <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
 <div class="modal-dialog">
   <div class="modal-content">
   <form action="" method='post' enctype="multipart/form-data">
     <div class="modal-header">
       <h5 class="modal-title" onclick="upload" id="exampleModalLabel">Upload Execel file<span id='contact_des_c'></span>.</h5>
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
        $sel1="SELECT * FROM `users` WHERE admin='$user' AND user_id!='$user'";
        $query1=mysqli_query($con, $sel1);
        while( $row1 = mysqli_fetch_array($query1)){
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
     <button type="submit" name="import" class="btn btn-primary" >Save </button>
       <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
      
     </div>
   </form>
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
jQuery( document ).ready(function( $ ) {
    
    $('#employee_grid').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url :"pages/dashboard/datatables-ajax/ajax_upload_data.php", // PHP script that fetches data
            type: "post",  // method used for sending data to the server
            error: function(){  // error handling
              $("#employee_grid_processing").css("display","none");
            }
        },
        "columns": [  // define columns to be displayed
            { "data": "sr" },  // "id" should match with the key in your JSON response
            { "data": "name" },  // "record_url" should match with the key in your JSON response     
            { "data": "phone_number" },  // "record_url" should match with the key in your JSON response   
            { "data": "email" },  // "status" should match with the key in your JSON response
            { "data": "company_name" },  // "start_time" should match with the key in your JSON response
            { "data": "industry" },  // "dur" should match with the key in your JSON response
              { "data": "dial_status",
              "render": function(data, type, row) {
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
<script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous"></script>
<script>
$(document).ready(function() {
    $('#delete_this_data').on('click', function() {
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
                window.location.href = "pages/new_action/contact_remove.php"; // Redirect with the ID query string
            }
        });
    });
});
</script>


<script>
$(document).ready(function() {
    $('#delete_this_data_one').on('click', function() {
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



