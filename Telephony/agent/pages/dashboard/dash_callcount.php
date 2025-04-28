<?php
session_start();
$Adminuser = $_SESSION['user'];
include "../../../conf/db.php";

class CallCount {
    private $con;
    private $Adminuser;
    private $date1;

    public function __construct($con, $Adminuser) {
        $this->con = $con;
        $this->Adminuser = $Adminuser;
        $this->date1 = date("Y-m-d");
    }

    public function getCallCounts($filter) {
        if ($filter == 'today') {
            $condition = "AND start_time LIKE '%$this->date1%'";
        } elseif ($filter == 'all') {
            $condition = "";
        } else {
            $condition = "AND start_time LIKE '%$this->date1%'";
        }

        return [
            'total_call' => $this->getTotalCalls($condition),
            'answer_call' => $this->getAnswerCalls($condition),
            'cancel_call' => $this->getCancelCalls($condition),
            'congetion_call' => $this->getCongetionCalls($condition),
            'getqueueCalls' => $this->getqueueCalls($condition),
            'idial_agents' => $this->getIdleAgents($condition)
            // 'weatingtime' => $this->weatingtime($condition)
        ];
    }

    private function getTotalCalls($condition) {
        $query = "SELECT * FROM cdr WHERE (call_from='$this->Adminuser' || call_to='$this->Adminuser') $condition";
        $result = mysqli_query($this->con, $query);
        return mysqli_num_rows($result);
        // die();
    }

    private function getAnswerCalls($condition) {
        $query = "SELECT * FROM cdr WHERE status='ANSWER' AND (call_from='$this->Adminuser' || call_to='$this->Adminuser') $condition";
        $result = mysqli_query($this->con, $query);
        return mysqli_num_rows($result);
    }

    private function getCancelCalls($condition) {
        $query = "SELECT * FROM cdr WHERE status='CANCEL' AND (call_from='$this->Adminuser' || call_to='$this->Adminuser') $condition";
        $result = mysqli_query($this->con, $query);
        return mysqli_num_rows($result);
    }

    private function getCongetionCalls($condition) {
        $query = "SELECT * FROM cdr WHERE status!='ANSWER' AND status!='CANCEL' AND (call_from='$this->Adminuser' || call_to='$this->Adminuser') $condition";
        $result = mysqli_query($this->con, $query);
        return mysqli_num_rows($result);
    }

    private function getqueueCalls($condition) {
        $query = "SELECT COUNT(*) as call_to
        FROM live WHERE (status = 'Ringing' OR Agent = 'NOAGENT') 
        AND direction = 'inbound'";
        $result = mysqli_query($this->con, $query);
        $row = mysqli_fetch_assoc($result);
        return $row['call_to'];

    }

    private function getIdleAgents($condition) {
        $sel = "SELECT users.user_id 
                FROM users 
                JOIN login_log ON users.user_id = login_log.user_name 
                WHERE (login_log.status = '1' AND login_log.log_in_time LIKE '%$this->date1%') 
                AND users.user_id != '$this->Adminuser' AND users.admin = (SELECT admin FROM users WHERE user_id = '$this->Adminuser')";
        
        $sel_query = mysqli_query($this->con, $sel);
        $total_users = 0;
    
        while ($row_data = mysqli_fetch_array($sel_query)) {
            $login_user = $row_data['user_id'];
            
            $query = "SELECT COUNT(DISTINCT login_log.user_name) AS user_count 
                      FROM login_log 
                      JOIN ( 
                          SELECT user_name 
                          FROM break_time 
                          WHERE break_status != '1' 
                          AND start_time LIKE '%$this->date1%' 
                          AND user_name NOT IN (
                              SELECT user_name 
                              FROM break_time 
                              WHERE break_status = '1' 
                              AND start_time LIKE '%$this->date1%'
                          )
                          ORDER BY start_time DESC 
                      ) AS latest_break_time 
                      ON login_log.user_name = latest_break_time.user_name 
                      WHERE login_log.user_name = '$login_user' 
                      AND login_log.status = '1' 
                      AND login_log.log_in_time LIKE '%$this->date1%'";
            
            $result = mysqli_query($this->con, $query);
            $row = mysqli_fetch_assoc($result);
    
            // Accumulate the total count of users
            $total_users += $row['user_count'];
        }
    
        // Return the total count
        return $total_users;
    }

    // private function getinboundCalls($condition) {
    //     $query = "SELECT * FROM cdr WHERE direction='inbound' AND (call_from='$this->Adminuser' || call_to='$this->Adminuser') $condition";
    //     $result = mysqli_query($this->con, $query);
    //     return mysqli_num_rows($result);
    // }


}

// Usage example:
$all_data_check = $_REQUEST['filter_data'];
// $all_data_check = 'filter_data';
$callCount = new CallCount($con, $Adminuser);
$counts = $callCount->getCallCounts($all_data_check);

echo json_encode($counts);
?>
