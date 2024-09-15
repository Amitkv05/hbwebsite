// stringify is use to convert the value into string.......


let add_destination_form = document.getElementById('add_destination_form');

add_destination_form.addEventListener('submit', function (e) {
    e.preventDefault();
    add_destination();
});

function add_destination() {
    let data = new FormData();
    data.append('add_destination', '');
    data.append('name', add_destination_form.elements['name'].value);
    data.append('price', add_destination_form.elements['price'].value);
    data.append('description', add_destination_form.elements['description'].value);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/destination.php", true);

    xhr.onload = function () {

        // hide the popup edit button
        var myModal = document.getElementById('add-destination')
        var modal = bootstrap.Modal.getInstance(myModal)
        modal.hide();

        if (this.responseText == '1') {
            alert('success', 'New destination Added!');
            add_destination_form.reset();
            get_all_destination();
        } else {
            alert('error', 'Server Down!');
        }
        // console.log(this.responseText); // to check the response
    }

    xhr.send(data);
}


function get_all_destination() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/destination.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('destination-data').innerHTML = this.responseText;
    }

    xhr.send('get_all_destination');

}


let edit_destination_form = document.getElementById('edit_destination_form');


function edit_details(id) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/destination.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        let data = JSON.parse(this.responseText);
        edit_destination_form.elements['name'].value = data.destinationdata.name;
        edit_destination_form.elements['price'].value = data.destinationdata.price;
        edit_destination_form.elements['description'].value = data.destinationdata.description;
        edit_destination_form.elements['destination_id'].value = data.destinationdata.id;
    }

    xhr.send('get_destination=' + id);
}

edit_destination_form.addEventListener('submit', function (e) {
    e.preventDefault();
    submit_edit_destination();
});

function submit_edit_destination() {
    let data = new FormData();
    data.append('edit_destination', '');
    data.append('destination_id', edit_destination_form.elements['destination_id'].value);
    data.append('name', edit_destination_form.elements['name'].value);
    data.append('price', edit_destination_form.elements['price'].value);
    data.append('description', edit_destination_form.elements['description'].value);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/destination.php", true);

    xhr.onload = function () {

        // hide the popup edit button
        var myModal = document.getElementById('edit-destination')
        var modal = bootstrap.Modal.getInstance(myModal)
        modal.hide();

        if (this.responseText == '1') {
            alert('success', 'destination data edited!');
            edit_destination_form.reset();
            edit_destination_form();
        } else {
            alert('error', 'Server Down!');
        }
        // console.log(this.responseText); // to check the response
    }

    xhr.send(data);
}


function toggle_status(id, val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/destination.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {

        if (this.responseText == 1) {
            alert('success', 'Status toggled!');
            get_all_destination();
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
    data.append('destination_id', add_image_form.elements['destination_id'].value);
    data.append('add_image', '');


    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/destination.php", true);

    xhr.onload = function () {

        if (this.responseText == 'inv_img') {
            alert('error', 'Only JPG, WEBP or PNG images are allowed!', 'image-alert');
        } else if (this.responseText == 'inv_size') {
            alert('error', 'Image should be less than 2MB!', 'image-alert');
        } else if (this.responseText == 'upd_failed') {
            alert('error', 'Image upload failed. Server Down!', 'image-alert');
        } else {
            alert('success', 'New Image Added!', 'image-alert');
            destination_images(add_image_form.elements['destination_id'].value,document.querySelector("#destination-images .modal-title").innerText);
            add_image_form.reset();
        }
        // console.log(this.responseText); // to check the response
    }

    xhr.send(data);
}

function destination_images(id,rname) {
    document.querySelector("#destination-images .modal-title").innerText = rname;
    add_image_form.elements['destination_id'].value = id;
    add_image_form.elements['image'].value = '';

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/destination.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('destination-images-data').innerHTML = this.responseText;
    }

    xhr.send('get_destination_images='+id);
}

function rem_image(img_id,destination_id)
{
    let data = new FormData();
    data.append('image',img_id);
    data.append('destination_id',destination_id);
    data.append('rem_image', '');
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/destination.php", true);

    xhr.onload = function () {

        if (this.responseText == 1) {
            alert('error', 'Image Removed!', 'image-alert');
            destination_images(destination_id,document.querySelector("#destination-images .modal-title").innerText);
        } 
        else {
            alert('error', 'Image Removal failed!', 'image-alert');
        }
    }
    xhr.send(data);
}
function thumb_image(img_id,destination_id)
{
    let data = new FormData();
    data.append('image_id',img_id);
    data.append('destination_id',destination_id);
    data.append('thumb_image', '');


    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/destination.php", true);

    xhr.onload = function () {

        if (this.responseText == 1) {
            alert('succeess', 'Image Thumbnail Changed!', 'image-alert');
            destination_images(destination_id,document.querySelector("#destination-images .modal-title").innerText);
        } 
        else {
            alert('error', 'Thumbnail Update failed!', 'image-alert');
        }
    }
    xhr.send(data);
}
function remove_destination(destination_id)
{
    if(confirm("Are you sure, You want to delete this destination?"))
    {
        let data = new FormData();
        data.append('destination_id',destination_id);
        data.append('remove_destination', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/destination.php", true);
    
        xhr.onload = function () {
    
            if (this.responseText == 1) {
                alert('succeess', 'destination Removed!');
                get_all_destination();
            } 
            else {
                alert('error', 'destination Removal failed!');
            }
        }
        xhr.send(data);
    }
}
window.onload = function () {
    get_all_destination();

}