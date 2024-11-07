    <!--Header-->
    <?php require_once './php/layout/header.php' ?>
    <!--Side bar start-->
    <?php require_once './php/layout/slidebar.php' ?>
    <!--Side bar end-->

    <!--contact section start-->

    <div class="contact">
    
            
        <div class="row">

            <div class="image">
            <img src="/DACS2/images/contact-img.svg" alt="">
            </div>

            <form action="" method="post">
            <h3>get in touch</h3>
            <input type="text" placeholder="enter your name" name="name" required maxlength="50" class="box">
            <input type="email" placeholder="enter your email" name="email" required maxlength="50" class="box">
            <input type="number" placeholder="enter your number" name="number" required maxlength="50" class="box">
            <textarea name="msg" class="box" placeholder="enter your message" required maxlength="1000" cols="30" rows="10"></textarea>
            <input type="submit" value="send message" class="inline-btn" name="submit">
            </form>

        </div>

        <div class="box-container">

            <div class="box">
                <i class="fas fa-phone"></i>
                <h3>phone number</h3>
                <a href="tel:1234567890">123-456-7890</a>
                <a href="tel: 111222333">111-222-333</a>
            </div>

            <div class="box">
                <i class="fas fa-envelope"></i>
                <h3>email address</h3>
                <a href="mailto:hoahandsome@gmail.com">hoahandsome@gmail.com</a>
                <a href="mailto:johndeo@gmail.com">johndeo@gmail.com</a>
            </div>

            <div class="box">
                <i class="fas fa-map-marker-alt"></i>
                <h3>office address</h3>
                <a href="#">flat no. 1, a-1 building, jogeshwari, mumbai, india - 400104</a>
            </div>

        </div>

    </div>

    <!--contact section start-->

    
    <!--footer-start-->
    <?php require_once './php/layout/footer.php' ?>
    <!--footer-end-->

