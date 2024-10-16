    <!--Header-->
    <?php require_once './layout/header.php' ?>
    <!--Side bar start-->
    <?php require_once './layout/slidebar.php' ?>
    <!--Side bar end-->

    <!--register section start-->

    <section class="form-container">

        <form action="" method="post" enctype="multipart/form-data">
            <h3>register</h3>
            <p>your name <span>*</span></p>
            <input type="name" name="name" placeholder="enter your name" maxlength="100" required class="box">
            <p>your email <span>*</span></p>
            <input type="email" name="name" placeholder="enter your email" maxlength="100" required class="box">
            <p>your password <span>*</span></p>
            <input type="password" name="pass" placeholder="enter your password" maxlength="50" required class="box">
            <p>confirm password <span>*</span></p>
            <input type="password" name="c_pass" placeholder="confirm your new password" maxlength="50" required class="box">
            <p>select image <span>*</span></p>
            <input type="file" name="image" accept="image/*" required class="box">
            <input type="submit" name="submit" value="register now" class="btn">
        </form>

    </section>

    <!--register section end-->
    
    <!--footer-start-->
    <?php require_once './layout/footer.php' ?>
    <!--footer-end-->