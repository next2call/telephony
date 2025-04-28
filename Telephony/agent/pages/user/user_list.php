<?php

require '../../../conf/db.php';
include "../../../conf/Get_time_zone.php";

session_start();
$_SESSION['page_start'] = 'Report_page';  
$user = $_SESSION['user'];
$usersql2 = "SELECT * FROM `users` WHERE user_id='$user'"; 
$usersresult = mysqli_query($con, $usersql2);

?>
                
                <div class="ml-5">
                    <!-- Layout Start -->
                    <div class="total-stats">
                    <div>
                        <h3 class="ml-5">Profile</h3>
                        <div class="select">
                          
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
      <th scope="col"><a href="#">USER ID</a></th>
                        <!-- <th scope="col"><a href="#">PASSWORD</a></th> -->
                        <th scope="col"><a href="#">FULL NAME</a></th>
                        <th scope="col"><a href="#">Outbound CLI</a></th>
                        <th scope="col"><a href="#">STATUS</a></th>
                        <!-- <th scope="col"><a href="#">DATE</a></th> -->
                        <th scope="col"><a href="#">ACTION</a></th>

      </tr>
    </thead>
    <?php

while ($usersrow = mysqli_fetch_array($usersresult)) {
    echo '<tr>';
    echo '<td>' . $usersrow['user_id'] . '</td>';
    // echo '<td>' . $usersrow['password'] . '</td>';
    echo '<td>' . $usersrow['full_name'] . '</td>';
    echo '<td>' . $usersrow['use_did'] . '</td>';
   

           ?>
    <td>
        <!-- <a href="pages/user/editstatus.php?id=<?= $usersrow['user_id'] ?>"> -->
            <?php 
          if($usersrow['status'] == 'Y'){
          echo '<span class="active-yes text-success cursor_p">' . 'Active' . '</span>';
          } else {
           echo '<span class="active-no text-warning cursor_p">' . 'Inactive' . '</span>';
             }
              ?>
        <!-- </a> -->
    
    </td>
    <?php
    // echo '<td>' . $usersrow['ins_date'] . '</td>';
    ?>
    <td> <span class="badge bg-info cursor_p text-white contact_add"
            data-user_id="<?Php echo $usersrow['user_id']; ?>" data-toggle="modal"
            data-target="#staticBackdrop" title="Click here and Edit user ">Edit</span>
            <!-- <button class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">Upload</button> -->
            </td> 
    <?php echo '</tr>'; } ?>
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
   <form action="" id="myForm_insert_data" method="POST">
     <div class="modal-header">
       <h5 class="modal-title" onclick="Change cli" id="exampleModalLabel">Profile<span id='contact_des_c'></span>.</h5>
       <button type="button" class="close" id="close_id" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
   
     <div class="modal-body">
     <div class="row">
                         <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                                <input type="hidden" name="nidd" id="id">
                                <input type="text" class="form-control" id="new-user-number" name="user_id"
                                    aria-describedby="new-user-no"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    maxlength="8" placeholder="User ID" readonly>
                                <!-- <label for="new-user-number">User ID</label> -->
                            </div>
                        </div> 
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                            <!-- <label for="full-name">Full Name</label> -->

                                <input type="text" class="form-control" id="full-name" name="full_name"
                                    aria-describedby="full-name" placeholder="Your Name" required>
                            </div>

                        </div>
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                            <!-- <label for="password">Use DID </label> -->
                            <input type="text" class="form-control" id="new_use_did" name="use_did"
                                    aria-describedby=""
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    maxlength="11" placeholder="CLI">
                            </div>
                        </div>      
     </div> 
     </div>
     <div class="modal-footer">
     <button type="submit" name="import" class="btn btn-primary" onclick="saveData()">Save </button>
       <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
      
     </div>
   </form>
   </div>
   
 </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $(document).on("click", ".contact_add", function() {
    var cnumber = $(this).data("user_id");
    //  alert(cnumber);  
    $("#new-user-number").val("");
        $("#full-name").val("");
        $("#new_use_did").val("");
        $("#id").val("")
    $.ajax({
            url: "pages/user/get_name.php",
            type: "POST",
            data: {
                cnumber: cnumber
            },
            dataType: "json",
            success: function(response) {
                if (response.error) {
                    alert(response.error);
                } else {
                    // Populate the fields with the response
                    $("#new-user-number").val(response.user_id);
                    $("#full-name").val(response.full_name);
                    $("#new_use_did").val(response.use_did);
                    $("#id").val(response.id);

                    // alert(response); // Show the alert box
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });

    // });
});
</script>
