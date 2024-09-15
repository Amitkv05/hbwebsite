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
                <h3 class="d-flex align-items-center justify-content-center mb-4 fw-bold">Users</h3>
                <!-- Rooms section-->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive" style="height: 550px; overflow-y:scroll;">
                            <table class="table table-hover border text-center">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="users-data">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require('inc/scripts.php'); ?>
    <script src="scripts/users.js">
    </script>
</body>

</html>