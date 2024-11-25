<?php

  require_once './php/components/connect.php';

  if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
  } else {
    $user_id = '';
    header('location: home.php');
  }

// playlist
$count_bookmark = $conn->prepare("SELECT * FROM bookmark WHERE user_id = ?");

$count_bookmark->execute([$user_id]);

$total_bookmarks = $count_bookmark->rowCount();
// like
$count_likes = $conn->prepare("SELECT * FROM likes WHERE user_id = ?");

$count_likes->execute([$user_id]);

$total_likes = $count_likes->rowCount();
// comment
$count_comments = $conn->prepare("SELECT * FROM comments WHERE user_id = ?");

$count_comments->execute([$user_id]);

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
     <link rel="stylesheet" href="./css/style.css">
</head>
<body>
  <!-- Header section start -->
   <?php require_once './php/components/user_header.php'; ?>
  <!-- Header section end -->

  <!-- profile section starts -->
  <section class="profile">
      <h1 class="heading">profile details</h1>
      <div class="details">
          
          <div class="tutor">
              <img src="./php/uploaded_files/<?php echo $fetch_profile['image'];?>" alt="" srcset="">
              <h3><?php echo $fetch_profile['name'];?></h3>
              <p><?php echo $fetch_profile['email'];?></p>
              <span>student</span>
              <a href="./update.php" class="inline-btn">update profile</a>
          </div>

          <div class="box-container">

              <div class="box">   
                  <h3><?php echo $total_bookmarks; ?></h3>
                  <p>playlist bookmarked</p>
                  <a href="./playlists.php" class="btn">view playlists</a>
              </div>

              <div class="box">   
                  <h3><?php echo $total_likes; ?></h3>
                  <p>total liked</p>
                  <a href="./contents.php" class="btn">view Contents</a>
              </div>
              
              <div class="box">   
                  <h3><?php echo $total_comments; ?></h3>
                  <p>total commented</p>
                  <a href="./comments.php" class="btn">view comments</a>
              </div>

          </div>
      </div>    
  </section>
  <!-- profile section end -->

  <!-- Footer section start -->
   <?php require_once './php/components/footer.php'; ?>
  <!-- Footer section end -->
  <script src="./js/style.js"></script>
</body>
</html>