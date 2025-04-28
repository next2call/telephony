<?php

function sql_execute($sql)
{
    global $conn;
    $result = mysqli_query($conn, $sql);
    $data = $result->fetch_assoc();
    return $data;
}


function sql_count($sql)
{

    global $conn;
    $result=mysqli_query($conn,$sql);
    $count = mysqli_num_rows($result);;
    return $count;
}

function renderBody(){
    $pages=$_GET['p'];
}





?>

<script type="text/javascript">
    function myClock() {
        setTimeout(function () {
            const d = new Date();
            const n = d.toLocaleTimeString();
            document.getElementById("demo").innerHTML = n;
            myClock();
        }, 1000)
    }

    myClock();
</script>