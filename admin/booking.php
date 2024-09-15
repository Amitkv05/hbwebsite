<?php
require('inc/essentials.php');
require('inc/db_config.php');
adminLogin();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users-Panel</title>
    <?php require('inc/link.php') ?>
</head>

<body class="bg-light">

    <?php require('inc/header.php') ?>

    <div class="container-fluid" id="main-content">
        <div class="row">

            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="d-flex align-items-center justify-content-center mb-4 fw-bold">Booking</h3>
                <!-- Rooms section-->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">

                        <div class="text-end mb-4">
                            <!-- <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#add-room">
                                <i class="bi bi-plus-square"></i>Add
                            </button> -->
                        </div>

                        <div class="table-responsive" style="height: 550px; overflow-y:scroll;">
                            <table class="table table-hover border text-center" style="min-width: 1100px;">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Number</th>
                                        <th scope="col">Check IN</th>
                                        <th scope="col">Check OUT</th>
                                        <th scope="col">Rooms</th>
                                        <th scope="col">Adult</th>
                                        <th scope="col">Children</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="booking-data">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





        <!--Assign Room modal(Edit-Button) -->
        <div class="modal fade " id="assign-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="assign_room_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Assign Room</h1>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Room Number</label>
                            <input type="text" name="room_no" class="form-control shadow-none" required>
                        </div>
                    </div>
                    <span class="badge rounded-pill text-dark bg-light text-wrap lh-base">
                        Note: Assign Room Number Only When User Has Been Arrived.
                    </span>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondar shadow-none" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">Assign</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php require('inc/scripts.php'); ?>
    <script src="scripts/booking.js">
    </script>
</body>

</html>