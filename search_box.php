<?php
include "config.php";

if (isset($_POST['search_word']) && !empty($_POST['search_word'])) {
    $search_word = $conn->real_escape_string($_POST['search_word']);

    $sql = "
        (SELECT id, title, slug, 'course' AS type FROM courses WHERE title LIKE '%$search_word%' LIMIT 5)
        UNION
        (SELECT id, title, slug, 'article' AS type FROM articles WHERE title LIKE '%$search_word%' LIMIT 5)
    ";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $link = ($row['type'] === 'course') 
                ? "courses/course.php?slug=" . urlencode($row['slug']) 
                : "articles/article.php?slug=" . urlencode($row['slug']);

            echo "<div class='suggestion-item' data-id='" . $row['id'] . "'>";
            echo "<a href='$link'>" . htmlspecialchars($row['title']) . "</a>";
            echo "</div>";
        }
    } else {
        echo "<div class='suggestion-item'>نتیجه‌ای یافت نشد</div>";
    }
}
?>
