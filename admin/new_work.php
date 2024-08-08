<?php
session_start();

if (!isset($_SESSION["all_data"])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION["all_data"]['id'];
// $admin = $_SESSION["all_data"]['admin'];
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خانه</title>


    <link rel="icon" href="img/logo.png" type="image/x-icon">

    <?php
    include 'includes.php';
    include '../config.php';
    // include 'functions.php';
    // include 'PersianCalendar.php';
    ?>
    <!-- <link rel="stylesheet" href="styles.css"> -->



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

   

<?php include 'header.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 d-flex">
                <?php
                include 'sidebar.php';
                ?>
              
            </div>

            <div class="col-md-8 col-sm-12">
                <form action="new_user.php" method="POST" enctype="multipart/form-data" class="p-3 border mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold">
                                نام
                            </label>
                            <input type="text" name="name" class="form-control" required autocomplete="off">
                        </div>
                        <div class="col-md-6">
                            <label for="family" class="form-label fw-semibold">
                                نام خانوادگی
                            </label>
                            <input type="text" name="family" class="form-control" required autocomplete="off">
                        </div>
                    </div>
                   
                    <div class="row mt-1">
                        <div class="col-md-6">
                            <label for="username" class="form-label fw-semibold">
                                یوزرنیم
                            </label>
                            <input type="username" name="username" class="form-control" required autocomplete="off">
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label fw-semibold">
                                پسوورد(عدد)
                            </label>
                            <input type="number" name="password" class="form-control" required autocomplete="off">
                        </div>
                    </div>

                    <div class="row mt-2">
                        
                        <div class="col-md-1">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="isAdmin" name="isAdmin">
                                <label class="form-check-label" for="isAdmin" >
                                    ادمین
                                </label>
                            </div>
                        </div>
                        <div class="col-md-10">
                            
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <button name="enter" class="btn btn-outline-success">ثبت</button>
                        </div>
                    </div>
                </form>


                <script>
                    document.getElementById('userForm').addEventListener('submit', function(event) {
                       
                        event.preventDefault();
                        
                  
                        document.getElementById('userForm').reset();
                    });
                </script>

                <div class="row mt-4">
                    <div class="col-md-10">
                        <?php
                        // Pagination configuration
                        $items_per_page = 10; // Number of items per page
                        $current_page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page, default is 1

                        // Calculate the offset for the SQL query
                        $offset = ($current_page - 1) * $items_per_page;

                        // SQL query to retrieve a subset of rows based on pagination
                        $sql = "SELECT * FROM users ";
                        $result = $conn->query($sql);

                        // Display the table
                        if ($result->num_rows > 0) {
                            $a = ($current_page - 1) * $items_per_page + 1; // Counter for row numbers
                            ?>
                            <div class="table-responsive">
                                <table class="table border border-4">
                                    <h4>نگاه کلی :</h4>
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">ردیف</th>
                                            <th scope="col" class="text-center">نام</th>
                                            <th scope="col" class="text-center">نام خانوادگی</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <th scope="row" class="text-center"><?= $a ?></th>
                                                <td class="text-center"><?= $row['name'] ?></td>
                                                <td class="text-center"><?= $row['family'] ?></td>
                                            </tr>
                                            <?php
                                            $a++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php

                            // Pagination links
                            $sql = "SELECT COUNT(*) AS total FROM users";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            $total_items = $row['total'];
                            $total_pages = ceil($total_items / $items_per_page);

                            // Display pagination links
                            ?>
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <?php
                                    for ($i = 1; $i <= $total_pages; $i++) {
                                        ?>
                                        <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </nav>
                            <?php
                        } else {
                            echo "<p>No records found.</p>";
                        }
                        ?>

                    </div>
                
                </div>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.nav-link').click(function() {
                $('.nav-link').removeClass('active');
                $(this).addClass('active');
            });
        });
    </script>
</body>

</html>


<?php

if(isset($_POST['enter'])){

    // die();
    $name = $_POST['name'];
    $family = $_POST['family'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    if(isset($_POST['isAdmin'])){
        $isAdmin = 1 ;
    }else{
        $isAdmin = 0 ;
    }

  


    $SQL1 = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result1 = $conn->query($SQL1);
    if ($result1->num_rows > 0) {
        echo "<div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 20px; right: 20px; width: 300px;'>
                <div class='toast-header bg-danger text-white'>
                    <strong class='mr-auto'>Error</strong>
                    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='toast-body'>
                    این یوزرنیم و پسورد قبلا به ثبت رسیده است!
                </div>
            </div>
            <script>
            $(document).ready(function(){
                $('#errorToast').toast({
                    autohide: true,
                    delay: 3000
                }).toast('show');
            });
            </script>";

    }else{
       $sql = "INSERT INTO users (name, family, username, password, admin, created_at) 
            VALUES ('$name', '$family', '$username', '$password', '$isAdmin', NOW())";
        $result = $conn->query($sql); 

        if ($result) {
            // Success Toast
            echo "<div id='successToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 20px; right: 20px; width: 300px;'>
                    <div class='toast-header bg-success text-white'>
                        <strong class='mr-auto'>Success</strong>
                        <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>
                    <div class='toast-body'>
                        یوزر با موفقیت اضافه شد!
                    </div>
                  </div>
                  <script>
                  $(document).ready(function(){
                      $('#successToast').toast({
                          autohide: true,
                          delay: 3000
                      }).toast('show');
                      setTimeout(function(){
                          window.location.href = 'new_user';
                      }, 3000);
                  });
                  </script>";
        } else {
            // Error Toast
            echo "<div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 20px; right: 20px; width: 300px;'>
                    <div class='toast-header bg-danger text-white'>
                        <strong class='mr-auto'>Error</strong>
                        <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>
                    <div class='toast-body'>
                        خطایی در افزودن یوزر پیش آمده!
                    </div>
                  </div>
                  <script>
                  $(document).ready(function(){
                      $('#errorToast').toast({
                          autohide: true,
                          delay: 3000
                      }).toast('show');
                      setTimeout(function(){
                          $('#errorToast').toast('hide');
                      }, 3000);
                  });
                  </script>";
        
            echo "<div class='alert alert-danger mt-2' role='alert'>
                    Error: " . $sql . "<br>" . $conn->error . "
                  </div>";
        }
        

    }

    
    
}