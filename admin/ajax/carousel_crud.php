<?php
require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();

// add member
if (isset($_POST['add_image'])) {
    // $frm_data = filteration($_POST);

    $img_r = uploadImage($_FILES['picture'],CAROUSEL_FOLDER);

    if ($img_r == 'inv_img') {
        echo $img_r;
    } else if ($img_r == 'inv_size') {
        echo $img_r;
    } else if ($img_r == 'upd_failed') {
        echo $img_r;
    } else {
        $q = "INSERT INTO `carousel`(`image`) VALUES (?)";
        $values =  [$img_r];
        $res = insert($q, $values, 's');
        echo $res;
    }
}

// Add members details....
if (isset($_POST['get_carousel']))
{
    // this $res and db_config.php $res is different...
    $res = selectAll('carousel');

    while ($row = mysqli_fetch_assoc($res))
    {
        $path = CAROUSEL_IMG_PATH;
        echo <<<data
            <div class="col-md-4 mb-3">
                <div class="card text-bg-dark">
                    <img src="$path$row[image]" class="card-img">
                    <div class="card-img-overlay text-end">
                        <button type="button" onclick="rem_image($row[s_no])" class="btn btn-danger btn-sm shadow-none">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        data;
    }
}


//deleting member system....
if(isset($_POST['rem_image']))
{
    $frm_data = filteration($_POST);
    $values = [$frm_data['rem_image']];

    $pre_q = "SELECT * FROM `carousel` WHERE `s_no`=?";
    $res = select($pre_q,$values,'i');
    $img = mysqli_fetch_assoc($res);

    if(deleteImage($img['image'],CAROUSEL_FOLDER)){
        $q = "DELETE FROM `carousel` WHERE `s_no`=?";
        $res = delete($q, $values,'i');
        echo $res;

    }
    else{
        echo 0;
    }
}
