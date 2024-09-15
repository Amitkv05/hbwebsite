<?php
require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();

// Adding destinations
if (isset($_POST['add_destination'])) {

    $frm_data = filteration($_POST);
    $flag = 0;
    $q1 = "INSERT INTO `destination`(`name`, `price`, `description`) VALUES (?,?,?)";
    $values = [$frm_data['name'],$frm_data['price'], $frm_data['description']];
    if (insert($q1, $values, 'sis')) {
        $flag = 1;
    }

    $destination_id = mysqli_insert_id($con);
}

// destinations control (button and all).....
if (isset($_POST['get_all_destination'])) {
    $res = select("SELECT * FROM `destination` WHERE `removed`=?", [0], 'i');
    $i = 1;
    

    $data = "";
    while ($row = mysqli_fetch_assoc($res)) {
        if ($row['status'] == 1) {
            $status = "<button onclick='toggle_status($row[id],0)' class='btn btn-dark btn-sm shadow-none'>active</button>
                ";
        } else {
            $status = "<button onclick='toggle_status($row[id],1)' class='btn btn-warning btn-sm shadow-none'>inactive</button>
                ";
        }
        $data .= "
                <tr calss='align-middle'>
                    <td>$i</td>
                    <td>$row[name]</td>
                    <td>₹$row[price]</td>
                    <td>$row[description]</td>
                    <td>$status</td>
                    <td>
                        <button type='button' onclick='edit_details($row[id])' class='btn btn-primary shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#edit-destination'>
                        <i class='bi bi-pencil-square'></i>
                        </button>

                        <button type='button' onclick=\"destination_images($row[id],'$row[name]')\" class='btn btn-info shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#destination-images'>
                        <i class='bi bi-images'></i>
                        </button>
                        
                        <button type='button' onclick='remove_destination($row[id])' class='btn btn-danger shadow-none btn-sm'>
                        <i class='bi bi-trash'></i>
                        </button>
                    </td>
                </tr>
            ";
        $i++;
    }
    echo $data;
}

// Showing destinations Details..
if (isset($_POST['get_destination'])) {
    $frm_data = filteration($_POST);

    $res1 = select("SELECT * FROM `destination` WHERE `id`=?", [$frm_data['get_destination']], 'i');
    $destinationdata = mysqli_fetch_assoc($res1);

    $data = ["destinationdata" => $destinationdata];

    $data = json_encode($data);

    echo $data;
}

// Edit destinations...
if (isset($_POST['edit_destination'])) {

    $frm_data = filteration($_POST);
    $flag = 0;

    $q1 = "UPDATE `destination` SET`name`=?,`price`=?,`description`=? WHERE `id`=?";
    $values = [$frm_data['name'], $frm_data['price'], $frm_data['description'], $frm_data['destination_id']];

    if (update($q1, $values, 'sisi')) {
        $flag = 1;
    }

    

    // if ($flag) {
    //     echo 1;
    // } else {
    //     echo 0;
    // }
}

// status button 
if (isset($_POST['toggle_status'])) {
    $frm_data = filteration($_POST);

    $q = "UPDATE `destination` SET `status`= ? WHERE `id`=?";
    $v = [$frm_data['value'], $frm_data['toggle_status']];

    if (update($q, $v, 'ii')) {
        echo 1;
    } else {
        echo 0;
    }
}

// add image in destinations
if (isset($_POST['add_image'])) {
    $frm_data = filteration($_POST);

    $img_r = uploadImage($_FILES['image'], DESTINATION_FOLDER);

    if ($img_r == 'inv_img') {
        echo $img_r;
    } else if ($img_r == 'inv_size') {
        echo $img_r;
    } else if ($img_r == 'upd_failed') {
        echo $img_r;
    } else {
        $q = "INSERT INTO `destination_images`(`destination_id`, `image`) VALUES (?,?)";
        $values = [$frm_data['destination_id'], $img_r];
        $res = insert($q, $values, 'is');
        echo $res;
    }
}

//Print destination Images in page
if (isset($_POST['get_destination_images'])) {
    $frm_data = filteration($_POST);
    $res = select("SELECT * FROM `destination_images` WHERE `destination_id`=?", [$frm_data['get_destination_images']], 'i');

    $path = DESTINATION_IMG_PATH;

    while ($row = mysqli_fetch_assoc($res)) {
        if ($row['thumb'] == 1) {
            $thumb_btn = "<i class='bi bi-check-lg text-light bg-success px-2 py-1 rounded fs-5'></i>";
        } else {
            $thumb_btn = "<button type='button' onclick='thumb_image($row[s_no],$row[destination_id])' class='btn btn-secondary shadow-none'>
                <i class='bi bi-check-lg'></i>
            </button>";
        }
        echo <<<data
            <tr class="align-middle">
                <td><img src="$path$row[image]" class="img-fluid"></td>
                <td>$thumb_btn</td>
                <td>
                    <button type='button' onclick='rem_image($row[s_no],$row[destination_id])' class='btn btn-danger shadow-none'>
                        <i class='bi bi-trash'></i>
                    </button>
                </td>
            </tr>
        data;
    }
}

//deleting images form destination....
if (isset($_POST['rem_image'])) {
    $frm_data = filteration($_POST);
    $values = [$frm_data['image'], $frm_data['destination_id']];

    $pre_q = "SELECT * FROM `destination_images` WHERE `s_no`=? AND `destination_id`=?";
    $res = select($pre_q, $values, 'ii');
    $img = mysqli_fetch_assoc($res);

    if (deleteImage($img['image'], DESTINATION_FOLDER)) {
        $q = "DELETE FROM `destination_images` WHERE `s_no`=? AND `destination_id`=?";
        $res = delete($q, $values, 'ii');
        echo $res;
    } else {
        echo 0;
    }
}
// Selecting Images b/w 2or more images in destination....
if (isset($_POST['thumb_image'])) {
    $frm_data = filteration($_POST);

    $pre_q = "UPDATE `destination_images` SET `thumb`=? WHERE `destination_id`=?";
    $pre_v = [0, $frm_data['destination_id']];
    $pre_res = update($pre_q, $pre_v, 'ii');

    $q = "UPDATE `destination_images` SET `thumb`=? WHERE `s_no`=? AND `destination_id`=?";
    $v = [1, $frm_data['image_id'], $frm_data['destination_id']];
    $res = update($q, $v, 'iii');

    echo $res;
}

// Removing destinations From Page ....
if (isset($_POST['remove_destination'])) {
    $frm_data = filteration($_POST);

    $res1 = select("SELECT * FROM `destination_images` WHERE `destination_id`=?", [$frm_data['destination_id']], 'i');

    while ($row = mysqli_fetch_assoc($res1)) {
        deleteImage($row['image'], DESTINATION_FOLDER);
    }

    $res2 = delete("DELETE FROM `destination_images` WHERE `destination_id`=?", [$frm_data['destination_id']], 'i');
    $res3 = update("UPDATE `destination` SET `removed`=? WHERE `id`=?",[1,$frm_data['destination_id']],'ii');

    if ($res2 || $res3) {
        echo 1;
    } else {
        echo 0;
    }
}

?>
