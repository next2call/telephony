<?php

$cdate = date("Y-m-d");
$sql_agents="SELECT * FROM `vicidial_live_agents`";
$sql_agents_call_today="SELECT * FROM vicidial_auto_calls where status NOT LIKE 'SENT'";


$Current_user='select * from vicidial_users where user_id='.$_SESSION['user_id'];
$users='select * from vicidial_users';
$user_active='select * from vicidial_users where active="Y"';
$user_inactive='select * from vicidial_users where active="N"';



$count_campaigns='SELECT * from vicidial_campaigns';
$count_campaigns_active='SELECT * from vicidial_campaigns where active="Y"';
$count_campaigns_inactive='SELECT * from vicidial_campaigns where active="N"';

$count_lists='SELECT * from vicidial_lists';
$count_lists_active='SELECT * from vicidial_lists where active="Y"';
$count_lists_inactive='SELECT * from vicidial_lists where active="N"';


$count_dids='SELECT * from vicidial_inbound_dids';
$count_dids_active='SELECT * from vicidial_inbound_dids where did_active="Y"';
$count_dids_inactive='SELECT * from vicidial_inbound_dids where did_active="N"';



$query_active_call = "SELECT * FROM vicidial_auto_calls";
$query_calling = "SELECT * FROM `live_channels` WHERE `extension` LIKE 'ring'";