<?php
if(isset($_GET['id'])){
    $id=$_GET['id'];
    $sql="SELECT * FROM vicidial_users where user_id =".$id;
   $result=mysqli_query($conn, $sql);
   $user=mysqli_fetch_assoc($result);

}
?>

<!-- Code goes here -->
<div class="user-stats">
    <!-- back button with title -->
    <div class="back-with-title">
        <a href="./show_users.html"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        <h5> User Stats for <?=$user['user']?></h5>
    </div>

    <!-- form starts here -->
    <form action="">
        <div class="row my-card align-items-center">

            <!-- first input for date -->
            <div class="my-input-with-help col-12 col-md-6 col-lg-3">
                <div class="form-group my-input">

                    <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control"
                           id="begin_date" name="begin_date" aria-describedby="begin_date" required>
                    <label for="begin_date">From Date</label>
                </div>
            </div>

            <div class="my-input-with-help col-12 col-md-6 col-lg-3">
                <div class="form-group my-input">

                    <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control"
                           id="end_date" name="end_date" aria-describedby="end_date" required>
                    <label for="end_date">To Date</label>
                </div>
            </div>

            <!-- second input for user ID -->
            <!-- <div class="my-input-with-help col-12 col-md-6 col-lg-3">
                <div class="form-group my-input">

                    <input type="text" class="form-control" id="call_status" name="call_status"
                           aria-describedby="call_status" required>
                    <label for="call_status">Call Status</label>
                </div>
            </div> -->

            <!-- archived data check box -->
            <!-- <div class="check align-self-center">
                <input type="checkbox" name="search_archived_data" id="search_archived_data">
                <label for="search_archived_data">Search archived data</label>
            </div> -->

            <input type="submit" value="Submit">

        </div>
    </form>

    <div class="table-nav">
        <a href="?c=user&v=user-stats&page=talk_time" >TALK TIME AND STATUS</a>
        <a href="?c=user&v=user-stats&page=loginlogout">LOGIN/LOGOUT TIME</a>
        <a href="?c=user&v=user-stats&page=timeclock">TIMECLOCK</a>
        <a href="?c=user&v=user-stats&page=closer">CLOSER IN-GROUP</a>
        <a href="?c=user&v=user-stats&page=outbound">OUTBOUND CALL</a>

        <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
           aria-expanded="false">
            <img src="../assets/images/common-icons/eva_menu-arrow-outline.png" alt="">
        </a>

        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <a class="dropdown-item" href="?c=user&v=user-stats&page=outboundemail">Outbound Emails</a>
            <a class="dropdown-item" href="?c=user&v=user-stats&page=inboundcloser">Inbound Closer Calls</a>
            <a class="dropdown-item" href="?c=user&v=user-stats&page=agent">Agent Activity</a>
            <a class="dropdown-item" href="?c=user&v=user-stats&page=recordings">Recordings</a>
            <a class="dropdown-item" href="?c=user&v=user-stats&page=manual">Manual Outbound Calls</a>
            <a class="dropdown-item" href="?c=user&v=user-stats&page=leadSearch">Lead Searches</a>
            <a class="dropdown-item" href="?c=user&v=user-stats&page=previewlead">Preview Lead Skips</a>
            <a class="dropdown-item" href="?c=user&v=user-stats&page=agentLead">Agent Lead Switches</a>
            <a class="dropdown-item" href="?c=user&v=user-stats&page=manager">Manager Pause Code Approvals</a>
        </div>

    </div>

    <div class="my-card-with-title">
        <?php
        if(isset($_GET['page']))
        {
            $page=$_GET['page'];
            include 'stats/'.$page.".php";
        }else{
            include 'stats/talk_time.php';
        }

        ?>

</div>
<!-- Code goes here -->