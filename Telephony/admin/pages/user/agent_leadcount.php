<?php
session_start();
include "../../../conf/db.php";

date_default_timezone_set('Asia/Kolkata'); // Set the timezone to Kolkata

$Adminuser = $_SESSION['user'];
$campaign_id = $_SESSION['T_L_campaigns_id']; 
$filter_data = $_SESSION['filter_data'];
$filter_campaign = $_SESSION['filter_campaign'];
$user_level = $_SESSION['user_level'];
$user_id = $_SESSION['veiw_agent_xyz'];


$sel = "SELECT  SUM(target) as total_target FROM `users` WHERE user_id='$user_id'";
//   die();
$sel_sqli = mysqli_query($con, $sel);
$row = mysqli_fetch_array($sel_sqli);
$month_target = $row['total_target'];
 


class CallCount
{
    private $con;
    private $Adminuser;
    private $campaign_id;
    private $date1;
    private $yesterday;
    private $weekStart;
    private $monthStart;
    private $threeMonthsAgo;
    private $sixMonthsAgo;

    public function __construct($con, $Adminuser, $campaign_id)
    {
        $this->con = $con;
        $this->Adminuser = $Adminuser;
        $this->campaign_id = $campaign_id;
        $this->date1 = date("Y-m-d");
        $this->yesterday = date('Y-m-d', strtotime('-1 day'));
        $this->weekStart = date('Y-m-d', strtotime('last week'));
        $this->monthStart = date('Y-m-d', strtotime('-1 month'));
        $this->threeMonthsAgo = date('Y-m-d', strtotime('-3 months'));
        $this->sixMonthsAgo = date('Y-m-d', strtotime('-6 months'));
    }

    public function getCallCounts($filter_data, $month_target, $check_campaign)
    {
        $one_day_target = $month_target / 30; 
        switch ($filter_data) {
            case 'today':
                $condition = "AND enquiry_date LIKE '%$this->date1%'";
                 $days = 1;
                 $target = $one_day_target;
                break;
            case 'yesterday':
                $condition = "AND enquiry_date LIKE '%$this->yesterday%'";
                $days = 1;
                $target = $one_day_target;
                break;
            case 'weekly':
                $condition = "AND DATE(enquiry_date) BETWEEN '$this->weekStart' AND '$this->date1'";
                $days = 7;
                $target = $one_day_target * 7;
                break;
            case 'monthly':
                $condition = "AND DATE(enquiry_date) BETWEEN '$this->monthStart' AND '$this->date1'";
                $days = 30;
                $target = $month_target;
                break;
            case 'threemonthago':
                $condition = "AND DATE(enquiry_date) BETWEEN '$this->threeMonthsAgo' AND '$this->date1'";
                $days = 90;
                $target = $month_target * 3;
                break;
            case 'sixmonthago':
                $condition = "AND DATE(enquiry_date) BETWEEN '$this->sixMonthsAgo' AND '$this->date1'";
                $days = 180;
                $target = $month_target * 6;
                break;
            case 'all':
                $condition = "";
                $target = $month_target;
                $days = 30;
                break;
            default:
                $condition = "AND enquiry_date LIKE '%$this->date1%'";
                $days = 30;
                $target = $month_target;
                break;
        }
        // $check_campaign = !empty($this->campaign_id) ? "campaign_id = '$this->campaign_id'" : "1=1";
        $target_lead_percentage = round(($this->actual_revanueLead($condition, $check_campaign) / $target) * 100);
        return [
            'total_lead' => $this->getTotalLead($condition, $check_campaign),
            'pending_lead' => $this->getPendingLead($condition, $check_campaign),
            'new_lead' => $this->getNewLead($condition, $check_campaign),
            'close_lead' => $this->getCloseLead($condition, $check_campaign),
            'refunds_lead' => $this->getRefundsLead($condition, $check_campaign),
            'prank_leads' => $this->getPrankLead($condition, $check_campaign),
            'target_lead' => $target_lead_percentage . " %",
            'target_deficit' => 100 - $target_lead_percentage . " %",
            'rpc' => round($this->actual_revanueLead($condition, $check_campaign) / $days) . " $",
            'chargeback' => round(($this->getchargebackLead($condition, $check_campaign) / $this->actualLead($condition, $check_campaign)) * 100) . "",
            'chargeback_lead' => $this->getchargebackLead($condition, $check_campaign),
        ];
    }

    private function getTotalLead($condition, $check_campaign)
    {
        $query = "SELECT * FROM enquiry_form WHERE $check_campaign $condition";
        $result = mysqli_query($this->con, $query);
        return mysqli_num_rows($result);
    }

    private function getPendingLead($condition, $check_campaign)
    {
        $query = "SELECT * FROM enquiry_form WHERE Lead_status='PENDING' AND order_status!='Charge Back' AND order_status != 'Prank' AND order_status != 'Wrong Number' AND $check_campaign $condition";
        $result = mysqli_query($this->con, $query);
        return mysqli_num_rows($result); 
    }

    private function getNewLead($condition, $check_campaign)
    {
        $query = "SELECT * FROM enquiry_form WHERE Lead_status='NEW' AND order_status!='Charge Back' AND order_status != 'Prank' AND order_status != 'Wrong Number' AND $check_campaign $condition";
        $result = mysqli_query($this->con, $query);
        return mysqli_num_rows($result);
    }

    private function getCloseLead($condition, $check_campaign)
    {
      $query = "SELECT * FROM enquiry_form WHERE Lead_status='CLOSE' AND order_status!='Charge Back' AND order_status != 'Prank' AND order_status != 'Wrong Number' AND $check_campaign $condition";
        $result = mysqli_query($this->con, $query);
        return mysqli_num_rows($result);
    }

    private function getRefundsLead($condition, $check_campaign)
    {
        $query = "SELECT * FROM enquiry_form WHERE order_status='Refund' AND $check_campaign $condition";
        $result = mysqli_query($this->con, $query);
        return mysqli_num_rows($result);
    }

    private function getPrankLead($condition, $check_campaign)
    {
        $query = "SELECT * FROM enquiry_form WHERE order_status='Prank' AND $check_campaign $condition";
        $result = mysqli_query($this->con, $query);
        return mysqli_num_rows($result);
    }
    private function actual_revanueLead($condition, $check_campaign)
    {
         $query = "SELECT SUM(price) as total_price FROM enquiry_form 
          WHERE order_status != 'Refund' 
             AND order_status != 'Prank' 
             AND order_status != 'Wrong Number' 
             AND campaign_id != 'Support' 
             AND $check_campaign $condition";
        $result = mysqli_query($this->con, $query);
        $row = mysqli_fetch_assoc($result);
        return $row['total_price'];
    }
    private function getchargebackLead($condition, $check_campaign)
    {
        $query = "SELECT * FROM enquiry_form WHERE order_status='Charge Back' AND $check_campaign $condition";
        $result = mysqli_query($this->con, $query);
        return mysqli_num_rows($result);
    }
    private function actualLead($condition, $check_campaign)
    {
          $query = "SELECT * FROM enquiry_form WHERE order_status != 'Refund' AND order_status != 'Prank' AND order_status != 'Wrong Number' AND $check_campaign $condition";
        $result = mysqli_query($this->con, $query);
        return mysqli_num_rows($result);
    }
}

// Usage example:
$all_data_check = $_SESSION['filter_data'];
$callCount = new CallCount($con, $Adminuser, $campaign_id);
$counts = $callCount->getCallCounts($all_data_check, $month_target, $check_campaign);

echo json_encode($counts);
?>
