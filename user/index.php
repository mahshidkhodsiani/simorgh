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
    <div class="sidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
            <div class="sidebar-brand-text mx-3">پنل مدیریت</div>
        </a>

        <hr class="sidebar-divider my-0">

        <ul class="nav flex-column">
            <li class="nav-item active">
                <a class="nav-link" href="#">
                    <i class="bi bi-house-door"></i>
                    <span>داشبورد</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-people"></i>
                    <span>کاربران</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-cart"></i>
                    <span>سفارشات</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-grid"></i>
                    <span>محصولات</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-chat-left-text"></i>
                    <span>نظرات</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-gear"></i>
                    <span>تنظیمات</span>
                </a>
            </li>
        </ul>
    </div>

    <div id="content-wrapper">
        <nav class="navbar navbar-expand topbar mb-4 static-top shadow-sm bg-white">
            <div class="container-fluid">
                <button id="sidebarToggle" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="bi bi-list"></i>
                </button>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell"></i>
                            <span class="badge bg-danger badge-counter">3+</span>
                        </a>
                    </li>

                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-envelope"></i>
                            <span class="badge bg-danger badge-counter">7</span>
                        </a>
                    </li>

                    <div class="d-none d-sm-block topbar-divider"></div>

                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="d-none d-lg-inline text-gray-600 small">علی محمدی</span>
                            <img class="img-profile rounded-circle me-2" src="https://via.placeholder.com/40">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2 text-gray-400"></i> پروفایل</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2 text-gray-400"></i> تنظیمات</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-list-check me-2 text-gray-400"></i> فعالیت ها</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-left me-2 text-gray-400"></i> خروج</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow h-100 py-2 bg-gradient-primary">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col me-2">
                                    <div class="text-xs font-weight-bold text-white text-uppercase mb-1">درآمد امروز</div>
                                    <div class="h5 mb-0 font-weight-bold text-white">۲,۵۰۰,۰۰۰ تومان</div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-currency-dollar text-white icon-big"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow h-100 py-2 bg-gradient-success">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col me-2">
                                    <div class="text-xs font-weight-bold text-white text-uppercase mb-1">کاربران جدید</div>
                                    <div class="h5 mb-0 font-weight-bold text-white">۱۸ نفر</div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-people text-white icon-big"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow h-100 py-2 bg-gradient-info">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col me-2">
                                    <div class="text-xs font-weight-bold text-white text-uppercase mb-1">سفارشات جدید</div>
                                    <div class="h5 mb-0 font-weight-bold text-white">۴۷ مورد</div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-cart text-white icon-big"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow h-100 py-2 bg-gradient-warning">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col me-2">
                                    <div class="text-xs font-weight-bold text-white text-uppercase mb-1">پیام های خوانده نشده</div>
                                    <div class="h5 mb-0 font-weight-bold text-white">۵ پیام</div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-chat-left-text text-white icon-big"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-8 col-lg-7">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold" style="color: var(--primary-color);">بررسی عملکرد هفتگی</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-area" style="height: 320px;">
                                <canvas id="myAreaChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-5">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold" style="color: var(--primary-color);">منابع ترافیک</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-pie pt-4 pb-2">
                                <canvas id="myPieChart" style="height: 280px;"></canvas>
                            </div>
                            <div class="mt-4 text-center small">
                                <span class="me-2"><i class="bi bi-circle-fill" style="color: var(--primary-color);"></i> مستقیم</span>
                                <span class="me-2"><i class="bi bi-circle-fill text-success"></i> شبکه‌های اجتماعی</span>
                                <span class="me-2"><i class="bi bi-circle-fill text-info"></i> موتورهای جستجو</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold" style="color: var(--primary-color);">آخرین کاربران ثبت‌نام شده</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>نام کاربر</th>
                                    <th>ایمیل</th>
                                    <th>تلفن</th>
                                    <th>تاریخ عضویت</th>
                                    <th>وضعیت</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>محمد رضایی</td>
                                    <td>mohammad@example.com</td>
                                    <td>09123456789</td>
                                    <td>1402/05/15</td>
                                    <td><span class="badge bg-success">فعال</span></td>
                                </tr>
                                <tr>
                                    <td>فاطمه احمدی</td>
                                    <td>fatemeh@example.com</td>
                                    <td>09129876543</td>
                                    <td>1402/05/14</td>
                                    <td><span class="badge bg-success">فعال</span></td>
                                </tr>
                                <tr>
                                    <td>علی حسینی</td>
                                    <td>ali@example.com</td>
                                    <td>09351234567</td>
                                    <td>1402/05/13</td>
                                    <td><span class="badge bg-warning">معلق</span></td>
                                </tr>
                                <tr>
                                    <td>زهرا محمدی</td>
                                    <td>zahra@example.com</td>
                                    <td>09131112233</td>
                                    <td>1402/05/12</td>
                                    <td><span class="badge bg-success">فعال</span></td>
                                </tr>
                                <tr>
                                    <td>رضا کریمی</td>
                                    <td>reza@example.com</td>
                                    <td>09124445566</td>
                                    <td>1402/05/11</td>
                                    <td><span class="badge bg-danger">غیرفعال</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
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