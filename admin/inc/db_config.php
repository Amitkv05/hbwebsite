<?php 
    $hname='localhost';
    $uname = 'root';
    $pass = '';
    $db = 'hbwebsite';

    $con = mysqli_connect($hname,$uname,$pass,$db);

    // booking database
    $db_name = 'mysql:host=localhost;dbname=hbwebsite';
    $db_user_name = 'root';
    $db_user_pass = '';
 
    $conn = new PDO($db_name, $db_user_name, $db_user_pass);

    if(!$con){
        die("cannot connect to Database" . mysqli_connect_error());
    }
    function create_unique_id(){
        $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $rand = array();
        $length = strlen($str) - 1;
  
        for($i = 0; $i < 20; $i++){
           $n = mt_rand(0, $length);
           $rand[] = $str[$n];
        }
        return implode($rand);
     }

    function filteration($data)
    {
        foreach($data as $key => $value){
            $value = trim($value);
            $value = stripslashes($value);
            $value = strip_tags($value);
            $value = htmlspecialchars($value);
            $data[$key] = $value;
        }
        return $data;
    }

    function selectAll($table)
    {
        $con = $GLOBALS['con'];
        $res = mysqli_query($con,"SELECT * FROM $table");
        return $res;
    }

    function select($sql,$values,$datatypes)
    {
        $con = $GLOBALS['con'];
        if($stmt = mysqli_prepare($con,$sql))
        {
            mysqli_stmt_bind_param($stmt,$datatypes,...$values);
            if(mysqli_stmt_execute($stmt)){
                $res = mysqli_stmt_get_result($stmt);
                mysqli_stmt_close($stmt);
                return $res;
            }
            else{
                mysqli_stmt_close($stmt);
                die("Query cannot be executed - Select");
            }
        }
        else{
            die("Query cannot be executed - Select");
        }
    }

    function update($sql,$values,$datatypes)
    {
        $con = $GLOBALS['con'];
        if($stmt = mysqli_prepare($con,$sql))
        {
            mysqli_stmt_bind_param($stmt,$datatypes,...$values);
            if(mysqli_stmt_execute($stmt)){
                $res = mysqli_stmt_affected_rows($stmt);
                mysqli_stmt_close($stmt);
                return $res;
            }
            else{
                mysqli_stmt_close($stmt);
                die("Query cannot be executed - Update");
            }
        }
        else{
            die("Query cannot be executed - Update");
        }
    }
    function insert($sql,$values,$datatypes)
    {
        $con = $GLOBALS['con'];
        if($stmt = mysqli_prepare($con,$sql))
        {
            mysqli_stmt_bind_param($stmt,$datatypes,...$values);
            if(mysqli_stmt_execute($stmt)){
                $res = mysqli_stmt_affected_rows($stmt);
                mysqli_stmt_close($stmt);
                return $res;
            }
            else{
                mysqli_stmt_close($stmt);
                die("Query cannot be executed - Insert");
            }
        }
        else{
            die("Query cannot be executed - Insert");
        }
    }

    // Deleting members form list

    function delete($sql,$values,$datatypes)
    {
        $con = $GLOBALS['con'];
        if($stmt = mysqli_prepare($con,$sql))
        {
            mysqli_stmt_bind_param($stmt,$datatypes,...$values);
            if(mysqli_stmt_execute($stmt)){
                $res = mysqli_stmt_affected_rows($stmt);
                mysqli_stmt_close($stmt);
                return $res;
            }
            else{
                mysqli_stmt_close($stmt);
                die("Query cannot be executed - Deleted");
            }
        }
        else{
            die("Query cannot be executed - Deleted");
        }
    }
?>