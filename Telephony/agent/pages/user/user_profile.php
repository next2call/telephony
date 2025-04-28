<?php
session_start();

require '../../../conf/db.php';
include "../../../conf/Get_time_zone.php";
require '../../../conf/url_page.php';

$agentuser = $_SESSION['user'];
$campaign_id = $_SESSION['campaign_id'];

$usersql2 = "SELECT * FROM `users` WHERE user_id='$agentuser'"; 

$usersresult = mysqli_query($con, $usersql2);
$usersrow = mysqli_fetch_assoc($usersresult);
  $user_name = $usersrow['full_name'];
 $user_id = $usersrow['user_id'];
 $password = $usersrow['password'];
 $total_campaign = $usersrow['campaigns_id'];
 $admin_email = $usersrow['admin_email'];
 $admin_mobile = $usersrow['admin_mobile'];
 $admin_profile = $usersrow['admin_profile'];
 $use_did = $usersrow['use_did'];


 $usql2 = "SELECT `user_id` FROM `users` WHERE admin='$Adminuser' AND user_id!='$Adminuser'"; 
 $usqur = mysqli_query($con, $usql2);
 $data_count = mysqli_num_rows($usqur);
//  $counr_agent = $data_count['user_id'];


?>
<style>
        .main_box {
            font-family: 'Arial', sans-serif;
            background-color: #e0f7fa;
            margin: 0;
            margin-top: -50px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100% !important;
            width: 100% !important;
            font-family: "Times New Roman", Times, serif;
        }

        .profile-container {
            /* background-color: #ffffff; */
            /* background-color: #e0f7fa; */
            padding: 10px;
            /* border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); */
            width: 100%;
            text-align: center;
            font-family: "Times New Roman", Times, serif;

        }

        .profile-header {
            margin-bottom: 20px;
        }

        .profile-pic {
            width: 220px;
            height: 220px;
            border-radius: 50%;
            margin-bottom: 15px;
            border: 3px solid #00796b;
        }

        .name {
            margin-top: -10px;
            font-size: 28px;
            color: #00796b;
        }

        .title {
            margin: 5px 0 20px 0;
            font-size: 18px;
            color: #004d40;
        }

        .profile-bio {
            margin-bottom: 25px;
            color: #444444;
        }

        .profile-contact, .profile-social, .profile-skills {
            margin-bottom: 20px;
            color: #004d40;
            font-family: "Times New Roman", Times, serif;


        }
        .profile-contact h1, h6, h5, h4, p{
            font-family: "Times New Roman", Times, serif;

        }

        .profile-contact h2, .profile-social h2, .profile-skills h2 {
            font-size: 30px;
            color: #00796b;
        }

        .profile-contact p, .profile-social a, .profile-skills ul li {
            margin: 5px 0;
            color: #444444;
        }

        .profile-social a {
            display: block;
            color: #00796b;
            text-decoration: none;
        }
.update_text{
    display: block;
            color: #00796b;
            text-decoration: none;
            margin-top: 25px;
}
.main_time {
        color: blue;
        font-weight: bold;
        font-size: 15px;
    }
    </style>
<!-- <div> -->
    <div class="show-users ml-5">
        <div class="table-responsive my-table ml-5">
            <div class="main_box">
        <div class="profile-container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="profile-header text-center">
                      <?php if($admin_profile){ ?> 
                      <img src="<?= $agent_pro_img.$admin_profile ?>" alt="Profile Picture" class="profile-pic">
                      <?php }else{ ?>
                      <img src="<?= $image_url ?>image3.png" alt="Profile Picture" class="profile-pic">
                      <?php } ?>
                        <p class="title">Welcome Mr.</p>
                        <h1 class="name"><?= $user_name; ?></h1>
                    </div>
                </div>
            <div class="col-md-6">
                            <div class="profile-contact text-left">
                                <h2>Contact Information</h2>
                                <div class="row mt-5">
                                    <div class="col-md-12">
                                        <h4>Name: <span class="float-right mr-4"><?= $user_name; ?></span></h4>
                                        <h6>Your User ID: <span class="float-right mr-4"><?= $user_id; ?></span></h6>
                                        <h6>Password: <span class="float-right mr-4"><?= str_repeat('*', strlen($password)); ?></span></h6>
                                        <h6>Login To Campaign: <span class="float-right mr-4"><?= $campaign_id; ?></span></h6>
                                        <h6>Your Use CLI: <span class="float-right mr-4"><?= $use_did; ?></span></h6>
                                        <!-- <h6>Your Total Agent: <span class="float-right mr-4"><?= $data_count; ?></span> -->
                                        <!-- </h6> -->
                                        <h6>Your Email: <span class="float-right mr-4"><?= $admin_email; ?></span></h6>
                                        <h6>Your Contact: <span class="float-right mr-4"><?= $admin_mobile; ?></span>
                                        </h6>
                                    </div>
                                </div>
                                <span class="update_text">Update Your Details
                                    <span class="badge bg-primary cursor_p text-white contact_add"
                                        data-user_id="<?php echo $user_id; ?>" data-toggle="modal"
                                        data-target="#staticBackdrop" title="Click here and Edit user">Click</span> 
                                </span>
                            </div>
                        </div>
        </div>
    </div>
        </div>
    </div>
