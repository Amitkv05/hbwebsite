
function get_users() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('users-data').innerHTML = this.responseText;
    }

    xhr.send('get_users');

}

 function toggle_status(id, val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {

        if (this.responseText == 1) {
            alert('success', 'Status toggled!');
            get_users();
        } else {
            alert('error', 'Server Down!');
        }
}

    xhr.send('toggle_status=' + id + '&value=' + val);

}



function remove_user(user_id)
{
    if(confirm("Are you sure, You want to remove this User?"))
    {
        let data = new FormData();
        data.append('user_id',user_id);
        data.append('remove_user', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/users_crud.php", true);
    
        xhr.onload = function () {
    
            if (this.responseText == 1) {
                alert('succeess', 'User Removed!');
                get_users();
            } 
            else {
                alert('error', 'User Removal failed!');
            }
        }
    
        xhr.send(data);
    }
}



window.onload = function () {
    get_users();
}