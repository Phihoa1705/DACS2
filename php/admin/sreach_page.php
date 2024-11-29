<?php
require_once '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
    $tutor_id = $_COOKIE['tutor_id'];
 }else{
    $tutor_id = '';
    header('location:login.php');
 }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Page</title>

    <!-- font awesome cdn link -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- custom css file -->
     <link rel="stylesheet" href="../../css/admin_style.css">
</head>
<body>
    <!-- header section link -->
    <?php require_once '../components/admin_header.php'; ?>

        <!-- Contents section starts -->
        <section class="contents">
      <h1 class="heading">contents</h1>

      <div class="box-container">
         <?php
            if(isset($_POST['search_btn']) || isset($_POST['search_box'])) {
                $search_box = $_POST['search_box'];
                $search_box = filter_var($search_box, FILTER_SANITIZE_STRING);

                $select_content = getDatabaseConnection()->prepare("SELECT * FROM content WHERE title LIKE '%{$search_box}%' AND tutor_id = ? ORDER BY creation_date DESC");
                $select_content->execute([$tutor_id]);

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
                echo '<p class="empty">no contents was found</p>
                ';
                }
            } else {
                echo '<p class="empty">search something!</p>';
            }
         ?>
         
         
      </div>
    </section>
   <!-- Contents section end -->

   <!-- View playlist section starts -->
   <section class="playlist">
         <h1 class="heading">playlist</h1>
         <div class="box-container">

            <?php
                if(isset($_POST['search_btn']) || isset($_POST['search_box'])) {
                    $search_box = $_POST['search_box'];
                    $search_box = filter_var($search_box, FILTER_SANITIZE_STRING);

                    $select_playlist = getDatabaseConnection()->prepare("SELECT * FROM playlist WHERE title LIKE '%{$search_box}%' AND tutor_id = ? ORDER BY creation_date DESC");
                    $select_playlist->execute([$tutor_id]);
                    if($select_playlist->rowCount() > 0) {
                        while($fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC)) {
        
                            $playlist_id = $fetch_playlist['playlist_id'];
        
                            // content
                            $count_content = getDatabaseConnection()->prepare("SELECT * FROM content WHERE playlist_id = ?");
        
                            $count_content->execute([$playlist_id]);
        
                            $total_contents = $count_content->rowCount();    
            ?>
            <div class="box">
    
                <div class="flex">
                    <div>
                        <i class="fas fa-circle-dot" style="color: <?php echo ($fetch_playlist['status'] == 'active') ? 'limegreen' : 'red'; ?>;"></i>
                        <span style="color: <?php echo ($fetch_playlist['status'] == 'active') ? 'limegreen' : 'red'; ?>;"><?php echo $fetch_playlist['status']; ?></span>
                    </div>
                    <div>
                        <i class="fas fa-calendar"></i>
                        <span><?php echo $fetch_playlist['creation_date']; ?></span>
                    </div>
                </div>
    
                <div class="thumb">
                    <span><?php echo $total_contents;?></span>
                    <img src="../uploaded_files/<?php echo $fetch_playlist['thumb']; ?>" alt="">
                </div>
    
                <h3 class="title"><?php echo $fetch_playlist['title']; ?></h3>
    
                <p class="description"><?php echo $fetch_playlist['description']; ?></p>
    
                <form action="" method="POST" class="flex-btn">
                    <input type="hidden" name="delete_id" value="<?php echo $playlist_id;?>">
                    <a href="update_playlist.php?get_id=<?php echo $playlist_id;?>" class="option-btn">update</a>
                    <input type="submit" value="delete" name="delete_playlist" class="delete-btn">
                </form>
                <a href="view_playlist.php?get_id=<?php echo $playlist_id; ?>" class="btn">View Playlist</a>
    
            </div>
           <?php
                        }
                    } else {
                        echo ' <p class="empty">no playlists was found!</p>';
                    }
                } else {
                    echo '<p class="empty">search something!</p>';
                }
           ?>
         </div>
     </section>
    <!-- View playlist section end -->  

    <!-- footer section link -->
    <?php require_once '../components/footer.php'; ?>
    <!-- custom js file -->
    <script src="../../js/admin_script.js"></script>

    <script>
        document.querySelectorAll('.description').forEach(content => {
            if(content.innerHTML.length > 100) content.innerHTML = content.innerHTML.slice(0,100);
        });

    </script>
</body>
</html>