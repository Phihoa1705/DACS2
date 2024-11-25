<?php

  require_once './php/components/connect.php';

  if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
  } else {
    $user_id = '';
    header('location: home.php');
  }

  if(isset($_POST['delete'])) {

    if($user_id != '') {

        $delete_id = $_POST['delete_id']; 
        $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

        $verify_list = $conn->prepare("SELECT * FROM `bookmark` WHERE playlist_id = ? AND user_id = ?");
        $verify_list->execute([$delete_id, $user_id]);

        if($verify_list->rowCount() > 0) {
            $remove_list = $conn->prepare("DELETE FROM `bookmark` WHERE user_id = ? AND playlist_id = ?");
            $remove_list->execute([$user_id, $delete_id]);
            $message[] = 'playlist removed!';
        } else {
            $message[] = 'playlist already removed!';
        }

    } else {
        $message[] = 'please login first!';
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bookmarked</title>

  <!-- font awesome cdn link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- custom css file -->
     <link rel="stylesheet" href="./css/style.css">
</head>
<body>
  <!-- Header section start -->
   <?php require_once './php/components/user_header.php'; ?>
  <!-- Header section end -->

  <!-- courses section starts -->
  <section class="course">
      <h1 class="heading">Saved Playlist</h1>
      <div class="box-container">
        <?php
          $select_bookmark = $conn->prepare("SELECT * FROM bookmark WHERE user_id = ?");
          $select_bookmark->execute([$user_id]);
          if($select_bookmark->rowCount() > 0) {
            while($fetch_bookmark = $select_bookmark->fetch(PDO::FETCH_ASSOC)) {
              $select_courses = $conn->prepare("SELECT * FROM playlist WHERE playlist_id = ? AND status = ? 
              ORDER BY creation_date DESC");
              $select_courses->execute([$fetch_bookmark['playlist_id'],'active']);

              if($select_courses->rowCount() > 0) {
                while($fetch_course = $select_courses->fetch(PDO::FETCH_ASSOC)) {
                  $course_id = $fetch_course['playlist_id'];

                  $count_course = $conn->prepare('SELECT * FROM content WHERE playlist_id = ?');
                  $count_course->execute([$course_id]);
                  $total_course = $count_course->rowCount();

                  $select_tutor = $conn->prepare("SELECT * FROM tutors WHERE tutor_id = ?");
                  $select_tutor->execute([$fetch_course['tutor_id']]);
                  $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
        ?>
        <div class="box">
            <div class="tutor">
              <img src="./php/uploaded_files/<?php echo $fetch_tutor['image']; ?>" alt="">
              <div>
                <h3><?php echo $fetch_tutor['tutor_name']; ?></h3>
                <span><?php echo $fetch_course['creation_date']; ?></span>
              </div>
            </div>
            <div class="thumb">
              <span><?php echo $total_course;?></span>
              <img src="./php/uploaded_files/<?php echo $fetch_course['thumb'];?>" alt="">
            </div>
            <h3 class="title"><?php echo $fetch_course['title'];?></h3>
            <form action="" method="post" class="flex-btn">
              <input type="hidden" name="delete_id" value="<?php echo $course_id; ?>"">
              <a href="playlist.php?get_id=<?php echo $course_id; ?>" class="inline-btn">view playlist</a>
              <input type="submit" value="remove" name="delete" class="inline-delete-btn" onclick="return confirm('remove from playlist');">
            </form>
        </div>
        <?php
                }
              } else {
                echo '<p class="emtpy">no courses added yet!</p>';
              }
            }
          } else {
            echo '<p class="empty">nothing bookmarked yet!</p>';
          }
        ?>
      </div>
  </section>
  <!-- courses section end -->

  <!-- Footer section start -->
   <?php require_once './php/components/footer.php'; ?>
  <!-- Footer section end -->
  <script src="./js/style.js"></script>
</body>
</html>