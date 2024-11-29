<?php

require_once './php/components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}
if (isset($_GET['get_id'])) {
    $get_id = $_GET['get_id'];
} else {
    $get_id = '';
    header('location: courses.php');
}

if(isset($_POST['save_list'])) {

    if($user_id != '') {

        $list_id = $_POST['list_id']; 
        $list_id = filter_var($list_id, FILTER_SANITIZE_STRING);

        $verify_list = getDatabaseConnection()->prepare("SELECT * FROM `bookmark` WHERE playlist_id = ? AND user_id = ?");
        $verify_list->execute([$list_id, $user_id]);

        if($verify_list->rowCount() > 0) {
            $remove_list = getDatabaseConnection()->prepare("DELETE FROM `bookmark` WHERE user_id = ? AND playlist_id = ?");
            $remove_list->execute([$user_id, $list_id]);
            $message[] = 'playlist removed!';
        } else {
            $add_list = getDatabaseConnection()->prepare("INSERT INTO `bookmark`(`user_id`, `playlist_id`) VALUES (?, ?)");
            $add_list->execute([$user_id, $list_id]);
            $message[] = 'playlist saved!';
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
    <title>View Playlist</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- custom css file -->
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <!-- Header section start -->
    <?php require_once './php/components/user_header.php'; ?>
    <!-- Header section end -->

    <!-- view playlist section start -->
    <section class="playlist-details">

        <h1 class="heading">playlist details</h1>

        <div class="row">
            <?php
            $select_playlist = getDatabaseConnection()->prepare("SELECT * FROM `playlist` WHERE playlist_id = ? AND status = ? LIMIT 1");
            $select_playlist->execute([$get_id, 'active']);

            if ($select_playlist->rowCount() > 0) {
                while ($fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC)) {

                    $playlist_id = $fetch_playlist['playlist_id'];

                    $count_content = getDatabaseConnection()->prepare("SELECT * FROM `content` WHERE playlist_id = ? AND status = ?");
                    $count_content->execute([$playlist_id,'active']);
                    $total_content = $count_content->rowCount();

                    $select_tutor = getDatabaseConnection()->prepare('SELECT * FROM tutors WHERE tutor_id = ? LIMIT 1');
                    $select_tutor->execute([$fetch_playlist['tutor_id']]);
                    $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);

                    $select_bookmark = getDatabaseConnection()->prepare("SELECT * FROM `bookmark` WHERE user_id = ? AND playlist_id = ?");
                    $select_bookmark->execute([$user_id, $playlist_id]);
            ?>  
            <div class="col">
                <form action="" method="POST">
                    <input type="hidden" name="list_id" value="<?php echo $playlist_id; ?>">
                    <?php if ($select_bookmark->rowCount() > 0) { ?>
                        <button type="submit" name="save_list" class="inline-btn"><i class="fas fa-bookmark"></i><span>saved</span></button>
                    <?php } else { ?>
                        <button type="submit" name="save_list" class="inline-option-btn"><i class="fas fa-bookmark"></i><span>saved playlist</span></button>
                    <?php } ?>
                </form>
                <div class="thumb">
                    <span><?php echo $total_content; ?></span>
                    <img src="./php/uploaded_files/<?php echo $fetch_playlist['thumb']; ?>" alt="">
                </div>
            </div>
            <div class="col">
                <div class="tutor">
                    <img src="./php/uploaded_files/<?php echo $fetch_tutor['image']; ?>" alt="">
                    <div>
                        <h3><?php echo $fetch_tutor['tutor_name']; ?></h3>
                        <span><?php echo $fetch_tutor['profession']; ?></span>
                    </div>
                </div>
                <h3 class="title"><?php echo $fetch_playlist['title']; ?></h3>
                <p class="description">
                    <?php echo $fetch_playlist['description']; ?>
                </p>
                <div class="date"><i class="fas fa-calendar"></i><span><?php echo $fetch_playlist['creation_date']; ?></span></div>
            </div>
            <?php 
                }
            } else {
                echo '<p class="empty">playlist was not found!</p>';
            }
            ?>
        </div>

    </section>
    <!-- view playlist section end -->
    
    <!-- playlist video section start -->
    <section class="playlist-videos">
        <h1 class="heading">playlist videos</h1>
        <div class="box-container">
            <?php
                $select_content = getDatabaseConnection()->prepare("SELECT * FROM `content` WHERE playlist_id = ? AND status = ? ORDER BY creation_date DESC");
                $select_content->execute([$get_id, 'active']);
                if($select_content->rowCount() > 0) {
                    while($fetch_content = $select_content->fetch(PDO::FETCH_ASSOC)) {

            ?>
            <a href="watch-video.php?get_id=<?php echo $fetch_content['content_id'];?>" class="box">
                <i class="fas fa-play"></i>
                <img src="./php/uploaded_files/<?php echo $fetch_content['thumb']; ?>" alt="">
                <h3><?php echo $fetch_content['title']; ?></h3>
            </a>
            <?php
                    }
                } else {
                    echo '<p class="empty">content not added yet!</p>';
                }
            ?>
        </div>
    </section>
    <!-- playlist video section end -->

    <!-- Footer section start -->
    <?php require_once './php/components/footer.php'; ?>
    <!-- Footer section end -->
    <script src="./js/style.js"></script>
</body>
</html>
