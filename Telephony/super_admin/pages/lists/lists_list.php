<?php
session_start();
$Adminuser = $_SESSION['user'];
require '../include/user.php';
include "../../../conf/db.php";
include "../../../conf/url_page.php";


// if($con){
//   echo "success";
// }else{
//   echo "no";
// }
// die();
// $con = new mysqli("localhost", "cron", "1234", "vicidial_master");
$usersql = "Select user,user_id, full_name, user_level, user_group, active from vicidial_users";
$usersql2 = "SELECT * FROM `lists` WHERE ADMIN='$Adminuser'"; 

$usersresult = mysqli_query($con, $usersql2);


$eUser = "";
$full_name = "";
$user_level = "";
$user_group = "";
$pass = "";
$error = 0;


if (isset($_POST['submit_add_list'])) {
     $list_id = $_POST['list_id'];
    $list_name = $_POST['list_name'];
    $list_desc = $_POST['list_description'];
    $campaign_id = $_POST['campaign_id'];
    $active = $_POST['active'];
    $date = date('Y-m-d H:i:s');

   $select1 = "SELECT * FROM lists WHERE LIST_ID='$list_id'";
    $sel_query1 = mysqli_query($con, $select1);

    if (mysqli_num_rows($sel_query1) > 0) {
      echo '
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
      
      <script>
      // var username = document.getElementById("floatingInput1").value;
      window.onload = function() {
        Swal.fire({
          title: "Failed",
          text: "Sorry, this Lists Id already exists",
          icon: "error",
          confirmButtonText: "OK"
        }).then(() => {
          window.location.href = "'.$admin_ind_page.'?c=lists&v=lists_list";
      });
      }
      </script>';
    } else {

           $ins_daata = "INSERT INTO `lists`(`LIST_ID`, `NAME`, `DESCRIPTION`, `RTIME`, `CAMPAIGN`, `ACTIVE`, `ADMIN`) VALUES ('$list_id','$list_name','$list_desc','$date','$campaign_id','$active', '$Adminuser')";
        //  die();
        $query_ins = mysqli_query($con, $ins_daata);

    if($query_ins){
  echo '
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
  <script>
  window.onload = function() {
      Swal.fire({
          icon: "success",
          title: "Lists creation is successful",
          confirmButtonText: "OK"
      }).then(() => {
          window.location.href = "'.$admin_ind_page.'?c=lists&v=lists_list";
      });
  };                
  </script>';
    }
  
    } // check already insert number
  
    //  } // check select user select or no select
  }
  

  ################################################## Update List name and discription ########################
  
if (isset($_POST['update_list'])) {
   $list_id = $_POST['list_id'];
  // die();
 $list_name = $_POST['list_name'];
 $list_desc = $_POST['list_description'];
 $campaign_id = $_POST['campaign_id'];
//  $active = $_POST['active'];
 $date = date('Y-m-d H:i:s');

  $data_user= ($date . '||' . $Adminuser);
// die();
        // $ins = "INSERT INTO `lists`(`LIST_ID`, `NAME`, `DESCRIPTION`, `RTIME`, `CAMPAIGN`, `ACTIVE`, `ADMIN`) VALUES ('$list_id','$list_name','$list_desc','$date','$campaign_id','$active', '$Adminuser')";

        $update = "UPDATE `lists` SET `NAME`='$list_name',`DESCRIPTION`='$list_desc',`CAMPAIGN`='$campaign_id',`LIST_UP_DATE`='$data_user' WHERE `LIST_ID`='$list_id'";
     //  die();
     $query = mysqli_query($con, $update);

 if($query){
     echo '
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
   
   <script>
   // var username = document.getElementById("floatingInput1").value;
   window.onload = function() {
     Swal.fire({
       title: "Lists Update",
       text: "Lists update is successful.",
       icon: "success",
       confirmButtonText: "OK"
     }).then(() => {
          window.location.href = "'.$admin_ind_page.'?c=lists&v=lists_list";
      });
   }
   </script>';
 }

 } // check already insert number

 //  } // check select user select or no select


  ################################################## Update List name and discription ########################

