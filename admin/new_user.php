<?php
session_start();

if (!isset($_SESSION["all_data"])) {
    header("Location: ../login.php");
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

    <style>
    /* استایل‌های اختصاصی برای ریسپانسیو شدن بهتر */
    .users-table th,
    .users-table td {
        white-space: nowrap;
        vertical-align: middle;
        font-size: 0.95rem;
    }

    .users-table .action-btns {
        display: inline-flex;
        gap: 4px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .users-table .action-btns .btn {
        font-size: 0.8rem;
        padding: 4px 8px;
    }

    @media (max-width: 767.98px) {
        .users-table th,
        .users-table td {
            font-size: 0.82rem;
            padding: 6px 4px;
        }

        .users-table .action-btns {
            flex-direction: column;
            align-items: stretch;
        }

        .users-table .action-btns .btn {
            font-size: 0.75rem;
            padding: 3px 6px;
            width: 100%;
        }

        .form-section {
            padding: 12px !important;
            margin-top: 15px !important;
        }

        .form-section .form-control {
            font-size: 0.9rem;
        }

        h4 {
            font-size: 1.05rem;
        }

        .pagination {
            flex-wrap: wrap;
            justify-content: center;
            gap: 4px;
        }

        .pagination .page-link {
            font-size: 0.85rem;
            padding: 5px 9px;
        }
    }
    </style>
</head>

<body>


    <?php include 'header.php'; ?>
    <div class="container-fluid">
        <div class="row g-0">
            <div class="col-12 col-md-3 d-flex">
                <?php
                include 'sidebar.php';
                ?>

            </div>

            <div class="col-12 col-md-9 px-3 px-md-4">
                <form action="new_user.php" method="POST" enctype="multipart/form-data"
                    class="p-3 border mt-4 rounded form-section bg-white">
                    <h5 class="mb-3 text-center text-md-start">افزودن کاربر جدید</h5>
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="name" class="form-label fw-semibold">
                                نام
                            </label>
                            <input type="text" name="name" class="form-control" required autocomplete="off">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="family" class="form-label fw-semibold">
                                نام خانوادگی
                            </label>
                            <input type="text" name="family" class="form-control" required autocomplete="off">
                        </div>
                    </div>

                    <div class="row g-3 mt-1">
                        <div class="col-12 col-md-6">
                            <label for="username" class="form-label fw-semibold">
                                یوزرنیم
                            </label>
                            <input type="username" name="username" class="form-control" required autocomplete="off">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="password" class="form-label fw-semibold">
                                پسوورد(عدد)
                            </label>
                            <input type="number" name="password" class="form-control" required autocomplete="off">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="isAdmin" name="isAdmin">
                                <label class="form-check-label" for="isAdmin">
                                    ادمین
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12 col-md-6">
                            <button name="enter" class="btn btn-outline-success w-100 w-md-auto">ثبت</button>
                        </div>
                    </div>
                </form>

                <div class="row mt-4">
                    <div class="col-12">
                        <?php
                        // Pagination configuration
                        $items_per_page = 10; // Number of items per page
                        $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1; // Current page, default is 1
                        if ($current_page < 1) $current_page = 1;

                        // Calculate the offset for the SQL query
                        $offset = ($current_page - 1) * $items_per_page;

                        // SQL query to retrieve a subset of rows based on pagination with LIMIT
                        $sql = "SELECT * FROM users ORDER BY id DESC LIMIT $offset, $items_per_page";
                        $result = $conn->query($sql);

                        // Display the table
                        if ($result && $result->num_rows > 0) {
                            $a = ($current_page - 1) * $items_per_page + 1; // Counter for row numbers
                            ?>
                        <h4 class="mb-2">نگاه کلی :</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered users-table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="text-center">ردیف</th>
                                        <th scope="col" class="text-center">نام</th>
                                        <th scope="col" class="text-center">نام خانوادگی</th>
                                        <th scope="col" class="text-center">کد ملی</th>
                                        <th scope="col" class="text-center">نقش</th>
                                        <th scope="col" class="text-center">گوینده</th>
                                        <th scope="col" class="text-center">عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                    <tr>
                                        <th scope="row" class="text-center"><?= $a ?></th>
                                        <td class="text-center"><?= htmlspecialchars($row['name']) ?></td>
                                        <td class="text-center"><?= htmlspecialchars($row['family']) ?></td>
                                        <td class="text-center"><?= htmlspecialchars($row['meli_code']) ?></td>
                                        <td class="text-center">
                                            <?= $row['level'] == 'admin' ? '<span class="badge bg-danger">ادمین</span>' : '<span class="badge bg-secondary">کاربر عادی</span>' ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if (isset($row['speaker']) && $row['speaker'] == 1): ?>
                                            <form method="POST" action="" style="display: inline;"
                                                onsubmit="return confirm('آیا مطمئن هستید که می‌خواهید دسترسی گویندگی این کاربر را بردارید؟');">
                                                <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                                                <input type="hidden" name="remove_speaker" value="1">
                                                <input type="hidden" name="page" value="<?= $current_page ?>">
                                                <button type="submit"
                                                    class="btn btn-sm btn-outline-danger w-100">🎙️ برداشتن</button>
                                            </form>
                                            <?php else: ?>
                                            <form method="POST" action="" style="display: inline;"
                                                onsubmit="return confirm('آیا مطمئن هستید که می‌خواهید این کاربر را به گوینده تبدیل کنید؟');">
                                                <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                                                <input type="hidden" name="make_speaker" value="1">
                                                <input type="hidden" name="page" value="<?= $current_page ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-primary w-100">تبدیل
                                                    به گوینده</button>
                                            </form>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <form method="POST" action="" style="display: inline;"
                                                onsubmit="return confirm('آیا مطمئن هستید که می‌خواهید این کاربر را حذف کنید؟');">
                                                <input type="hidden" name="delete_user_id" value="<?= $row['id'] ?>">
                                                <input type="hidden" name="page" value="<?= $current_page ?>">
                                                <button type="submit" name="delete_user"
                                                    class="btn btn-sm btn-outline-danger w-100">🗑️ حذف</button>
                                            </form>
                                        </td>
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
                            if ($total_pages > 1) {
                            ?>
                        <nav aria-label="Page navigation" class="mt-3">
                            <ul class="pagination justify-content-center mb-0">
                                <?php if ($current_page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $current_page - 1 ?>">قبلی</a>
                                </li>
                                <?php endif; ?>

                                <?php
                                // محدود کردن تعداد لینک‌های نمایش داده شده در موبایل
                                $start = max(1, $current_page - 2);
                                $end = min($total_pages, $current_page + 2);

                                if ($start > 1) {
                                    echo '<li class="page-item"><a class="page-link" href="?page=1">1</a></li>';
                                    if ($start > 2) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                }

                                for ($i = $start; $i <= $end; $i++) {
                                    ?>
                                <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                                <?php
                                }

                                if ($end < $total_pages) {
                                    if ($end < $total_pages - 1) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                    echo '<li class="page-item"><a class="page-link" href="?page=' . $total_pages . '">' . $total_pages . '</a></li>';
                                }
                                ?>

                                <?php if ($current_page < $total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $current_page + 1 ?>">بعدی</a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                        <?php
                            }
                        } else {
                            echo "<p class='text-center mt-3'>هیچ رکوردی یافت نشد.</p>";
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

    $name = $_POST['name'];
    $family = $_POST['family'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    if(isset($_POST['isAdmin'])){
        $isAdmin = 1 ;
    }else{
        $isAdmin = 0 ;
    }

    $SQL1 = "SELECT * FROM users WHERE username = '$username'";
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
                    این یوزرنیم قبلا به ثبت رسیده است!
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

// منطق تبدیل کاربر به گوینده (ست کردن 1)
if (isset($_POST['make_speaker'])) {
    $user_id_to_update = intval($_POST['user_id']);
    $return_page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    
    $update_sql = "UPDATE users SET speaker = 1 WHERE id = $user_id_to_update";
    
    if ($conn->query($update_sql) === TRUE) {
        echo "<script>
                alert('✅ کاربر با موفقیت به گوینده تبدیل شد');
                window.location.href = 'new_user.php?page=$return_page';
              </script>";
    } else {
        echo "<script>alert('❌ خطا در بروزرسانی: " . $conn->error . "');</script>";
    }
}

// منطق برداشتن از گویندگی (ست کردن 0)
if (isset($_POST['remove_speaker'])) {
    $user_id_to_update = intval($_POST['user_id']);
    $return_page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    
    $update_sql = "UPDATE users SET speaker = 0 WHERE id = $user_id_to_update";
    
    if ($conn->query($update_sql) === TRUE) {
        echo "<script>
                alert('🗑️ دسترسی گویندگی از کاربر برداشته شد');
                window.location.href = 'new_user.php?page=$return_page';
              </script>";
    } else {
        echo "<script>alert('❌ خطا در بروزرسانی: " . $conn->error . "');</script>";
    }
}

// منطق حذف کاربر
if (isset($_POST['delete_user'])) {
    $user_id_to_delete = intval($_POST['delete_user_id']);
    $return_page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    
    if ($user_id_to_delete == $id) {
        echo "<script>alert('❌ شما نمی‌توانید خودتان را حذف کنید!');</script>";
    } else {
        $delete_sql = "DELETE FROM users WHERE id = $user_id_to_delete";
        
        if ($conn->query($delete_sql) === TRUE) {
            echo "<script>
                    alert('✅ کاربر با موفقیت حذف شد');
                    window.location.href = 'new_user.php?page=$return_page';
                  </script>";
        } else {
            echo "<script>alert('❌ خطا در حذف کاربر: " . $conn->error . "');</script>";
        }
    }
}
?>