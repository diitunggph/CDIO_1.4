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
        die("Connection failed: " . $conn->connect_error);
    }
    
    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        $sql = "SELECT tenFile FROM storagefile WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Duyệt qua mỗi hàng dữ liệu
            while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["tenFile"] . "</td>"; // Sử dụng tên file từ cơ sở dữ liệu
            echo "<td>0</td>";
            echo "<td><i class='fa-regular fa-thumbs-up'></i> None</td>";
            echo "<td><input type='checkbox' value='true'></td>";
            echo "<td><input type='button' value='Chia sẻ tài liệu' class='btn_share'></td>";
            echo "<td><button type='button' class='btn_del'><i class='fa-solid fa-trash'></i></button></td>";
            echo "</tr>";
            }
        } else {
            echo "";
        }
    } else {
        echo "0";
    }

    $conn->close();

?>