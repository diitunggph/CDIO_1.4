<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dtudocu";

    // Tạo kết nối
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['mail'];
        $password = $_POST['pass'];

        if(!empty($email) && !empty($password) && !is_numeric($email)){
            // Tạo truy vấn SQL
            $query = "SELECT * FROM login WHERE email = ?";

            // Chuẩn bị và thực thi truy vấn
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s', $email);
            $stmt->execute();

            // Lấy kết quả
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            // Kiểm tra mật khẩu
            if ($password == $user['passwordd']) {
                // Đăng nhập thành công, trả về tên người dùng
                echo json_encode(['username' => $user['usernamee'], 'email' => $email]);
            } else {
                // Đăng nhập thất bại
                echo 'Email hoặc mật khẩu không đúng!';
            }
        } else {
            echo 'Vui lòng nhập thông tin hợp lệ';
        }
    }
?>
