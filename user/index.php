<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پنل کاربری</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #FF4500;
            --secondary-color: #f8f9fc;
            --sidebar-width: 250px;
        }

        body {
            font-family: 'Vazir', 'Tanha', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fc;
        }

        /* استایل سایدبار کاملا سفید */
        .sidebar {
            position: fixed;
            right: 0;
            top: 0;
            height: 100%;
            width: var(--sidebar-width);
            background-color: #ffffff;
            /* پس زمینه سفید */
            color: #333;
            /* رنگ متن تیره برای خوانایی بهتر */
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar .sidebar-brand {
            height: 70px;
            text-decoration: none;
            font-size: 1.2rem;
            font-weight: 800;
            padding: 1.5rem 1rem;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.05rem;
            z-index: 1;
            color: #333 !important;
            /* رنگ تیره برای متن برند */
        }

        .sidebar .nav-item {
            position: relative;
            margin: 0 10px;
        }

        .sidebar .nav-item .nav-link {
            color: #555;
            /* رنگ متن لینک‌ها */
            font-weight: 500;
            padding: 10px;
            margin: 5px 0;
            border-radius: 10px;
        }

        /* حالت شناور (Hover) با رنگ قرمز کمرنگ */
        .sidebar .nav-item .nav-link:hover {
            color: #333;
            background: rgba(255, 69, 0, 0.05);
        }

        /* حالت فعال (Active) با رنگ قرمز بسیار کمرنگ */
        .sidebar .nav-item.active .nav-link {
            color: #333;
            background: rgba(255, 69, 0, 0.1);
            font-weight: 700;
        }

        .sidebar .nav-item .nav-link i {
            margin-left: 10px;
        }

        #content-wrapper {
            width: calc(100% - var(--sidebar-width));
            margin-right: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s;
        }

        .topbar {
            height: 70px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .card-stats .card-body {
            padding: 1rem;
        }

        .card-stats .icon-big {
            font-size: 3rem;
            opacity: 0.3;
        }

        .bg-gradient-primary {
            background: linear-gradient(87deg, #FF4500 0, #FFD700 100%) !important;
        }

        .bg-gradient-success {
            background: linear-gradient(87deg, #1cc88a 0, #13855c 100%) !important;
        }

        .bg-gradient-info {
            background: linear-gradient(87deg, #36b9cc 0, #258391 100%) !important;
        }

        .bg-gradient-warning {
            background: linear-gradient(87deg, #FFD700 0, #FF4500 100%) !important;
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .dropdown-menu {
            left: 0 !important;
            right: auto !important;
        }

        /* استایل‌های جدید برای حالت موبایل */
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                overflow: hidden;
            }

            body.sidebar-toggled .sidebar {
                width: var(--sidebar-width);
                overflow: visible;
            }

            body.sidebar-toggled #content-wrapper {
                margin-right: var(--sidebar-width);
            }

            #content-wrapper {
                width: 100%;
                margin-right: 0;
            }
        }
    </style>
</head>

<body>

    <?php include 'sidebar.php'; ?>

    <div id="content-wrapper">

        <?php include 'header.php'; ?>

        <div class="container-fluid">



        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <script>
        // برای باز و بسته کردن سایدبار در حالت موبایل
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.body.classList.toggle('sidebar-toggled');
        });

        // نمودارها (نمونه کد)
        var ctx = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["شنبه", "یکشنبه", "دوشنبه", "سه شنبه", "چهارشنبه", "پنجشنبه", "جمعه"],
                datasets: [{
                    label: "فروش",
                    lineTension: 0.3,
                    backgroundColor: "rgba(255, 69, 0, 0.05)",
                    borderColor: "rgba(255, 69, 0, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(255, 69, 0, 1)",
                    pointBorderColor: "rgba(255, 69, 0, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(255, 69, 0, 1)",
                    pointHoverBorderColor: "rgba(255, 69, 0, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: [3500000, 2800000, 4200000, 3100000, 4900000, 5100000, 4500000],
                }],
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            callback: function(value, index, values) {
                                return value.toLocaleString() + ' تومان';
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });

        // نمودار دایره ای
        var ctx2 = document.getElementById("myPieChart");
        var myPieChart = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ["مستقیم", "شبکه‌های اجتماعی", "موتورهای جستجو"],
                datasets: [{
                    data: [55, 30, 15],
                    backgroundColor: ['#FF4500', '#1cc88a', '#36b9cc'],
                    hoverBackgroundColor: ['#FFD700', '#13855c', '#258391'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                legend: {
                    display: false
                },
                cutoutPercentage: 80,
            },
        });
    </script>
</body>

</html>