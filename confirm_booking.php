<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/link.php'); ?>
    <title><?php echo $settings_r['site_title'] ?>--Confirm Booking</title>

    <!-- Swiperjs -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

</head>

<body>

    <?php require('inc/header.php'); ?>
    <?php

    if (!isset($_GET['id']) || $settings_r['shutdown'] == true) {
        redirect('rooms.php');
    } else if (!(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true)) {
        redirect('rooms.php');
    }
    #filter and get rooms data...

    $data = filteration($_GET);
    $rooms_res = select("SELECT * FROM `rooms` WHERE `id`=? AND`status`=? AND `removed`=?", [$data['id'], 1, 0], 'iii');

    if (mysqli_num_rows($rooms_res) == 0) {
        redirect('rooms.php');
    }

    $rooms_data = mysqli_fetch_assoc($rooms_res);

    $_SESSION['rooms'] = [
        "id" => $rooms_data["id"],
        "name" => $rooms_data["name"],
        "price" => $rooms_data["price"],
        "payment" => null,
        "available" => false,
    ];


    // #filter and get package data..
    $package_res = select("SELECT * FROM `package` WHERE `id`=? AND`status`=? AND `removed`=?", [$data['id'], 1, 0], 'iii');

    $package_data = mysqli_fetch_assoc($package_res);

    $_SESSION['package'] = [
        "id" => $package_data["id"],
        "name" => $package_data["name"],
    ];


    $user_res = selectAll('users');
    $user_data = mysqli_fetch_assoc($user_res);

// booking database.....

    // include 'components/connect.php';

    if (isset($_COOKIE['user_id'])) {
        $user_id = $_COOKIE['user_id'];
    } else {
        setcookie('user_id', create_unique_id(), time() + 60 * 60 * 24 * 30, '/');
        header('location:index.php');
    }

    if (isset($_POST['book'])) {

        $booking_id = create_unique_id();
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $number = $_POST['number'];
        $number = filter_var($number, FILTER_SANITIZE_STRING);
        $rooms = $_POST['room'];
        $rooms = filter_var($rooms, FILTER_SANITIZE_STRING);
        $check_in = $_POST['check_in'];
        $check_in = filter_var($check_in, FILTER_SANITIZE_STRING);
        $check_out = $_POST['check_out'];
        $check_out = filter_var($check_out, FILTER_SANITIZE_STRING);
        $adults = $_POST['adults'];
        $adults = filter_var($adults, FILTER_SANITIZE_STRING);
        $childs = $_POST['childs'];
        $childs = filter_var($childs, FILTER_SANITIZE_STRING);

        $total_rooms = 0;

        $check_bookings = $conn->prepare("SELECT * FROM `bookings` WHERE check_in = ?");
        $check_bookings->execute([$check_in]);

        while ($fetch_bookings = $check_bookings->fetch(PDO::FETCH_ASSOC)) {
            $total_rooms += $fetch_bookings['rooms'];
        }

        if ($total_rooms >= 30) {
            $warning_msg[] = 'rooms are not available';
        } else {

            $verify_bookings = $conn->prepare("SELECT * FROM `bookings` WHERE user_id = ? AND name = ? AND email = ? AND number = ? AND rooms = ? AND check_in = ? AND check_out = ? AND adults = ? AND childs = ?");
            $verify_bookings->execute([$user_id, $name, $email, $number, $rooms, $check_in, $check_out, $adults, $childs]);

            if ($verify_bookings->rowCount() > 0) {
                $warning_msg[] = 'rooms booked alredy!';
            } else {
                $book_rooms = $conn->prepare("INSERT INTO `bookings`(booking_id, user_id, name, email, number, rooms, check_in, check_out, adults, childs) VALUES(?,?,?,?,?,?,?,?,?,?)");
                $book_rooms->execute([$booking_id, $user_id, $name, $email, $number, $rooms, $check_in, $check_out, $adults, $childs]);
                $success_msg[] = 'rooms booked successfully!';
            }
        }
    }

