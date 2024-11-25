<?php

  require_once './php/components/connect.php';

  if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
  } else {
    $user_id = '';
  }

  if(isset($_POST['submit'])){

    $id = create_unique_id();
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $c_pass = sha1($_POST['c_pass']);
    $c_pass = filter_var($c_pass, FILTER_SANITIZE_STRING);
 
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = create_unique_id().'.'.$ext;
    $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'php/uploaded_files/'.$rename;
 
    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_user->execute([$email]);
    
    if($select_user->rowCount() > 0){
       $message[] = 'email already taken!';
    }else{
       if($pass != $c_pass){
          $message[] = 'confirm passowrd not matched!';
       }else{

          $insert_user = $conn->prepare("INSERT INTO `users`(user_id, name, email, password, image) VALUES(?,?,?,?,?)");
          $insert_user->execute([$id, $name, $email, $c_pass, $rename]);
          move_uploaded_file($image_tmp_name, $image_folder);
          
          $verify_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
          $verify_user->execute([$email, $pass]);
          $row = $verify_user->fetch(PDO::FETCH_ASSOC);
          
          if($insert_user){
            if($verify_user->rowCount() > 0){
              setcookie('user_id', $row['user_id'], time() + 60*60*24*30, '/');
              header('location:home.php');
           }else{
               $message[] = 'something went wrong!';
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