//==================== new code start 
if(isset($_POST["import"])){
      // Enable error reporting for debugging
      // error_reporting(E_ALL);
      // ini_set('display_errors', 1);

   $list_id = $_POST["list_old_id"];
  // echo "</br>";
   $campaign_name = $_POST["campaign_name"];
// echo "</br>";
   $fileName = $_FILES["excel"]["name"];  
//  die();
    // $user_name = $_POST["users"];
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

     if (!empty($company_name) && !empty($phone_number) && $company_name != 'company_name') {

      $tfnsnjkj = "SELECT * FROM upload_data WHERE phone_number='$phone_number' AND dial_status='NEW'";
      $njnkkmkj = mysqli_query($con, $tfnsnjkj);
  
      if (mysqli_num_rows($njnkkmkj) == 0) {
  
         $insert = "INSERT INTO `upload_data`(`company_name`, `employee_size`, `industry`, `country`, `city`, `department`, `designation`, `email`, `name`, `phone_number`, `phone_2`, `phone_3`, `phone_code`, `admin`, `ins_date`, `dial_status`, `list_id`, `campaign_Id`) VALUES ('$company_name', '$employee_size', '$industry', '$country', '$city', '$department', '$designation', '$email', '$name', '$phone_number', '$phone2', '$phone3', '$phone_code', '$Adminuser', '$ins_date', 'NEW', '$list_id', '$campaign_name')";
       $queryy = mysqli_query($con, $insert);
      }
      }
              //========================check soource code for already insert
}     //========================for each loop code cond

// die();
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
   }).then(() => {
    window.location.href = "'.$admin_ind_page.'?c=lists&v=lists_list";
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
     }).then(() => {
      window.location.href = "'.$admin_ind_page.'?c=lists&v=lists_list";
  });
   }
   </script>';
 }                    
}         //========================submit code

####################################################### DUBLICATE LIST ID ################################################

if (isset($_POST['dublicate_list'])) {
  $list_id_new = $_POST['list_id_new'];
 $list_id_old = $_POST['list_id_old'];
 $date = date('Y-m-d H:i:s');


 $sslect_list = "SELECT * FROM lists WHERE LIST_ID='$list_id_old'";
 $sselect_query = mysqli_query($con, $sslect_list);
$ssle_row = mysqli_fetch_assoc($sselect_query);

$NAME=$ssle_row['NAME'];
$DESCRIPTION=$ssle_row['DESCRIPTION'];
$CAMPAIGN=$ssle_row['CAMPAIGN'];
$ACTIVE=$ssle_row['ACTIVE'];


$select1 = "SELECT * FROM lists WHERE LIST_ID='$list_id_new'";
 $sel_query1 = mysqli_query($con, $select1);

 if (mysqli_num_rows($sel_query1) > 0) {
   echo '
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
   
   <script>
   // var username = document.getElementById("floatingInput1").value;
   window.onload = function() {
     Swal.fire({
       title: "Failed",
       text: "Sorry, this Lists Id already exists",
       icon: "error",
       confirmButtonText: "OK"
     }).then(() => {
      window.location.href = "'.$admin_ind_page.'?c=lists&v=lists_list";
  });
   }
   </script>';
 } else {

  $ins_copy = "INSERT INTO `lists`(`LIST_ID`, `NAME`, `DESCRIPTION`, `RTIME`, `CAMPAIGN`, `ACTIVE`, `ADMIN`) VALUES ('$list_id_new','$NAME','$DESCRIPTION','$date','$CAMPAIGN','$ACTIVE', '$Adminuser')";

     //  die();
     $query = mysqli_query($con, $ins_copy);

 if($query){
     echo '
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
   
   <script>
   // var username = document.getElementById("floatingInput1").value;
   window.onload = function() {
     Swal.fire({
       title: "Lists Create",
       text: "Lists Coppy is successful.",
       icon: "success",
       confirmButtonText: "OK"
     }).then(() => {
      window.location.href = "'.$admin_ind_page.'?c=lists&v=lists_list";
  });
   }
   </script>';
 }

 } // check already insert number

 //  } // check select user select or no select
}
####################################################### DUBLICATE LIST ID ################################################

?>

