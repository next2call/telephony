<?php

class sql_operation
{
    public function sql_execution($sql)
    {
        global $conn;
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row;
    }

    public function sql_count($sql)
    {
        global $conn;
        $result = mysqli_query($conn, $sql);
        $row = mysqli_num_rows($result);
        return $row;
    }
}