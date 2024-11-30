<?php
require_once './php/components/connect.php';

// Kiểm tra cookie của người dùng
if(isset($_COOKIE['user_id'])){
  $user_id = $_COOKIE['user_id'];
} else {
  $user_id = '';
}

  // Xử lý form đăng nhập khi người dùng nhấn nút submit
if (isset($_POST['submit'])) {
  // Lấy và làm sạch dữ liệu đầu vào
  $email = $_POST['email'];
  $email = filter_var($email, FILTER_SANITIZE_STRING);
  $pass = $_POST['pass'];
  $pass = filter_var($pass, FILTER_SANITIZE_STRING);

  // Chuẩn bị và thực thi truy vấn để kiểm tra người dùng
  $verify_user = getDatabaseConnection()->prepare('SELECT * FROM users WHERE email = ?');
  $verify_user->execute([$email]);

  // Lấy kết quả truy vấn
  $row = $verify_user->fetch(PDO::FETCH_ASSOC);

  // Kiểm tra kết quả truy vấn và xác thực mật khẩu
  if ($row && password_verify($pass, $row['password'])) {
      setcookie('user_id', $row['user_id'], time() + 60 * 60 * 24 * 30, '/');
      header('Location: home.php');
      exit();
  } else {
      $message[] = 'Incorrect email or password!';
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>

  <!-- font awesome cdn link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- custom css file -->
     <link rel="stylesheet" href="./css/style.css">
</head>
<body>
  <!-- Header section start -->
   <?php require_once './php/components/user_header.php'; ?>
  <!-- Header section end -->

  <!-- login section starts -->
  <section class="form-container">
            <form action="" method="POST" class="login" enctype="multipart/form-data">
                <h3>welcome back!</h3>
                <p>your email <span>*</span></p>
                <input type="email" name="email" class="box" 
                maxlength="55" require placeholder="enter your email" id="">
                <!-- </div> -->
                <p>your password <span>*</span></p>
                <input type="password" name="pass" class="box" 
                maxlength="50" require placeholder="enter your password" id="">
                <input type="submit" value="login now" name="submit" class="btn">
            </form>
        </section>
    <!-- login section end -->

  <!-- Footer section start -->
   <?php require_once './php/components/footer.php'; ?>
  <!-- Footer section end -->
  <script src="./js/style.js"></script>
</body>
</html>