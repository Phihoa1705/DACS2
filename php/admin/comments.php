<?php
require_once '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
    $tutor_id = $_COOKIE['tutor_id'];
 }else{
    $tutor_id = '';
    header('location:login.php');
 }

 if(isset($_POST['delete_comment'])){
   $delete_id = $_POST['comment_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING); 

   $verify_comment = getDatabaseConnection()->prepare("SELECT * FROM comments WHERE comment_id = ?");
   $verify_comment->execute([$delete_id]);

   if($verify_comment->rowCount() > 0){
      $delete_comment = getDatabaseConnection()->prepare("DELETE FROM comments WHERE comment_id = ?");
      $delete_comment->execute([$delete_id]);
      $message[] = 'comment deleted successfully';
      header('location:comments.php');
   } else {
      $message[] = 'comment already deleted';
   }
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>

    <!-- font awesome cdn link -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- custom css file -->
     <link rel="stylesheet" href="../../css/admin_style.css">
</head>
<body>
    <!-- header section link -->
    <?php require_once '../components/admin_header.php'; ?>

        <!-- Comments section start -->
        <section class="comments">
         <h1 class="heading">User comments</h1>
         
         <div class="box-container">
            <?php
               $select_comments = getDatabaseConnection()->prepare("SELECT * FROM comments WHERE tutor_id = ?");
               $select_comments->execute([$tutor_id]);
               if($select_comments->rowCount() > 0) {
                  while($fetch_comment = $select_comments->fetch(PDO::FETCH_ASSOC)) {
                     $comment_id = $fetch_comment['comment_id'];

                     $select_commentor = getDatabaseConnection()->prepare("SELECT * FROM users WHERE user_id = ?");
                     $select_commentor->execute([$fetch_comment['user_id']]);
                     $fetch_commentor = $select_commentor->fetch(PDO::FETCH_ASSOC);

                     $select_content = getDatabaseConnection()->prepare("SELECT * FROM content WHERE content_id = ?");
                     $select_content->execute([$fetch_comment['content_id']]);
                     $fetch_content = $select_content->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="box">
                <div class="comment-content">
                    <p><?php echo $fetch_content['title'] ?></p>
                    <a href="view_content.php?get_id=<?php echo $fetch_content['content_id']; ?>">View Content</a>
                </div>
               <div class="user">
                  <img src="../uploaded_files/<?php echo $fetch_commentor['image'];?>" alt="">
                  <div>
                     <h3><?php echo $fetch_commentor['name'];?></h3>
                     <span><?php echo $fetch_comment['creation_date'];?></span>
                  </div>
               </div>
               <p class="comment-box"><?php echo $fetch_comment['comment'];?></p>
               <form action="" method="post">
                  <input type="hidden" name="comment_id" value="<?php echo $fetch_comment['content_id'];?>">
                  <input type="submit" value="delete comment" name="delete_comment" 
                  onclick="return confirm('delete this comnment?');" class="inline-delete-btn">
               </form>
            </div>
            <?php
                  }
               } else{
                  echo '<p class="empty">no comments added yet!</p>';
               }
            ?>
         </div>
     </section>
    <!-- Comments section end -->

    <!-- footer section link -->
    <?php require_once '../components/footer.php'; ?>
    <!-- custom js file -->
    <script src="../../js/admin_script.js"></script>
</body>
</html>