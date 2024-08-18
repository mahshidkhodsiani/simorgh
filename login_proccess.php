<?php
session_start();
if(isset($_POST['enter']) ){

   include 'config.php';
   include 'PersianCalendar.php';
   
   $username = $_POST['username'];
   $password = $_POST['password'];

   $sql = "SELECT * FROM  users WHERE username='$username' AND password='$password'";
   
   $result = $conn->query($sql);

   if($result->num_rows > 0){
      $row = $result->fetch_assoc();

  
      if($row['admin']== 1){
         $_SESSION['all_data'] = $row;
   
         header("Location: admin/index");
         exit();
      }else{
         echo 'برای شما یوزری وجود ندارد';
         exit();
      }
   
         
     

      
   }else {
      echo 'نام کاربری یا رمز عبور درست نیست';
    
   }
}
?>
