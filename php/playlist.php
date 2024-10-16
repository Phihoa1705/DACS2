    <!--Header-->
    <?php require_once './layout/header.php' ?>
    <!--Side bar start-->
    <?php require_once './layout/slidebar.php' ?>
    <!--Side bar end-->

    <!--playlist section start-->

    <section class="playlist">

        <h1 class="heading">playlist details</h1>
     
        <div class="row">
     
           <div class="col">
              <form action="" method="post" class="save-list">
                 <button type="submit"><i class="far fa-bookmark"></i> <span>save playlist</span></button>
              </form>
        
              <div class="thumb">
                 <img src="/DACS2/images/thumb-1.png" alt="">
                 <span>6 videos</span>
              </div>
           </div>
           <div class="col">
              <div class="tutor">
                 <img src="/DACS2/images/pic-2.jpg" alt="">
                 <div>
                    <h3>john deo</h3>
                    <span>21-10-2022</span>
                 </div>
              </div>
        
              <div class="details">
                 <h3>complete HTML tutorial</h3>
                 <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum minus reiciendis, error sunt veritatis exercitationem deserunt velit doloribus itaque voluptate.</p>
                 <a href="/DACS2/php/teacher_profile.php" class="inline-btn">view profile</a>
              </div>
           </div>
        </div>
     
     </section>

    <!--playlist section end-->

    <!--video container section starts-->

    <section class="videos-container">
        
        <h1 class="heading">playlist videos</h1>

        <div class="box-container">

            <a href="/DACS2/php/watch-video.php" class="box">
                <i class="fas fa-play"></i>
                <img src="/DACS2/images/post-1-1.png" alt="">
                <h3>complete HTML tutorial (part 01)</h3>
            </a>

            <a href="/DACS2/php/watch-video.php" class="box">
                <i class="fas fa-play"></i>
                <img src="/DACS2/images/post-1-2.png" alt="">
                <h3>complete HTML tutorial (part 02)</h3>
            </a>

            <a href="/DACS2/php/watch-video.php" class="box">
                <i class="fas fa-play"></i>
                <img src="/DACS2/images/post-1-3.png" alt="">
                <h3>complete HTML tutorial (part 03)</h3>
            </a>

            <a href="/DACS2/php/watch-video.php" class="box">
                <i class="fas fa-play"></i>
                <img src="/DACS2/images/post-1-4.png" alt="">
                <h3>complete HTML tutorial (part 04)</h3>
            </a>

            <a href="/DACS2/php/watch-video.php" class="box">
                <i class="fas fa-play"></i>
                <img src="/DACS2/images/post-1-5.png" alt="">
                <h3>complete HTML tutorial (part 05)</h3>
            </a>

            <a href="/DACS2/php/watch-video.php" class="box">
                <i class="fas fa-play"></i>
                <img src="/DACS2/images/post-1-6.png" alt="">
                <h3>complete HTML tutorial (part 06)</h3>
            </a>
            
        </div>

    </section>



    <!--video container section ends-->
    
    <!--footer-start-->
    <?php require_once './layout/footer.php' ?>
    <!--footer-end-->
