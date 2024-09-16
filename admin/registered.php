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

    <script src="../summernote-0.8.20-dist/cdn/jquery.min.js"></script>

    <link rel="stylesheet" href="../summernote-0.8.20-dist/summernote-bs5.css" />

    <script src="../summernote-0.8.20-dist/summernote-bs5.js"></script>

    <link rel="stylesheet" href="../summernote-0.8.20-dist/summernote-bs4.css" />

    <script src="../summernote-0.8.20-dist/summernote-bs4.js"></script>

    <link rel="stylesheet" href="../summernote-0.8.20-dist/summernote.css" />

    <script src="../summernote-0.8.20-dist/summernote.js"></script>

    <link rel="stylesheet" href="../summernote-0.8.20-dist/summernote-lite.css" />

    <script src="../summernote-0.8.20-dist/summernote-lite.js"></script>

    <script src="../summernote-0.8.20-dist/lang/summernote-es-ES.js"></script>


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
                                        <th scope="col" class="text-center">آدرس</th>
                                        <th scope="col" class="text-center">مبلغ پرداختی</th>
                                        <th scope="col" class="text-center">پرداخت</th>
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