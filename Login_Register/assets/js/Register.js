function validateAndSubmit(event) {
    event.preventDefault();

    var username = document.getElementById('usename').value;
    var email = document.getElementById('email').value;
    var pass1 = document.getElementById('pass1').value;
    var pass2 = document.getElementById('pass2').value;
    var checkbox = document.getElementById('confirmCheckbox').checked;

    if (username === "" || email === "" || pass1 === "" || pass2 === "" || !checkbox) {
        if (!checkbox) {
            alert("Vui lòng đồng ý với các điều khoản và điều kiện trước khi đăng ký");
        } else {
            alert("Vui lòng điền đầy đủ thông tin!");
        }
        return false;    
    }

    if (pass1 !== pass2) {
        alert("Mật khẩu không khớp!");
        return false;
    }

    // Nếu tất cả các điều kiện đều hợp lệ, thực hiện yêu cầu AJAX
    $.ajax({
        type: "POST",
        url: "php/register.php",
        data: {
            name: username,
            email: email,
            pass: pass1,
            confirmPass: pass2
        },
        success: function(response) {
            var data = JSON.parse(response);
            if(data.status === 'success') {
                alert("Đăng ký thành công!");
                window.location.href = './login.html';
            } else {
                alert("Vui lòng nhập thông tin hợp lệ!");
            }
        }
    });

    return false;  // Trả về false để ngăn chặn việc gửi form theo cách thông thường
}