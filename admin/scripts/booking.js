
function get_booking() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/booking_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('booking-data').innerHTML = this.responseText;
    }

    xhr.send('get_booking');

}


let assign_room_form = document.getElementById('assign_room_form');

function assign_room(id){
    assign_room_form.elements['booking_id'].value=id;
}

assign_room_form.addEventListener('submit',function(e){
    e.preventDefault();


        let data = new FormData();
        data.append('room_no', assign_room_form.elements['room_no'].value);
        data.append('booking_id', assign_room_form.elements['booking_id'].value);
        data.append('assign_room');


        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/booking_crud.php", true);

        xhr.onload = function() {

            // hide the popup edit button
            var myModal = document.getElementById('assign-room')
            var modal = bootstrap.Modal.getInstance(myModal)
            modal.hide();

        xhr.send(data);

        if(this.responseText==1){
            alert('success','Room Number Alloted! Booking Finalized!');
            assign_room_form.reset();
            get_booking()
        }
        else{
            alert('error','Server Down!');
        }
    }
})






function cancel_booking(booking_id)
{
    if(confirm("Are you sure, You want to Cancel this booking?"))
    {
        let data = new FormData();
        data.append('booking_id',booking_id);
        data.append('cancel_booking', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/booking_crud.php", true);
    
        xhr.onload = function () {
    
            if (this.responseText == 1) {
                alert('succeess', 'Booking Cancelled!');
                get_booking();
            } 
            else {
                alert('error', 'Booking Cancelled Failed!');
            }
        }
    
        xhr.send(data);
    }
}

window.onload = function () {
    get_booking();
}