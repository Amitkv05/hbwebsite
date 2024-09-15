<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<!-- Bootstrap-Icons-->
<!-- Font -->
<link href="https://fonts.googleapis.com/css2?family=Merienda:wght@400;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="inc/style.css">

<?php

session_start();

require('admin/inc/db_config.php');
require('admin/inc/essentials.php');

// making frontend dynamic page (changing the page from backend) start.....

$contact_q = "SELECT * FROM `contact_details` WHERE `s_no`=?";
// to change the site name and about in footer section
$settings_q = "SELECT * FROM `settings` WHERE `s_no`=?";

$values = [0];
$values1 = [1];


$contact_r = mysqli_fetch_assoc(select($contact_q, $values, 'i'));

// to change the site name and about in footer section
$settings_r = mysqli_fetch_assoc(select($settings_q, $values1, 'i'));


// print_r($contact_r); //it shows all data regarding this...

// making frontend dynamic page (changing the page from backend) end.....

?>




<?php

date_default_timezone_set("Asia/Kolkata");

$contact_q = "SELECT * FROM `contact_details` WHERE `s_no`=?";
$settings_q = "SELECT * FROM `settings` WHERE `s_no`=?";
$values = [1];
$contact_r = mysqli_fetch_assoc(select($contact_q, $values, 'i'));
$settings_r = mysqli_fetch_assoc(select($settings_q, $values, 'i'));


// ...............to shutdown the webpage.....


if ($settings_r['shutdown']) {
    echo <<<alertbar
        <div class='bg-danger text-center p-2 fw-bold'>
            <i class="bi bi-exclamation-triangle-fill"></i>
            Bookings are temporarily closed!
        </div>
    alertbar;
}

?>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>