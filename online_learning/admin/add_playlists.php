<?php
    include '../components/connect.php';
    if(isset($_COOKIE['tutor_id']))
        $tutor_id = $_COOKIE['tutor_id'];
    else
    {
        $tutor_id = '';
        header('location:login.php');
    }

    if(isset($_POST['submit']))
    {
        $id = create_unique_id();
        $title = $_POST['title'];
        $title = filter_var($title, FILTER_SANITIZE_STRING);
        $description = $_POST['description'];
        $description = filter_var($description, FILTER_SANITIZE_STRING);
        $status = $_POST['status'];
        $status = filter_var($status, FILTER_SANITIZE_STRING);

        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        $rename = create_unique_id().'.'.$ext;
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = '../uploaded_files/'.$rename;

        $add_playlist = $conn->prepare("INSERT INTO `playlist`(id, tutor_id, title, description, thumb, status) VALUES(?,?,?,?,?,?)");
        $add_playlist->execute([$id, $tutor_id, $title, $description, $rename, $status]);
        move_uploaded_file($image_tmp_name, $image_folder);
        $message[] = 'New playlist created';
    }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Playlist</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>

    <?php
        include '../components/admin_header.php';
    ?>

    <section class="playlist-form">

        <h1 class="heading">Add Playlist</h1>

        <form action="" method="POST" enctype="multipart/form-data">
            <p>Playlist status<span>*</span></p>
            <select name="status" required id="" class="box">
                <option value="" selected disabled>-- Select status</option>
                <option value="Active">Active</option>
                <option value="Deactive">Deactive</option>
            </select>
            <p>Playlist title<span>*</span></p>
            <input type="text" class="box" required name="title" maxlength="100" placeholder="Enter title of playlist">
            <p>Playlist description<span>*</span></p>
            <textarea name="description" class="box" required placeholder="Description" maxlength="1000" cols="30"
                rows="10"></textarea>
            <p>Playlist thumbnail<span>*</span></p>
            <input type="file" name="image" accept="image/*" required class="box">
            <input type="submit" value="Create Playlist" name="submit" class="main-btn">

        </form>

    </section>



    <?php
        include '../components/footer.php';
    ?>

    <script src="../js/admin_script.js"></script>
</body>


</html>