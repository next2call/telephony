<?php
session_start();
include "../../../conf/db.php";
include "../../../conf/Get_time_zone.php";

$_SESSION['page_start'] = 'Report_page';  

$user_level = $_SESSION['user_level'];

if($user_level == 2 || $user_level == 7 || $user_level == 6){
    $user = $_SESSION['admin'];
    $new_user = $_SESSION['user'];
    $user_sql2 = "SELECT campaigns_id FROM `users` WHERE admin='$user' AND user_id='$new_user'"; 
    $user_query = mysqli_query($con, $user_sql2);
    if(!$user_query) {
        die("Query Failed: " . mysqli_error($con));
    }
    $row_compain = mysqli_fetch_assoc($user_query);
    $new_campaign = $row_compain['campaigns_id'];

} else {
    $user = $_SESSION['user'];
}


?>
 <style>
        /* Style the audio player container */
        .audio-container {
            display: flex;
            align-items: center;
        }

        /* Style the play/pause button */
        .control {
            background: none;
            border: none;
            cursor: pointer;
        }

        /* Style the Download button and its icon */
        .download-button {
            background: none;
            border: none;
            cursor: pointer;
        }

        /* Adjust the size of the icons */
        .control span, .download-button i {
            font-size: 24px; /* Change the size as needed */
        }
        .select_date{
          margin-top: -2rem;
        }
        .img_answer{
          height: 1.2rem;
          width: 1.1rem;
        }
        table td {
            padding: 2px 10px !important;
        }

        .data_btn {
        background:rgb(21, 94, 230);
        color:rgb(234, 239, 249);
        font-weight: bold;
        font-size: 10px;
        line-height: 15px;
        /* color: #637381; */
        /* background: transparent; */
        border-radius: 10px;
        padding: 5px;
        margin-right: 25px;
        transition: 0.3s all ease-in-out;
        margin-top: 10px;
        display: inline-block;
    }

    </style>

 <div class="user-stats">



    <div class="my-card-with-title ">
    <div class="title-bar">
    <h4>Create and Send Emails to Clients</h4>
    <!-- <a href="#"><i class="fa fa-download" aria-hidden="true"></i></a> -->
    <a class="data_btn text-white" href="#create-email" data-toggle="modal" data-target="#create-email">
                    <i class="fa fa-envelope" aria-hidden="true"></i> Create Email
                </a>
    </div>
<!-- ################################################### -->
<div class="">
<table id="employee_grid" class="table table-bordered">
                <thead>
                    <tr>
                    <th scope="col"><a href="#">Sr.</a></th>
                    <th scope="col"><a href="#">Clients Email</a></th>
                    <th scope="col"><a href="#">Subjact</a></th>
                    <th scope="col"><a href="#">Send Date</a></th>
                    <th scope="col"><a href="#">Action</a></th>
                    </tr>
                </thead>
            </table>
    </div>

<!-- ################################################### -->

</div>
</div>

<div class="modal fade" id="create-email" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div style="min-width: 1080px;" class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="myForm_insert_data" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <!-- <div class="col-12 col-md-6 col-lg-12 mb-5">
                        <div class="card p-3">
                                <h6>Use this tag for merge Email</h6>
                                <p>[CUSTOMER_NAME], [CUSTOMER_PHONE], [CUSTOMER_PHONE_MASK], [CUSTOMER_EMAIL]</p>
                                </div>
                        </div> -->
                        <div class="my-input-with-help col-12 col-md-6 col-lg-6">
                                           <div class="form-group my-input"> 
                                           <input type="text" class="form-control" name="to_email"
                                                        id="to_email" required>
                                                    <label for="to-email">To Email:</label>
                                            </div>

                                        </div>
                        <div class="my-input-with-help col-12 col-md-6 col-lg-6">
                                           <div class="form-group my-input"> 
                                           <input type="text" class="form-control" name="subject_name"
                                                        id="subject_name" required>
                                                    <label for="full-name">Subject:</label>
                                            </div>

                                        </div>
                        
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group my-input">
                                <textarea class="ckeditor form-control" rows="5" name='email_body'
                                    id="con_name-d" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary my-btn-secondary"
                        data-dismiss="modal">Cancel</button>
                    <!-- <input class="my-btn-primary" type="submit" value="submit" name="create_speech"> -->
                    <button type="button" class="btn btn-primary my-btn-primary" onclick="saveData()"> <i class="fa fa-paper-plane" aria-hidden="true"></i> Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="view_email" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View Email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ml-5">
                <h6 class="text-primary">To Email</h6>
                <p id="to_emails"></p>
                <hr class="color-black">
                <h6 class="text-primary">Subject</h6>
                <p id="subject"></p>
                <hr class="color-black">
                <h6 class="text-primary">Email Body</h6>
                <p id="email_body"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary my-btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- jQuery script for clicktocall functionality -->
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
            "url": "pages/user/datatables-ajax/get_data_email.php", // PHP script that fetches data
            "type": "POST",
            "error": function() {
                $("#employee_grid_processing").css("display", "none");
            }
        },
     "columns": [
    { "data": "sr" },
    { "data": "to_emails" },
    { "data": "subject" },
    { "data": "Create_time" },
    { 
        "data": "id", 
        "render": function(data, type, row) {
            return `
                <a href="#" data-toggle="modal" data-target="#view_email"  
                   class="btn btn-outline-secondary btn-sm" 
                   onclick="viewEmail(${data})">
                   <i class="fa fa-eye cursor_p text-info"></i>
                </a>
            `;
        }
    }
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
    <script>
 function saveData() {
    // Update CKEditor instance before sending data
    for (let instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }

    var formData = new FormData(document.getElementById("myForm_insert_data"));

    // Debugging: Check what is being sent
    console.log("Sending Email Body:", formData.get("email_body"));

    $.ajax({
        url: "pages/email/data_save.php", // Change this to the actual PHP file handling the request
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            if (response.trim() === "Email sent successfully") {
                // Show success alert
                Swal.fire({
                                icon: "success",
                                title: "Email Sent Successfully",
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            }).then(() => {
                    // Close the modal programmatically
                    $("#create-email").modal("hide");
                    $("#create-email").find("form")[0].reset();
                });
            } else {
                // Handle failure scenario
                Swal.fire({
                                icon: "error",
                                title: response || "An error occurred while sending Emails",
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            });
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", xhr.responseText);
        }
    });
}

</script>
<script>
function viewEmail(id) {
    // Alert the selected ID
    // alert("Selected ID: " + id);

    // Clear previous data
    $("#to_emails").text("");
    $("#subject").text("");
    $("#email_body").html(""); // Use .html() for formatted content

    $.ajax({
        url: "pages/email/get_data.php",
        type: "POST",
        data: { id: id },
        dataType: "json",
        success: function (response) {
            if (response.error) {
                alert(response.error);
            } else {
                console.log(response); // Debugging purpose

                // Populate the fields with the response
                $("#to_emails").text(response.to_emails);
                $("#subject").text(response.subject);
                $("#email_body").html(response.email_body); // Use .html() for formatted content

                // Show the modal
                $("#view_email").modal("show");
            }
        },
        error: function (xhr, status, error) {
            console.log(error);
        }
    });
}



</script>