<!-- </div> -->
<!-- Start code to new update model popup -->
<!-- <div class="modal fade" id="edit_user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"> -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    
<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Your Details</h5>
                <button type="button" class="close" data-dismiss="modal" id="close_id" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <!-- <button type="button" class="close" id="close_id" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
       </button> --> 
            </div>
            <form action="" id="myForm_insert_data" method="POST" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="row">
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                                <input type="hidden" name="get_id" id="get_id">
                                <input type="text" class="form-control" id="c_number" name="c_number"
                                    aria-describedby="new-user-no"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    maxlength="15" readonly>
                                <!-- <label for="new-user-number">User ID</label> -->
                            </div>

                        </div>
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">

                                <input type="text" class="form-control" id="edit_name_c" name="edit_name_c"
                                    aria-describedby="full-name" placeholder="Full Name" required>
                                <!-- <label for="full-name">Full Name</label> -->
                            </div>

                        </div>

                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">

                                <input type="password" class="form-control" id="password_new" name="password_new"
                                    aria-describedby="password" placeholder="Enter Password" required>
                                <!-- <label for="password">password</label> -->
                            </div>
                        </div>
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                                <input type="email" class="form-control" id="emailid" name="email_id"
                                    aria-describedby="email" placeholder="Enter Email">
                                <!-- <label for="password">Email</label> -->
                            </div>
                        </div>
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                                <input type="" class="form-control" id="mobile" name="mobile"
                                    aria-describedby="password" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="12" placeholder="Enter Mobile">
                                <!-- <label for="password">Mobile</label> -->
                            </div>
                        </div>
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                                <input type="file" class="form-control" id="profile_img" name="profile_img"
                                    aria-describedby="profile" placeholder="Upload Profile">
                                <!-- <label for="profile">Upload Profile</label> -->
                            </div>
                        </div>
                        <!-- <div class="my-dropdown-with-help col-6">
                            <div class="my-dropdown">
                                <select name="new_timezone" id="timezone">
                                    <option value="Asia/Kolkata">Indian TimeZone (Asia/Kolkata)</option>
                                    <option value="America/New_York">US TimeZone (America/New_York)</option>
                                    <option value="Europe/Istanbul">Turkey TimeZone (Europe/Istanbul)</option>
                                </select>
                                <label for="password">Select User Timezone</label>
                            </div>
                        </div> -->
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary my-btn-secondary" id="close_id" data-dismiss="modal">Cancel
                    </button>
                    <input class="my-btn-primary" type="submit" value="submit" name="update_user" onclick="saveData()">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Start code to new update model popup -->




<script>
$(document).ready(function() {
    $(document).on("click", ".contact_add", function() {
        var cnumber = $(this).data("user_id");

        // Clear the fields before making the request
        $("#get_id").val("");
        $("#c_number").val("");
        $("#edit_name_c").val("");
        $("#use_did").val("");
        $("#password_new").val("");
        // $("#valuesBox").val("");
        $("#user_lable_new").val("");
        $("#user_priority").val("");
        $("#new_ext_number").val("");
        $("#emailid").val("");
        $("#mobile").val("");
        $("#profile_img").val("");

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
                    $("#get_id").val(response.id);
                    $("#c_number").val(response.user_id);
                    $("#edit_name_c").val(response.full_name);
                    $("#use_did").val(response.use_did);
                    $("#password_new").val(response.password);
                    $("#valuesBox").val(response.campaigns_id);
                    $("#user_lable_new").val(response.user_type);
                    $("#user_priority").val(response.agent_priorty);
                    $("#new_ext_number").val(response.ext_number);
                    $("#emailid").val(response.admin_email);
                    $("#mobile").val(response.admin_mobile);
                    $("#profile_img").val(response.admin_profile);
                    // $("#Organization_new").val(response.CAMPAIGN);

                    // alert(response.admin); // Show the alert box
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });
});
</script>