<?php

    include 'components/connect.php';
    if(isset($_COOKIE['user_id']))
        $user_id = $_COOKIE['user_id'];
    else
        $user_id = '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
</head>

<body>

   <?php include 'components/user_header.php';?>


   <section class="about">

      <div class="row">

         <div class="image">
            <img src="images/about-img.svg" alt="">
         </div>

         <div class="content">

            <p>This is a non-profit platform providing free access to educational content.</p>
            <a href="courses.php" class="inline-btn">our courses</a>
         </div>

      </div>

      <div class="box-container">

         <div class="box">
            <i class="fas fa-graduation-cap"></i>
            <div>
               <h3>+1k</h3>
               <span>Courses</span>
            </div>
         </div>

         <div class="box">
            <i class="fas fa-user-graduate"></i>
            <div>
               <h3>+25k</h3>
               <span>Learners</span>
            </div>
         </div>

         <div class="box">
            <i class="fas fa-chalkboard-user"></i>
            <div>
               <h3>+5k</h3>
               <span>Tutors</span>
            </div>
         </div>

         <div class="box">
            <i class="fas fa-briefcase"></i>
            <div>
               <h3>100%</h3>
               <span>Free Access</span>
            </div>
         </div>

      </div>

   </section>



   <section class="reviews">

      <h1 class="heading">student's reviews</h1>

      <div class="box-container">

         <div class="box">
            <p>This platform makes learning easy.</p>
            <div class="user">
               <img src="images/s1.png" alt="">
               <div>
                  <h3>Mayur Kharche</h3>
                  <div class="stars">
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                  </div>
               </div>
            </div>
         </div>

         <div class="box">
            <p>Lived up to all the expectations.</p>
            <div class="user">
               <img src="images/s2.png" alt="">
               <div>
                  <h3>Brijesh Sahoo</h3>
                  <div class="stars">
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star-half-alt"></i>
                  </div>
               </div>
            </div>
         </div>

         <div class="box">
            <p>Played a pivotal role in my journey.</p>
            <div class="user">
               <img src="images/s3.png" alt="">
               <div>
                  <h3>Soumya Darbari</h3>
                  <div class="stars">
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                  </div>
               </div>
            </div>
         </div>

         <div class="box">
            <p>Helped me channel my energy properly.</p>
            <div class="user">
               <img src="images/s4.png" alt="">
               <div>
                  <h3>Rohit Joshi</h3>
                  <div class="stars">
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                  </div>
               </div>
            </div>
         </div>

         <div class="box">
            <p>Quality of content improved dynamically.</p>
            <div class="user">
               <img src="images/s5.png" alt="">
               <div>
                  <h3>Hardik Param</h3>
                  <div class="stars">
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                  </div>
               </div>
            </div>
         </div>

         <div class="box">
            <p>Courses are structured in a proper way.</p>
            <div class="user">
               <img src="images/s6.png" alt="">
               <div>
                  <h3>Samrat Singh</h3>
                  <div class="stars">
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star-half-alt"></i>
                  </div>
               </div>
            </div>
         </div>

      </div>

   </section>





   <?php include 'components/footer.php';?>

   <script src="js/script.js"></script>

</body>

</html>