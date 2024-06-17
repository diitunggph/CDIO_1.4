<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

    // $file_name = $_FILES['file']['name'];
    // $tmp_name = $_FILES['file']['tmp_name'];
    // $file_up_name = time().$file_name;
    // move_uploaded_file($tmp_name,"files/".$file_up_name);

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dtudocu";

    // Tạo kết nối
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    } else {
        echo "Kết nối thành công!";
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_FILES['file'])) {
            $errors = [];
            $path = 'files/';
            $file_name = $_FILES['file']['name'];
            $file_tmp = $_FILES['file']['tmp_name'];
            $file_size = $_FILES['file']['size'];
            $file_size_bytes = $_FILES['file']['size'];
            $file_up_name = $file_name;
            $file = $path . $file_up_name;

             // Chuyển đổi dung lượng tệp sang KB hoặc MB
             $file_size = $file_size_bytes / 1024; // Chuyển đổi sang KB
             if ($file_size > 1024) {
                 $file_size = $file_size / 1024; // Chuyển đổi sang MB nếu lớn hơn 1024 KB
                 $file_size = round($file_size, 2) . ' MB';
             } else {
                 $file_size = round($file_size, 2) . ' KB';
             }
 
             if ($file_size_bytes > 2097152) {
                 $errors[] = 'File size exceeds limit: ' . $file_name;
             }

            if (empty($errors)) {
                move_uploaded_file($file_tmp, $file);
            }

            if ($errors) print_r($errors);
            
            $maFile = time();
            $email = $_POST['email']; // Lấy email từ dữ liệu được gửi

            // Lưu tên tệp và kích thước tệp vào cơ sở dữ liệu
            $sql = "INSERT INTO storagefile (maFile, tenFile, dungLuong, email) VALUES ('$maFile', '$file_up_name', '$file_size', '$email')";
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
                echo $email;
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
?>