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
    $password = "root";
    $dbname = "dtudocu";

    // Tạo kết nối
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    $sql = "SELECT COUNT(*) AS count FROM storagefile";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    echo $row['count'];

?>