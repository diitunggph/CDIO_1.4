$(document).ready(function() {
    //Kiểm tra email hợp lệ
    function isValidEmail(email) {
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return emailRegex.test(email);
    }    

    // Kiểm tra mật khẩu hợp lệ
    function isValidPassword(password) {
        // Mật khẩu phải có ít nhất 8 ký tự
        return password.length >= 1;
    }

    $('form').on('submit', function(event) {
        event.preventDefault(); // Ngăn chặn việc gửi form mặc định

        var email = document.getElementsByName('mail')[0].value;
        var password = document.getElementsByName('pass')[0].value;

        if (!isValidEmail(email)) {
            alert("Email không hợp lệ. Vui lòng nhập lại.");
            return;
        }

        if (!isValidPassword(password)) {
            alert("Mật khẩu không hợp lệ. Bạn không được để trống mật khẩu!");
            return;
        }

        // Nếu tất cả các điều kiện đều hợp lệ, thực hiện yêu cầu AJAX
        $.ajax({
            type: "POST",
            url: "php/login.php",
            data: {
                mail: email,
                pass: password
            },
            success: function(response) {
                if(response !== 'Email hoặc mật khẩu không đúng!' && response !== 'Vui lòng nhập thông tin hợp lệ') {
                    alert("Đăng nhập thành công!");
                    
                    // Lưu tên đăng nhập vào localStorage
                    var user = JSON.parse(response);

                    // Lưu tên đăng nhập và email vào sessionStorage
                    sessionStorage.setItem('username', user.username);
                    sessionStorage.setItem('email', user.email);

                    var lastPage = sessionStorage.getItem('lastPage');
                    if (lastPage) {
                        window.location.href = lastPage;
                    } else {
                        // Chuyển hướng đến trang mặc định nếu không có trang cuối cùng
                        window.location.href = '/DoAnNhom/home/index.html';
                    }
                    
                } else {
                    alert(response);
                }
            }
        });
    });
});
