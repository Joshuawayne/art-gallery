<?php
include 'connection.php';
session_start();
$user_id = $_SESSION['user_id'];
if(!isset($user_id)){
   header('location:login.php');
}
if(isset($_POST['update_profile'])){
   $name = $_POST['name'];
   $email = $_POST['email'];
   mysqli_query($conn, "UPDATE `users` SET name = '$name', email='$email' WHERE id = '$user_id'") or die('query failed');
   
   $old_pw= $_POST['old_pw'];
   $update_pw = $_POST['update_pw'];
   $new_pw = $_POST['new_pw'];
   $c_pw = $_POST['c_pw'];

   if(!empty($update_pw) AND !empty($new_pw) AND !empty($c_pw)){
      if($update_pw != $old_pw){
         $message[] = 'old password not matched!';
      }elseif($new_pw != $c_pw){
         $message[] = 'confirm password not matched!';
      }else{
         mysqli_query($conn, "UPDATE `users` SET password='$new_pw' WHERE id = '$user_id'") or die('query failed');
         $message[] = 'password updated successfully!';
      }
   }
}
?>
<html>
<head>
   <title>update admin profile</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="user_css.css">
</head>
<body>
<?php include 'user_header.php'; ?>
<h1 class="heading">update <span>profile</span> <a href="#all"><span>&#8594;</a></span></h1>
<section class="update-profile">
   <form action="" method="POST">
      <div class="flex">
      <?php
         $res = mysqli_query($conn, "SELECT * FROM `users` WHERE id='$user_id'") or die('query failed');
         if(mysqli_num_rows($res) > 0){
         $row = mysqli_fetch_assoc($res);
      ?>
      <div class="inputBox">
         <span>username :</span>
         <input type="text" name="name" value="<?php echo $row['name']; ?>" placeholder="update username" required class="box">
         <span>email :</span>
         <input type="email" name="email" value="<?php echo $row['email']; ?>" placeholder="update email" required class="box">
      </div>
      <div class="inputBox">
         <input type="hidden" name="old_pw" value="<?php echo $row['password']; ?>">
         <span>old password :</span>
         <input type="password" name="update_pw" placeholder="enter previous password" class="box">
         <span>new password :</span>
         <input type="password" name="new_pw" placeholder="enter new password" class="box">
         <span>confirm password :</span>
         <input type="password" name="c_pw" placeholder="confirm new password" class="box">
      </div>
      </div>
      <input type="submit" class="btnn" value="update profile" name="update_profile">
      <a href="index.php" class="btn">go back</a>
   </form>
<?php
}
?>
</section>
<script src="js/script.js"></script>
</body>
</html>
