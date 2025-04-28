<?php
session_start();
require '../../../conf/db.php';
include "../../../conf/url_page.php";
include "../../../conf/Get_time_zone.php";
$_SESSION['page_start'] = 'Report_page';  
$user = $_SESSION['user'];
$user_admin = $_SESSION['user_admin'];
$log_campaign_id = $_SESSION['campaign_id'];

 
$tfnsel_1 = "SELECT caller_email, caller_contact FROM users WHERE admin = '$user_admin'";
$data_1 = mysqli_query($con, $tfnsel_1);
$user_row = mysqli_fetch_assoc($data_1);
$caller_email = $user_row['caller_email'];
$caller_contact = $user_row['caller_contact']; 


$tfnsel="SELECT 
    upload_data.* 
FROM 
    upload_data 
JOIN 
    users 
    ON users.user_id = upload_data.admin
JOIN 
    lists 
    ON lists.list_id = upload_data.list_id 
WHERE 
    (upload_data.username = '$user' OR upload_data.username = ' ')
    AND dial_status = 'NEW'
    AND upload_data.campaign_id = '$log_campaign_id'
ORDER BY 
    upload_data.id DESC";

// die();
?>
 <style>
    .align_text {
  margin-top: 1px;
  position: absolute;
  left: 30%;
}
</style>         
                <div class="ml-5">
                    <!-- Layout Start -->
                    <div class="total-stats">
                    <div>
                        <h3 class="ml-5">Total Upload Data</h3>
                        <!-- <div class="align_text " title="To upload, download the data format from here and upload your data in this format">
        <a href="<?= $upload_dd_f ?>dashboard/uploads/vicidial_data.csv" download> <i class="fa fa-arrow-circle-o-down" style="font-size:20px;"></i> </a>
    </div> -->
                        <div class="select">

                            <!-- <button class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">Auto Dial</button> -->
                            <!-- <button class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">Upload</button> -->
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
                          
  <table class="table" id="example">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <!-- <th>Cust.ID</th> -->
        <th>email</th>
        <th>Number</th>
        <!-- <th>Sale Date</th>
        <th>Remark</th> -->
        <th>Status</th>
        <!-- <th>Phone Code</th> -->
        <!-- <th>Action</th> -->
      </tr>
    </thead>
    <?php
      // $tfnsel="SELECT * from upload_data WHERE username='$user' AND dial_status = 'NEW'";


$data = mysqli_query($con, $tfnsel);
$count = 0;

while ($row = mysqli_fetch_array($data))
{
  $sale_date = $row['sale_date'];
  $remark = $row['remark'];
  $Cust_ID = $row['Cust_ID'];
  $full_name=$row['name'];
    $number = $row['phone_number'];
    $email = $row['email'];
    $dial_status = $row['dial_status'];

  // Process email hiding logic
  if ($caller_email == '1') {
      $emailParts = explode('@', $email);
      if (count($emailParts) == 2) {
          $username = $emailParts[0];
          $domain = $emailParts[1];

          // Hide middle part of the username (replace it with asterisks)
          if (strlen($username) > 2) {
              $username = substr($username, 0, 2) . str_repeat('*', strlen($username) - 2);
          }

          // Reassemble the email
          $formattedEmail = $username . '@' . $domain;
      } else {
          // If email format is incorrect, keep it as is
          $formattedEmail = $email;
      }
  } else {
      $formattedEmail = $email;
  }

  // Process phone number hiding logic
  if ($caller_contact == '1') {
      $formattedNumber = str_repeat('*', 6) . substr($number, -4); // Show last 4 digits
  } else {
      $formattedNumber = $number;
  }

  $count++;
    ?>
      <tr>
        <td><?php echo $count ; ?></td>
        <td><?php echo $full_name ; ?></td>
        <!-- <td><?php echo $Cust_ID ; ?></td> -->
        <td><?php echo $formattedEmail ; ?></td> 
        <td><?php echo $formattedNumber ; ?>
        <a type="button" data-callernumber="<?= $number ?>" class="badge bg-primary clicktocall ml-2 cursor_p">
                                                            <i class="fa fa-phone-square"></i></a>
    </td>

    <!-- <td><?php echo $sale_date ; ?></td> -->
    <!-- <td><?php echo $remark ; ?></td> -->
    <td><?php echo $dial_status ; ?></td>
        <!-- <td><?php echo $phone_code ; ?></td> -->
        
      </tr>
      <?php } ?>
      <!-- Add more rows as needed -->
    

  </table>
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
        <label for="">Upload Contact file</label>
     <input type="file" name="excel" accept=".csv" class="submit_list">
                
     </div>
     <div class="modal-footer">
     <button type="submit" name="import" class="btn btn-primary" >Save </button>
       <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
      
     </div>
   </form>
   </div>
   
 </div>
</div>


