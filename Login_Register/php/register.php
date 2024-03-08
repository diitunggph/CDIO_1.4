<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "dtudocu";

    // Tạo kết nối
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $usename = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['pass'];
        $confirmPass = $_POST['confirmPass'];

        if(!empty($email) && !empty($password) && !empty($confirmPass) && !is_numeric($email)){
            $checkEmailQuery = "SELECT * FROM login WHERE email = '$email'";
            $checkEmailResult = $conn->query($checkEmailQuery);

            if ($checkEmailResult->num_rows > 0) {
                echo json_encode(array('status' => 'error', 'message' => 'Email đã được sử dụng!'));
            } else {
                $query = "INSERT INTO login (email, usernamee, passwordd, confirmPass) VALUES ('$email', '$usename', '$password','$confirmPass')";
                $result = $conn->query($query);
                echo json_encode(array('status' => 'success', 'message' => 'Đăng ký thành công!'));
            }
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Vui lòng nhập thông tin hợp lệ'));
        }
    }
?>
