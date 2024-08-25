<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>گالری تصاویر سیمرغ</title>

    <!-- Uncomment the Google Fonts link if needed -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet"> -->

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
                <?php
                $sql = "SELECT * FROM gallery ORDER BY id DESC LIMIT 20";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $counter = 0;
                    echo '<div class="container">'; // Ensure that there's a container for better layout

                    while ($galleryRow = $result->fetch_assoc()) {
                        // Start a new row every 2 images
                        if ($counter % 2 == 0) {
                            if ($counter > 0) {
                                echo '</div>'; // Close the previous row div
                            }
                            echo '<div class="row mt-4">'; // Start a new row
                        }

                        // Display the image
                        echo '<div class="col-md-6">';
                        echo '<img src="../' . $galleryRow['images'] . '" height="400px" width="100%" onclick="openModal(this.src)">';
                        echo '</div>';

                        $counter++;
                    }

                    // Close the last row div
                    if ($counter % 2 != 0) {
                        echo '</div>';
                    }

                    echo '</div>'; // Close the container div
                }
                ?>


                    ?>
                </div>
            </div>
        </div>

    <?php
        }
    }
    ?>

    <?php include 'footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const showFeedbackButton = document.getElementById('show-feedback');
            const showSuggestionButton = document.getElementById('show-suggestion');
            const feedbackForm = document.getElementById('enteghad');
            const suggestionForm = document.getElementById('suggest');

            showFeedbackButton.addEventListener('click', function() {
                feedbackForm.style.display = 'block';
                suggestionForm.style.display = 'none';
            });

            showSuggestionButton.addEventListener('click', function() {
                suggestionForm.style.display = 'block';
                feedbackForm.style.display = 'none';
            });
        });

    </script>

</body>
</html>

