<?php

  require_once './php/components/connect.php';

  if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
  } else {
    $user_id = '';
  }

  if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_NUMBER_INT);
    $msg = $_POST['msg'];
    $msg = filter_var($msg, FILTER_SANITIZE_STRING);

    $verify_contact = getDatabaseConnection()->prepare("SELECT * FROM contact WHERE name = ? AND email = ? AND number = ? AND message = ?");
    $verify_contact->execute([$name, $email, $number, $msg]);

    if($verify_contact->rowCount() > 0){
      $message[] = "Your message is already sent!";
    } else {
      $send_message = getDatabaseConnection()->prepare("INSERT INTO contact (name, email, number, message) VALUES (?, ?, ?, ?)");
      $send_message->execute([$name, $email, $number, $msg]);
      $message[] = "Your message is sent!";
    }
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us</title>

  <!-- font awesome cdn link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- custom css file -->
     <link rel="stylesheet" href="./css/style.css">
</head>
<body>
  <!-- Header section start -->
   <?php require_once './php/components/user_header.php'; ?>
  <!-- Header section end -->

  <!-- Contact section starts -->
    <section class="contact">

      <div class="row">

        <div class="image">
          <img src="images/contact-img.svg" alt="">
        </div>

        <form action="" method="POST">
          <h3>get in touch</h3>
          <input type="text" class="box" required maxlength="50" name="name" placeholder="please enter your name">
          <input type="email" class="box" required maxlength="50" name="email" placeholder="please enter your email">
          <input type="number" class="box" required maxlength="10" name="number" placeholder="please enter your number" min="0" max="9999999999">
          <textarea name="msg" class="box" required maxlength="1000" placeholder="enter your message" cols="30" rows="10"></textarea>
          <input type="submit" value="send message" class="inline-btn" name="submit">
        </form>

      </div>

      <div class="box-container">

      <div class="box">
        <i class="fas fa-phone"></i>
        <h3>phone number</h3>
        <a href="tel:1234567890">123-456-7890</a>
        <a href="tel:1112223333">111-222-3333</a>
      </div>

      <div class="box">
        <i class="fas fa-envelope"></i>
        <h3>email address</h3>
        <a href="mailto:danh@gmail.com">danh@gmail.com</a>
        <a href="mailto:hoa@gmail.com">Hoa@gmail.com</a>
      </div>

      <div class="box">
        <i class="fas fa-map-marker-alt"></i>
        <h3>office address</h3>
        <a href="#">dai hoc vku </a>
      </div>

      </div>

    </section>
  <!-- Contact section ends -->

  <!-- Footer section start -->
   <?php require_once './php/components/footer.php'; ?>
  <!-- Footer section end -->
  <script src="./js/style.js"></script>
</body>
</html>