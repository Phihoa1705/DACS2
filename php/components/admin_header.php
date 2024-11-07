<?php
    if(isset($message)){
        foreach($message as $message) {
            echo '
            <div class="message">
                <span>'.$message.'</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>';
        }
    }
?>
<!-- header section start -->
    <header class="header">
        <section class="flex">
            <a href="/DACS2/php/admin/dashboard.php" class="logo">Admin.</a>

            <form action="/DACS2/php/admin/sreach_page.php" method="post" class="search-form">
                <input type="text" placeholder="search here..." name="search_box" id="" required maxlength="100">
                <button type="submit" class="fas fa-search" name="search_btn"></button>
            </form>

            <div class="icons">
                <div id="menu-btn" class="fas fa-bars"></div>
                <div id="search-btn" class="fas fa-search"></div>
                <div id="user-btn" class="fas fa-user"></div>
                <div id="toggle-btn" class="fas fa-sun"></div>
            </div>

            <div class="profile">
                
                <?php 
                $select_profile = $conn->prepare("SELECT * FROM tutors WHERE tutor_id = ?");
                    $select_profile->execute([$tutor_id]);
                    if($select_profile->rowCount() > 0)
                    {
                        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                ?>

                <img src="../uploaded_files/<?php echo $fetch_profile['image']; ?>" alt="">

                <h3><?php echo $fetch_profile['tutor_name']; ?></h3>

                <span><?php echo $fetch_profile['profession']; ?></span>

                <a href="../admin/profile.php" class="btn">View Profile</a>

                <div class="flex-btn">
                    <a href="../admin/login.php" class="option-btn">login</a>
                    <a href="../admin/register.php" class="option-btn">register</a>
                </div>

                <a href="../components/admin_logout.php" 
                onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>

                <?php
                } else {       
                ?>

                <h3>please login first</h3>

                <div class="flex-btn">
                    <a href="../admin/login.php" class="option-btn">login</a>
                    <a href="../admin/register.php" class="option-btn">register</a>
                </div>

                <?php
                }
                ?>
            </div>
        </section>
    </header>
<!-- header section end -->

<!-- slide bar section starts -->
 <div class="side-bar">

    <div id="close-bar" >
        <i class="fas fa-times"></i>
    </div>

    <div class="profile">

        <?php 
            $select_profile = $conn->prepare("SELECT * FROM tutors WHERE tutor_id = ?");
            $select_profile->execute([$tutor_id]);
            if($select_profile->rowCount() > 0)
            {
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>

        <img src="../uploaded_files/<?php echo $fetch_profile['image'] ?>" alt="">

        <h3><?php echo $fetch_profile['tutor_name'] ?></h3>

        <span><?php echo $fetch_profile['profession'] ?></span>

        <a href="../admin/profile.php" class="btn">View Profile</a>
        
        <?php
             } else {       
        ?>

        <h3>please login first</h3>

        <div class="flex-btn">
            <a href="../admin/login.php" class="option-btn">login</a>
            <a href="../admin/register.php" class="option-btn">register</a>
        </div>

        <?php
            }
        ?>
    </div>

    <nav class="navbar">
        <a href="../admin/dashboard.php"><i class="fas fa-home"></i><span>home</span></a>
        <a href="../admin/playlists.php"><i class="fas fa-bars-staggered"></i><span>playlist</span></a>
        <a href="../admin/contents.php"><i class="fas fa-graduation-cap"></i><span>contents</span></a>
        <a href="../admin/comments.php"><i class="fas fa-comment"></i><span>comments</span></a>
        <a href="./admin_logout.php" onclick="return confirm('logout from this website?');">
            <i class="fas fa-right-from-bracket"></i><span>logout</span></a>
    </nav>

 </div>
<!-- slide bar section end -->