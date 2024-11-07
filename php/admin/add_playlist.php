<?php
require_once '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
    $tutor_id = $_COOKIE['tutor_id'];
} else {
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

    $thumb = $_FILES['thumb']['name'];
    $thumb = filter_var($thumb, FILTER_SANITIZE_STRING);
    $ext = pathinfo($thumb, PATHINFO_EXTENSION);
    $rename = create_unique_id().'.'.$ext;

    $thumb_tmp_name = $_FILES['thumb']['tmp_name'];
    $thumb_size = $_FILES['thumb']['size'];
    $thumb_folder = '../uploaded_files/'.$rename;

    $verify_playlist = $conn->prepare("SELECT * FROM playlist WHERE playlist_id = ? AND tutor_id = ? AND title = ? AND description = ? AND thumb = ? AND status = ?");
    $verify_playlist->execute([$id, $tutor_id, $title, $description, $thumb, $status]);

    if($verify_playlist->rowCount() > 0){
        $message[] = 'playlist already exist!';
    } else {
        $add_playlist = $conn->prepare("INSERT INTO playlist (playlist_id, tutor_id, title,
     description, thumb, status) VALUES (?, ?, ?, ?, ?, ?)");

        $add_playlist->execute([$id, $tutor_id, $title, $description, $rename, $status]);

        move_uploaded_file($thumb_tmp_name, $thumb_folder);

        $message[] = 'new playlist created!';
    }

    
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Playlist</title>

    <!-- font awesome cdn link -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- custom css file -->
     <link rel="stylesheet" href="../../css/admin_style.css">
</head>
<body>
    <!-- header section link -->
    <?php require_once '../components/admin_header.php'; ?>

    <!-- Add playlist starts -->
     <section class="crud-form">
        <h1 class="heading">Add Playlist</h1>

        <form action="" method="POST" enctype="multipart/form-data">
            <p>playlist status <span>*</span></p>
            <select name="status" class="box" require>
                <option value="active">active</option>
                <option value="deactive">deactive</option>
            </select>

            <p>playlist title <span>*</span></p>
            <input type="text" class="box" name="title" maxlength="100" 
            placeholder="enter playlist title" required>

            <p>playlist description <span>*</span></p>
            <textarea name="description" class="box" cols="30" 
            rows="10" require placeholder="enter playlist description" maxlength="1000"></textarea>

            <p>playlist thumnail <span>*</span></p>
            <input type="file" name="thumb" accept="image/*" require class="box">

            <input type="submit" value="create playlist" name="submit" class="btn">
        </form>

     </section>
    <!-- Add playlist end -->

    <!-- footer section link -->
    <?php require_once '../components/footer.php'; ?>
    <!-- custom js file -->
    <script src="../../js/admin_script.js"></script>
</body>
</html>