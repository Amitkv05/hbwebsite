<?php
require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();

// Rooms control (button and all).....
if (isset($_POST['get_users'])) {
    $res = selectAll('users');
    $i = 1;
    $path = USERS_IMG_PATH;

    $data = "";
    while ($row = mysqli_fetch_assoc($res))
    {
        // delete button..
        $del_btn = "<button type='button' onclick='remove_user($row[id])' class='btn btn-danger shadow-none btn-sm'>
        <i class='bi bi-trash'></i>
        </button>";

        // toggle-status....
        $status = "<button onclick='toggle_status($row[id],0)' class='btn btn-dark btn-sm shadow-none'>active</button>";

        if(!$row['status'])
        {
            $status = "<button onclick='toggle_status($row[id],1)' class='btn btn-warning btn-sm shadow-none'>inactive</button>";
        }

        $data .= "
                <tr calss='align-middle'>
                    <td>$i</td>
                    <td>$row[name]</td>
                    <td>$row[username]</td>
                    <td>$row[email]</td>
                    <td>$status</td>
                    <td>$del_btn</td>
                </tr>
            ";
        $i++;
    }
    echo $data;
}


if (isset($_POST['toggle_status'])) {
    $frm_data = filteration($_POST);

    $q = "UPDATE `users` SET `status`= ? WHERE `id`=?";
    $v = [$frm_data['value'], $frm_data['toggle_status']];

    if (update($q, $v, 'ii')) {
        echo 1;
    } else {
        echo 0;
    }
}

// Removing Rooms From Page ....
if (isset($_POST['remove_user'])) {
    $frm_data = filteration($_POST);

    $res = delete("DELETE FROM `users` WHERE `id`=?", [$frm_data['user_id']], 'i');

    if ($res) {
        echo 1;
    } else {
        echo 0;
    }
}

?>
