<?php

  require_once './php/components/connect.php';

  if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
  } else {
    $user_id = '';
  }

  // Xử lý form đăng ký khi người dùng nhấn nút submit
if (isset($_POST['submit'])) {
   // Tạo ID duy nhất cho người dùng
   $id = createUniqueID();
   
   // Lấy và làm sạch dữ liệu đầu vào
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = $_POST['pass'];
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $c_pass = $_POST['c_pass'];
   $c_pass = filter_var($c_pass, FILTER_SANITIZE_STRING);

   // Mã hóa mật khẩu
   $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

   // Xử lý hình ảnh người dùng tải lên
   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $ext = pathinfo($image, PATHINFO_EXTENSION);
   $rename = createUniqueID() . '.' . $ext;
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'php/uploaded_files/' . $rename;

   // Kiểm tra email có tồn tại trong hệ thống chưa
   $select_user = getDatabaseConnection()->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_user->execute([$email]);

   if ($select_user->rowCount() > 0) {
       $message[] = 'Email already taken!';
   } else {
       // Kiểm tra mật khẩu xác nhận
       if (!password_verify($c_pass, $hashedPass)) {
           $message[] = 'Confirm password not matched!';
       } else {
           // Thêm người dùng mới vào database
           $insert_user = getDatabaseConnection()->prepare("INSERT INTO `users` (user_id, name, email, password, image) VALUES (?, ?, ?, ?, ?)");
           $insert_user->execute([$id, $name, $email, $hashedPass, $rename]);
           move_uploaded_file($image_tmp_name, $image_folder);

           // Xác thực người dùng ngay sau khi đăng ký
           $verify_user = getDatabaseConnection()->prepare("SELECT * FROM `users` WHERE email = ? LIMIT 1");
           $verify_user->execute([$email]);
           $row = $verify_user->fetch(PDO::FETCH_ASSOC);

           if ($insert_user) {
               if ($verify_user->rowCount() > 0) {
                   setcookie('user_id', $row['user_id'], time() + 60 * 60 * 24 * 30, '/');
                   header('Location: home.php');
                   exit();
               } else {
                   $message[] = 'Something went wrong!';
               }
           }
       }
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>

  <!-- font awesome cdn link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- custom css file -->
     <link rel="stylesheet" href="./css/style.css">
</head>
<body>
  <!-- Header section start -->
   <?php require_once './php/components/user_header.php'; ?>
  <!-- Header section end -->

  <!-- register section starts -->
  <section class="form-container">

   <form class="register" action="" method="post" enctype="multipart/form-data">
      <h3>create account</h3>
      <div class="flex">
         <div class="col">
            <p>your name <span>*</span></p>
            <input type="text" name="name" placeholder="eneter your name" maxlength="50" required class="box">
            <p>your email <span>*</span></p>
            <input type="email" name="email" placeholder="enter your email" maxlength="30" required class="box">
         </div>
         <div class="col">
            <p>your password <span>*</span></p>
            <input type="password" name="pass" placeholder="enter your password" maxlength="20" required class="box">
            <p>confirm password <span>*</span></p>
            <input type="password" name="c_pass" placeholder="confirm your password" maxlength="20" required class="box">
         </div>
      </div>
      <p>select pic <span>*</span></p>
      <input type="file" name="image" accept="image/*" required class="box">
      <p class="link">already have an account? <a href="login.php">login now</a></p>
      <input type="submit" name="submit" value="register now" class="btn">
   </form>

</section>
    <!-- register section end -->

  <!-- Footer section start -->
   <?php require_once './php/components/footer.php'; ?>
  <!-- Footer section end -->
  <script src="./js/style.js"></script>
</body>
</html>