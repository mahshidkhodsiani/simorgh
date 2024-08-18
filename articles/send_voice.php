<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ارسال صدای خودتان</title>

   
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
                            <div class="row mb-5">
                                <div class="col-md-6">
                                   <h5>لطفا از روی متن بخوانید و صدای خود را ضبط کنید و برای ما ارسال کنید</h5>
                                </div>
                                <div class="col-md-6">
                                   <p>متن:</p>
                                   <p style="color: #b53e53;">اینجا متن خواندن</p>
                                </div>
                            </div>

                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label class="control-label">نام</label>
                                            <input type="text" name="name" class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="control-label">نام خانوادگی </label>
                                            <input type="text" name="name" class="form-control" required>
                                        </div>
                                    </div>
                              
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label class="control-label">شماره موبایل </label>
                                            <input type="number" name="name" class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="file" name="audioFile" class="form-control" accept="audio/mp3" required>
                                            <button class="btn btn-outline-info btn-block animated-button">آپلود</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            
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



<?php

include 'config.php';


// Check if a file was uploaded
if (isset($_FILES['audioFile']) && $_FILES['audioFile']['error'] == 0) {
    $fileName = $_FILES['audioFile']['name'];
    $fileType = $_FILES['audioFile']['type'];
    $fileSize = $_FILES['audioFile']['size'];
    $fileData = file_get_contents($_FILES['audioFile']['tmp_name']);

    // Additional form fields (you need to add these fields in your form)
    $name = $_POST['name'];
    $family = $_POST['family'];
    $number = $_POST['number'];

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("INSERT INTO sounds (name, family, number, file_name, file_type, file_size, file_data) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssis", $name, $family, $number, $fileName, $fileType, $fileSize, $fileData);

    if ($stmt->execute()) {
        echo "File uploaded successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "No file uploaded or upload error.";
}