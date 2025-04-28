<?php
$camp=new campaign();
if(isset($_GET['id'])){
    $id=$_GET['id'];
}

if(isset($_POST['submitstatus'])){
    $abc=$_POST;

// foreach ($abc as $k->$v){
//     echo $k;
//     echo "<br>";
// }

// foreach($abc as $k=>$v){
//         echo '$camp';
//         echo "->";
//         echo $k;
//         echo "= ";
//         echo '$_POST['.$k.']';
//         echo "<br>";
//     }

$camp->group= $_POST['group'];
$camp->status= $_POST['status'];
$camp->date_with_hour= $_POST['date_with_hour'];


$sql="UPDATE `vicidial_campaigns` SET group='".$camp->group.",status='".$camp->status."'
Where ";

$result=mysqli_query($conn,$sql);

}
?>



<!--===========Group Hourly Stats: New Page Tazbin Ahad	 -->
<div class="user-stats group-hourly-stats">
    <!-- back button with title -->
    <div class="back-with-title">
        <a href="./show_users.html"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        <h5>Group Hourly Stats</h5>
    </div>

    <!-- form starts here -->
    <form action="" method="POST">
        <div class="my-card-with-title">
            <div class="title-bar">
                <h4>Please enter the group you want to get hourly stats for:</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                        <div class="my-dropdown">
                            <select name="group" id="group">
                                <option selected="" value="ADMIN">ADMIN - VICIDIAL ADMINISTRATORS</option>
                                <option selected="" value="AGENTS">AGENTS - VICIDIAL AGENTS</option>
                                <option selected="" value="CUSTOM-ADMIN">CUSTOM-ADMIN - CUSTOM-ADMIN</option>
                            </select>
                            <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                            <label for="group"
                                style="font-size: 100%; transform: translate3d(0px, -40%, 0px); opacity: 0.5; background-color: transparent; padding: 15px 0px 0px 13px; z-index: 0;">group</label>
                        </div>
                    </div>

                    <div class="my-input-with-help col-12 col-md-6 col-lg-3 ">
                        <div class="form-group my-input">

                            <input type="text" class="form-control" id="status" name="status" aria-describedby="status"
                                required>
                            <label for="status">Status</label>
                        </div>
                    </div>

                    <div class="my-input-with-help col-12 col-md-6 col-lg-3 ">
                        <div class="form-group my-input">

                            <input type="text" class="form-control" id="date_with_hour" name="date_with_hour"
                                aria-describedby="date_with_hour" required>
                            <label for="date_with_hour">Date with hour</label>
                        </div>
                    </div>

                    <input type="submit" value="Submit" class=" my-btn-primary" name="submitstatus">
                </div>

            </div>
        </div>
    </form>
</div>
<!--===========Group Hourly Stats: New Page Tazbin Ahad	 -->