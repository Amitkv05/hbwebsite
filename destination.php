<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/link.php'); ?>
    <title><?php echo $settings_r['site_title'] ?>--Destination</title>

    <!-- Swiperjs -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

</head>

<body>
    <?php require('inc/header.php'); ?>

    <div class="my-5 pc-4">
        <h2 class="fw-bold h-font text-center">Destination</h2>
        <div class="h-line bg-dark"></div>

    </div>

    <div class="container-fluid">
        <div class="row ">
            <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 ps-4">
                <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow-none">
                    <div class="container-fluid flex-lg-column align-items-stretch">
                        <h4 class="mt-2">Filters</h4>
                        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse"
                            data-bs-target="#filterDropdown" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="filterDropdown">
                            <div class="border bg-light p-3 rounded mb-3">
                                <h5 class="mb-3" style="font-size: 18px;">Check Availability</h5>
                                <label class="form-label">Check-in</label>
                                <input type="date" class="form-control shadow-none">
                                <label class="form-label">Check-out</label>
                                <input type="date" class="form-control shadow-none">
                            </div>
                            <div class="border bg-light p-3 rounded mb-3">
                                <h5 class="mb-3" style="font-size: 18px;">Facilities</h5>
                                <div class="mb-2">
                                    <input type="checkbox" id="f1" class="form-check-input shadow-none mb-3">
                                    <label class="form-label" for="f1">Facility one</label>
                                </div>
                                <div class="mb-2">
                                    <input type="checkbox" id="f2" class="form-check-input shadow-none mb-3">
                                    <label class="form-label" for="f2">Facility two</label>
                                </div>
                                <div class="mb-2">
                                    <input type="checkbox" id="f3" class="form-check-input shadow-none mb-3">
                                    <label class="form-label" for="f3">Facility three</label>
                                </div>
                            </div>
                            <div class="border bg-light p-3 rounded mb-3">
                                <h5 class="mb-3" style="font-size: 18px;">Guest</h5>
                                <div class="d-flex">
                                    <div class="me-3">
                                        <label class="form-label">Adults</label>
                                        <input type="Number" class="form-control shadow-none mb-3">
                                    </div>
                                    <div>
                                        <label class="form-label">Children</label>
                                        <input type="Number" class="form-control shadow-none mb-3">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>

            <div class="col-lg-9 col-md-12 px-3" id="destination-data">
                <?php
                $destination_res = select("SELECT * FROM `destination` WHERE `status`=? AND `removed`=? ORDER BY `id` DESC", [1, 0], 'ii');
                // $destination_res = select("SELECT * FROM `destination` WHERE `status`=? ORDER BY `id` DESC", [1], 'i');

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

                        $book_btn = "<button onclick ='checkLoginToSelect($login,$destination_data[id])' class='btn btn-sm w-100 text-white custom-bg shadow-none mb-2'>Book Now</button>
                        ";
                    }

                    // print destination card

                    echo <<<data

                            <div class="card mb-4 border-0 shadow">
                                <div class="row g-0 p-3 align-items-center">
                                    <div class="col-md-5 px-lg-1 mb-md-0 mb-2">
                                        <img src="$destination_thumb" class="img-fluid rounded-start">
                                    </div>
                                    <div class="col-md-5 px-lg-3 px-md-3 px-0">
                                        <h5 class="mb-1">$destination_data[name]</h5>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <h6 class="mb-4">₹$destination_data[price]</h6>
                                        $book_btn
                                        <a href="destination_details.php?id=$destination_data[id]" class="btn btn-sm w-100 btn-outline-dark shadow-none">More Details</a>
                                    </div>
                                </div>
            
                            </div>

                        data;
                }
                ?>
            </div>

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