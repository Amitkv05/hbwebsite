<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/link.php'); ?>
    <title><?php echo $settings_r['site_title'] ?>--Booking</title>

    <!-- Swiperjs -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

</head>

<body>

    <?php require('inc/header.php'); ?>
    <?php

    if (isset($_COOKIE['user_id'])) {
        $user_id = $_COOKIE['user_id'];
    } else {
        setcookie('user_id', create_unique_id(), time() + 60 * 60 * 24 * 30, '/');
        header('location:index.php');
    }

    if (isset($_POST['cancel'])) {

        $booking_id = $_POST['booking_id'];
        $booking_id = filter_var($booking_id, FILTER_SANITIZE_STRING);

        $verify_booking = $conn->prepare("SELECT * FROM `bookings` WHERE booking_id = ?");
        $verify_booking->execute([$booking_id]);

        if ($verify_booking->rowCount() > 0) {
            $delete_booking = $conn->prepare("DELETE FROM `bookings` WHERE booking_id = ?");
            $delete_booking->execute([$booking_id]);
            $success_msg[] = 'booking cancelled successfully!';
        } else {
            $warning_msg[] = 'booking cancelled already!';
        }
    }
    ?>



    <div class="container">
        <div class="row ">

            <div class="col-12 my-5 mb-4 pc-4">
                <h2 class="fw-bold">Booking Details</h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">Home</a>
                    <span class="text-secondary">></span>
                    <a href="#" class="text-secondary text-decoration-none">Booking</a>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row ">
                    <div class="col-lg-9 col-md-12 px-3">
                        <?php
                        $select_bookings = $conn->prepare("SELECT * FROM `bookings` WHERE user_id = ? ");
                        $select_bookings->execute([$user_id]);
                        if ($select_bookings->rowCount() > 0) {
                            while ($fetch_booking = $select_bookings->fetch(PDO::FETCH_ASSOC)) {
                                echo <<<booking
                                        <div class="card mb-4 border-0 shadow">
                                            <div class="row g-0 p-3 align-items-center">
                                                <div class="col-md-5 px-lg-1 mb-md-0 mb-2">
                                                <h5 class='fw-bold'><img src="images/users/pic-3.png" width="280px"></h5>
                                                </div>
                                                <div class="col-md-5 px-lg-3 px-md-3 px-0">
                                                    <h5 class="mb-1">$fetch_booking[name]</h5>
                                                    <div class=" mb-2">
                                                        <h6 class="mb-3">Email: $fetch_booking[email]</h6>
                                                        
                                                    </div>
                                                    <div class="facilities mb-2">
                                                        <h6 class="mb-1">Phone No.: $fetch_booking[number]</h6>
                                                    </div>
                                                    <div class="facilities mb-2">
                                                        <h6 class="mb-1">Booking_id.: $fetch_booking[booking_id]</h6>
                                                    </div>
                                                    <div class="facilities mb-2">
                                                        <h6 class="mb-1">Rooms.: $fetch_booking[rooms]</h6>
                                                    </div>
                                                    <div class="facilities mb-2">
                                                        <h6 class="mb-1">Check_in.: $fetch_booking[check_in]</h6>
                                                    </div>
                                                    <div class="facilities mb-2">
                                                        <h6 class="mb-1">Check_out.: $fetch_booking[check_out]</h6>
                                                    </div>
                                                    <div class="guest">
                                                        <h6 class="mb-1">Guests</h6>
                                                        <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                            Adult: $fetch_booking[adults]
                                                        </span>
                                                        <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                            Children: $fetch_booking[childs]
                                                        </span>
                                                    </div>
                                                    <span class="mt-2 badge rounded-pill bg-light text-dark text-wrap" style="font-size:12px;">
                                                        Status: $fetch_booking[booking_status]
                                                    </span>
                                                </div>
                                                <div class="col-md-2 text-center">
                                                    <form action="" method="POST">
                                                        <input type="hidden" name="booking_id" value="$fetch_booking[booking_id]">
                                                        <button name="cancel" type="submit" onclick="return confirm('cancel this booking?');" class="btn w-100 text-white custom-bg shadow-none mb-1">Cancel Booking</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                                
                                        booking;
                        ?>
                                <!-- <h6 class="mb-4">₹$fetch_booking[price] per night</h6> -->
                            <?php
                            }
                        } else {

                            ?>
                            <div class="box" style="text-align: center;">
                                <p style="padding-bottom: .5rem; text-transform:capitalize;">no bookings found!</p>
                                <a href="index.php#reservation" class="btn">book new</a>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Footer Start -->
    <?php require('inc/footer.php'); ?>
    <!-- Footer End -->
    <script>
        // accessing data of booking_form,.. etc by storing in booking_form....
        let booking_form = document.getElementById('booking_form');
        let info_loader = document.getElementById('info_loader');
        let pay_info = document.getElementById('pay_info');

        // pay_now switch only available for available rooms....
        function check_availability() {
            let checkin_val = booking_form.elements['checkin'].value;
            let checkout_val = booking_form.elements['checkout'].value;
            booking_form.elements['pay_now'].setAttribute('disabled', true);

            if (checkin_val != '' && checkout_val != '') {
                pay_info.classList.add('d-none');
                pay_info.classList.replace('text-dark', 'text-danger');
                info_loader.classList.remove('d-none');

                let data = new FormData();

                data.append('check_availability', '');
                data.append('check_in', checkin_val);
                data.append('check_out', checkout_val);

                let xhr = new XMLHttpRequest();
                xhr.open("POST", "ajax/confirm_booking_crud.php", true);

                xhr.onload = function() {

                    let data = JSON.parse(this.responseText);

                    if (data.status == 'check_in_out_equal') {
                        pay_info.innerText = "You cannot check-out on the same day!";
                    } else if (data.status == 'check_out_earlier') {
                        pay_info.innerText = "Check-out date is earlier than check-in date!";
                    } else if (data.status == 'check_in_earlier') {
                        pay_info.innerText = "Check-in date is earlier than today's date!";
                    } else if (data.status == 'unavailable') {
                        pay_info.innerText = "Room not available for this check-in date!";
                    } else {
                        pay_info.innerHTML = "No. of Days: " + data.days + "<br>Total Amount to Pay: ₹" + data.payment;
                        pay_info.classList.replace('text-danger', 'text-dark');
                        booking_form.elements['pay_now'].removeAttribute('disabled');
                    }
                    pay_info.classList.remove('d-none');
                    info_loader.classList.add('d-none');
                }

                xhr.send(data);
            }
        }
    </script>

</body>

</html>