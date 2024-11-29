<?php
require_once '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
    $tutor_id = $_COOKIE['tutor_id'];
 }else{
    $tutor_id = '';
    header('location:login.php');
 }

 if(isset($_POST['delete_playlist'])) {
    $delete_id = $_POST['delete_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    $verify_playlist = getDatabaseConnection()->prepare("SELECT * FROM playlist WHERE playlist_id = ?");
    $verify_playlist->execute([$delete_id]);

    if($verify_playlist->rowCount() > 0) {
        $feth_thumb = $verify_playlist->fetch(PDO::FETCH_ASSOC);
        $prev_thumb = $feth_thumb['thumb'];
        if($prev_thumb != 'default.jpg') {
            unlink('../uploaded_files/'.$prev_thumb);
        }
        $delete_bookmark = getDatabaseConnection()->prepare("DELETE FROM bookmark WHERE playlist_id = ?");
        $delete_bookmark->execute([$delete_id]);

        $delete_playlist = getDatabaseConnection()->prepare("DELETE FROM playlist WHERE playlist_id = ?");
        $delete_playlist->execute([$delete_id]);

        $message[] = 'playlist was delete!';
    } else {
        $message[] = 'playlist was already delete!';
    }
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Playlist</title>

    <!-- font awesome cdn link -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- custom css file -->
     <link rel="stylesheet" href="../../css/admin_style.css">
</head>
<body>
    <!-- header section link -->
    <?php require_once '../components/admin_header.php'; ?>


    <!-- View playlist section starts -->
     <section class="playlist">
         <h1 class="heading">all playlist</h1>
         <div class="box-container">

            <div class="box" style="text-align: center;">
                <h3 class="title" style="padding-bottom: 0.7rem;">Create New Playlist</h3>
                <a href="add_playlist.php" class="btn">Add Playlist</a>
            </div>

            <?php
                $select_playlist = getDatabaseConnection()->prepare("SELECT * FROM playlist WHERE tutor_id = ?");
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
                    echo '<p class="empty">playlist not created yet!</p>';
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