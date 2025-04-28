<?php
session_start();
$user_level = $_SESSION['user_level'];

if($user_level == 2 || $user_level == 6 || $user_level == 7){
    $Adminuser = $_SESSION['admin'];
    $new_user = $_SESSION['user'];
} else {
    $Adminuser = $_SESSION['user'];
}

require '../include/user.php';
include "../../../conf/db.php";
include "../../../conf/url_page.php";
$user = new user();

// $user = $Adminuser;


$usersql = "Select user,user_id, full_name, user_level, user_group, active from vicidial_users";

if($user_level == 2 || $user_level == 6 || $user_level == 7){
    $usersql2 = "SELECT * FROM `users` WHERE user_id='$new_user'"; 
} else {
    $usersql2 = "SELECT * FROM `users` WHERE admin='$Adminuser' AND user_id='$Adminuser'"; 
}

$usersresult = mysqli_query($con, $usersql2);
$usersrow = mysqli_fetch_assoc($usersresult);
 $user_name = $usersrow['full_name'];
 $user_id = $usersrow['user_id'];
 $password = $usersrow['password'];
 $admin_email = $usersrow['admin_email'];
 $admin_mobile = $usersrow['admin_mobile'];
 $admin_profile = $usersrow['admin_profile'];
 $user_timezone = $usersrow['user_timezone'];
 $api_key = $usersrow['api_key'];
 $use_did = $usersrow['use_did'] ?? '';
 $caller_email = $usersrow['caller_email'] ?? '';
 if($caller_email == '0' || $caller_email == ''){
    $get_caller_email = 'Unhide email';
 }else{
    $get_caller_email = 'Hide email';
 }
 $caller_contact = $usersrow['caller_contact'] ?? '';
 if($caller_contact == '0' || $caller_contact == ''){
    $get_caller_contact = 'Unhide Contact';
 }else{
    $get_caller_contact = 'Hide Contact';
 }

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
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100% !important;
            width: 100% !important;
            font-family: "Times New Roman", Times, serif;
        }

        .profile-container {
            /* background-color: #ffffff; */
            background-color: #e0f7fa;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
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
        .profile-contact h1, h6, h5, p{
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
<div>
    <div class="show-users ml-5">
        <div class="table-responsive my-table ml-5">
            <div class="main_box">
        <div class="profile-container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="profile-header text-center">
                      <?php if($admin_profile){ ?> 
                      <img src="<?= $image_url.$admin_profile ?>" alt="Profile Picture" class="profile-pic">
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
                        <!-- <div class="col-md-5">
                         <h6>Name :</h6> 
                         <h6>Your User ID :</h6> 
                         <h6>Password :</h6>
                         <h6>Your Use CLI :</h6>
                         <h6>Your Total Agent :</h6>
                         <h6>Your Email :</h6>
                         <h6>Your Contact :</h6>                         
                         <h6>User Timezone :</h6>
                         <h6>API key :</h6>
                        </div>
                        <div class="col-md-7">
                        <h6><?= $user_name; ?></h6> 
                        <h6><?= $user_id; ?></h6> 
                         <h6><?= $password; ?></h6>
                         <h6><?= $use_did; ?></h6>
                         <h6><?= $data_count; ?></h6>
                         <h6><?= $admin_email; ?></h6>
                         <h6><?= $admin_mobile; ?></h6>
                         <h6 class="main_time"><?= $user_timezone; ?></h6>
                         <h6 class="main_time"><?= $api_key; ?></h6>
                        </div> -->
                             
                        <div class="col-md-12">
                                        <h6>Name: <span class="float-right mr-4"><?= $user_name; ?></span></h6>
                                        <h6>Your User ID: <span class="float-right mr-4"><?= $user_id; ?></span></h6>
                                        <h6>Password: <span class="float-right mr-4"><?= str_repeat('*', strlen($password)); ?></span></h6>
                                        <h6>Your Use CLI: <span class="float-right mr-4"><?= $use_did; ?></span></h6>
                                        <h6>Your Total Agent: <span class="float-right mr-4"><?= $data_count; ?></span>
                                        </h6>
                                        <h6>Your Email: <span class="float-right mr-4"><?= $admin_email; ?></span></h6>
                                        <h6>Your Contact: <span class="float-right mr-4"><?= $admin_mobile; ?></span></h6>
                                        <h6>Hide Email from Agent Side: <span class="float-right mr-4"><?= $get_caller_email; ?></span></h6>
                                        <h6>Hide Contact Number from Agent Side: <span class="float-right mr-4"><?= $get_caller_contact; ?></span></h6>
                                        <h6  class="main_time">User Timezone :<span class="float-right mr-4"><?= $user_timezone; ?></span>
                                        <h6  class="main_time">API key :<span class="float-right mr-4"><?= $api_key; ?></span>
                                        </h6>
                                    </div>
                        </div>

                        <span class="update_text">Update Your Details 
                            <span class="badge bg-primary cursor_p text-white contact_add" data-user_id="<?php echo $user_id; ?>" data-toggle="modal" data-target="#edit_user" title="Click here and Edit user">Click</span>
                            <button class="badge bg-secondry ml-2" onclick="create_apikey('<?php echo $user_id; ?>')" title="Click Update the API key AND Reload the Page"><i class="fa fa-repeat"  style="color: black"></i></button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
        </div>

    </div>
</div>

<div class="modal fade" id="edit_user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Your Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="myForm_insert_data" method="POST" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="row">
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">

                                <input type="text" class="form-control" id="c_number" name="c_number"
                                    aria-describedby="new-user-no"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    maxlength="15" readonly>
                                <label for="new-user-number">User ID</label>
                            </div>

                        </div>
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">

                                <input type="text" class="form-control" id="edit_name_c" name="edit_name_c"
                                    aria-describedby="full-name" required>
                                <label for="full-name">Full Name</label>
                            </div>

                        </div>

                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                                <input type="text" class="form-control" id="use_did" name="use_did" aria-describedby=""
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    maxlength="12">
                                <label for="password">Use DID </label>
                            </div>
                        </div>

                        <div class="my-dropdown-with-help col-6">
                            <div class="my-dropdown">
                                <select name="add_subject" id="add_subject" onchange="addValue()">
                                    <option></option>
                                    <?php
                                        $sel_check_one = "SELECT * FROM `compaign_list` WHERE admin='$Adminuser'";
                                        $quer_check_one = mysqli_query($con, $sel_check_one);
                                        while($row_one = mysqli_fetch_assoc($quer_check_one)){
                                            $campaign_name = $row_one['compaignname'];
                                            $compaign_id = $row_one['compaign_id'];
                                            
                                            ?>
                                    <option value="<?= $compaign_id; ?>"><?= $compaign_id; ?></option>
                                    <?php }   ?>
                                </select>

                                <br><br>
                                <div id="valuesBox"></div>

                                <script>
                                function addValue() {
                                    var selectBox = document.getElementById("add_subject");
                                    var selectedIndex = selectBox.selectedIndex;
                                    var selectedValue = selectBox.options[selectedIndex].value;

                                    // Add the selected value to the box
                                    var valuesBox = document.getElementById("valuesBox");
                                    var newElement = document.createElement("div");
                                    newElement.className = "value-item";
                                    newElement.textContent = selectedValue;

                                    var removeIcon = document.createElement("span");
                                    removeIcon.className = "remove-icon";
                                    removeIcon.textContent = "✖";
                                    removeIcon.onclick = function() {
                                        removeValue(newElement, selectedValue);
                                    };

                                    newElement.appendChild(removeIcon);
                                    valuesBox.appendChild(newElement);

                                    // Remove the selected option from the dropdown
                                    selectBox.remove(selectedIndex);
                                }

                                function removeValue(element, value) {
                                    var selectBox = document.getElementById("add_subject");

                                    // Re-add the option to the dropdown
                                    var newOption = document.createElement("option");
                                    newOption.value = value;
                                    newOption.text = value;
                                    selectBox.add(newOption);

                                    // Remove the element from the valuesBox
                                    element.remove();
                                }
                                </script>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="campaign_description">Campaign Name</label>
                            </div>

                        </div>

                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">

                                <input type="password" class="form-control" id="password_new" name="password_new"
                                    aria-describedby="password" required>
                                <label for="password">password</label>
                            </div>
                        </div>
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                                <input type="email" class="form-control" id="emailid" name="email_id"
                                    aria-describedby="password">
                                <label for="password">Email</label>
                            </div>
                        </div>
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                                <input type="" class="form-control" id="mobile" name="mobile"
                                    aria-describedby="password" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="12">
                                <label for="password">Mobile</label>
                            </div>
                        </div>
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                                <input type="file" class="form-control" id="profile_img" name="profile_img"
                                    aria-describedby="password">
                                <label for="password">Upload Profile</label>
                            </div>
                        </div>

                        <div class="my-dropdown-with-help col-6">
                            <div class="my-dropdown">
                                <select name="new_timezone" id="timezone">
                                    <option value="Asia/Kolkata">Indian TimeZone (Asia/Kolkata)</option>
                                    <option value="America/New_York">US TimeZone (America/New_York)</option>
                                    <option value="Europe/Istanbul">Turkey TimeZone (Europe/Istanbul)</option>
                                </select>
                                <label for="password">Select User Timezone</label>
                            </div>
                        </div>

                        <div id="timeDisplay" class="main_time">Time will be displayed here</div>

                        <script>
                            // Function to display current time in selected timezone with seconds
                            function updateTime() {
                                var timezone = document.getElementById('timezone').value || 'Asia/Kolkata';

                                var now = new Date().toLocaleString('en-US', {
                                    timeZone: timezone,
                                    hour12: false, // 24-hour format
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    second: '2-digit'
                                });

                                document.getElementById('timeDisplay').innerHTML = "Current time: " + now + " (" + timezone + ")";
                            }

                            // Update time when timezone changes
                            document.getElementById('timezone').addEventListener('change', updateTime);

                            // Initial time display
                            updateTime();
                        </script>
<br class="bg-dark">
<div class="my-input-with-help col-6 mt-2">
                            <div class="form-group form-check">
                                  <input class="form-check-input cursor_p" type="checkbox" value="1" name="get_hide_email">
                                  <label class="form-check-label" for="flexCheckDefault">
    Hide Email from Agent Side
</label>
                            </div>
                        </div>
                        <div class="my-input-with-help col-6 mt-2">
                            <div class="form-group form-check">
                                  <input class="form-check-input cursor_p" type="checkbox" value="1" name="hide_number">
                                  <label class="form-check-label" for="flexCheckDefault"> 
    Hide Contact Number from Agent Side
</label>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary my-btn-secondary close_model" data-dismiss="modal" >Cancel
                    </button>
                    <input class="my-btn-primary" type="button" value="submit" onclick="saveData()">
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Add user name for user id modal ends here -->
<!-- Your modal HTML code -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $(document).on("click", ".contact_add", function() {
        var cnumber = $(this).data("user_id");

        // Clear the fields before making the request
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
        $("#hide_email").val("");
        $("#hide_number").val("");

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
                    // $("#hide_email").val(response.caller_email);
                    // $("#hide_number").val(response.caller_contact);
                    $("#hide_email").prop("checked", response.caller_email === "on"); // Assuming "1" means checked
                   $("#hide_number").prop("checked", response.caller_contact === "on"); // Assuming "1" means checked
        

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

</script>
<script>
$(document).ready(function() {
    // Add an event listener to the Close button
    $("#closeModalButton").on("click", function() {
        // Find the modal and close it
        $("#staticBackdrop").modal("hide");
    });
});
</script>
<script>
$(document).ready(function() {
    $(document).on("click", ".show_break_report", function() {
        // $(document).on("click", ".agent_dashboard.php", function() {
        var user_id = $(this).data("user_id");
        // Assuming you want to redirect to another page
        // window.location.href = "?c=user&v=user_break_status&user_id=" + user_id;
        window.location.href = "?c=user&v=agent_dashboard&user_id=" + user_id;
    });
});
</script>
<script>
function saveData() {
    var formData = new FormData(document.getElementById('myForm_insert_data'));

    // Collect values from valuesBox
    var valuesBox = document.getElementById('valuesBox');
    var valueItems = valuesBox.getElementsByClassName('value-item');
    var values = [];
    for (var i = 0; i < valueItems.length; i++) {
        values.push(valueItems[i].textContent.replace('✖', '').trim());
    }

    // Add the values to the formData
    formData.append('selected_values', JSON.stringify(values));
    $.ajax({
        type: 'POST',
        url: "pages/user/update_user_profile.php", // Replace with the actual server-side file to handle data insertion
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            // alert(response);
            // console.log(response);

            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Your data has been saved",
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
        // Trigger the click event on the button with the 'close_model' class
        $(".close_model").click();
    }); 

        },
        error: function(error) {
            // alert('sorry');
            Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Your data is not inserted",
                showConfirmButton: false,
                timer: 1500
            });
        }
    });
}
</script>
<script>
$(document).ready(function() {
    $(document).on("click", ".remove_user", function() {
        var user_id = $(this).data("user_id");
        var user_priorty = $(this).data("user_priorty");

        Swal.fire({
            title: "Are you sure?",
            text: "This data will be deleted",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href =
                    `pages/new_action/agent_user_delete.php?user_id=${user_id}&user_priorty=${user_priorty}`;
            }
        });
    });
});
</script>
<script>
    function create_apikey(user_id) {
        $.ajax({
            type: 'POST',
            url: "pages/user/create_apikey.php", // The server-side PHP file that creates the API key
            data: { user_id: user_id },  // Pass the user_id to the PHP file
            success: function (response) {
                location.reload();  // Reload the page after the API key is created
            }
        });
    }

</script>