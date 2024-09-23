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
    include '../functions.php';
    // include '../PersianCalendar.php';


    

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

              
            <div class="row mt-4">
                <div class="col-md-12">
                    <?php
                    
                    // Pagination configuration
                    $items_per_page = 10; // Number of items per page
                    $current_page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page, default is 1

                    // Calculate the offset for the SQL query
                    $offset = ($current_page - 1) * $items_per_page;

                    // SQL query to retrieve a subset of rows based on pagination
                    $sql = "SELECT * FROM contacts ORDER BY id DESC LIMIT $offset, $items_per_page";
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
                                        <th scope="col" class="text-center">فیلد ثبت نامی</th>
                                        <th scope="col" class="text-center">شماره</th>
                                        <th scope="col" class="text-center">کد ملی</th>
                                        <th scope="col" class="text-center">سن</th>
                                        <th scope="col" class="text-center">تاریخ</th>
                                        <th scope="col" class="text-center">آدرس</th>
                                        <th scope="col" class="text-center">مبلغ پرداختی</th>
                                        <th scope="col" class="text-center">پرداخت</th>
                                        <th scope="col" class="text-center">عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <th scope="row" class="text-center"><?= $a ?></th>
                                            <td class="text-center"><?= $row['name'] ?></td>
                                            <td class="text-center"><?= $row['lastname'] ?></td>
                                            <td class="text-center"><?= $row['course'] ?></td>
                                            <td class="text-center"><?= $row['mobile'] ?></td>
                                            <td class="text-center"><?= $row['meli_code'] ?></td>
                                            <td class="text-center"><?= $row['age'] ?></td>
                                            <td class="text-center">
                                                <?= mds_date("j F Y , i : H", strtotime($row['created_at'])) ?>
                                            </td>
                                            <td class="text-center"><?= $row['address'] ?></td>
                                            <td class="text-center"><?= $row['amount'] ?></td>
                                            <td class="text-center">
                                                <?php
                                                if($row['pardakht'] == 1){
                                                    echo "شده" ;
                                                }else{
                                                    echo "نشده" ;
                                                }
                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <form action="" method="GET">
                                                    <input type="hidden" value="<?= $row['id'] ?>" name="id_reg">
                                                    <button type="submit" name="delete_register" class="btn btn-outline-danger btn-sm" 
                                                    onclick="return confirmDelete()">حذف</button>
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
                        </div>
                        <?php

                        // Pagination links
                        $sql = "SELECT COUNT(*) AS total FROM contacts";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        $total_items = $row['total'];
                        $total_pages = ceil($total_items / $items_per_page);

                        // Display pagination links
                        ?>
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <?php
                                // Previous Button
                                if ($current_page > 1) {
                                    ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?= $current_page - 1 ?>" aria-label="قبلی">
                                            <span aria-hidden="true">&laquo; قبلی</span>
                                        </a>
                                    </li>
                                    <?php
                                }

                                // Numbered links (show 3 at a time)
                                $start = max(1, $current_page - 1); // Start page
                                $end = min($total_pages, $current_page + 1); // End page

                                for ($i = $start; $i <= $end; $i++) {
                                    ?>
                                    <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                    </li>
                                    <?php
                                }

                                // Next Button
                                if ($current_page < $total_pages) {
                                    ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?= $current_page + 1 ?>" aria-label="بعدی">
                                            <span aria-hidden="true">بعدی &raquo;</span>
                                        </a>
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

                    <!-- Hidden Textarea for Full Text -->
                    <div class="col-md-10 mt-3 mb-3" id="full-text-container" style="display: none;">
                        <textarea class="form-control" id="full-text" rows="5"></textarea>
                    </div>

                </div>
            </div>

            <script>
                function showFullText(fullText) {
                    // Show the hidden textarea and populate it with the full text
                    document.getElementById('full-text-container').style.display = 'block';
                    document.getElementById('full-text').value = fullText;
                }
            </script>


                
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

    <script>
        $('.summernote').summernote({

            hint: {

                mentions: ['jayden','sam','alvin','david'],

                match: /\B@(\w*)$/,

                search:function (keyword, callback) {

                    callback($.grep(this.mentions,function (item) {

                        return item.indexOf(keyword) == 0;

                    }));

                },

                content:function (item) {

                    return '@' + item;

                }   

            }

        });
    </script>

  


</body>

</html>

<?php

if(isset($_GET['delete_register'])){

    $id_reg = $_GET['id_reg'];

    $sql = "DELETE FROM contacts WHERE id = $id_reg";
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
                این مورد با موفقیت حذف شد!
            </div>
            </div>
            <script>
            $(document).ready(function(){
                $('#successToast').toast('show');
                setTimeout(function(){
                    $('#successToast').toast('hide');
                    // Redirect after 3 seconds
                    setTimeout(function(){
                        window.location.href = 'registered';
                    }, 2000);
                }, 2000);
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
                    خطایی در حذف این مورد پیش آمده!
                </div>
              </div>
              <script>
                $(document).ready(function(){
                    $('#errorToast').toast('show');
                    setTimeout(function(){
                        $('#errorToast').toast('hide');
                    }, 2000);
                });
              </script>";

        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
}