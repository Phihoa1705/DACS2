    <!--Header-->
    <?php require_once './php/layout/header.php' ?>
    <!--Side bar start-->
    <?php require_once './php/layout/slidebar.php' ?>
    <!--Side bar end-->

    <!--profile section starts-->

    <section class="profile">

        <h1 class="heading">profile details</h1>

        <div class="details">

            <div class="user">
                <img src="/DACS2/images/pic-1.jpg" alt="">
                <h3>Hoa handsome</h3>
                <p>student</p>
                <a href="update.php" class="inline-btn">update profile</a>
            </div>

            <div class="box-container">

                <div class="box">
                    <div class="flex">
                            <i class="fas fa-bookmark"></i>
                        <div>
                            <h3>3</h3>
                            <span>saved playlists</span>
                        </div>
                    </div>
                    <a href="#" class="inline-btn">view playlists</a>
                </div>

                <div class="box">
                    <div class="flex">
                            <i class="fas fa-heart"></i>
                        <div>
                            <h3>55</h3>
                            <span>liked tutorials</span>
                        </div>
                    </div>
                    <a href="#" class="inline-btn">view liked</a>
                </div>

                <div class="box">
                    <div class="flex">
                            <i class="fas fa-comment"></i>
                        <div>
                            <h3>15</h3>
                            <span>video comments</span>
                        </div>
                    </div>
                    <a href="#" class="inline-btn">view comments</a>
                </div>

            </div>

        </div>

    </section>

    <!--profile section starts-->
    
    <!--footer-start-->
    <?php require_once './php/layout/footer.php' ?>
    <!--footer-end-->