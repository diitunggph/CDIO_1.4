<?php
    // Kiểm tra xem tên file đã được gửi không
    if (isset($_POST['fileName'])) {
        $fileName = $_POST['fileName'];

        // Tạo đường dẫn tuyệt đối đến file
        $filePath = 'upload/php/files' . $fileName;

        // Kiểm tra xem file tồn tại không
        if (file_exists($filePath)) {
            // Đọc nội dung file và trả về nó
            $fileContent = file_get_contents($filePath);
            echo $fileContent;
        } else {
            if (!file_exists($filePath)) {
                echo "File không tồn tại. Đường dẫn: " . $filePath;
            } else if (!is_readable($filePath)) {
                echo "File không thể đọc được. Đường dẫn: " . $filePath;
            }
        }
    } else {
        echo "Tên file không được cung cấp.";
    }
?>
