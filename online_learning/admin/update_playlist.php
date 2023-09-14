<?php
    include '../components/connect.php';
    if(isset($_COOKIE['tutor_id']))
        $tutor_id = $_COOKIE['tutor_id'];
    else
    {
        $tutor_id = '';
        header('location:login.php');
    }

    if(isset($_GET['get_id']))
    {
        $get_id = $_GET['get_id'];
    }
    else
    {
        $get_id = '';
        header('location:playlist.php');
    }

    if(isset($_POST['submit']))
    {

        $title = $_POST['title'];
        $title = filter_var($title, FILTER_SANITIZE_STRING);
        $description = $_POST['description'];
        $description = filter_var($description, FILTER_SANITIZE_STRING);
        $status = $_POST['status'];
        $status = filter_var($status, FILTER_SANITIZE_STRING);
     
        $update_playlist = $conn->prepare("UPDATE `playlist` SET title = ?, description = ?, status = ? WHERE id = ?");
        $update_playlist->execute([$title, $description, $status, $get_id]);
     
        $old_image = $_POST['old_image'];
        $old_image = filter_var($old_image, FILTER_SANITIZE_STRING);
        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        $rename = create_unique_id().'.'.$ext;
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = '../uploaded_files/'.$rename;
     
        if(!empty($image))
        {
           if($image_size > 2000000)
           {
                $message[] = 'image size is too large!';
           }
           else
           {
                $update_image = $conn->prepare("UPDATE `playlist` SET thumb = ? WHERE id = ?");
                $update_image->execute([$rename, $get_id]);
                move_uploaded_file($image_tmp_name, $image_folder);
                if($old_image != '' AND $old_image != $rename)
                {
                    unlink('../uploaded_files/'.$old_image);
                }
           }
        } 
     
        $message[] = 'Playlist updated';  
     
    }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Playlist</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>

    <?php
        include '../components/admin_header.php';
    ?>

    <section class="playlist-form">

        <h1 class="heading">Update Playlist</h1>

        <?php
                $select_playlist = $conn->prepare("SELECT * FROM `playlist` WHERE id=?");
                $select_playlist->execute([$get_id]);
                if($select_playlist->rowCount()>0)
                {
                    while($fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC))
                    {
                        $playlist_id = $fetch_playlist['id'];
           
                
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="old_image" value="<?=$fetch_playlist['thumb'];?>">
            <p>Update status</p>
            <select name="status" class="box" required>
                <option value="" selected>
                    <?= $fetch_playlist['status']; ?>
                </option>
                <option value="Active">Active</option>
                <option value="Deactive">Deactive</option>
            </select>
            <p>Update title</p>
            <input type="text" class="box" name="title" maxlength="100" placeholder="Enter title of playlist"
                value="<?= $fetch_playlist['title']; ?>">
            <p>Update description</p>
            <textarea name="description" class="box" placeholder="Description" maxlength="1000" cols="30"
                rows="10"><?= $fetch_playlist['description']; ?></textarea>
            <p>Update thumbnail</p>
            <img src="../uploaded_files/<?=$fetch_playlist['thumb'];?>" alt="">
            <input type="file" name="image" accept="image/*" class="box">
            <input type="submit" value="Update Playlist" name="submit" class="main-btn">
            <div class="flex-btn">
                <a href="view_playlist.php?get_id=<?= $playlist_id; ?>" class="main-btn">View Playlist</a>
            </div>

        </form>

        <?php
                    }
            
                }
                else
                {
                    echo '<p class="empty">Empty Playlist</p>';
                }


        ?>

    </section>




    <?php
        include '../components/footer.php';
    ?>

    <script src="../js/admin_script.js"></script>
</body>


</html>