// Validate
$(document).ready(function () {
    $('#user-register-submit-btn').click(function (e) {
        if (!$('#user_name').val()) {
            alert('Chưa nhập tên truy cập');
            return;
        }
        if (!$('#password').val()) {
            alert('Chưa nhập mật khẩu');
            return;
        }
        if ($('#password').val() != $('#confirm-password').val()) {
            alert('Mật khẩu xác nhận phải giống với mật khẩu đã nhập');
            return;
        }
        if (!$('#full_name').val()) {
            alert('Chưa nhập họ tên');
            return;
        }
        if (!$('#email-register').val()) {
            alert('Chưa nhập email');
            return;
        } else {
            var email = $('#email-register').val();
            var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
            if (!filter.test(email)) {
                alert('Chưa đúng định dạng email');
                return;
            }
        }
        var data = $("#user-register-form").serialize();
        $.ajax({
            type: "POST",
            url: "vi/user/register/store",
            data: data, // serializes the form's elements.
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            success: function (response) {
                if (response['errors']) {
                    alert(response['errors']);
                    return;
                } else {
                    alert('Bạn đã đăng ký thành công. Mời đăng nhập để đăng tin bất động sản !');
                    location.reload();
                }

            },
            error: function () {
                alert('Đã có lỗi xảy ra. Mời thử lại');
            }
        });
        e.preventDefault();
    });

    // not input space and special character
    $('#user_name').on('keypress', function (e) {
        var k = e.which;
        var char = k >= 97 && k <= 122 || // a-z
                k >= 48 && k <= 57 //0-9 ;
        if (!char) {
            e.preventDefault();
        }
//        k >= 65 && k <= 90 || // A-Z
    });

    $("body").on('focus', '.user-register-form .register-content .row #user_name', function (e) {
        $(this).parents('.row').find('.hint-user-name').show();
    });
    $("body").on('blur', '.user-register-form .register-content .row #user_name', function (e) {
        $(this).parents('.row').find('.hint-user-name').hide();
    });

    $("body").on('focus', '.user-register-form .register-content .row #password', function (e) {
        $(this).parents('.row').find('.hint-password').show();
    });
    $("body").on('blur', '.user-register-form .register-content .row #password', function (e) {
        $(this).parents('.row').find('.hint-password').hide();
    });

});