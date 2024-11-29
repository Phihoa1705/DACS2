<?php
// Nơi chứa các hàm liên quan đến database

// Hàm kết nối với database
function getDatabaseConnection($host = 'localhost', $port = 3366, $dbname = 'course_db', $user = 'root', $password = '')
{
    try {
        // Data Source Name, chứa thông tin kết nối đến database
        $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
        
        // Tạo kết nối PDO mới
        $conn = new PDO($dsn, $user, $password);
        
        // Thiết lập chế độ lỗi cho PDO để ném ngoại lệ
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Trả về đối tượng kết nối
        return $conn;
    } catch (PDOException $e) {
        // Xử lý lỗi nếu kết nối thất bại và in ra thông báo lỗi
        die("Connection failed: " . $e->getMessage());
    }
}

// Tạo kết nối đến database
$conn = getDatabaseConnection();

// Hàm tạo ID duy nhất ngẫu nhiên
function createUniqueID($length = 20)
{
    // Chuỗi ký tự dùng để tạo ID
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    
    // Độ dài của chuỗi ký tự
    $charactersLength = strlen($characters);
    
    // Biến lưu trữ ID ngẫu nhiên được tạo ra
    $randomString = '';
    
    // Vòng lặp tạo ra chuỗi ngẫu nhiên có độ dài $length
    for ($i = 0; $i < $length; $i++) {
        // Thêm một ký tự ngẫu nhiên từ chuỗi $characters vào $randomString
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    
    // Trả về chuỗi ngẫu nhiên được tạo ra
    return $randomString;
}

?>
