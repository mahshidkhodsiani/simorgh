<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ارتباط با ما</title>

    <?php include "includes.php"; ?>

    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">

    <style>
        /* Custom styles for this page */
        .contact-card {
            border-radius: 40px;
        }

        .contact-card .card-body {
            padding: 30px; /* Add some padding inside the card */
        }

        .contact-card h1,
        .contact-card h2,
        .contact-card h3,
        .contact-card h4 {
            font-family: "B Titr", sans-serif; /* Apply your specific font */
            text-align: center; /* Center headings */
            margin-bottom: 20px; /* Space below headings */
            color: #333; /* Darker color for headings */
        }

        .contact-card p,
        .contact-card ul {
            text-align: right; /* Right-align general text */
            line-height: 1.8; /* Improve line spacing for readability */
            font-size: 17px; /* Slightly adjust font size */
            margin-bottom: 15px;
        }

        .contact-card ul {
            list-style: none; /* Remove default list bullets */
            padding: 0; /* Remove default list padding */
        }

        .contact-card ul li {
            margin-bottom: 8px;
            font-family: "B Titr", sans-serif; /* Apply your specific font */
        }

        .contact-card a {
            color: #007bff; /* Standard link color */
            text-decoration: none;
            transition: color 0.3s ease-in-out;
            font-weight: bold;
        }

        .contact-card a:hover {
            color: #0056b3; /* Darker blue on hover */
            text-decoration: underline;
        }

        .contact-action-btn-container {
            text-align: center; /* Center the button */
            margin-top: 30px; /* Space above the button */
        }

        .btn-outline-quarternary {
            color: #621e52;
            background-color: transparent;
            border-color: #621e52;
            padding: 10px 25px; /* Adjust button padding */
            font-size: 18px; /* Larger font for button */
            font-weight: bold;
            border-radius: 8px; /* Slightly rounded corners */
        }

        .btn-outline-quarternary:hover {
            color: #fff;
            background-color: #621e52;
            border-color: #621e52;
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
    ?>


    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10">
                <div class="card border border-danger contact-card">
                    <div class="card-body" dir="rtl" style="text-align: right;">

                        <h4 class="text-center">جهت ارتباط با موسسه فرهنگی هنری سیمرغ می توانید از یکی از راهای زیر اقدام کنید:</h4>

                        <p>شما می‌توانید از طریق روش‌های زیر با ما در ارتباط باشید:</p>
                        <ul>
                            <li><strong>واتساپ یا تلگرام:</strong> ۰۹۳۵۴۶۳۷۰۵۵</li>
                            <li><strong>اینستاگرام:</strong> <a href="https://www.instagram.com/haft_simorgh/" target="_blank" rel="noopener noreferrer">haft_simorgh@</a></li>
                            <li><strong>ایمیل:</strong> <a href="mailto:info@simorghtv.com">info@simorghtv.com</a></li>
                            <li><strong>تلفن:</strong> ۰۲۱-۹۱۳۰۰۵۱۷</li>
                            <li><strong>سامانه پیامکی:</strong> ۳۰۰۰۱۶۳۴۳۰۰۰</li>
                        </ul>

                        <div class="contact-action-btn-container">
                            <p>جهت ثبت انتقاد یا پیشنهاد:</p>
                            <a href="suggestion" class="btn btn-outline-quarternary">رفتن به صفحه انتقاد و پیشنهاد</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php include 'footer.php'; ?>

</body>

</html>