//send a delete company ajax request
function deleteCompany(id) {
    $.ajax({
        url: '/company/'+id,
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            _method: 'DELETE'
        },
        success: function (data) {
            $('#deleteCompanyModal' + id).modal('hide');
            $('tr.'+id).fadeOut('slow');
            notify("Customer Deleted!");
        },
        error: function (data) {
            notify("Error Occurred While Deleting A Company");
            console.log(data);
        }
    });
}

//send an update company request
function updateCompany(id) {
    $('form#' + id).submit();
}

//send password update request to server
function updatePassword() {
    let newPassword = $("input[name='new_password']").val();
    let id = $("[name='select_user']").find(':selected').val();
    let username = $("[name='select_user']").find(':selected').text();
    if (newPassword.length <= 4) {
        return;
    }else{
        $.ajax({
            url: '/user/'+id,
            type: 'POST',
            data: {
                _method: 'PATCH',
                _token: $('meta[name="csrf-token"]').attr('content'),
                password: newPassword,
                username: username
            },
            success: function (data) {
                $("#editPassword").val('');
                notify("Password Changed");
            },
            error: function (data) {
                notify("Error Occured While Changing Password");
                console.log(data);
            }
        });
    }
}