    <!--Header-->
    <?php require_once './layout/header.php' ?>
    <!--Side bar start-->
    <?php require_once './layout/slidebar.php' ?>
    <!--Side bar end-->

    <!--login section start-->

    <section class="form-container">

        <form action="" method="post">
            <h3>welcome back!</h3>
            <p>your email <span>*</span></p>
            <input type="email" name="name" placeholder="enter your email" maxlength="100" required class="box">
            <p>your password <span>*</span></p>
            <input type="password" name="pass" placeholder="enter your password" maxlength="50" required class="box">
            <input type="submit" name="submit" value="login now" class="btn">
        </form>

    </section>

    <!--login section end-->
    
     <!--footer-start-->
     <?php require_once './layout/footer.php' ?>
    <!--footer-end-->
