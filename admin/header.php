
<header class="navbar sticky-top flex-md-nowrap p-0 shadow " style="background-color: #3e3838;">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 d-flex align-items-center" href="../">
    <img src="../images/logo1.png" height="50px" class="me-2">
    <h3 style="color: white;" class="mb-0">موسسه هفت هنر سیمرغ</h3>
  </a>

  
  
        <?php
      



          include '../PersianCalendar.php';
          ?>
          
          <div style="display: flex; align-items: center; justify-content: space-between; color: white; padding: 10px;">
            <h6 style="margin-left: 20px;">امروز : <?php echo mds_date("l j F Y ", time(), 0); ?></h6>
            <a href="logout.php" >خروج</a>
          </div>
          
       

 
    
</header>