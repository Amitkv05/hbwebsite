<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/link.php'); ?>
    <title><?php echo $settings_r['site_title'] ?>--Destination Details</title>

    <!-- Swiperjs -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

</head>

<body>
    <?php require('inc/header.php'); ?>
    <?php
    if (!isset($_GET['id'])) {
        redirect('destination.php');
    }

    $data = filteration($_GET);
    $destination_res = select("SELECT * FROM `destination` WHERE `id`=? AND`status`=? AND `removed`=?", [$data['id'], 1, 0], 'iii');

    if (mysqli_num_rows($destination_res) == 0) {
        redirect('destination.php');
    }

    $destination_data = mysqli_fetch_assoc($destination_res);
    ?>



    <div class="container">
        <div class="row ">

            <div class="col-12 my-5 mb-4 pc-4">
                <h1 class="fw-bold"><?php echo $destination_data['name']?> Trips</h1>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">Home</a>
                    <span class="text-secondary">></span>
                    <a href="destination.php" class="text-secondary text-decoration-none">Destination</a>
                </div>
            </div>

            <div class="col-lg-7 col-md-12 px-2">
                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <?php
                        echo <<<desc
                        <p class="mt-3" style="font-size:20px;">
                            $destination_data[description]
                        </p>
                        desc;

                        echo <<<rating
                                <div class="rating mb-1">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-half text-warning"></i>
                                </div>
                        rating;

                        // shutdown section
                        $book_btn = "";

                        if (!$settings_r['shutdown']) {

                            $login = 0;
                            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                                $login = 1;
                            }

                            $book_btn = "<button onclick ='checkLoginToSelect($login,$destination_data[id])' class='btn btn-sm w-100 text-white custom-bg shadow-none mb-2'>Book Now</button>
                        ";
                        }

                        ?>
                    </div>
                </div>

            </div>

            <div class="col-lg-5 col-md-12 px-2">
                <div id="destinationCarousel" class="carousel slide">
                    <div class="carousel-inner">
                        <?php
                        // Rooms Detail image print....
                        $destination_img = DESTINATION_IMG_PATH . "thumbnail.jpg";
                        $img_q = mysqli_query($con, "SELECT * FROM `destination_images` 
                                WHERE `destination_id` = '$destination_data[id]'");

                        if (mysqli_num_rows($img_q) > 0) {
                            $active_class = 'active';
                            while ($img_res = mysqli_fetch_assoc($img_q)) {
                                echo " <div class='carousel-item $active_class'>
                                        <img src='" . DESTINATION_IMG_PATH . $img_res['image'] . "'class='d-block w-100 rounded'>
                                    </div>";
                                $active_class = '';
                            }
                        } else {
                            echo " <div class='carousel-item active'>
                                    <img src='$destination_img 'class='d-block w-100'>
                                </div>";
                        }
                        ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#destinationCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#destinationCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
<hr>
    <div class="container-fluid">
        <div class="row ">
            <h1 class="fw-bold text-center">Package</h1>
            <?php

            $package_res = select("SELECT * FROM `package` WHERE `status`=? AND `removed`=? ORDER BY `id` ASC", [1, 0], 'ii');

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


    <!-- Footer Start -->
    <?php require('inc/footer.php'); ?>
    <!-- Footer End -->

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            // slidesPerView: 4,
            spaceBetween: 40,
            pagination: {
                el: ".swiper-pagination",
                dynamicBullets: true,
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                },
                640: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            }
        });
    </script>
</body>

</html>