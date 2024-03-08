$(document).ready(function(){
    $('.dropdown-toggle').click(function(e) {
        $('.dropdown-menu').toggle();
        $('.dropdown-menu').addClass("active");
    });

    $(document).click(function(e) {
        var target = e.target;
        if (!$(target).is('.dropdown-toggle') && !$(target).parents().is('.dropdown-toggle')) {
            $('.dropdown-menu').hide();
            $('.dropdown-menu').removeClass("active");
        }
    });

    var dropdownItems = document.querySelectorAll('.dropdown-item');

    for (var i = 0; i < dropdownItems.length; i++) {
        dropdownItems[i].addEventListener('click', function(e) {
            e.preventDefault();
            var language = this.textContent.trim();
            localStorage.setItem('language', language);
            location.reload();
        });
    }
});

window.onload = function() {
    var email = sessionStorage.getItem('email');
    if (email) {
        $.ajax({
            type: "POST",
            url: '/DoAnNhom/file_uploaded/php/countFile.php',
            data: {
                email: email
            },
            success: function(data) {
                $('.upload').html(data + '<span>Đã tải lên</span>');
            }
        });
    } else {
        $('.upload').html('0<span>Đã tải lên</span>');
    }

    var username = sessionStorage.getItem('username');
    if (username) {
        document.querySelector('.username-display').textContent = username;
    }

    var loginButton = document.querySelector('.btn_Signin');

    if (username) {
        loginButton.textContent = 'Đăng xuất';
    } else {
        loginButton.textContent = 'Đăng nhập';
    }

    loginButton.addEventListener('click', function() {
        if (this.textContent === 'Đăng xuất') {
            sessionStorage.removeItem('username');
            sessionStorage.removeItem('email');
            location.reload();
        } else {
            location.href = '/DoAnNhom/Login_Register/login.html';
        }
    });
};
