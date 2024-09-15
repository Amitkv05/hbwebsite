<?php
include("admin/inc/db_config.php");
if (isset($_POST['request'])) {

    $request = $_POST['name'];
    // $frm_data = filteration($_POST);


    $query = "SELECT * FROM `package` WHERE `name` ='$request'";
    $result = mysqli_query($con, $query);
    $count = mysqli_num_rows($result);


    if($package ==""){
        // $package = getAllProducts();
    }else{
        // $package = getAllProductsByCategory($package);
    }
    echo json_encode($package);
}

?>