<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رادیو سیمرغ</title>


    <link rel="stylesheet" href="../fonts/icomoon/style.css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/mainstyles.css">

    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">

</head>
<body>

    <?php
    include 'header.php';
    include '../config.php';
    include '../PersianCalendar.php';
    include '../jalaliDate.php';
    $sdate = new SDate();
    ?>

   
       <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10">
                    <div class="card border border-danger" style="border-radius: 40px;">
                        <img class="mx-auto d-block img-fluid" src="../images/radio-simorgh.jpg" alt="موسسه هفت هنر سیمرغ" style="width: 100%; height: auto;">

                        <div class="card-body" dir="rtl" style="text-align: right;"> <!-- Ensured text-align right for RTL text -->
                            <h3 class="">برنامه‌های رادیویی "هفت هنر سیمرغ"</h3><p> با هدف ایجاد یک ارتباط عمیق و حسی با مخاطبان تهیه شده‌اند.
                                 این برنامه‌ها، با صدای گرم و روایات جذاب، شما را به یک دنیای جدید از هنر و فرهنگ دعوت می‌کنند؛ دنیایی که هر روز با شما همراه خواهد بود.<br></p>
                        </div>

                        <?php
                   

                        // Pagination logic
                        $limit = 5; // Number of entries per page
                        if (isset($_GET['page'])) {
                            $page = (int)$_GET['page'];
                        } else {
                            $page = 1;
                        }

                        $start_from = ($page - 1) * $limit;

                        // Fetching data from the database
                        $sql = "SELECT * FROM radio ORDER BY id ASC LIMIT $start_from, $limit";
                        $result = $conn->query($sql);

                        // Count the total number of rows
                        $sql_total = "SELECT COUNT(id) FROM radio";
                        $result_total = $conn->query($sql_total);
                        $row_total = $result_total->fetch_row();
                        $total_records = $row_total[0];
                        $total_pages = ceil($total_records / $limit);
                        ?>

                        <div class="table-responsive mt-5">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">ردیف</th>
                                        <th class="text-center">نام برنامه</th>
                                        <th class="text-center">نوع برنامه</th>
                                        <th class="text-center">mp3</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        $row_number = $start_from + 1; // Start row numbering
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td class='text-center'>" . $row_number++ . "</td>";
                                            echo "<td class='text-center'>" . htmlspecialchars($row['title']) . "</td>";
                                            echo "<td class='text-center'>" . htmlspecialchars($row['program_type']) . "</td>";
                                            echo "<td class='text-center'>";
                                            if (!empty($row['file_path'])) {
                                                echo "<audio controls>";
                                                echo "<source src='" . htmlspecialchars($row['file_path']) . "' type='audio/mpeg'>";
                                                echo "Your browser does not support the audio element.";
                                                echo "</audio>";
                                            } else {
                                                echo "No audio file";
                                            }
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='4' class='text-center'>No records found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <!-- Previous Page Link -->
                                <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                                    <a class="page-link" href="<?php if ($page > 1) echo '?page=' . ($page - 1); ?>">قبلی</a>
                                </li>
                                
                                <!-- Numbered Page Links -->
                                <?php
                                for ($i = 1; $i <= $total_pages; $i++) {
                                    echo "<li class='page-item" . ($i == $page ? " active" : "") . "'>";
                                    echo "<a class='page-link' href='?page=" . $i . "'>" . $i . "</a>";
                                    echo "</li>";
                                }
                                ?>
                                
                                <!-- Next Page Link -->
                                <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                                    <a class="page-link" href="<?php if ($page < $total_pages) echo '?page=' . ($page + 1); ?>">بعدی</a>
                                </li>
                            </ul>
                        </nav>

                        <?php
                        // Close the connection
                        $conn->close();
                        ?>


                        
                    </div>
                </div>
            </div>
        </div>



    <?php include 'footer.php'; ?>

  

</body>
</html>

