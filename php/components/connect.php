<?php
// Nơi chứa các hàm liên quan đến database
    
    // Kết nối với database
    // Data Source Name 
    $dsn = "mysql:host=localhost;port=3366;dbname=course_db";
    $user = "root";
    $passWord = "";
    $conn = new PDO($dsn, $user, $passWord);

    function create_unique_id()
    {
        $str = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $rand = array();
        $length = strlen($str) - 1;
        for ($i = 0; $i < 20; $i++) {
            $n = mt_rand(0, $length);
            $rand[] = $str[$n];
        }
        return implode($rand);
    }
?>