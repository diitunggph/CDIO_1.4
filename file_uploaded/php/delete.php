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

// Lấy tên file từ yêu cầu POST
$fileName = $_POST['fileName'];

// Truy vấn SQL để xóa file
$sql = "DELETE FROM storagefile WHERE tenFile = '$fileName'";

if ($conn->query($sql) === TRUE) {
    echo "File deleted successfully";
} else {
    echo "Error deleting file: " . $conn->error;
}

$conn->close();
?>
