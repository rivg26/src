$(document).ready(function () {
    for (let x = 0; x < 2; x++) {
        $(document).on('click',".show_hide_password"+ x +" a" ,{'classx': x} ,function(e) {
            e.preventDefault();
            if ($('.show_hide_password'+ e.data.classx +' input').attr("type") == "text") {
                $('.show_hide_password'+ e.data.classx +' input').attr('type', 'password');
                $('.show_hide_password'+ e.data.classx +' i').addClass("fa-eye-slash");
                $('.show_hide_password'+ e.data.classx +' i').removeClass("fa-eye");
            } else if ($('.show_hide_password'+ e.data.classx +' input').attr("type") == "password") {
                $('.show_hide_password'+ e.data.classx +' input').attr('type', 'text');
                $('.show_hide_password'+ e.data.classx +' i').removeClass("fa-eye-slash");
                $('.show_hide_password'+ e.data.classx +' i').addClass("fa-eye");
            }
        });
    }

   
});