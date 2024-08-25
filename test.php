<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="audioFile" accept="audio/mp3" required>
    <button type="submit">Upload</button>
</form>

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

$conn->close();
?>






