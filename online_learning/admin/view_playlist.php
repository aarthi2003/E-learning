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

    if(isset($_POST['delete_playlist']))
    {
        $delete_id = $_POST['playlist_id'];
        $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
        $delete_playlist_thumb = $conn->prepare("SELECT * FROM `playlist` WHERE id = ? LIMIT 1");
        $delete_playlist_thumb->execute([$delete_id]);
        $fetch_thumb = $delete_playlist_thumb->fetch(PDO::FETCH_ASSOC);
        unlink('../uploaded_files/'.$fetch_thumb['thumb']);
        $delete_bookmark = $conn->prepare("DELETE FROM `bookmark` WHERE playlist_id = ?");
        $delete_bookmark->execute([$delete_id]);
        $delete_playlist = $conn->prepare("DELETE FROM `playlist` WHERE id = ?");
        $delete_playlist->execute([$delete_id]);
        header('location:playlists.php');
    }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Playlist</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>

    <?php
        include '../components/admin_header.php';
    ?>

    <section class="playlist-details">

        <div class="heading">
            Playlist
            <a href="add_contents.php" class="option-btn">Upload Video</a>
        </div>

        <?php
            
            $select_playlist = $conn->prepare("SELECT * FROM `playlist` WHERE id=? LIMIT 1");
            $select_playlist->execute([$get_id]);
            if($select_playlist->rowCount()>0)
            {
                while($fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC))
                {
                    $count_videos = $conn->prepare("SELECT * FROM `content` WHERE playlist_id = ?");
                    $count_videos->execute([$get_id]);
                    $total_videos = $count_videos->rowCount();
                
        ?>

        <div class="row">

            <div class="thumb">

                <img src="../uploaded_files/<?= $fetch_playlist['thumb']; ?>" alt="">

                <div class="flex">

                    <p>
                        <i class="fas fa-video"></i>
                        <span>
                            <?=$total_videos;?>
                        </span>
                    </p>

                    <p>
                        <i class="fas fa-calendar"></i>
                        <span>
                            <?= $fetch_playlist['date']; ?>
                        </span>
                    </p>

                </div>

            </div>

            <div class="details">

                <h3 class="title">
                    <?= $fetch_playlist['title']; ?>
                </h3>
                <p class="description">
                    <?= $fetch_playlist['description']; ?>
                </p>

                <form action="" method="post" class="flex-btn">
                    <input type="hidden" name="playlist_id" value="<?= $fetch_playlist['id']; ?>">
                    <a href="update_playlist.php?get_id=<?=$fetch_playlist['id']; ?>" class="main-btn">update</a>
                    <input type="submit" value="delete" class="main-btn"
                        onclick="return confirm('Delete this playlist?');" name="delete_playlist">
                </form>

            </div>

        </div>

        <?php
                }
          
            }
            else
            {
                echo '<p class="empty">Empty Playlist</p>';
            }

        ?>

    </section>


    <section class="contents">

        <h1 class="heading">Videos</h1>

        <div class="box-container">

            <?php

                $select_videos = $conn->prepare("SELECT * FROM `content` WHERE tutor_id = ? AND playlist_id = ?");
                $select_videos->execute([$tutor_id, $get_id]);
                if($select_videos->rowCount() > 0)
                {
                   while($fecth_videos = $select_videos->fetch(PDO::FETCH_ASSOC))
                   { 
                      $video_id = $fecth_videos['id'];
            ?>

            <div class="box">

                <div class="flex">

                    <div><i class="fas fa-dot-circle"
                            style="<?php if($fecth_videos['status'] == 'Active'){echo 'color:limegreen'; }else{echo 'color:red';} ?>"></i><span
                            style="<?php if($fecth_videos['status'] == 'Active'){echo 'color:limegreen'; }else{echo 'color:red';} ?>">
                            <?= $fecth_videos['status']; ?>
                        </span></div>
                    <div><i class="fas fa-calendar"></i><span>
                            <?= $fecth_videos['date']; ?>
                        </span></div>

                </div>

                <div class="cover">
                    <img src="../uploaded_files/<?= $fecth_videos['thumb']; ?>" class="thumb" alt="">
                </div>

                <h3 class="title">
                    <?= $fecth_videos['title']; ?>
                </h3>

                <form action="" method="post" class="display">
                    <input type="hidden" name="video_id" value="<?= $video_id; ?>">
                    <a href="update_content.php?get_id=<?= $video_id; ?>" class="main-btn">update</a>
                    <input type="submit" value="delete" class="main-btn" onclick="return confirm('delete this video?');"
                        name="delete_video">
                </form>
                <a href="view_content.php?get_id=<?= $video_id; ?>" class="main-btn">watch video</a>


            </div>

            <?php

                   }
                }
                else
                {
                    echo '<p class="empty">Playlist is empty<a href="add_contents.php" class="main-btn">Upload Videos</a></p>';
                }

            ?>

        </div>

    </section>


    <?php
        include '../components/footer.php';
    ?>

    <script src="../js/admin_script.js"></script>
</body>


</html>