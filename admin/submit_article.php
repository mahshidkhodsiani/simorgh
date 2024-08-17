<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include "../config.php";









if(isset($_POST['submit_gallery'])){
    $title = $_POST['title'];
    $content = $_POST['content'];
    $type = $_POST['type'];

    // Ensure the title, content, and type are properly escaped to prevent SQL injection
    $title = $conn->real_escape_string($title);
    $content = $conn->real_escape_string($content);
    $type = $conn->real_escape_string($type);

    $imagePath = '';

    // Handle the file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = '../upload/images/2024/';
        $originalFileName = basename($_FILES['image']['name']);
        $uploadFile = $uploadDir . $originalFileName;

        // Ensure the upload directory exists
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $imagePath = $uploadFile; // Save the path for the database entry
        } else {
            echo "Failed to upload file.";
            exit;
        }
    }

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO gallery (title, images, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("ss", $title, $imagePath);

    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

}


if(isset($_POST['submit_radio'])){
    $title = $_POST['title'];
    $content = $_POST['content'];
    $type = $_POST['type'];

    // Ensure the title, content, and type are properly escaped to prevent SQL injection
    $title = $conn->real_escape_string($title);
    $content = $conn->real_escape_string($content);
    $type = $conn->real_escape_string($type);

    $imagePath = '';

    // Handle the file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = '../upload/images/2024/';
        $originalFileName = basename($_FILES['image']['name']);
        $uploadFile = $uploadDir . $originalFileName;

        // Ensure the upload directory exists
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $imagePath = $uploadFile; // Save the path for the database entry
        } else {
            echo "Failed to upload file.";
            exit;
        }
    }

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO gallery (title, images, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("ss", $title, $imagePath);

    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

}