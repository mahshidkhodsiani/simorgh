<?php

include 'config.php';



    // Prepare and execute the SQL query
    $sql ="SELECT * from sounds";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<audio controls>';
            echo    '<source src="data:audio/mpeg;base64,'.base64_encode($row['file_data']).'">';
            echo '</audio><br>';
        }
    }


$conn->close();
?>
