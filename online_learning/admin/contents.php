<?php
    include '../components/connect.php';
    if(isset($_COOKIE['tutor_id']))
        $tutor_id = $_COOKIE['tutor_id'];
    else
    {
        $tutor_id = '';
        header('location:login.php');
    }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available videos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>

    <?php
        include '../components/admin_header.php';
    ?>

    <section class="contents">

        <h1 class="heading">Uploaded Videos</h1>

        <div class="box-container">

            <?php

                $select_videos = $conn->prepare("SELECT * FROM `content` WHERE tutor_id = ?");
                $select_videos->execute([$tutor_id]);
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
                    echo '<p class="empty">No videos uploaded yet</p>';
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