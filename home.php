    <!--Header-->
    <?php require_once './php/layout/header.php' ?>
    <!--Side bar start-->
    <?php require_once './php/layout/slidebar.php' ?>
    <!--Side bar end-->

    <!--quick select section start-->

    <section class="quick-select">
      <h1 class="heading">quick options</h1>
      <div class="box-container">
        <div class="box">
          <h3 class="title">likes and comments</h3>
          <p>total likes: <span>14</span></p>
          <a href="#" class="inline-btn">view likes</a>
          <p>total comments: <span>5</span></p>
          <a href="#" class="inline-btn">view comments</a>
          <p>total playlist: <span>3</span></p>
          <a href="#" class="inline-btn">view playlist</a>
        </div>

        <div class="box">
          <h3 class="title">top categories</h3>
          <div class="flex">
            <a href="#"><i class="fas fa-code"></i><span>development</span></a>
            <a href="#"
              ><i class="fas fa-chart-simple"></i><span>business</span></a
            >
            <a href="#"><i class="fas fa-pen"></i><span>design</span></a>
            <a href="#"
              ><i class="fas fa-chart-line"></i><span>marketing</span></a
            >
            <a href="#"><i class="fas fa-music"></i><span>music</span></a>
            <a href="#"><i class="fas fa-camera"></i><span>photgraphy</span></a>
            <a href="#"><i class="fas fa-cog"></i><span>software</span></a>
            <a href="#"><i class="fas fa-vival"></i><span>sicence</span></a>
          </div>
        </div>

        <div class="box">
          <h3 class="title">popular topic</h3>
          <div class="flex">
            <a href="#"><i class="fab fa-html5"></i><span>HTML</span></a>
            <a href="#"><i class="fab fa-css3"></i><span>CSS</span></a>
            <a href="#"><i class="fab fa-js"></i><span>javascript</span></a>
            <a href="#"><i class="fab fa-react"></i><span>react</span></a>
            <a href="#"><i class="fab fa-php"></i><span>PHP</span></a>
            <a href="#"
              ><i class="fab fa-bootstrap"></i><span>bootstrap</span></a
            >
          </div>
        </div>

        <div class="box tutor">
          <h3 class="title">become a tutor</h3>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
            ad minim veniam.
          </p>
          <a href="register.php" class="inline-btn">get started</a>
        </div>
      </div>
    </section>

    <!--quick select section end-->

    <!--courses section starts -->

    <section class="home-grid">
      <h1 class="heading">our courses</h1>

      <div class="box-container">
        <div class="box">
          <div class="tutor">
            <img src="/DACS2/images/pic-2.jpg" alt="" />
            <div>
              <h3>John Deo</h3>
              <span>12-10-2024</span>
            </div>
          </div>
          <img src="/DACS2/images/thumb-1.png" class="thumb" alt="" />
          <h3 class="title">complete HTML tutorial</h3>
          <a href="playlist.php" class="inline-btn">view playlist</a>
        </div>

        <div class="box">
          <div class="tutor">
            <img src="/DACS2/images/pic-3.jpg" alt="" />
            <div>
              <h3>John Deo</h3>
              <span>12-10-2024</span>
            </div>
          </div>
          <img src="/DACS2/images/thumb-2.png" class="thumb" alt="" />
          <h3 class="title">complete CSS tutorial</h3>
          <a href="playlist.php" class="inline-btn">view playlist</a>
        </div>

        <div class="box">
          <div class="tutor">
            <img src="/DACS2/images/pic-4.jpg" alt="" />
            <div>
              <h3>John Deo</h3>
              <span>12-10-2024</span>
            </div>
          </div>
          <img src="/DACS2/images/thumb-3.png" class="thumb" alt="" />
          <h3 class="title">complete JS tutorial</h3>
          <a href="playlist.php" class="inline-btn">view playlist</a>
        </div>

        <div class="box">
          <div class="tutor">
            <img src="/DACS2/images/pic-5.jpg" alt="" />
            <div>
              <h3>John Deo</h3>
              <span>12-10-2024</span>
            </div>
          </div>
          <img src="/DACS2/images/thumb-4.png" class="thumb" alt="" />
          <h3 class="title">complete Boostrap tutorial</h3>
          <a href="playlist.php" class="inline-btn">view playlist</a>
        </div>

        <div class="box">
          <div class="tutor">
            <img src="/DACS2/images/pic-6.jpg" alt="" />
            <div>
              <h3>John Deo</h3>
              <span>12-10-2024</span>
            </div>
          </div>
          <img src="/DACS2/images/thumb-5.png" class="thumb" alt="" />
          <h3 class="title">complete JQuery tutorial</h3>
          <a href="playlist.php" class="inline-btn">view playlist</a>
        </div>

        <div class="box">
          <div class="tutor">
            <img src="/DACS2/images/pic-7.jpg" alt="" />
            <div>
              <h3>John Deo</h3>
              <span>12-10-2024</span>
            </div>
          </div>
          <img src="/DACS2/images/thumb-6.png" class="thumb" alt="" />
          <h3 class="title">complete SASS tutorial</h3>
          <a href="playlist.php" class="inline-btn">view playlist</a>
        </div>
      </div>

      <div class="more-btn">
        <a href="courses.php" class="inline-option-btn">view more</a>
      </div>
    </section>

    <!--courses section ends-->

    <!--footer-start-->
    <?php require_once './php/layout/footer.php' ?>
    <!--footer-end-->
