<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>هفت هنر سیمرغ</title>

    <!-- Uncomment the Google Fonts link if needed -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet"> -->

    <link rel="stylesheet" href="../fonts/icomoon/style.css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/mainstyles.css">


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
                            <h3 class="">آرشیو گویندگان موسسه سیمرغ: منبعی برای یادگیری و الهام</h3>
                         
                           
                            <br>
                            <a href="send_voice" class="btn btn-outline-quarternary btn-block animated-button">ارسال صدای خودتان</a>

                         

                            <div class="table-responsive mt-5">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ردیف</th>
                                            <th class="text-center">اسم گوینده</th>
                                            <th class="text-center">صدا</th>
                                            <th class="text-center">تصویر گوینده</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Rows -->
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td class="text-center">آیدا نصیری</td>
                                            <td class="text-center"> 
                                                <audio controls>
                                                    <source src="../upload/sounds/2024/aida-nasiri/aida-nasiri.mp3" type="audio/mpeg">
                                                 
                                                </audio>
                                            </td>
                                            <td class="text-center">
                                                <img src="../upload/sounds/2024/aida-nasiri/pro.jpg" alt="تمرین گویندگی" height="80px">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">2</td>
                                            <td class="text-center">زری راد</td>
                                            <td class="text-center"> 
                                                <audio controls>
                                                    <source src="../upload/sounds/2024/zari-rad/zari-rad.mp3" type="audio/mpeg">
                                                 
                                                </audio>
                                            </td>
                                            <td class="text-center">
                                                <img src="../upload/sounds/2024/zari-rad/pro.jpg" alt="تمرین گویندگی" height="80px">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Pagination -->
                            <nav aria-label="Table pagination">
                                <ul class="pagination">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1">قبلی</a>
                                    </li>
                                    <li class="page-item active" aria-current="page">
                                        <span class="page-link">1</span>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">2</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">3</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">بعدی</a>
                                    </li>
                                </ul>
                            </nav>
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
