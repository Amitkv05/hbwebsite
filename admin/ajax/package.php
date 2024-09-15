<?php
require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();

// Adding packages
if (isset($_POST['add_package'])) {

    $frm_data = filteration($_POST);
    $flag = 0;

    // print_r($frm_data);

    $q1 = "INSERT INTO `package`(`name`, `title`, `description`, `destination`,`price`, `age_range`, `regions`, `operated_in`) VALUES (?,?,?,?,?,?,?,?)";
    $values = [$frm_data['name'],$frm_data['title'], $frm_data['description'],$frm_data['destination'],$frm_data['price'],$frm_data['age_range'],$frm_data['regions'],$frm_data['operated_in']];

    if (insert($q1, $values, 'ssssssss')) {
        $flag = 1;
    }

    $package_id = mysqli_insert_id($con);
}

// packages control (button and all).....
if (isset($_POST['get_all_package'])) {
    $res = select("SELECT * FROM `package` WHERE `removed`=?", [0], 'i');
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
                    <td>$row[title]</td>
                    <td>$row[description]</td>
                    <td>$row[destination]</td>
                    <td>$row[price]</td>
                    <td>$row[age_range]</td>
                    <td>$row[regions]</td>
                    <td>$row[operated_in]</td>
                    <td>$status</td>
                    <td>
                        <button type='button' onclick='edit_details($row[id])' class='btn btn-primary shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#edit-package'>
                        <i class='bi bi-pencil-square'></i>
                        </button>

                        <button type='button' onclick=\"package_img($row[id],'$row[name]')\" class='btn btn-info shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#package-img'>
                        <i class='bi bi-images'></i>
                        </button>
                        
                        <button type='button' onclick='remove_package($row[id])' class='btn btn-danger shadow-none btn-sm'>
                        <i class='bi bi-trash'></i>
                        </button>
                    </td>
                </tr>
            ";
        $i++;
    }
    echo $data;
}

// Showing packages Details..
if (isset($_POST['get_package'])) {
    $frm_data = filteration($_POST);

    $res1 = select("SELECT * FROM `package` WHERE `id`=?", [$frm_data['get_package']], 'i');
    $packagedata = mysqli_fetch_assoc($res1);

    $data = ["packagedata" => $packagedata];

    $data = json_encode($data);

    echo $data;
}

// Edit packages...
if (isset($_POST['edit_package'])) {

    $frm_data = filteration($_POST);
    $flag = 0;

    $q1 = "UPDATE `package` SET`name`=?,`title`=?,`description`=?,`destination`=?,`price`=?,`age_range`=?,`regions`=?,`operated_in`=? WHERE `id`=?";

    $values = [$frm_data['name'],$frm_data['title'], $frm_data['description'],$frm_data['destination'],$frm_data['price'],$frm_data['age_range'],$frm_data['regions'],$frm_data['operated_in'], $frm_data['package_id']];

    if (update($q1, $values, 'sssssssi')) {
        $flag = 1;
    }

    if ($flag) {
        echo 1;
    } else {
        echo 0;
    }
}

// status button 
if (isset($_POST['toggle_status'])) {
    $frm_data = filteration($_POST);

    $q = "UPDATE `package` SET `status`= ? WHERE `id`=?";
    $v = [$frm_data['value'], $frm_data['toggle_status']];

    if (update($q, $v, 'ii')) {
        echo 1;
    } else {
        echo 0;
    }
}

// add image in packages
if (isset($_POST['add_image'])) {
    $frm_data = filteration($_POST);

    $img_r = uploadImage($_FILES['image'], PACKAGE_FOLDER);

    if ($img_r == 'inv_img') {
        echo $img_r;
    } else if ($img_r == 'inv_size') {
        echo $img_r;
    } else if ($img_r == 'upd_failed') {
        echo $img_r;
    } else {
        $q = "INSERT INTO `package_img`(`package_id`, `image`) VALUES (?,?)";
        $values = [$frm_data['package_id'], $img_r];
        $res = insert($q, $values, 'is');
        echo $res;
    }
}

//Print package Images in page
if (isset($_POST['get_package_img'])) {
    $frm_data = filteration($_POST);
    $res = select("SELECT * FROM `package_img` WHERE `package_id`=?", [$frm_data['get_package_img']], 'i');

    $path = PACKAGE_IMG_PATH;

    while ($row = mysqli_fetch_assoc($res)) {
        if ($row['thumb'] == 1) {
            $thumb_btn = "<i class='bi bi-check-lg text-light bg-success px-2 py-1 rounded fs-5'></i>";
        } else {
            $thumb_btn = "<button type='button' onclick='thumb_image($row[s_no],$row[package_id])' class='btn btn-secondary shadow-none'>
                <i class='bi bi-check-lg'></i>
            </button>";
        }
        echo <<<data
            <tr class="align-middle">
                <td><img src="$path$row[image]" class="img-fluid"></td>
                <td>$thumb_btn</td>
                <td>
                    <button type='button' onclick='rem_image($row[s_no],$row[package_id])' class='btn btn-danger shadow-none'>
                        <i class='bi bi-trash'></i>
                    </button>
                </td>
            </tr>
        data;
    }
}

//deleting images form package....
if (isset($_POST['rem_image'])) {
    $frm_data = filteration($_POST);
    $values = [$frm_data['image'], $frm_data['package_id']];

    $pre_q = "SELECT * FROM `package_img` WHERE `s_no`=? AND `package_id`=?";
    $res = select($pre_q, $values, 'ii');
    $img = mysqli_fetch_assoc($res);

    if (deleteImage($img['image'], PACKAGE_FOLDER)) {
        $q = "DELETE FROM `package_img` WHERE `s_no`=? AND `package_id`=?";
        $res = delete($q, $values, 'ii');
        echo $res;
    } else {
        echo 0;
    }
}
// Selecting Images b/w 2or more images in package....
if (isset($_POST['thumb_image'])) {
    $frm_data = filteration($_POST);

    $pre_q = "UPDATE `package_img` SET `thumb`=? WHERE `package_id`=?";
    $pre_v = [0, $frm_data['package_id']];
    $pre_res = update($pre_q, $pre_v, 'ii');

    $q = "UPDATE `package_img` SET `thumb`=? WHERE `s_no`=? AND `package_id`=?";
    $v = [1, $frm_data['image_id'], $frm_data['package_id']];
    $res = update($q, $v, 'iii');

    echo $res;
}

// Removing packages From Page ....
if (isset($_POST['remove_package'])) {
    $frm_data = filteration($_POST);

    $res1 = select("SELECT * FROM `package_img` WHERE `package_id`=?", [$frm_data['package_id']], 'i');

    while ($row = mysqli_fetch_assoc($res1)) {
        deleteImage($row['image'], PACKAGE_FOLDER);
    }

    $res2 = delete("DELETE FROM `package_img` WHERE `package_id`=?", [$frm_data['package_id']], 'i');
    $res3 = update("UPDATE `package` SET `removed`=? WHERE `id`=?",[1,$frm_data['package_id']],'ii');

    if ($res2 || $res3) {
        echo 1;
    } else {
        echo 0;
    }
}

?>
