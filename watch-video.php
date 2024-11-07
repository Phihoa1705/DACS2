    <!--Header-->
    <?php require_once './php/layout/header.php' ?>
    <!--Side bar start-->
    <?php require_once './php/layout/slidebar.php' ?>
    <!--Side bar end-->

    <!--watch video section start-->

    <section class="watch-video">

        <div class="video-details">
            <video src="/DACS2/images/vid-1.mp4" class="video" poster="/DACS2/images/post-1-1.png" controls autoplay></video>
            <h3 class="title">complete HTML tutorial (part 01)</h3>
            <div class="info">
                <p><div><i class="fas fa-calendar"><span>21-25-2022</span></i></div></p>
                <p><div><i class="fas fa-heart"><span>45 likes</span></i></div></p>
            </div>
            <div class="tutor">
                <img src="/DACS2/images/pic-2.jpg" alt="">
                <div>
                    <h3>John Deo</h3>
                    <span>developer</span>
                </div>
            </div>
                <form action="" mehthod="post" class="flex">
                    <a href="playlist.php" class="inline-btn">view playlist</a>
                    <button type="submit"><i class="far fa-heart"></i><span>like</span></button>
                </form>
                <div class="description">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut eum facere ex ab, odio eaque cum maxime enim dolor, sed consequatur consequuntur. Magni doloribus assumenda quidem commodi enim, tempore possimus?</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima facere, sed beatae cum labore, odio velit maiores distinctio magnam ad quae fugit pariatur dignissimos nisi iusto voluptatum corporis, aliquid hic.</p>

                </div>
        </div>

    </section>

    <!--watch video section start-->

    <!--comments section start-->

    <section class="comment">

        <h1 class="heading">add a comment</h1>

        <form action="" method="post" class="add-comment">
            <h3>add title</h3>
            <textarea name="commet_box" required placeholder="write your comment...." maxlength="1000" cols="30" rows="10"></textarea>
            <input type="submit" value="add comment" name="add-comment" class="inline-btn">
        </form>

        <h1 class="heading">6 comment</h1>

        <div class="show-comments">

            <div class="box">
                <div class="user">
                    <img src="/DACS2/images/pic-1.jpg" alt="">
                    <div>
                        <h3>Hoa handsome</h3>
                        <span>21-25-2022</span>
                    </div>
                </div>
                <p class="text">this is a comment from Hoa handsome</p>
                <form action="" class="flex-btn" method="post">
                    <button type="submit" name="edit_comment" class="inline-option-btn">edit comment</button>
                    <button type="submit" name="delete_comment" class="inline-delete-btn">delete comment</button>
                </form>
            </div>

            <div class="box">
                <div class="user">
                    <img src="/DACS2/images/pic-1.jpg" alt="">
                    <div>
                        <h3>John Deo</h3>
                        <span>21-25-2022</span>
                    </div>
                </div>
                <p class="text">wow amazing video! thank for the source code</p>
            </div>

            <div class="box">
                <div class="user">
                    <img src="/DACS2/images/pic-2.jpg" alt="">
                    <div>
                        <h3>John Deo</h3>
                        <span>21-25-2022</span>
                    </div>
                </div>
                <p class="text">wow amazing video! thank for the source code</p>
            </div>

            <div class="box">
                <div class="user">
                    <img src="/DACS2/images/pic-3.jpg" alt="">
                    <div>
                        <h3>John Deo</h3>
                        <span>21-25-2022</span>
                    </div>
                </div>
                <p class="text">wow amazing video! thank for the source code</p>
            </div>

            <div class="box">
                <div class="user">
                    <img src="/DACS2/images/pic-4.jpg" alt="">
                    <div>
                        <h3>John Deo</h3>
                        <span>21-25-2022</span>
                    </div>
                </div>
                <p class="text">wow amazing video! thank for the source code</p>
            </div>

            <div class="box">
                <div class="user">
                    <img src="/DACS2/images/pic-5.jpg" alt="">
                    <div>
                        <h3>John Deo</h3>
                        <span>21-25-2022</span>
                    </div>
                </div>
                <p class="text">wow amazing video! thank for the source code</p>
            </div>



        </div>

    </section>

    <!--comments section end-->
    
     <!--footer-start-->
     <?php require_once './php/layout/footer.php' ?>
    <!--footer-end-->