<?php

class user
{
    public $user;
    public $full_name;
    public $user_level;
    public $user_group;
    public $pass;


    public function userGroup()
    {
        global $conn;
        $sql = "SELECT * FROM vicidial_user_groups";
        $result = mysqli_query($conn, $sql);
        return $result;
    }
}
