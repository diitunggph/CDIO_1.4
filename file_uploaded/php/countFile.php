<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "dtudocu";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    if(!empty($email) && !is_numeric($email)){
        // Tạo truy vấn SQL
        $query = "SELECT COUNT(*) AS file_count FROM storagefile WHERE email = ?";

        // Chuẩn bị và thực thi truy vấn
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();

        // Lấy kết quả
        $result = $stmt->get_result();
        $fileCount = $result->fetch_assoc();

        // Trả về số lượng tệp
        echo $fileCount['file_count'];
    } else {
        echo '0';
    }
}

$conn->close();
?>