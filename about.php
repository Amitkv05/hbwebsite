<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/link.php'); ?>
    <title><?php echo $settings_r['site_title'] ?>--About</title>

    <!-- Swiperjs -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <style>
        .box {
            border-top-color: var(--teal) !important;
        }

        .swiper {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <?php require('inc/header.php'); ?>

    <div class="my-5 pc-4">
        <h2 class="fw-bold h-font text-center">About Us</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">
            This is instead to provide the best traveling services to the customers and travel agents. <br>
            It helps them to search the information faster than the present system, to find customer records readily and report of the customer payment, etc are generated as per requirement.<br>
            The tour and travel management system also includes a CRM module that stores customer information and helps agents keep track of their interactions with customers. This module also includes features for customer segmentation, targeted marketing, and customer feedback management.
        </p>
    </div>

    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
                <h3 class="mb-3">Amit Kumar</h3>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Officia sit omnis provident consectetur quod autem tempore illum optio rem aut!
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Dolorem sequi reiciendis cupiditate voluptatibus
                </p>
            </div>
            <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-2 order-1">
                <img src="images/about/about.jpg" class="w-100" alt="">
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-3 col-md-6 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="images/about/hotel.svg" width="70px" alt="">
                    <h3 class="mt-3">100+ Rooms</h3>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="images/about/customers.svg" width="70px" alt="">
                    <h3 class="mt-3">300+ Customers</h3>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="images/about/rating.svg" width="70px" alt="">
                    <h3 class="mt-3">150+ Review</h3>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="images/about/staff.svg" width="70px" alt="">
                    <h3 class="mt-3">100+ Staff</h3>
                </div>
            </div>
        </div>
    </div>

    <h3 class="my-5 fw-bold h-font text-center"> Management Team</h3>
    <!-- Swiper -->
    <div class="container px-4">

        <div class="swiper mySwiper">
            <div class="swiper-wrapper mb-5">
                <?php

                $about_r = selectAll('team_details');
                $path = ABOUT_IMG_PATH;
                while ($row = mysqli_fetch_assoc($about_r)) {
                    echo <<<data
                            <div class="swiper-slide bg-white text-center d-inline overflow-hidden rounded">
                                <img src="$path$row[picture]"><br>
                                <h5 class="mt-2 p-2">$row[name]</h5>
                            </div>
                        data;
                }

                ?>
            </div>
            <div class="swiper-pagination"></div>
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