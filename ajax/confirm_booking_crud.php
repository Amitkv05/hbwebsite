<?php

require('../admin/inc/db_config.php');
require('../admin/inc/essentials.php');

if(isset($_POST['check_availability']))
{
    $frm_data = filteration($_POST);
    $status = "";
    $result = "";

    // check in and out validations

    $today_date = new DateTime(date("Y-m-d"));
    $check_in_date = new DateTime($frm_data['check_in']);
    $check_out_date = new DateTime($frm_data['check_out']);

    if($check_in_date ==$check_out_date){
        $status = 'check_in_out_equal';
        $result = json_encode(["status"=>$status]);
    }
    else if($check_out_date < $check_in_date){
        $status = 'check_out_earlier';
        $result = json_encode(["status"=>$status]);
    }
    else if($check_in_date < $today_date){
        $status = 'check_in _earlier';
        $result = json_encode(["status"=>$status]);
    }

    // check booking availavility if status os blank else return the error

    if($status!='')
    {
        echo $result;
    }
    else{
        session_start();
        $_SESSION['rooms'];
        
        // run query to check rooms is available or not
        
        $count_days = date_diff($check_in_date,$check_out_date)->days;
        $payment = $_SESSION['rooms']['price']* $count_days;
        
        $_SESSION['rooms']['payment'] = $payment;
        $_SESSION['rooms']['available'] = true;
        
        $result = json_encode(["status"=>'available', "days"=>$count_days,"payment"=>$payment]);
        echo $result;
    }
}

?>
