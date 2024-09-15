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
    <title>Package-Panel</title>
    <?php require('inc/link.php') ?>
</head>

<body class="bg-light">

    <?php require('inc/header.php') ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="d-flex align-items-center justify-content-center mb-4 fw-bold">Package</h3>
                <!-- Rooms section-->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">

                        <div class="text-end mb-4">
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#add-package">
                                <i class="bi bi-plus-square"></i>Add
                            </button>
                        </div>

                        <div class="table-responsive-lg" style="height: 550px; overflow-y:scroll;">
                            <table class="table table-hover border text-center" style="min-width: 1400px; font-size:13px;">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Destination</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Age Range</th>
                                        <th scope="col">regions</th>
                                        <th scope="col">Operated_in</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="package-data">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Add Room modal(Edit-Button) -->
    <div class="modal fade " id="add-package" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="add_package_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Add Package</h1>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Name</label>
                                <input type="text" name="name" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Title</label>
                                <input type="text" name="title" class="form-control shadow-none" required>
                            </div>
                            <div class="col-12 md-3">
                                <label class="form-label fw-bold">Description</label>
                                <textarea name="description" rows="4" class="form-control shadow-none" required></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Destination</label>
                                <input type="text" name="destination" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Price</label>
                                <input type="number" min="1" name="price" class="form-control shadow-none">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Age Range</label>
                                <input type="text" name="age_range" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">regions</label>
                                <input type="text" name="regions" class="form-control shadow-none">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Operated_in</label>
                                <input type="text" name="operated_in" class="form-control shadow-none" required>
                            </div>                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondar shadow-none" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- Edit Room Modal -->

    <div class="modal fade " id="edit-package" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="edit_package_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Edit Package</h1>
                    </div>
                    <div class="modal-body">
                    <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Name</label>
                                <input type="text" name="name" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Title</label>
                                <input type="text" name="title" class="form-control shadow-none" required>
                            </div>
                            <div class="col-12 md-3">
                                <label class="form-label fw-bold">Description</label>
                                <textarea name="description" rows="4" class="form-control shadow-none" required></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Destination</label>
                                <input type="text" name="destination" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Price</label>
                                <input type="number" min="1" name="price" class="form-control shadow-none" >
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Age Range</label>
                                <input type="text" name="age_range" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">regions</label>
                                <input type="text" name="regions" class="form-control shadow-none">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Operated_in</label>
                                <input type="text" name="operated_in" class="form-control shadow-none" required>
                            </div>                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondar shadow-none" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- Manage room images modals -->
    <div class="modal fade" id="package-img" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title">Package Name</h1>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="image-alert"></div>
                    <div class="border-bottom border-3 pb-3 mb-3">
                        <form id="add_image_form">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Add Images</label>
                                <input type="file" name="image" accept=".jpg, .png, .webp, .jpeg" class="form-control shadow-none mb-3" required>
                                <button class="btn custom-bg text-white shadow-none">ADD</button>
                                <input type="hidden" name="package_id">
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive-lg" style="height: 350px; overflow-y:scroll;">
                        <table class="table table-hover border text-center">
                            <thead>
                                <tr class="bg-dark text-light sticky-top">
                                    <th scope="col" width="60%">Image</th>
                                    <th scope="col">Thumb</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody id="package-img-data">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require('inc/scripts.php'); ?>
    <script src="scripts/package.js">
    </script>
</body>

</html>