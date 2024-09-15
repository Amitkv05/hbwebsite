<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/link.php'); ?>
    <title><?php echo $settings_r['site_title'] ?>--Package</title>

    <!-- Swiperjs -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <?php require('inc/header.php'); ?>

</head>

<body>

    <div class="container-fluid">
        <div class="row ">
        <?php
                
                $package_res = select("SELECT * FROM `package` WHERE `status`=? AND `removed`=? ORDER BY `name` ASC", [1, 0], 'ii');

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

                        $book_btn = "<button onclick ='checkLoginToBook($login,$package_data[id])' class='btn btn-sm w-100 text-white custom-bg shadow-none mb-2'>Book Now</button>
                        ";
                    }

                    // print destination card

                    echo <<<data
                            <div class="col-lg-4 col-md-6 my-3">
                                <div class="card border-0  shadow" style="max-width: 350px; margin: auto">
                                    <div class="box" data-aos="fade-up" data-aos-delay="150">
                                        <div class="image">
                                            <img width="350px" height="170"src="$package_thumb">
                                        </div>
                                        <div class="container">
                                            <div class="card-body">
                                                <!-- <div class="col-lg-9 col-md-12 px-3"> -->
                                                <h4 class="text-center fw-bold" style="color:blue">$package_data[name]</h4>
                                                <div class="mb-3">
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
                                                    <h6 class="mb-1 fw-bold col-lg-5 col-md-6">Destinations:</h6>
                                                    <span class='col-lg-5 col-md-6 px-3 badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                                                    $package_data[price]
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
            
        </div>
    </div>
    <?php require('inc/footer.php'); ?>

</body>

</html>