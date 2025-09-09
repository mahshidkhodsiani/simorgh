<?php
session_start();

// اگر کاربر وارد نشده است، به صفحه لاگین هدایت شود
if (!isset($_SESSION['all_data'])) {
    header("location: ../login.php");
    exit;
}

$user_id = $_SESSION['all_data']['id'];
$username = $_SESSION['all_data']['username'];
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پنل کاربری</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link rel="stylesheet" href="styles.css">

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