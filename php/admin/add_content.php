<?php
require_once '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
    $tutor_id = $_COOKIE['tutor_id'];
 }else{
    $tutor_id = '';
    header('location:login.php');
 }

 if(isset($_POST['submit'])){
    $id = create_unique_id();
    $status = $_POST['status'];
    $status = filter_var($status, FILTER_SANITIZE_STRING);
    $title = $_POST['title'];
    $title = filter_var($title, FILTER_SANITIZE_STRING);
    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_STRING);
    $playlist_id = $_POST['playlist'];
    $playlist_id = filter_var($playlist_id, FILTER_SANITIZE_STRING);

    $thumb = $_FILES['thumb']['name'];
    $thumb = filter_var($thumb, FILTER_SANITIZE_STRING);
    $thumb_ext = pathinfo($thumb, PATHINFO_EXTENSION);
    $rename_thumb = create_unique_id().'.'.$thumb_ext;

    $thumb_tmp_name = $_FILES['thumb']['tmp_name'];
    $thumb_size = $_FILES['thumb']['size'];
    $thumb_folder = '../uploaded_files/'.$rename_thumb;

    $video = $_FILES['video']['name'];
    $video = filter_var($video, FILTER_SANITIZE_STRING);
    $video_ext = pathinfo($video, PATHINFO_EXTENSION);
    $rename_video = create_unique_id().'.'.$video_ext;

    $video_tmp_name = $_FILES['video']['tmp_name'];
    
    $video_folder = '../uploaded_files/'.$rename_video;

    $verify_content = $conn->prepare("SELECT * FROM content WHERE content_id = ? AND tutor_id = ? AND title = ? AND description = ? AND thumb = ? AND status = ?");
    $verify_content->execute([$id, $tutor_id, $title, $description, $thumb, $status]);

    if($verify_content->rowCount() > 0){
        $message[] = 'content already exist!';
    } else {
        if($thumb_size > 2000000) {
            $message[] = 'image size is too large!';
        } else {
            $add_content = $conn->prepare("INSERT INTO content (content_id, tutor_id, playlist_id, title,
            description, video, thumb, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
       
            $add_content->execute([$id, $tutor_id,$playlist_id, $title, $description, $rename_video, $rename_thumb, $status]);
       
            move_uploaded_file($thumb_tmp_name, $thumb_folder);
            move_uploaded_file($video_tmp_name, $video_folder);
       
            $message[] = 'new content created!';
        }
    }

    
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Content</title>

    <!-- font awesome cdn link -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- custom css file -->
     <link rel="stylesheet" href="../../css/admin_style.css">
</head>
<body>
    <!-- header section link -->
    <?php require_once '../components/admin_header.php'; ?>

    <!-- Add Content Section Starts -->
     <section class="crud-form">
        <h1 class="heading">Add content</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <p>content status <span>*</span></p>
            <select name="status" class="box" require>
                <option value="active">active</option>
                <option value="deactive">deactive</option>
            </select>
            
            <p>content title <span>*</span></p>
            <input type="text" class="box" name="title" maxlength="100" 
            placeholder="enter content title" required>

            <p>content description <span>*</span></p>
            <textarea name="description" class="box" cols="30" 
            rows="10" require placeholder="enter playlist description" maxlength="1000"></textarea>

            <select name="playlist" required class="box">

                <option value="" disabled selected>--select playlist</option>
                <?php
                    $select_playlist = $conn->prepare("SELECT * FROM playlist WHERE tutor_id = ?");
                    $select_playlist->execute([$tutor_id]);
                    if($select_playlist->rowCount() > 0) {
                        while($fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC)) {
                            
                        
                ?>
                    <option value="<?php echo $fetch_playlist['playlist_id'] ?>">
                        <?php echo $fetch_playlist['title'] ?></option>
                <?php
                        }
                    } else {
                        echo '<option value="" disabled >no playlists created yet!</option>';
                    }
                ?>
            </select>

            <p>select thumnail <span>*</span></p>
            <input type="file" name="thumb" accept="image/*" require class="box">

            <p>select video <span>*</span></p>
            <input type="file" name="video" accept="video/*" require class="box">

            <input type="submit" value="add content" name="submit" class="btn">
            
        </form>
     </section>
    <!-- Add Content Section End -->

    <!-- footer section link -->
    <?php require_once '../components/footer.php'; ?>
    <!-- custom js file -->
    <script src="../../js/admin_script.js"></script>
</body>
</html>