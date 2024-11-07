    <!--Header-->
    <?php require_once './php/layout/header.php' ?>
    <!--Side bar start-->
    <?php require_once './php/layout/slidebar.php' ?>
    <!--Side bar end-->
    
    <!--update profile section start-->

    <section class="form-container">

        <form action="" method="post">
            <h3>update profile</h3>
            <p>your name</p>
            <input type="name" name="name" placeholder="Hoa handsome" maxlength="100" class="box">
            <p>your email</p>
            <input type="email" name="name" placeholder="hoahandsome@gmail.com" maxlength="100" class="box">
            <p>old password</p>
            <input type="password" name="old_pass" placeholder="enter your old password" maxlength="50" class="box">
            <p>new password</p>
            <input type="password" name="new_pass" placeholder="enter your new password" maxlength="50" class="box">
            <p>confirm password</p>
            <input type="password" name="c_pass" placeholder="confirm your new password" maxlength="50" class="box">
            <p>update image</p>
            <input type="file" name="image" accept="image/*" class="box">
            <input type="submit" name="submit" value="update profile" class="btn">
        </form>

    </section>

    <!--update profile section start-->
    
     <!--footer-start-->
     <?php require_once './php/layout/footer.php' ?>
    <!--footer-end-->