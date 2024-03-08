$(document).ready(function() {
    var email = sessionStorage.getItem('email');
    var username = sessionStorage.getItem('username');
    if(email){
        $.ajax({
            type: "POST",
            url: 'php/file_uploaded.php',
            data: {
                email: email
            },
            success: function(data) {
                var tbody = $('.file_uploaded table tbody');
        
                // Thêm dữ liệu vào tbody
                tbody.html(data);

                // Thêm sự kiện click vào nút "freeshare"
                $('.tb').on('click', '.btn_share', function() {
                    var button = $(this);

                    // Tìm hàng gần nhất chứa nút "freeshare"
                    var row = button.closest('tr');

                    // Lấy tên file từ ô đầu tiên của hàng
                    var fileName = row.find('td:first-child').text();
                    // Mã hóa URL tên file
                    var encodedFileName = encodeURIComponent(fileName);

                    // Gửi yêu cầu AJAX đến tệp PHP để lấy nội dung file
                    $.ajax({
                        url: 'php/getFileContent.php', // Đường dẫn đến tệp PHP để lấy nội dung file
                        method: 'POST',
                        data: { fileName: encodedFileName }, // Gửi tên file cần lấy nội dung
                        success: function(data) {
                            // Nếu yêu cầu thành công, hiển thị nội dung file cho người dùng
                            console.log(fileName);
                            alert(data);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            // Nếu có lỗi, hiển thị thông báo lỗi
                            alert("AJAX error: " + textStatus + ' : ' + errorThrown);
                        }
                    });
                });

                if (email) {
                    $.ajax({
                        type: "POST",
                        url: 'php/countFile.php',
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


                // Thêm sự kiện click vào nút xóa
                tbody.on('click', '.btn_del', function() {
                    // 'this' trong hàm callback là nút xóa đã được nhấn
                    // $(this).closest('tr') tìm hàng gần nhất chứa nút xóa
                    var row = $(this).closest('tr');

                    // Lấy tên file từ ô đầu tiên của hàng
                    var fileName = row.find('td:first-child').text();

                    // Gửi yêu cầu AJAX đến tệp PHP để xóa file
                    $.ajax({
                        url: 'php/delete.php', // Đường dẫn đến tệp PHP để xóa file
                        method: 'POST',
                        data: { fileName: fileName }, // Gửi tên file cần xóa
                        success: function() {
                            // Nếu yêu cầu thành công, xóa hàng khỏi bảng
                            row.remove();

                            // Cập nhật số lượng tệp đã tải lên
                            $.ajax({
                                type: "POST",
                                url: 'php/countFile.php',
                                data: {
                                    email: email
                                },
                                success: function(data) {
                                    $('.upload').html(data + '<span>Đã tải lên</span>');
                                }
                            });
                        }
                    });
                });             
            }
        });
        $('.btn_Signin').text('Đăng xuất');
        $('.username-display').text(username);

        // Thêm sự kiện click vào nút "Đăng xuất"
        $('.btn_Signin').click(function() {
            // Xóa thông tin người dùng
            sessionStorage.removeItem('email');

            // Lưu trữ trang hiện tại
            sessionStorage.setItem('lastPage', '/DoAnNhom/file_uploaded/file_uploaded.html');

            // Cập nhật giao diện
            $('.btn_Signin').text('Đăng nhập');
            $('.username-display').text('Tên người dùng');
            $('.file_uploaded table tbody').empty();
            $('.upload').html('0<span>Đã tải lên</span>');

            $('.btn_Signin').off('click').click(function() {
                location.href = '../Login_Register/login.html';
            });
        });
    }else {
         // Người dùng chưa đăng nhập, thêm sự kiện chuyển hướng đến trang đăng nhập
         $('.btn_Signin').off('click').click(function() {
            var lastPage = sessionStorage.getItem('lastPage');
            if (lastPage) {
                // Xóa lastPage khỏi sessionStorage sau khi đã sử dụng
                sessionStorage.removeItem('lastPage');
                location.href = lastPage;
            } else {
                location.href = '../Login_Register/login.html';
            }
        });
    }
});