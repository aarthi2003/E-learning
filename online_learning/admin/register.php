<?php
    include '../components/connect.php';


    if(isset($_POST['submit']))
    {
        $id = create_unique_id();
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $profession = $_POST['profession'];
        $profession = filter_var($profession, FILTER_SANITIZE_STRING);
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $pass = sha1($_POST['pass']);
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);
        $cpass = sha1($_POST['cpass']);
        $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        $rename = create_unique_id().'.'.$ext;
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = '../uploaded_files/'.$rename;

        $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE email = ?");
        $select_tutor->execute([$email]);
   
        if($select_tutor->rowCount() > 0)
        {
            $message[] = 'Email already taken';
        }
        else
        {
            if($pass != $cpass)
            {
                $message[] = 'Confirm passowrd not matched';
            }
            else if($image_size > 2000000)
            {
                $message[] = 'Image size too large';
            }
            else
            {
                $insert_tutor = $conn->prepare("INSERT INTO `tutors`(id, name, profession, email, password, image) VALUES(?,?,?,?,?,?)");
                $insert_tutor->execute([$id, $name, $profession, $email, $cpass, $rename]);
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'new tutor registered! please login now';

                $verify_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE email = ? AND PASSWORD = ? LIMIT 1");
                $verify_tutor->execute([$email,$cpass]);
                $row = $verify_tutor->fetch(PDO::FETCH_ASSOC);
                    
                if($insert_tutor)
                {
                   if($verify_tutor->rowCount()>0)
                   {
                      setcookie('tutor_id',$row['id'], time()+60*60*24*30, '/');
                      header('location:dashboard.php');
                   }
                   
                }
            }
        }
    }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body style="padding-left: 0;">

    <?php
    if(isset($message))
    {
        foreach($message as $message)
        {
            echo '
            <div class="message form">
                <span>'.$message.'</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
            ';
        }
    }
?>

    <section class="form-container">

        <form action="" method="post" enctype="multipart/form-data">

            <h3>Register</h3>

            <div class="flex">

                <div class="col">

                    <p>Name<span>*</span></p>
                    <input type="text" name="name" maxlength="50" required placeholder="Enter your name" class="box">
                    <p>Profession<span>*</span></p>
                    <select name="profession" class="box">
                        <option value="" disabled selected>-- Select your profession</option>
                        <option value="Developer">Developer</option>
                        <option value="Desginer">Desginer</option>
                        <option value="Musician">Musician</option>
                        <option value="Biologist">Biologist</option>
                        <option value="Professor">Professor</option>
                        <option value="Engineer">Engineer</option>
                        <option value="Lawyer">Lawyer</option>
                        <option value="Accountant">Accountant</option>
                        <option value="Doctor">Doctor</option>
                        <option value="Journalist">Journalist</option>
                        <option value="Entrepreneur">Entrepreneur</option>
                        <option value="Other">Other</option>
                    </select>
                    <p>Email<span>*</span></p>
                    <input type="email" name="email" maxlength="50" required placeholder="Enter your email" class="box">

                </div>

                <div class="col">

                    <p>Password <span>*</span></p>
                    <input type="password" name="pass" placeholder="Enter your password" maxlength="20" required
                        class="box">
                    <p>Confirm password <span>*</span></p>
                    <input type="password" name="cpass" placeholder="Confirm password" maxlength="20" required
                        class="box">
                    <p>Select profile picture<span>*</span></p>
                    <input type="file" name="image" accept="image/*" required class="box">

                </div>

            </div>

            <p class="link">Already have an account? <a href="login.php">Login now</a></p>
            <input type="submit" name="submit" value="Register" class="option-btn">

        </form>

    </section>







    <script src="../js/admin_script.js"></script>
</body>


</html>