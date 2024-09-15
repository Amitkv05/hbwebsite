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
    <title>User Queries-Panel</title>
    <?php require('inc/link.php') ?>
</head>
<body class="bg-light">

    <?php require('inc/header.php') ?>
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="d-flex align-items-center justify-content-center mb-4 fw-bold">User Queries</h3>

                <div class="card border-0 shadow mb-4">
                    <div class="card-body">

                        <div class="text-end md-4">
                            <a href="?seen=all" class="btn btn-dark rounded-pill shadow-none btn-sm mb-2"><i class="bi bi-check-all"></i> Mark all Read</a>
                            <a href="?del=all" class="btn btn-danger rounded-pill shadow-none btn-sm mb-2"><i class="bi bi-trash"></i> Delete all</a>
                        </div>

                        <div class="table-responsive-md" style="height: 550px; overflow-y:scroll;">
                            <table class="table table-hover border">
                                <thead class="sticky-top">
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col" width="20%">Subject</th>
                                        <th scope="col" width="20%">Message</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $q = "SELECT * FROM `user_queries` ORDER BY `s_no` DESC";
                                    $data = mysqli_query($con, $q);
                                    $i = 1;

                                    while ($row = mysqli_fetch_assoc($data)) {
                                        $date = date('d-m-y', strtotime($row["datentime"]));
                                        $seen = '';
                                        if ($row['seen'] != 1) {
                                            $seen = "<a href='?seen=$row[s_no]' class='btn btn-primary btn-sm rounded-pill'>Mark as read</a> <br>";
                                        }
                                        $seen.= "<a href='?del=$row[s_no]' class='btn btn-danger btn-sm rounded-pill mt-2'>Delete</a>";

                                        echo <<<query
                                            <tr>
                                                <td>$i</td>
                                                <td>$row[name]</td>
                                                <td>$row[email]</td>
                                                <td>$row[subject]</td>
                                                <td>$row[message]</td>
                                                <td>$date</td>
                                                <td>$seen</td>
                                            </tr>
                                        query;
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php require('inc/scripts.php'); ?>

</body>

</html>