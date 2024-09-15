<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/link.php'); ?>
    <title><?php echo $settings_r['site_title'] ?>--Home</title>

    <!-- Swiperjs -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <style>
    
    </style>

</head>


<body>

    <?php require('inc/header.php'); ?>

    <!-- Swiper Js start -->
    <div class="container-fluid">
        <div class="swiper swiper-container">
            <div class="swiper-wrapper">
                <?php
                $res = selectAll('carousel');

                while ($row = mysqli_fetch_assoc($res)) {
                    $path = CAROUSEL_IMG_PATH;
                    echo <<<data
                            <div class="swiper-slide">
                                <img src="$path$row[image]" class="w-100 d-block" />
                            </div>
                         data;
                }
                ?>
            </div>
        </div>
    </div>
    <!-- Swiper Js Ends -->

    <!-- Check availability form -->
    <div class="container availability-form" style="color: #aaa" ;>
        <div class="row">
            <div class="col-lg-12">
                <h5 class="mb-4">Check Booking Availability</h5>
                <form>
                    <div class="row align-items-end">
                        <div class="col-lg-4 mb-3">
                            <span>Where to?</span>
                            <input class="input" type="text" placeholder="Place Name" value="">
                        </div>
                        <div class="col-lg-3 mb-3">
                            <span>When?</span>
                            <input class="input" type="date" value="">
                        </div>
                        <div class="col-lg-3 mb-3">
                            <span>How Many?</span>
                            <input class="input" type="number" placeholder="Number of Travelers" value="">
                        </div>
                        <div class="col-lg-1 mb-lg-3 mx-2" style="padding-bottom: 12px;">
                            <button type=" submit" class="btn custom-bg">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Our Destination Type -->
    <h2 class="mt-5 pt-4 mc-4 text-center fw-bold h-font">Destination Type</h2>
    <div class="container-fluid">
        <div class="swiper swiper-dstype">
            <div class="swiper-wrapper">
                <?php
                $destination_res = select("SELECT * FROM `destination` WHERE `status`=? AND `removed`=? ORDER BY `id` ASC", [1, 0], 'ii');

                while ($destination_data = mysqli_fetch_assoc($destination_res)) {

                    $destination_thumb = DESTINATION_IMG_PATH . "thumbnail.jpg";
                    $thumb_d = mysqli_query($con, "SELECT * FROM `destination_images` 
                        WHERE `destination_id` = '$destination_data[id]' 
                        AND `thumb` ='1'");


                    if (mysqli_num_rows($thumb_d) > 0) {
                        $thumb_res = mysqli_fetch_assoc($thumb_d);
                        $destination_thumb = DESTINATION_IMG_PATH . $thumb_res['image'];
                    }

                    // shutdown section
                    $book_btn = "";

                    if (!$settings_r['shutdown']) {
                        $login = 0;
                        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                            $login = 1;
                        }
                    }

                    echo <<<data
                            <div class="swiper-slide" style=" width: 235px;">
                                    <div class="image">
                                        <img src="$destination_thumb"  class="card-img-top" style="height:223px" alt="destination_details.php">
                                    </div>
                                <div class="container">
                                    <center>
                                        <div class="card-body">
                                            <h3 style="margin-top:-36px; color:white">$destination_data[name]</h3>
                                            <a href="destination_details.php?id=$destination_data[id]"  class="btn btn-sm btn-outline-light shadow-none" style="margin-top:-275px">Select<i class="fas fa-angle-right"></i></a>
                                        </div>
                                    </center>
                                </div>
                            </div>
                         data;
                }
                ?>
            </div>
        </div>
    </div>
    <!-- Our Destination Type End -->


    <!-- Our Package -->
    <div class="container-fluid">
        <div class="row ">
            <h1 class="mt-5 pt-4 mc-4 text-center fw-bold h-font text-center">Package</h1>
            <?php

            $package_res = select("SELECT * FROM `package` WHERE `status`=? AND `removed`=? ORDER BY `id` ASC LIMIT 3", [1, 0], 'ii');

            while ($package_data = mysqli_fetch_assoc($package_res)) {

                $package_thumb = PACKAGE_IMG_PATH . "thumbnail.jpg";
                $thumb_d = mysqli_query($con, "SELECT * FROM `package_img` 
                            WHERE `package_id` = '$package_data[id]' 
                            AND `thumb` ='1'");


                if (mysqli_num_rows($thumb_d) > 0) {
                    $thumb_res = mysqli_fetch_assoc($thumb_d);
                    $package_thumb = PACKAGE_IMG_PATH . $thumb_res['image'];
                }


                // shutdown section
                $book_btn = "";

                if (!$settings_r['shutdown']) {
                    $login = 0;
                    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                        $login = 1;
                    }

                    $book_btn = "<button onclick ='checkLoginToSelect($login,$package_data[id])' class='btn btn-sm w-100 text-white custom-bg shadow-none mb-2'>Select</button>
                        ";
                }
                echo <<<data
                            <div class="col-lg-4 col-md-6 my-3">
                                <div class="card border-0  shadow" style="max-width: 350px; margin: auto">
                                    <div class="box" data-aos="fade-up" data-aos-delay="150">
                                        <div class="image">
                                            <img width="350px" height="170"src="$package_thumb">
                                        </div>
                                        <div class="container" style="height:31rem">
                                            <div class="card-body" >
                                                <!-- <div class="col-lg-9 col-md-12 px-3"> -->
                                                <h4 class="text-center fw-bold" style="color:blue">$package_data[name]</h4>
                                                <div class=" text-center" style="height:67px">
                                                    <span class="fw-bold text-center" style="font-size: 18px;">$package_data[title]</span>
                                                </div>
                                                
                                                <p class="badge text-dark text-wrap me-1 mb-1" style="font-size:12px">
                                                $package_data[description]
                                                </p>
                                                <hr>
                                                <div class="row mb-2">
                                                    <h6 class="mb-1 fw-bold col-lg-5 col-md-6">Destinations:</h6>
                                                    <span class='col-lg-5 col-md-6 px-3 badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                                                    $package_data[destination]
                                                    </span>
                                                </div>
                                                <div class="row mb-2">
                                                    <h6 class="mb-1 fw-bold col-lg-5 col-md-6">Age Range:</h6>
                                                    <span class='col-lg-5 col-md-6 px-3 badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                                                    $package_data[age_range]
                                                    </span>
                                                </div>
                                                <div class="row mb-2">
                                                    <h6 class="mb-1 fw-bold col-lg-5 col-md-6">Regions:</h6>
                                                    <span class='col-lg-5 col-md-6 px-3 badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                                                    $package_data[regions]
                                                    </span>
                                                </div>
                                                <div class="row mb-2">
                                                    <h6 class="mb-1 fw-bold col-lg-5 col-md-6">Operated in:</h6>
                                                    <span class='col-lg-5 col-md-6 px-3 badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                                                    $package_data[operated_in]
                                                    </span>
                                                </div>
                                                <div class="row mt-3 text-center">
                                                    $book_btn
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        data;
            }
            ?>
            <div class="col-lg-12 text-center mt-5">
                <a href="package.php" class="btn btn-sm btn-outline-dark rounded-0 custom-bg fw-bold shadow-none">More Package>>></a>
            </div>
        </div>
    </div>
    <!-- Our Package End -->


    <!-- Our Rooms -->
    <h2 class="mt-5 pt-4 mc-4 text-center fw-bold h-font">Our Rooms</h2>
    <div class="container">
        <div class="row">
            <?php
            $room_res = select("SELECT * FROM `rooms` WHERE `status`=? AND `removed`=? ORDER BY `id` DESC LIMIT 3", [1, 0], 'ii');

            while ($room_data = mysqli_fetch_assoc($room_res)) {
                // get features of room

                $fea_q = mysqli_query($con, "SELECT f.name FROM `features` f 
                            INNER JOIN `room_features` rfea ON f.id = rfea.features_id 
                            WHERE rfea.room_id = '$room_data[id]'");

                $features_data = "";
                while ($fea_row = mysqli_fetch_assoc($fea_q)) {
                    $features_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                                    $fea_row[name]
                                </span>";
                }
                // get facilities of room

                $fec_q = mysqli_query($con, "SELECT f.name FROM `facilities` f 
                            INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id 
                            WHERE rfac.room_id = '$room_data[id]' ORDER BY `id` DESC LIMIT 4");

                $facilities_data = "";
                while ($fec_row = mysqli_fetch_assoc($fec_q)) {
                    $facilities_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                                    $fec_row[name]
                                </span>";
                }

                // get thumbnail of room

                $room_thumb = ROOMS_IMG_PATH . "thumbnail.jpg";
                $thumb_q = mysqli_query($con, "SELECT * FROM `room_images` 
                            WHERE `room_id` = '$room_data[id]' 
                            AND `thumb` ='1'");

                if (mysqli_num_rows($thumb_q) > 0) {
                    $thumb_res = mysqli_fetch_assoc($thumb_q);
                    $room_thumb = ROOMS_IMG_PATH . $thumb_res['image'];
                }

                // shutdown section
                $book_btn = "";

                if (!$settings_r['shutdown']) {
                    $login = 0;
                    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                        $login = 1;
                    }

                    $book_btn = "<button onclick ='checkLoginToBook($login,$room_data[id])' class='btn btn-sm text-white custom-bg shadow-none'>Book Now</button>";
                }

                // print room card

                echo <<<data
                            <div class="col-lg-4 col-md-6 my-3">
                                <div class="card border-0  shadow" style="max-width: 350px; margin: auto">
                                    <img src="$room_thumb" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">$room_data[name]</h5>
                                        <div class="features mb-4">
                                            <h6 class="mb-1 fw-bold">Features</h6>
                                            $features_data
                                        </div>
                                        <div class="facilities mb-4">
                                            <h6 class="mb-1 fw-bold">Facilities</h6>
                                            $facilities_data <h8 class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1">More..</h8>
                                            
                                        </div>
                                        <div class="guests mb-2">
                                            <h6 class="mb-1 fw-bold">Guests</h6>
                                            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
                                                $room_data[adult] Adults
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
                                                $room_data[children] Children
                                            </span>
                                        </div>
                                        <div class="rating mb-4">
                                            <h6 class="mb-1 fw-bold">Rating</h6>
                                            <span class="badge rounded-pill bg-light">
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-half text-warning"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-evenly mb-2">
                                        $book_btn
                                        <a href="room_details.php?id=$room_data[id]" class="btn btn-sm btn-outline-dark shadow-none">More Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        data;
            }
            ?>
            <div class="col-lg-12 text-center mt-5">
                <a href="rooms.php" class="btn btn-sm btn-outline-dark rounded-0 custom-bg fw-bold shadow-none">More Rooms>>></a>
            </div>
        </div>
    </div>
    <!-- Our Rooms End -->

    <!-- Our Facilities start -->
    <h2 class="mt-5 pt-4 mc-4 text-center fw-bold h-font">Rooms Facilities</h2>
    <div class="container">
        <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">
            <?php
            $res = mysqli_query($con, "SELECT * FROM `facilities` ORDER BY id ASC LIMIT 5");
            $path = FEATURES_IMG_PATH;

            while ($row = mysqli_fetch_assoc($res)) {
                echo <<<data
                        <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
                            <!--....py= padding y-axis & my= margin y-axis....-->
                            <img src="$path$row[icon]" width="80px">
                            <h5 class="mt-3">$row[name]</h5>
                        </div>
                    data;
            }
            ?>
            <!--px-lg = padding x-axis in large devices
                    px-md = padding x-axis in medium devices
                -->

            <div class="col-lg-12 text-center mt-5">
                <a href="facilities.php" class="btn btn-sm btn-outline-dark custom-bg rounded-0 fw-bold shadow-none">More Facilities>>></a>
            </div>

        </div>
    </div>


    <!-- More Packages -->

    <?php require('inc/morepackage.php'); ?>


    <!-- More Packages ends -->


    <!-- Our Gallery -->
    <h2 class="mt-3 pt-4 mc-4 text-center fw-bold h-font">Our Gallery</h2>
    <div class="d-flex" style="margin-top: 4rem;">

        <swiper-container class="mySwiper" id="gallery" effect="coverflow" grab-cursor="true" centered-slides="true" slides-per-view="auto" coverflow-effect-rotate="50" coverflow-effect-stretch="0" coverflow-effect-modifier="1">
            <!-- <div> -->
            <swiper-slide>
                <img src="images/about/1.jpg" onclick="myFunction(this)">
            </swiper-slide>
            <swiper-slide>
                <img src="images/about/2.jpg" onclick="myFunction(this)">
            </swiper-slide>
            <swiper-slide>
                <img src="images/about/3.jpg" onclick="myFunction(this)">
            </swiper-slide>
            <swiper-slide>
                <img src="images/about/4.jpg" onclick="myFunction(this)">
            </swiper-slide>
            <swiper-slide>
                <img src="images/about/5.jpg" onclick="myFunction(this)">
            </swiper-slide>
            <swiper-slide>
                <img src="images/about/6.jpg" onclick="myFunction(this)">
            </swiper-slide>
            <swiper-slide>
                <img src="images/about/7.jpg" onclick="myFunction(this)">
            </swiper-slide>
            <swiper-slide>
                <img src="images/about/8.jpg" onclick="myFunction(this)">
            </swiper-slide>
            <swiper-slide>
                <img src="images/about/9.jpg" onclick="myFunction(this)">
            </swiper-slide>
            <swiper-slide>
                <img src="images/about/10.jpg" onclick="myFunction(this)">
            </swiper-slide>
            <swiper-slide>
                <img src="images/about/11.jpg" onclick="myFunction(this)">
            </swiper-slide>
            <swiper-slide>
                <img src="images/about/12.jpg" onclick="myFunction(this)">
            </swiper-slide>
        <!-- </div> -->
    </swiper-container>
    <div class="img-container">
        <img id="imageBox" src="images/about/1.jpg">
    </div>
</div>
<div style="margin-top: -6rem; width: 49rem; text-align: center; color: aliceblue; padding-left: 39px;">
<h3>
    It is all about bringing the world to people and exposing to them what else is out there.
</h3>
</div>
    <!-- Our Gallery End -->


    <!-- Review Section -->

    <section class="review">

        <div class="content aos-init aos-animate" data-aos="fade-right" data-aos-delay="300">
            <span>testimonials</span>
            <h3>good news from our clients</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda laudantium corporis fugiat quae unde perspiciatis similique ab modi enim consequatur aperiam cumque distinctio facilis sit, debitis possimus asperiores non harum.</p>
        </div>

        <div class="box-container aos-init aos-animate" data-aos="fade-left" data-aos-delay="600">
            <swiper-container class="mySwiper ">
                <div class="swiper swiper-testimonials">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="box">
                                <div class="p-3" style="text-align: center; height: 150px; margin-top: 45px; ">
                                    <p>This was a good hotel, close to a lot of things.

                                        Liked · I loved that the hot water never went out. The shower was gorgeous. The room was clean and the hotel was close to so many restaurants and shopping.</p>
                                </div>
                                <div class="rating" style="text-align:center">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-half text-warning"></i>
                                </div>
                                <div class="user d-flex align-items-center" style=" padding: 50px; ">
                                    <img src="images/users/pic-1.png" width="50px" style="margin-left: -28px; margin-right: 13px; padding: -24px;">
                                    <div class="info">
                                        <h5>John deo</h5>
                                        <span>User</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="box">
                                <div class="p-3" style="text-align: center; height: 150px; margin-top: 45px; ">
                                    <p>The stay exceeded our expectations. The cleanliness of the hotel was a major plus.</p>
                                </div>
                                <div class="rating" style="text-align:center">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-half text-warning"></i>
                                </div>
                                <div class="user d-flex align-items-center" style=" padding: 50px; ">
                                    <img src="images/users/pic-3.png" width="50px" style="margin-left: -28px; margin-right: 13px; padding: -24px;">
                                    <div class="info">
                                        <h5>Random User 1</h5>
                                        <span>User</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="box">
                                <div class="p-3" style="text-align: center; height: 150px; margin-top: 45px; ">
                                    <p>For the location, view, and amenities, AC Hotel by Atlanta Perimeter exceeded my expectations!</p>
                                </div>
                                <div class="rating" style="text-align:center">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-half text-warning"></i>
                                </div>
                                <div class="user d-flex align-items-center" style=" padding: 50px; ">
                                    <img src="images/users/pic-3.png" width="50px" style="margin-left: -28px; margin-right: 13px; padding: -24px;">
                                    <div class="info">
                                        <h5>Random User 1</h5>
                                        <span>User</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="box">
                                <div class="p-3" style="text-align: center; height: 150px; margin-top: 45px; ">
                                    <p>This was a good hotel, close to a lot of things.

                                        Liked · I loved that the hot water never went out. The shower was gorgeous. The room was clean and the hotel was close to so many restaurants and shopping.</p>
                                </div>
                                <div class="rating" style="text-align:center">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-half text-warning"></i>
                                </div>
                                <div class="user d-flex align-items-center" style=" padding: 50px; ">
                                    <img src="images/users/pic-1.png" width="50px" style="margin-left: -28px; margin-right: 13px; padding: -24px;">
                                    <div class="info">
                                        <h5>john deo</h5>
                                        <span>designer</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="box">
                                <div class="p-3" style="text-align: center; height: 150px; margin-top: 45px; ">
                                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quia, ratione.</p>
                                </div>
                                <div class="rating" style="text-align:center">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-half text-warning"></i>
                                </div>
                                <div class="user d-flex align-items-center" style="padding: 50px; ">
                                    <img src="images/users/pic-2.png" width="50px" style="margin-left: -28px; margin-right: 13px; padding: -24px;">
                                    <div class="info">
                                        <h5>Random User 2</h5>
                                        <span>User</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </swiper-container>
        </div>

    </section>
    <!-- Review Section End -->






    <!-- Banner -->

    <div class="banner">

        <div class="content" data-aos="zoom-in-up" data-aos-delay="300">
            <span>start your adventures</span>
            <h3>Let's Explore This World</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Earum voluptatum praesentium amet quibusdam quam officia suscipit odio.</p>
            <a href="#availability-form" class="btn btn-sm text-white custom-bg shadow-none">book now</a>
        </div>

    </div>
    <!-- Banner End -->


    <!-- Reach Us Start -->
    <h2 class="mt-5 pt-4 mc-4 text-center fw-bold h-font"> Reach Us</h2>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3">
                <iframe src="<?php echo $contact_r['iframe'] ?>" width="600" height="350" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="rounded">
                </iframe>
            </div>
            <div class="p-4 col-lg-4 col-md-4">
                <div class="bg-white p-4 rounded mb-4">
                    <h5>Call us</h5>
                    <a href="tel: +<?php echo $contact_r['pn1'] ?>" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-telephone-fill"></i>+<?php echo $contact_r['pn1'] ?></a>
                    <br>
                    <!-- optional -->
                    <?php
                    if ($contact_r['pn2'] != '') {
                        echo <<<data
                            <a href="tel: +$contact_r[pn2]" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-telephone-fill"></i>+$contact_r[pn2]</a>
                        data;
                    }
                    ?>
                </div>

                <div class="bg-white p-4 rounded mb-4">
                    <h5>Follow Us</h5>

                    <?php
                    if ($contact_r['tw'] != '') {
                        echo <<<data
                            <a href="$contact_r[tw]" class="d-inline-block mb-3">
                                <span class="badge bg-light text-dark fs-6 p-2">
                                    <i class="bi bi-twitter"></i> Twitter
                                </span>
                            </a>
                        data;
                    }
                    ?>


                    <br>
                    <a href="<?php echo $contact_r['fb'] ?>" class="d-inline-block mb-3">
                        <span class="badge bg-light text-dark fs-6 p-2">
                            <i class="bi bi-facebook"></i></i> Facebook</span>
                    </a>
                    <br>
                    <a href="<?php echo $contact_r['insta'] ?>" class="d-inline-block mb-3">
                        <span class="badge bg-light text-dark fs-6 p-2">
                            <i class="bi bi-instagram"></i></i> Instagram</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Reach Us Ends -->



    <!-- Footer Start -->
    <?php require('inc/footer.php'); ?>
    <script>
        function myFunction(smallImg) {
            var fullImg = document.getElementById("imageBox");
            fullImg.src = smallImg.src;
        }
    </script>
    <!-- Footer End -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".swiper-dstype", {
            watchSlidesProgress: true,
            slidesPerView: 3,
        });
    </script>
    <script>
        var swiper = new Swiper(".swiper-container", {
            spaceBetween: 30,
            effect: "fade",
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            loop: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            }
        });
    </script>


    <!-- testimonials -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-element-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".swiper-testimonials", {
            effect: "cards",
            grabCursor: true,
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-element-bundle.min.js"></script>

    <script>
        var swiper = new Swiper(".swiper-sppack", {
            slidesPerView: 3,
            grid: {
                rows: 2,
            },
            spaceBetween: 10,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
    </script>


</body>

</html>