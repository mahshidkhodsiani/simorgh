<?php
include "config.php";

if (isset($_POST['search_word']) && !empty($_POST['search_word'])) {
    $search_word = $conn->real_escape_string($_POST['search_word']);
    $sql = "SELECT id, title, slug FROM courses WHERE title LIKE '%$search_word%' LIMIT 5"; 
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // استفاده از لینک درست برای هر پیشنهاد
            echo "<div class='suggestion-item' data-id='" . $row['id'] . "'>";
            echo "<a href='courses/course.php?slug=" . urlencode($row['title']) . "'>" . htmlspecialchars($row['title']) . "</a>";
            echo "</div>";
        }
    } else {
        echo "<div class='suggestion-item'>نتیجه‌ای یافت نشد</div>";
    }
}
?>
