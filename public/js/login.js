function onNextClick() {
    if ($("input[type='email']")[0].checkValidity()){
        $("#login_email_wrapper").slideUp('fast');
        $("#login_password_wrapper").show('slow');
        $("#login_password_wrapper").removeClass('invisible');
    }else{
        $("button[type='submit']").click();
    }
}