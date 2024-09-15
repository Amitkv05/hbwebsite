<?php
require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();

// Rooms control (button and all).....
if (isset($_POST['get_booking'])) {

    // $query = "SELECT * FROM `bookings` WHERE `booking_id` = ?";
    $res = selectAll('bookings');
    $i = 1;
    $table_data = "";

    while ($data = mysqli_fetch_assoc($res)) {

        $table_data .= "
                <tr calss='align-middle'>
                    <td>$i</td>
                    <td>$data[name]</td>
                    <td>$data[email]</td>
                    <td>$data[number]</td>
                    <td>$data[check_in]</td>
                    <td>$data[check_out]</td>
                    <td>$data[rooms]</td>
                    <td>$data[adults]</td>
                    <td>$data[childs]</td>
                    <td>
                    <button type='button' onclick='cancel_booking($data[booking_id])' class='btn btn-outline-danger btn-sw fw-bold shadow-none'>
                    <i class='bi bi-trash'></i> Cancel Booking
                    </button>
                    </td>

                    </tr>
                    ";
        $i++;
    }
    echo $table_data;
}
// Removing Rooms From Page ....
if (isset($_POST['cancel_booking'])) {
    $frm_data = filteration($_POST);

    $res = delete("DELETE FROM `bookings` WHERE `booking_id`=?", [$frm_data['booking_id']], 'i');

    if ($res) {
        echo 1;
    } else {
        echo 0;
    }
}

?>