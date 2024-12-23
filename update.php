<?php

  require_once './php/components/connect.php';

  if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
  } else {
    $user_id = '';
    header('location: home.php');
  }


  if(isset($_POST['submit'])) {

    $select_user = getDatabaseConnection()->prepare("SELECT * FROM users WHERE user_id = ? LIMIT 1");

    $select_user->execute([$user_id]);

    $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);


    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    if(!empty($name)) {
        $update_name = getDatabaseConnection()->prepare("UPDATE users SET name = ? WHERE user_id = ?");

        $update_name->execute([$name, $user_id]);

        $message[] = 'name updated successfully!';
    }
    
    if(!empty($email)) {

        $select_turor_email = getDatabaseConnection()->prepare('SELECT * FROM users WHERE email = ?');
        $select_turor_email->execute([$email]);
        if($select_turor_email->rowCount() > 0) {
            $message[]= 'email already taken!';
        } else {
            $update_email  = getDatabaseConnection()->prepare("UPDATE users SET  email = ? WHERE user_id = ?");

            $update_email ->execute([$email , $user_id]);

            $message[] = 'email updated successfully!';
        }
    }
 
    $pre_image = $fetch_user['image'];
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = createUniqueID().'.'.$ext;

    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];
    $image_folder = './php/uploaded_files/'.$rename;

    if(!empty($image)) {
        if($image_size > 2000000) {
            $message[] = 'image size is too large!';
        } else {
            $update_image = getDatabaseConnection()->prepare("UPDATE users SET image = ? WHERE user_id = ?");

            $update_image->execute([$rename, $user_id]);

            move_uploaded_file($image_tmp_name,$image_folder);

            move_uploaded_file($image_tmp_name,$image_folder);
            if($pre_image != '' AND $pre_image != $rename) {
                unlink('./php/uploaded_files/'.$pre_image);
            }
            $message[] = 'image updated successfully!';
        }
    }

    $emty_pass = "da39a3ee5e6b4b0d3255bfef95601890afd80709";

    $pre_pass = $fetch_user['password'];
    $old_pass = sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);

    $new_pass = sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);

    $c_pass = sha1($_POST['c_pass']);
    $c_pass = filter_var($c_pass, FILTER_SANITIZE_STRING);

    if($old_pass != $emty_pass) {
        if($old_pass != $pre_pass) {
            $message[] = 'old password not matched!';
        } elseif($new_pass != $c_pass) {
            $message[] = 'confirm password not matched!';
        } else {
            if($new_pass != $emty_pass) {
                $update_pass = getDatabaseConnection()->prepare("UPDATE users SET password = ? WHERE user_id = ?");

                $update_pass->execute([$c_pass, $user_id]);

                $message[] = 'password updated successfully!';
            } else {
                $message[] = 'new password can not be empty!';
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
  <title>Update</title>

  <!-- font awesome cdn link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- custom css file -->
     <link rel="stylesheet" href="./css/style.css">
</head>
<body>
  <!-- Header section start -->
   <?php require_once './php/components/user_header.php'; ?>
  <!-- Header section end -->

  <!-- update profile section start -->
  <section class="form-container">
        <form action="" method="POST" enctype="multipart/form-data">
            <h3>update profile</h3>
            <div class="flex">
                <div class="col">

                    <p>your name </p>
                    <input type="text" name="name" class="box" 
                    maxlength="50" placeholder="<?php echo $fetch_profile['name'];?>" id="">

                    <p>your email </p>
                    <input type="email" name="email" class="box" 
                    maxlength="50"  placeholder="<?php echo $fetch_profile['email'];?>" id="">

                    <p>select pic</p>
                    <input type="file" name="image" class="box"  accept="image/*">
                </div>

                <div class="col">
                    <p>old password </p>
                    <input type="password" name="old_pass" class="box" 
                    maxlength="50"  placeholder="enter your old password" id="">

                    <p>your password </p>
                    <input type="password" name="new_pass" class="box" 
                    maxlength="50"  placeholder="enter your new password" id="">

                    <p>confirm password </p>
                    <input type="password" name="c_pass" class="box" 
                    maxlength="50"  placeholder="confirm your new password" id="">
                </div>

            </div>

            <input type="submit" value="update now" name="submit" class="btn">

        </form>

    </section>
  <!-- update profile section end -->

  <!-- Footer section start -->
   <?php require_once './php/components/footer.php'; ?>
  <!-- Footer section end -->
  <script src="./js/style.js"></script>
</body>
</html>