<?php
if (isset($_POST["login"])) {
    $query = "SELECT * FROM `users` WHERE `email` = '$_POST[username]' OR `username`= '$_POST[username]' ";
    $result = mysqli_query($con, $query);
    
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $result_fetch = mysqli_fetch_assoc($result);
            if(password_verify($_POST['password'],$result_fetch['password']))
            {
                #if passwordd matched
                $_SESSION['logged_in']=true;
                $_SESSION['username']=$result_fetch['username'];
                redirect('index.php');
            }
            else {
                #if password does not matched
                echo "
                <script>
                    alert('Incorrect Password');
                    redirect('index.php');
                </script>
            ";
            }
        }
        else {
            echo "
                <script>
                    alert('Email or Username not registered');
                    redirect('index.php');
                </script>
            ";
        }
    } else {
        echo "
            <script>
                alert('cannot run Query');
                redirect('index.php');
            </script>
        ";
    }
}
?>