<div>
    <div class="show-users">

        <!-- this is the top navbar that containes add user, copy user, time sheet and search option -->
        <div class="my-nav">
            <ul>
                <li>
                    <a class="nav-active" href="#add-user" data-toggle="modal" data-target="#add-user"><i
                            class="fa fa-plus-circle" aria-hidden="true"></i>
                        Add New List</a>
                </li>
                <li>
                  <a href="#copy-user" data-toggle="modal" data-target="#copy-user"><i class="fa fa-clone"
                  aria-hidden="true"></i> Copy List</a>
                </li>
                <!-- <li>
                    <a class="nav-active" href="#dynamic_lead" data-toggle="modal" data-target="#dynamic_lead"><i
                            class="fa fa-plus-circle" aria-hidden="true"></i>
                        Add New Custom List</a>
                </li> -->
                <!-- <li>
                    <a href="#copy-user" data-toggle="modal" data-target="#copy-user"><i class="fa fa-clone"
                            aria-hidden="true"></i> Copy Custom Fields</a>
                </li> -->
                
                <li>
                    <!-- <input type="search" placeholder="Search" name="search" id="search-user"> -->
                </li>
            </ul>
        </div>
        <!-- this is where top navbar ends -->

        <!-- user list table start -->
        <div class="table-responsive my-table">
            <div class="table-top">
                <h4>Show List</h4>
                <div class="my-filter-dropdown">
                    <div class="dropdown">
                        <button class="btn btn-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <img src="../../assets/images/common-icons/filter_list.png" alt="">
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">
                                <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M16.5 15.5C18.22 15.5 20.25 16.3 20.5 16.78V17.5H12.5V16.78C12.75 16.3 14.78 15.5 16.5 15.5M16.5 14C14.67 14 11 14.92 11 16.75V19H22V16.75C22 14.92 18.33 14 16.5 14M9 13C6.67 13 2 14.17 2 16.5V19H9V17.5H3.5V16.5C3.5 15.87 6.29 14.34 9.82 14.5A5.12 5.12 0 0 1 11.37 13.25A12.28 12.28 0 0 0 9 13M9 6.5A1.5 1.5 0 1 1 7.5 8A1.5 1.5 0 0 1 9 6.5M9 5A3 3 0 1 0 12 8A3 3 0 0 0 9 5M16.5 8.5A1 1 0 1 1 15.5 9.5A1 1 0 0 1 16.5 8.5M16.5 7A2.5 2.5 0 1 0 19 9.5A2.5 2.5 0 0 0 16.5 7Z" />
                                </svg></i> All</a>
                            <a class="dropdown-item" href="#">
                                <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M21.1,12.5L22.5,13.91L15.97,20.5L12.5,17L13.9,15.59L15.97,17.67L21.1,12.5M11,4A4,4 0 0,1 15,8A4,4 0 0,1 11,12A4,4 0 0,1 7,8A4,4 0 0,1 11,4M11,6A2,2 0 0,0 9,8A2,2 0 0,0 11,10A2,2 0 0,0 13,8A2,2 0 0,0 11,6M11,13C11.68,13 12.5,13.09 13.41,13.26L11.74,14.93L11,14.9C8.03,14.9 4.9,16.36 4.9,17V18.1H11.1L13,20H3V17C3,14.34 8.33,13 11,13Z" />
                                </svg> Active</a>
                        </div>
                    </div>
                </div>
            </div>
            <table class="all-user-table table table-hover">
                <thead>
                    <tr>
                    <th scope="col"><a href="#">LIST ID</a></th>
                        <th scope="col"><a href="#">NAME</a></th>
                        <th scope="col"><a href="#">DESCRIPTION</a></th>
  
                        <th scope="col">LEADS COUNT</th>
                     
                        <!-- <th scope="col">LAST CALL TIME</th> -->
                        <th scope="col">CAMPAIGN</th>
                        <th scope="col">ACTIVE</th>
                        <th scope="col"> CREATE TIME</th>
                        <!-- <th scope="col"><a href="#">RTIME</a></th> -->
                        <th scope="col">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                  <?php
                if ($usersresult) {
    while ($row = mysqli_fetch_assoc($usersresult)) {
        $list_id = $row['LIST_ID'];
        echo '<tr>';
        echo '<td><a href="#" class="go_to_nextpage" data-list_id="' . $row['LIST_ID'] . '">' . $row['LIST_ID'] . '</a></td>';
        echo '<td>' . $row['NAME'] . '</td>';
        echo '<td>' . $row['DESCRIPTION'] . '</td>';

        echo '<td class="lead_count text-success" data-list_id="' . $list_id . '"></td>';

        echo '<td>'.$row['CAMPAIGN'].'</td>';
        ?>
        <td>
   <a href="pages/new_action/status_edit.php?id=<?= $row['ID'] ?>">
      <?php 
      if($row['ACTIVE'] == 'Y'){
      echo '<span class="active-yes cursor_p">' . 'Active' . '</span>';
      } else {
       echo '<span class="active-no cursor_p">' . 'Inactive' . '</span>';
         }
          ?>
       </a>
    </td>
<?php
                    echo '<td>'.$row['RTIME'].'</td>';

                    echo "<td>
                    <a class='text-primary cursor_p update_list' data-id='".  $row['ID'] ."' data-toggle='modal' data-target='#updatalissst' title='You can Update Your List information'><i
                                class='fa fa-pencil-square' style='font-size:20px;'></i></a>
                     <a class='text-info cursor_p show_dddata' data-id='".  $row['LIST_ID'] ."' data-toggle='modal' data-target='#upload_lead' title='You can click here to Upload Your Lead'><i
                                class='fa fa-upload' style='font-size:20px;'></i></a>
                    <i class='fa fa-trash cursor_p text-danger mb-2 delete_your_list' style='font-size:20px;' data-id='".  $row['ID'] ."' title='You can click and remove Your List'></i>

                    </td>";
                    echo '</tr>';
                

    }
} else {
    echo "No data found";
}
?>




                </tbody>
            </table>
        </div>
        <!-- user list table ends -->
        <?php