?>



    <div class="container">
        <div class="row ">

            <div class="col-12 my-5 mb-4 pc-4">
                <h2 class="fw-bold">Confirm Booking</h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">Home</a>
                    <span class="text-secondary">></span>
                    <a href="rooms.php" class="text-secondary text-decoration-none">rooms</a>
                    <span class="text-secondary">></span>
                    <a href="#" class="text-secondary text-decoration-none">Confirm</a>
                </div>
            </div>

            <div class="col-lg-7 col-md-12 px-4">
                <?php
                // get thumbnail of rooms

                $rooms_thumb = ROOMS_IMG_PATH . "thumbnail.jpg";
                $thumb_q = mysqli_query($con, "SELECT * FROM `room_images` 
                        WHERE `room_id` = '$rooms_data[id]' 
                        AND `thumb` ='1'");

                if (mysqli_num_rows($thumb_q) > 0) {
                    $thumb_res = mysqli_fetch_assoc($thumb_q);
                    $rooms_thumb = ROOMS_IMG_PATH . $thumb_res['image'];
                }

                echo <<<data
                    <div class="card p-3 shadow-sm rounded">
                        <img src="$rooms_thumb" class="img-fluid rounded mb-3">
                        <h5>$rooms_data[name]</h5>
                        <h6 class="mb-4">₹$rooms_data[price] per night</h6>
                    </div>
                data;
                ?>
            </div>

            <div id="reservation" class="col-lg-5 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <form action="#" id="booking_form" method="post">
                            <h6 class="mb-3">Booking Details</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Room Name</label>
                                    <input name="name" type="text" value="<?php echo $rooms_data["name"] ?>" class="input form-control shadow-none" required>
                                    <!-- value="?php echo $result_fetch['username'] ?>" -->
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">User Name</label>
                                    <input name="name" type="text" value="<?php echo $user_data["name"] ?>" class="input form-control shadow-none" required>
                                    <!-- value="?php echo $result_fetch['username'] ?>" -->
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Package Name</label>
                                    <input name="name" type="text" value="<?php echo $package_data["name"] ?>" class="input form-control shadow-none" required>
                                    <!-- value="?php echo $result_fetch['username'] ?>" -->
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="input form-control shadow-none">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone Number</label>
                                    <!-- <input name="phonenum" type="number" class="form-control shadow-none" required> -->
                                    <input type="number" name="number" max="9999999999" class="input form-control shadow-none">

                                </div>
                                <div class="col-md-6 box">
                                    <label class="form-label">rooms</label>
                                    <br>
                                    <select name="room" class="input" required>
                                        <option value="1" selected>1 rooms</option>
                                        <option value="2">2 rooms</option>
                                        <option value="3">3 rooms</option>
                                        <option value="4">4 rooms</option>
                                        <option value="5">5 rooms</option>
                                        <option value="6">6 rooms</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Check-in</label>
                                    <input name="check_in" onchange="check_availability()" type="date" class="input form-control shadow-none" required>

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">check-out</label>
                                    <input name="check_out" onchange="check_availability()" type="date" class="input form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">adults</label>
                                    <select name="adults" class="input" required>
                                        <option value="1" selected>1 adult</option>
                                        <option value="2">2 adults</option>
                                        <option value="3">3 adults</option>
                                        <option value="4">4 adults</option>
                                        <option value="5">5 adults</option>
                                        <option value="6">6 adults</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">childs</label>
                                    <select name="childs" class="input" required>
                                        <option value="0" selected>0 child</option>
                                        <option value="1">1 child</option>
                                        <option value="2">2 childs</option>
                                        <option value="3">3 childs</option>
                                        <option value="4">4 childs</option>
                                        <option value="5">5 childs</option>
                                        <option value="6">6 childs</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <div class="spinner-border text-info d-none mb-3" id="info_loader" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>

                                    <h6 class="mb-3 text-danger" id="pay_info">Provide check-in & check-out date!</h6>

                                    <button name="book" type="submit" class="btn w-100 text-white custom-bg shadow-none mb-1" disabled>Pay Now</button>
                                    <!-- disabled -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Footer Start -->
    <?php require('inc/footer.php'); ?>
    <script src="js/confirm_booking.js">
    </script>
    <!-- Footer End -->

    <?php include 'components/message.php'; ?>

</body>

</html>