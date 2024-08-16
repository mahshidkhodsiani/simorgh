<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>هفت هنر سیمرغ</title>


    <link rel="stylesheet" href="../fonts/icomoon/style.css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/mainstyles.css">
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
                                <!-- Rows -->
                                <tr>
                                    <td class="text-center">1</td>
                                    <td class="text-center"></td>
                                    <td class="text-center">برنامه رادیویی</td>
                                    <td class="text-center"> 
                                        <audio controls>
                                            <source src="../upload/radios/2024/19-mordad.mp3" type="audio/mpeg">
                                        </audio>
                                    </td>
                                  
                                </tr>
                                <tr>
                                    <td class="text-center">2</td>
                                    <td class="text-center"></td>
                                    <td class="text-center">برنامه رادیویی</td>
                                    <td class="text-center"> 
                                        <audio controls>
                                            <source src="../upload/radios/2024/dovom-khordad.mp3" type="audio/mpeg">
                                        </audio>
                                    </td>
                                 
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>



    <?php include 'footer.php'; ?>

  

</body>
</html>

