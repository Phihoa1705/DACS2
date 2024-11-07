<?php
require_once '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
    $tutor_id = $_COOKIE['tutor_id'];
 }else{
    $tutor_id = '';
    header('location:login.php');
 }
// content
$count_content = $conn->prepare("SELECT * FROM content WHERE tutor_id = ?");

$count_content->execute([$tutor_id]);

$total_contents = $count_content->rowCount();

// playlist
$count_playlist = $conn->prepare("SELECT * FROM playlist WHERE tutor_id = ?");

$count_playlist->execute([$tutor_id]);

$total_playlists = $count_playlist->rowCount();
// like
$count_likes = $conn->prepare("SELECT * FROM likes WHERE tutor_id = ?");

$count_likes->execute([$tutor_id]);

$total_likes = $count_likes->rowCount();
// comment
$count_comments = $conn->prepare("SELECT * FROM comments WHERE tutor_id = ?");

$count_comments->execute([$tutor_id]);

$total_comments = $count_comments->rowCount();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <!-- font awesome cdn link -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- custom css file -->
     <link rel="stylesheet" href="../../css/admin_style.css">
</head>
<body>
    <!-- header section link -->
    <?php require_once '../components/admin_header.php'; ?>


    <!-- profile section starts -->

        <section class="profile">
            <h1 class="heading">profile details</h1>
            <div class="details">
                
                <div class="tutor">
                    <img src="../uploaded_files/<?php echo $fetch_profile['image'];?>" alt="" srcset="">
                    <h3><?php echo $fetch_profile['tutor_name'];?></h3>
                    <span><?php echo $fetch_profile['profession'];?></span>
                    <a href="./update.php" class="inline-btn">update profile</a>
                </div>

                <div class="box-container">

                    <div class="box">   
                        <h3><?php echo $total_contents; ?></h3>
                        <p>total contents</p>
                        <a href="./contents.php" class="btn">view contents</a>
                    </div>

                    <div class="box">   
                        <h3><?php echo $total_playlists; ?></h3>
                        <p>total playlists</p>
                        <a href="./playlists.php" class="btn">view playlists</a>
                    </div>

                    <div class="box">   
                        <h3><?php echo $total_likes; ?></h3>
                        <p>total likes</p>
                        <a href="./contents.php" class="btn">view Contents</a>
                    </div>
                    
                    <div class="box">   
                        <h3><?php echo $total_comments; ?></h3>
                        <p>total comments</p>
                        <a href="./comments.php" class="btn">view comments</a>
                    </div>

                </div>
            </div>    
        </section>

    <!-- profile section end -->

    <!-- footer section link -->
    <?php require_once '../components/footer.php'; ?>
    <!-- custom js file -->
    <script src="../../js/admin_script.js"></script>
</body>
</html>