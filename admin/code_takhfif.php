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


    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">

    <?php
    include 'includes.php';
    include '../config.php';
    // include 'functions.php';
    // include 'PersianCalendar.php';
    ?>
    <!-- <link rel="stylesheet" href="styles.css"> -->





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

            <div class="col-md-8 mt-5">

            
              
            <form id="articleForm" enctype="multipart/form-data" method="POST" class="border p-2">
            <h4>دقت کنید: هربار فقط و فقط یک کد تخفیف بگذارید. با تشکر **</h4>

                <div class="row">
                    <div class="col-6">
                        <label for="title">کد تخفیف:</label>
                        <input type="text" id="code_takhfif" name="code_takhfif" class="form-control mb-2" placeholder="کد را اینجا وارد کنید" required>

                        <label>مقدار تخفیف :</label>
                        <input type="number" placeholder="مقدار تخفیف به ریال لطفا" name="takhfif_amount" class="form-control">
                    </div>
          
                </div>

                <br>

                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-6">
                        <button class="btn btn-outline-success" type="submit" name="submit_codes">ثبت </button>
                    </div>
                </div>
            </form>

            <br>


            <div class="row mt-5">
                <div class="col-md-11">
                    <div class="table-responsive">
                        <?php
                        // Pagination configuration
                        $items_per_page = 10; // Number of items per page
                        $current_page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page, default is 1

                        // Calculate the offset for the SQL query
                        $offset = ($current_page - 1) * $items_per_page;

                        // SQL query to retrieve a subset of rows based on pagination
                        $sql = "SELECT * FROM codes ORDER BY id DESC LIMIT $items_per_page OFFSET $offset";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $a = ($current_page - 1) * $items_per_page + 1; // Counter for row numbers
                        ?>
                            <table class="table border border-4">
                                <h4>آخرین مقالات :</h4>
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">ردیف</th>
                                        <th scope="col" class="text-center">عنوان</th>
                                        <th scope="col" class="text-center">مبلغ(ریال)</th>
                                        <th scope="col" class="text-center">عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = $result->fetch_assoc()) {

                                        ?>
                                        <tr>
                                            <th scope="row" class="text-center"><?= $a ?></th>
                                            <td class="text-center"><?= htmlspecialchars($row['code']) ?></td>
                                            <td class="text-center"><?= htmlspecialchars(number_format($row['takhfif_amount'])) ?></td>
                                        
                                            <td class="text-center">
                                                <form action="" method="GET">
                                                    <input type="hidden" value="<?= $row['id'] ?>" name="id_codes">
                                                    <button type="submit" name="delete_codes" 
                                                        class="btn btn-outline-danger btn-sm" onclick="return confirmDelete()">حذف</button>
                                                </form>
                                            </td>
                                            <script>
                                                function confirmDelete() {
                                                    return confirm("آیا مطمئن هستید که می‌خواهید این مورد را حذف کنید؟");
                                                }
                                            </script>
                                        </tr>
                                    <?php
                                        $a++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <?php
                            // Pagination logic
                            $sql = "SELECT COUNT(*) AS total FROM codes";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            $total_items = $row['total'];
                            $total_pages = ceil($total_items / $items_per_page);

                            $start_page = max(1, $current_page - 1); // Start at the current page - 1 or 1 if the current page is 1
                            $end_page = min($total_pages, $start_page + 2); // Show 3 pages max

                            // Ensure there are always 3 pages in the pagination unless it's at the beginning or end
                            if ($end_page - $start_page < 2 && $start_page > 1) {
                                $start_page = max(1, $end_page - 2);
                            }
                            ?>

                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <!-- Previous Button -->
                                    <li class="page-item <?= $current_page == 1 ? 'disabled' : '' ?>">
                                        <a class="page-link" href="?page=<?= max(1, $current_page - 1) ?>">قبلی</a>
                                    </li>

                                    <?php
                                    // Page Numbers
                                    for ($i = $start_page; $i <= $end_page; $i++) {
                                    ?>
                                        <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                        </li>
                                    <?php
                                    }
                                    ?>

                                    <!-- Next Button -->
                                    <li class="page-item <?= $current_page == $total_pages ? 'disabled' : '' ?>">
                                        <a class="page-link" href="?page=<?= min($total_pages, $current_page + 1) ?>">بعدی</a>
                                    </li>
                                </ul>
                            </nav>

                        <?php
                        } else {
                            echo "<p>هیچ مشابهی پیدا نشد.</p>";
                        }
                        ?>
                    </div>
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

    <script>
        function toggleCheckbox(checkedId, uncheckedId) {
            var checkedBox = document.getElementById(checkedId);
            var uncheckedBox = document.getElementById(uncheckedId);
            if (checkedBox.checked) {
                uncheckedBox.checked = false;
            }
        }
    </script>




</body>

</html>

<?php


if (isset($_POST['submit_codes'])) {

    $code_takhfif = $_POST['code_takhfif'];
    $takhfif_amount = $_POST['takhfif_amount'];


    $sql = "INSERT INTO codes (code, takhfif_amount) VALUES('$code_takhfif', $takhfif_amount)";

    $result = $conn->query($sql);

    if ($result){

        echo "<div id='successToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 20px; right: 20px; width: 300px;'>
                <div class='toast-header bg-success text-white'>
                    <strong class='mr-auto'>Success</strong>
                    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='toast-body'>
                    فایل شما با موفقیت ثبت شد!
                </div>
            </div>
            <script>
            $(document).ready(function(){
                $('#successToast').toast({
                    autohide: true,
                    delay: 3000
                }).toast('show');
                setTimeout(function(){
                    window.location.href = 'code_takhfif';
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
                    خطایی در افزودن فایل پیش آمده!
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
                Error: " . $stmt->error . "
            </div>";
    }


}



if(isset($_GET['delete_codes'])){

    $id_codes = $_GET['id_codes'];

    $sql = "DELETE FROM codes WHERE id = $id_codes";
    $result = $conn->query($sql);
    if ($result) {
        // Use Bootstrap's toast component to show a success toast message
        echo "<div id='successToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 0; right: 0; width: 300px;'>
            <div class='toast-header bg-success text-white'>
                <strong class='mr-auto'>Success</strong>
                <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='toast-body'>
                فایل با موفقیت حذف شد!
            </div>
            </div>
            <script>
            $(document).ready(function(){
                $('#successToast').toast('show');
                setTimeout(function(){
                    $('#successToast').toast('hide');
                    // Redirect after 3 seconds
                    setTimeout(function(){
                        window.location.href = 'code_takhfif';
                    }, 1000);
                }, 1000);
            });
            </script>";
    } else {
        // Use Bootstrap's toast component to show an error toast message
        echo "<div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 0; right: 0; width: 300px;'>
                <div class='toast-header bg-danger text-white'>
                    <strong class='mr-auto'>Error</strong>
                    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='toast-body'>
                    خطایی در حذف فایل پیش آمده!
                </div>
              </div>
              <script>
                $(document).ready(function(){
                    $('#errorToast').toast('show');
                    setTimeout(function(){
                        $('#errorToast').toast('hide');
                    }, 1000);
                });
              </script>";

        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
}