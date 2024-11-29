<?php
require_once '../components/connect.php';

if(isset($_COOKIE['tutor_id']))
{
    $tutor_id = $_COOKIE['tutor_id'];
} else {
    $tutor_id = '';
}

if(isset($_POST['submit']))
{
    $id = createUniqueID();
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $profession = $_POST['profession'];
    $profession = filter_var($profession, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $c_pass = sha1($_POST['c_pass']);
    $c_pass = filter_var($c_pass, FILTER_SANITIZE_STRING);
 
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = createUniqueID().'.'.$ext;

    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];
    $image_folder = '../uploaded_files/'.$rename;

    $select_turor_email = getDatabaseConnection()->prepare('SELECT * FROM tutors WHERE email = ?');
    $select_turor_email->execute([$email]);

    if($select_turor_email->rowCount() > 0) {
        $message[]= 'email already taken!';
    } else {
       if($pass !== $c_pass){
            $message[] = 'password not matched!';
       } else {
            
            if($image_size > 2000000) {
                $message[] = 'image size is too large!';
            } else {
                $insert_tutor = getDatabaseConnection()->prepare('INSERT INTO tutors 
                (tutor_id, tutor_name, profession, email, pass_word, 
                image) VALUES (?, ?, ?, ?, ?, ?)');

                $insert_tutor->execute([$id, $name, $profession, 
                $email, $c_pass, $rename]);

                move_uploaded_file($image_tmp_name,$image_folder);

                $verify_tutor = getDatabaseConnection()->prepare('SELECT * FROM 
                tutors WHERE email = ? AND pass_word = ? LIMIT 1');

                $verify_tutor->execute([$email, $c_pass]);
                
                $row = $verify_tutor->fetch(PDO::FETCH_ASSOC);

                if($insert_tutor) {
                    if($verify_tutor->rowCount() > 0) {
                        setcookie('tutor_id',$row['tutor_id'],time() +60*60*24*30,'/');
                        header('location: dashboard.php');
                    } else {
                        $message[] = 'something went wrong!';
                    }
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
     <link rel="stylesheet" href="../../css/admin_style.css">
</head>
<body style="padding-left: 0;">

    <?php
        if(isset($message)){
            foreach($message as $message) {
                echo '
                <div class="message form">
                    <span>'.$message.'</span>
                    <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                </div>';
            }
        }
    ?>
    <!-- register section starts -->
        <section class="form-container">
            <form action="" method="POST" enctype="multipart/form-data">
                <h3>register new</h3>
                <div class="flex">
                    <div class="col">

                        <p>your name <span>*</span></p>
                        <input type="text" name="name" class="box" 
                        maxlength="50" require placeholder="enter your name" id="">

                        <p>your profession <span>*</span></p>
                        <select name="profession" class="box" id="">
                            <option value="" disabled selected>-- select your profession</option>
                            <option value="developer">developer</option>
                            <option value="desginer">desginer</option>
                            <option value="musician">musician</option>
                            <option value="biologist">biologist</option>
                            <option value="teacher">teacher</option>
                            <option value="engineer">engineer</option>
                            <option value="lawyer">lawyer</option>
                            <option value="accountant">accountant</option>
                            <option value="doctor">doctor</option>
                            <option value="journalist">journalist</option>
                            <option value="photographer">photographer</option>
                        </select>

                        <p>your email <span>*</span></p>
                        <input type="email" name="email" class="box" 
                        maxlength="50" require placeholder="enter your email" id="">
                    </div>
                    <div class="col">
                        <p>your password <span>*</span></p>
                        <input type="password" name="pass" class="box" 
                        maxlength="50" require placeholder="enter your password" id="">
                        <p>confirm password <span>*</span></p>
                        <input type="password" name="c_pass" class="box" 
                        maxlength="50" require placeholder="confirm your password" id="">
                        <p>select pic<span>*</span></p>
                        <input type="file" name="image" class="box" require accept="image/*">
                    </div>
                </div>
                <input type="submit" value="register now" name="submit" class="btn">
                <p class="link">already have an account? <a href="./login.php">login now</a></p>
            </form>
        </section>
    <!-- register section end -->

    <!-- custom js file -->
    <script src="../../js/admin_script.js"></script>
</body>
</html>