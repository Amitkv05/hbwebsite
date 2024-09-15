
        // accessing data of booking_form,.. etc by storing in booking_form....
        let booking_form = document.getElementById('booking_form');
        let info_loader = document.getElementById('info_loader');
        let pay_info = document.getElementById('pay_info');

        // book switch only available for available rooms....
        function check_availability() {
            let check_in_val = booking_form.elements['check_in'].value;
            let check_out_val = booking_form.elements['check_out'].value;
            booking_form.elements['book'].setAttribute('disabled', true);

            if (check_in_val != '' && check_out_val != '') {
                pay_info.classList.add('d-none');
                pay_info.classList.replace('text-dark', 'text-danger');
                info_loader.classList.remove('d-none');

                let data = new FormData();

                data.append('check_availability', '');
                data.append('check_in', check_in_val);
                data.append('check_out', check_out_val);

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
                        booking_form.elements['book'].removeAttribute('disabled');
                    }
                    pay_info.classList.remove('d-none');
                    info_loader.classList.add('d-none');
                }

                xhr.send(data);
            }
        }