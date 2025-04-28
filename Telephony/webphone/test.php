<?php
include "../conf/db.php";


$stmtA = "UPDATE servers SET rebuild_conf_files='Y' where generate_vicidial_conf='Y' and active_asterisk_server='Y' and server_ip='192.168.125.241'"; 
// $rslt=mysql_to_mysqli($stmtA, $link);
$query = mysqli_query($conn, $stmtA);
if(isset($query)){
    echo "OK";
}else{
    echo "Not OK";
} 

?>