<?php
require_once '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
    $tutor_id = $_COOKIE['tutor_id'];
 }else{
    $tutor_id = '';
    header('location:login.php');
 }
 if(isset($_GET['get_id'])) {
    $get_id = $_GET['get_id'];
 } else {
    $get_id = '';
    header('location:playlists.php');
 }

 if(isset($_POST['delete_playlist'])) {

   $verify_playlist = getDatabaseConnection()->prepare("SELECT * FROM playlist WHERE playlist_id = ?");
   $verify_playlist->execute([$get_id]);

   if($verify_playlist->rowCount() > 0) {
       $feth_thumb = $verify_playlist->fetch(PDO::FETCH_ASSOC);
       $prev_thumb = $feth_thumb['thumb'];
       if($prev_thumb != '') {
           unlink('../uploaded_files/'.$prev_thumb);
       }
       $delete_bookmark = getDatabaseConnection()->prepare("DELETE FROM bookmark WHERE playlist_id = ?");
       $delete_bookmark->execute([$get_id]);

       $delete_playlist = getDatabaseConnection()->prepare("DELETE FROM playlist WHERE playlist_id = ?");
       $delete_playlist->execute([$get_id]);

       header('location:playlists.php');
   } else {
       $message[] = 'playlist was already delete!';
   }
}

if(isset($_POST['delete_content'])) {
   $delete_id = $_POST['content_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_content = getDatabaseConnection()->prepare("SELECT * FROM content WHERE content_id = ?");
   $verify_content->execute([$delete_id]);

   if($verify_content->rowCount() > 0) {
      $fecth_content = $verify_content->fetch(PDO::FETCH_ASSOC);
      unlink('../uploaded_files/'.$fecth_content['thumb']);
      unlink('../uploaded_files/'.$fecth_content['video']);
      $delete_comment = getDatabaseConnection()->prepare("DELETE FROM comments WHERE content_id = ?");
      $delete_comment->execute([$delete_id]);
      
      $delete_likes = getDatabaseConnection()->prepare("DELETE FROM likes WHERE content_id = ?");
      $delete_likes->execute([$delete_id]);

      $delete_content = getDatabaseConnection()->prepare("DELETE FROM content WHERE content_id = ?");
      $delete_content->execute([$delete_id]);

      $message[] = 'content deleted successfully';
   } else {
      $message[] = 'content already deleted!';
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Playlist</title>

    <!-- font awesome cdn link -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- custom css file -->
     <link rel="stylesheet" href="../../css/admin_style.css">
</head>
<body>
    <!-- header section link -->
    <?php require_once '../components/admin_header.php'; ?>

   <!-- View playlist section starts -->
    <section class="playlist-details">
      <h1 class="heading">playlist details</h1> 
      <?php
         $select_playlist = getDatabaseConnection()->prepare("SELECT * FROM playlist WHERE playlist_id = ? AND tutor_id = ?");
         $select_playlist->execute([$get_id,$tutor_id]);
         if($select_playlist->rowCount() > 0) {
            while($fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC)) {

               $playlist_id = $fetch_playlist['playlist_id'];
               // content
               $count_content = getDatabaseConnection()->prepare("SELECT * FROM content WHERE playlist_id = ?");

               $count_content->execute([$get_id]);

               $total_contents = $count_content->rowCount();
               
      ?>

      <div class="row">
         <div class="thumb">

            <img src="../uploaded_files/<?php echo $fetch_playlist['thumb']; ?>" alt="">

            <div class="flex">
               <p><i class="fas fa-video"></i><span><?php echo $total_contents; ?></span></p>
               <p><i class="fas fa-calendar"></i><span><?php echo $fetch_playlist['creation_date']; ?></span></p>
            </div>

         </div>

         <div class="details">

            <h3 class="title"><?php echo $fetch_playlist['title']; ?></h3>

            <p class="description"><?php echo $fetch_playlist['description']; ?></p>
            
            <form action="" method="POST" class="flex-btn">
               <input type="hidden" name="delete_id" value="<?php echo $fetch_playlist['playlist_id'];?>">
               <a href="update_playlist.php?get_id=<?php echo $fetch_playlist['playlist_id'];?>" class="option-btn">update</a>
               <input type="submit" value="delete" name="delete_playlist" class="delete-btn">
            </form>

         </div>
      </div>

      
      
      <?php
            }
         } else {
            echo ' <p class="empty">playlist not created yet!</p>';
         }
      ?>
    </section>
   <!-- View playlist section end -->

   <!-- Contents section starts -->
    <section class="contents">
      <h1 class="heading">playlist contents</h1>

      <div class="box-container">
         <?php

            $select_content = getDatabaseConnection()->prepare("SELECT * FROM content WHERE tutor_id = ? AND playlist_id = ?");
            $select_content->execute([$tutor_id,$get_id]);

            if($select_content->rowCount() > 0) {
               while($fecth_content = $select_content->fetch(PDO::FETCH_ASSOC)) {
         ?>
         
         <div class="box">
            <div class="flex">
               <p><i class="fas fa-dot-circle" style="<?php if($fecth_content['status'] == 'active'){echo 'color:limegreen'; }else{echo 'color:red';} ?>"></i><span><?php echo $fecth_content['status']; ?></span></p>
               <p><i class="fas fa-calendar"></i><span><?php echo $fecth_content['creation_date']; ?></span></p>
            </div>

            <img src="../uploaded_files/<?php echo $fecth_content['thumb']; ?>" class="thumb" alt="">
            <h3 class="title"><?php echo $fecth_content['title']; ?></h3>

            <a href="view_content.php?get_id=<?php echo $fecth_content['content_id']; ?>" class="btn">watch video</a>
            <form action="" method="post" class="flex-btn">
               
               <input type="hidden" name="content_id" value="<?php echo $fecth_content['content_id']; ?>">
               <a href="update_content.php?get_id=<?php echo $fecth_content['content_id']; ?>" class="option-btn">update</a>
               <input type="submit" value="delete" class="delete-btn" onclick="return confirm('delete this content?');" name="delete_content">
            </form>

         </div>
         <?php
               }
            } else {
               echo '<p class="empty">No content added yet!<a href="add_content.php" style="margin-top: 1.5rem;" class="btn">Add new content</a></p>
               ';
            }
         ?>
         
      </div>
    </section>
   <!-- Contents section end -->

    <!-- footer section link -->
    <?php require_once '../components/footer.php'; ?>
    <!-- custom js file -->
    <script src="../../js/admin_script.js"></script>
</body>
</html>