include 'modals.php';
?>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $(document).on("click", ".show_dddata", function() {
        var list_id = $(this).data("id");
        // alert(list_id);
        // Clear the fields before making the request
        $("#list_id_neww").val(""); 
        $("#campaign_name_nn").val(""); 
        // $("#lead_upload").val(""); 

        $.ajax({
            url: "pages/new_action/get_list_id.php",
            type: "POST",
            data: { list_id: list_id },
            dataType: "json", // Expect JSON response
            success: function(response) {
                // Check if response is not empty
                if ($.isEmptyObject(response)) {
                    console.log("No data found");
                } else {
                    // Populate the fields with the response
                    $("#list_id_neww").val(list_id);
                    $("#campaign_name_nn").val(response.CAMPAIGN);

                    // alert(response.LIST_ID);
                    // alert(response.CAMPAIGN);
                    // $("#lead_upload").val(response.compaignname);

                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
});

</script>

  <script>
$(document).ready(function() {
    $(document).on("click", ".go_to_nextpage", function() {
    // $(document).on("click", ".agent_dashboard.php", function() {
        var list_id = $(this).data("list_id");
        // alert(list_id);
        // Assuming you want to redirect to another page
        // window.location.href = "?c=user&v=user_break_status&user_id=" + user_id;
        window.location.href = "?c=dashboard&v=contact_upload&list_id=" + list_id;
    });
});

</script>
<script>
$(document).ready(function() {
    $(document).on("click", ".update_list", function() {
        var id = $(this).data("id");
        // alert(id);
        // Clear the fields before making the request
        $("#list_id_new").val(""); 
        $("#list_name_new").val("");
        $("#campaign_description_new").val(""); 
        $("#campaign_id_new").val(""); 
        // $("#lead_upload").val(""); 

        $.ajax({
            url: "pages/new_action/get_list_information.php",
            type: "POST",
            data: { id : id },
            dataType: "json", // Expect JSON response
            success: function(response) {
                // Check if response is not empty
                if ($.isEmptyObject(response)) {
                    console.log("No data found");
                } else {
                    // Populate the fields with the response
                    $("#list_id_new").val(response.LIST_ID);
                    $("#list_name_new").val(response.NAME);
                    $("#campaign_description_new").val(response.DESCRIPTION);
                    $("#campaign_id_new").val(response.CAMPAIGN);
                    
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
});
</script>
<script>
$(document).ready(function() {
    $(document).on("click", ".delete_your_list", function() {
        var id = $(this).data("id");
    // alert(id);
    Swal.fire({
        title: "Are you sure?",
        text: "This data is delete",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete"
    }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "pages/new_action/list_delete.php?id=" + id // Redirect to block.php with the 'id' query string
        }
    });
  });

});
 
</script>

<script>
$(document).ready(function() {
    $(document).on("click", ".update_list", function() {
        var id = $(this).data("id");
        // alert(id);
        // Clear the fields before making the request
        $("#list_id_new").val(""); 

        $.ajax({
            url: "pages/new_action/get_list_information.php",
            type: "POST",
            data: { id : id },
            dataType: "json", // Expect JSON response
            success: function(response) {
                // Check if response is not empty
                if ($.isEmptyObject(response)) {
                    console.log("No data found");
                } else {
                    // Populate the fields with the response
                    $("#list_id_new").val(response.LIST_ID);
                    
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
});
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  setInterval(loadPage, 1000);

  function loadPage() {
    $('.lead_count').each(function() {
      var element = $(this);
      var list_id = element.data("list_id");

      $.ajax({
        url: "pages/lists/leadcount_ajaxfile.php",
        data: { list_id: list_id },
        type: "POST",
        dataType: "json",
        success: function (res) {
       
            var htmlcount = res.count || '0';  // Assuming 'count' is a key in the JSON response
          element.html(htmlcount);
        

        },
        error: function (xhr, status, error) {
          console.error("AJAX error: ", status, error);
        }
      });
    });
  }
</script>




