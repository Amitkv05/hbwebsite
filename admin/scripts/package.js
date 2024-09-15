    // stringify is use to convert the value into string.......


    let add_package_form = document.getElementById('add_package_form');

    add_package_form.addEventListener('submit', function (e) {
        e.preventDefault();
        add_package();
    });

    function add_package() {
        let data = new FormData();
        data.append('add_package', '');
        data.append('name', add_package_form.elements['name'].value);
        data.append('title', add_package_form.elements['title'].value);
        data.append('description', add_package_form.elements['description'].value);
        data.append('destination', add_package_form.elements['destination'].value);
        data.append('price', add_package_form.elements['price'].value);
        data.append('age_range', add_package_form.elements['age_range'].value);
        data.append('regions', add_package_form.elements['regions'].value);
        data.append('operated_in', add_package_form.elements['operated_in'].value);

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/package.php", true);

        xhr.onload = function () {

            // hide the popup edit button
            var myModal = document.getElementById('add-package')
            var modal = bootstrap.Modal.getInstance(myModal)
            modal.hide();

            if (this.responseText == '1') {
                alert('success', 'New package Added!');
                add_package_form.reset();
                get_all_package();
            } else {
                alert('error', 'Server Down!');
            }
            // console.log(this.responseText); // to check the response
        }

        xhr.send(data);
    }


    function get_all_package() {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/package.php", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function () {
            document.getElementById('package-data').innerHTML = this.responseText;
        }

        xhr.send('get_all_package');

    }


    let edit_package_form = document.getElementById('edit_package_form');


    function edit_details(id) {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/package.php", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function () {


            let data = JSON.parse(this.responseText);
            edit_package_form.elements['name'].value = data.packagedata.name;
            edit_package_form.elements['title'].value = data.packagedata.title;
            edit_package_form.elements['description'].value = data.packagedata.description;
            edit_package_form.elements['destination'].value = data.packagedata.destination;
            edit_package_form.elements['price'].value = data.packagedata.price;
            edit_package_form.elements['age_range'].value = data.packagedata.age_range;
            edit_package_form.elements['regions'].value = data.packagedata.regions;
            edit_package_form.elements['operated_in'].value = data.packagedata.operated_in;
            edit_package_form.elements['package_id'].value = data.packagedata.id;
        }

        xhr.send('get_package=' + id);
    }

    edit_package_form.addEventListener('submit', function (e) {
        e.preventDefault();
        submit_edit_package();
    });

    function submit_edit_package() {
        let data = new FormData();
        data.append('edit_package', '');
        data.append('package_id', edit_package_form.elements['package_id'].value);
        data.append('name', edit_package_form.elements['name'].value);
        data.append('title', edit_package_form.elements['title'].value);
        data.append('description', edit_package_form.elements['description'].value);
        data.append('destination', edit_package_form.elements['destination'].value);
        data.append('price', edit_package_form.elements['price'].value);
        data.append('age_range', edit_package_form.elements['age_range'].value);
        data.append('regions', edit_package_form.elements['regions'].value);
        data.append('operated_in', edit_package_form.elements['operated_in'].value);

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/package.php", true);

        xhr.onload = function () {

            // hide the popup edit button
            var myModal = document.getElementById('edit-package')
            var modal = bootstrap.Modal.getInstance(myModal)
            modal.hide();

            if (this.responseText == '1') {
                alert('success', 'package data edited!');
                edit_package_form.reset();
                edit_package_form();
            } else {
                alert('error', 'Server Down!');
            }
            // console.log(this.responseText); // to check the response
        }

        xhr.send(data);
    }


    function toggle_status(id, val) {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/package.php", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function () {

            if (this.responseText == 1) {
                alert('success', 'Status toggled!');
                get_all_package();
            } else {
                alert('error', 'Server Down!');
            }
        }

        xhr.send('toggle_status=' + id + '&value=' + val);

    }

    let add_image_form = document.getElementById('add_image_form');

    add_image_form.addEventListener('submit', function (e) {
        e.preventDefault();
        add_image();
    })

    function add_image() {
        let data = new FormData();
        data.append('image', add_image_form.elements['image'].files[0]);
        data.append('package_id', add_image_form.elements['package_id'].value);
        data.append('add_image', '');


        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/package.php", true);

        xhr.onload = function () {

            if (this.responseText == 'inv_img') {
                alert('error', 'Only JPG, WEBP or PNG images are allowed!', 'image-alert');
            } else if (this.responseText == 'inv_size') {
                alert('error', 'Image should be less than 2MB!', 'image-alert');
            } else if (this.responseText == 'upd_failed') {
                alert('error', 'Image upload failed. Server Down!', 'image-alert');
            } else {
                alert('success', 'New Image Added!', 'image-alert');
                package_img(add_image_form.elements['package_id'].value,document.querySelector("#package-img .modal-title").innerText);
                add_image_form.reset();
            }
            // console.log(this.responseText); // to check the response
        }

        xhr.send(data);
    }

    function package_img(id,rname) {
        document.querySelector("#package-img .modal-title").innerText = rname;
        add_image_form.elements['package_id'].value = id;
        add_image_form.elements['image'].value = '';

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/package.php", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function () {
            document.getElementById('package-img-data').innerHTML = this.responseText;
        }

        xhr.send('get_package_img='+id);
    }

    function rem_image(img_id,package_id)
    {
        let data = new FormData();
        data.append('image',img_id);
        data.append('package_id',package_id);
        data.append('rem_image', '');


        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/package.php", true);

        xhr.onload = function () {

            if (this.responseText == 1) {
                alert('error', 'Image Removed!', 'image-alert');
                package_img(package_id,document.querySelector("#package-img .modal-title").innerText);
            } 
            else {
                alert('error', 'Image Removal failed!', 'image-alert');
            }
        }

        xhr.send(data);

    }

    function thumb_image(img_id,package_id)
    {
        let data = new FormData();
        data.append('image_id',img_id);
        data.append('package_id',package_id);
        data.append('thumb_image', '');


        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/package.php", true);

        xhr.onload = function () {

            if (this.responseText == 1) {
                alert('succeess', 'Image Thumbnail Changed!', 'image-alert');
                package_img(package_id,document.querySelector("#package-img .modal-title").innerText);
            } 
            else {
                alert('error', 'Thumbnail Update failed!', 'image-alert');
            }
        }

        xhr.send(data);

    }

    function remove_package(package_id)
    {
        if(confirm("Are you sure, You want to delete this package?"))
        {
            let data = new FormData();
            data.append('package_id',package_id);
            data.append('remove_package', '');

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/package.php", true);
        
            xhr.onload = function () {
        
                if (this.responseText == 1) {
                    alert('succeess', 'package Removed!');
                    get_all_package();
                } 
                else {
                    alert('error', 'package Removal failed!');
                }
            }
        
            xhr.send(data);
        }




    }



    window.onload = function () {
        get_all_package();

    }