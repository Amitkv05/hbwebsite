<!-- Footer -->
    <div class="container-fluid mt-5" id="footer">
        <div class="row">
            <div class="col-lg-4 p-4">
                <h3 class="h-font fw-bold fs-3 mb-2"><?php echo $settings_r['site_title'] ?></h3>
                <p>
                    <?php echo $settings_r['site_about'] ?>
                </p>
            </div>
            <div class="col-lg-4 p-4">
                <h5 class="mb-3">Links</h5>
                <a href="index.php" class="d-inline-block mb-2 text-light text-decoration-none">Home</a> <br>
                <a href="Rooms.php" class="d-inline-block mb-2 text-light text-decoration-none">Rooms</a> <br>
                <a href="Facilities.php" class="d-inline-block mb-2 text-light text-decoration-none">Facilities</a> <br>
                <a href="contact.php" class="d-inline-block mb-2 text-light text-decoration-none">Contact Us</a> <br>
                <a href="About.php" class="d-inline-block mb-2 text-light text-decoration-none">About</a> <br>
            </div>
            <div class="col-lg-4 p-4">
                <h5 class="mb-3">Follow Us</h5>
                <?php
                if ($contact_r['tw'] != '') {
                    echo <<<data
                            <a href="$contact_r[tw]" class="d-inline-block mb-3">
                                <span class="badge bg-light text-dark fs-6 p-2">
                                    <i class="bi bi-twitter"></i> Twitter
                                </span>
                            </a>
                        data;
                }
                ?>


                <br>
                <a href="<?php echo $contact_r['fb'] ?>" class="d-inline-block mb-3">
                    <span class="badge bg-light text-dark fs-6 p-2">
                        <i class="bi bi-facebook"></i></i> Facebook</span>
                </a>
                <br>
                <a href="<?php echo $contact_r['insta'] ?>" class="d-inline-block mb-3">
                    <span class="badge bg-light text-dark fs-6 p-2">
                        <i class="bi bi-instagram"></i></i> Instagram</span>
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <script>
        function setActive() {
            let navbar = document.getElementById('nav-bar');
            let a_tags = navbar.getElementsByTagName('a');

            for (i = 0; i < a_tags.length; i++) {
                let file = a_tags[i].href.split('/').pop();
                let file_name = file.split('.')[0];

                if (document.location.href.indexOf(file_name) >= 0) {
                    a_tags[i].classList.add('active');
                }
            }
        }
        function checkLoginToSelect(status,destination_id){
            if(status){
                window.location.href='rooms.php?id='+destination_id;
            }
            else{
                alert('error','Please Login First!');
            }
        }
        function checkLoginToBook(status,room_id){
            if(status){
                window.location.href='confirm_booking.php?id='+room_id;
            }
            else{
                alert('error','Please Login First!');
            }
        }
    
        setActive();
    </script>