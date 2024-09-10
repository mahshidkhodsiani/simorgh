<?php
header("Cache-Control: public, max-age=31536000"); // Cache for 1 year
header("Pragma: cache");

?>
<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>آرشیو گویندگان</title>


    <link rel="stylesheet" href="../fonts/icomoon/style.css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/mainstyles.css">

    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">



    <style>
        /* Define the animation */
        @keyframes lightToDark {
        0% {
            background-color: #f8f9fa; /* Light background */
            color: #343a40; /* Dark text color */
        }
        50% {
            background-color: #343a40; /* Dark background */
            color: #f8f9fa; /* Light text color */
        }
        100% {
            background-color: #f8f9fa; /* Light background */
            color: #343a40; /* Dark text color */
        }
        }

        /* Style for the button */
        .animated-button {
        animation: lightToDark 2s infinite; /* Apply the animation */
        border: 2px solid #343a40; /* Dark border to match dark background */
        border-radius: 5px; /* Rounded corners */
        padding: 10px 20px; /* Add padding */
        text-transform: uppercase; /* Uppercase text */
        font-weight: bold; /* Bold text */
        font-size: 16px; /* Font size */
        }

        /* Optional: Style for the button on hover */
        .animated-button:hover {
        cursor: pointer; /* Change cursor on hover */
        background-color: #e9ecef; /* Slightly lighter background */
        color: #343a40; /* Dark text color */
        }

    </style>

</head>
<body>

    <?php
    include 'header.php';
    include '../config.php';
    include '../PersianCalendar.php';
    include '../jalaliDate.php';
    $sdate = new SDate();

    $sql = "SELECT * FROM articles WHERE title LIKE '%درباره موسسه%'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $counter = 0;
        while ($row = $result->fetch_assoc()) {
    ?>
       <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10">
                    <div class="card border border-danger" style="border-radius: 40px;">
                        <!-- <img class="mx-auto d-block img-fluid" src="../images/audio.jpg" alt="ثبت گویندگی" style="width: 100%; height: auto;"> -->
                        <div class="card-body" dir="rtl" style="text-align: right;">
                          
                         
                           
                            <br>

                            <h3 class="">آرشیو گویندگان موسسه سیمرغ</h3><p>منبعی ارزشمند از صداهای بی نظیر و مهارت های حرفه ای متنوع جهت گویندگی متن های شماست.</p><p>پس از گوش دادن صدا و انتخاب گوینده متن خود را به همراه اسم گوینده در تلگرام یا واتساپ برای ما ارسال کنید تا با کیفیت عالی در استودیوی سیمرغ برای شما ضبط و ارسال کنیم.&nbsp;</p>

                         

                            <div class="table-responsive mt-5">
                                <?php
                                // Pagination configuration
                                $items_per_page = 10; // Number of items per page
                                $current_page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page, default is 1

                                // Calculate the offset for the SQL query
                                $offset = ($current_page - 1) * $items_per_page;

                                // SQL query to retrieve a subset of rows based on pagination
                                $sql = "SELECT * FROM speakers ORDER BY id DESC LIMIT $items_per_page OFFSET $offset";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    $a = ($current_page - 1) * $items_per_page + 1; // Counter for row numbers
                                ?>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ردیف</th>
                                            <th class="text-center">اسم گوینده</th>
                                            <th class="text-center">نوع صدا</th>
                                            <th class="text-center">صدا</th>
                                            <th class="text-center">تصویر گوینده</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = $result->fetch_assoc()) {
                                           
                                        ?>
                                        <tr>
                                            <th scope="row" class="text-center"><?= $a ?></th>
                                            <td class="text-center"><?= $row['name'] ?></td>
                                            <td class="text-center"><?= $row['kind'] ?></td>
                                            <td class="text-center">
                                                <audio controls>
                                                    <source src="data:audio/mpeg;base64,<?= base64_encode($row['mp3']) ?>" type="audio/mpeg">
                                                </audio>
                                            </td>
                                            <td class="text-center">
                                                <img src="<?= $row['image']?>" height="50px" width="50px">
                                            </td>
                                        
                                            
                                        </tr>
                                        <?php
                                            $a++;
                                        }
                                        ?>
                                    </tbody>
                                   
                                </table>
                                <?php
                                // Pagination links
                                $sql = "SELECT COUNT(*) AS total FROM articles";
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
                                    echo "<p>هیچ گوینده ای پیدا نشد.</p>";
                                }
                                ?>
                            </div>
                            
                        </div>
                    </div>

                </div>
            </div>
        </div>

    <?php
        }
    }
    ?>

    <?php include 'footer.php'; ?>

  


</body>
</html>
