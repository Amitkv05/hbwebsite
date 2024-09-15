<?php
if (isset($_POST['register'])) {
    $frm_data = filteration($_POST);

    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    // $datentime = $_POST['datentime'];
    $password = password_hash($_POST['password'],PASSWORD_BCRYPT);;
    $confirmpassword = $_POST['confirmpassword'];
    $duplicate = mysqli_query($con, "SELECT * FROM users WHERE username = '$username' OR email = '$email'");


    if (mysqli_num_rows($duplicate) > 0) {
        echo "
        <script> alert('Username or Email has already taken');</script>     
        ";
    } else {
        if ($frm_data['password'] == $frm_data['confirmpassword']) {
            $query = "INSERT INTO `users` VALUES('','$name','$username','$email','$password','','') ";
            mysqli_query($con, $query);
            echo
            "<script> alert('Registration Successful');</script>";
        } else {
            echo "<script> alert('Password Does Not match');</script> ";
        }
    }
}

?>