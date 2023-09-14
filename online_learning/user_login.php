<?php

    include 'components/connect.php';
    if(isset($_COOKIE['user_id']))
        $user_id = $_COOKIE['user_id'];
    else
    {
        $user_id = '';
    }

    if(isset($_POST['submit']))
    {

        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $pass = sha1($_POST['pass']);
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);
     
        $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
        $select_user->execute([$email, $pass]);
        $row = $select_user->fetch(PDO::FETCH_ASSOC);
        
        if($select_user->rowCount() > 0){
          setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');
          header('location:home.php');
        }else{
           $message[] = 'Incorrect email or password';
        }
     
    }
     

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php include 'components/user_header.php';?>


    <section class="form-container">

        <form action="" class="login" method="post" enctype="multipart/form-data">

            <h3>Login</h3>
            <p>Email<span>*</span></p>
            <input type="email" name="email" maxlength="50" required placeholder="Enter your email" class="box">
            <p>Password <span>*</span></p>
            <input type="password" name="pass" placeholder="Enter your password" maxlength="20" required class="box">
            <p class="link">Don't have an account? <a href="user_register.php">Register</a></p>
            <input type="submit" name="submit" value="Login" class="option-btn">

        </form>

    </section>


    <?php include 'components/footer.php';?>

    <script src="js/script.js"></script>

</body>

</html>