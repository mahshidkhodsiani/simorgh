<?php
session_start();

if (!isset($_SESSION["all_data"])) {
    header("Location: ../login.php");
    exit();
}

$id = $_SESSION["all_data"]['id'];

include '../config.php';

// --- منطق حذف (همه چیز یه جا) ---
if (isset($_POST['delete_suggestion'])) {
    $suggestion_id = (int)$_POST['suggestion_id'];
    $stmt = $conn->prepare("DELETE FROM suggestions WHERE id = ?");
    $stmt->bind_param("i", $suggestion_id);
    $stmt->execute();
    $stmt->close();

    // ریدایرکت برای جلوگیری از ارسال مجدد فرم
    header("Location: suggests.php?deleted=1");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خانه</title>

    <link rel="icon" href="img/logo.png" type="image/x-icon">

    <?php
    include 'includes.php';
    ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="../summernote-0.8.20-dist/summernote-bs5.css" />
    <script src="../summernote-0.8.20-dist/summernote-bs5.js"></script>

    <link rel="stylesheet" href="../summernote-0.8.20-dist/summernote-bs4.css" />
    <script src="../summernote-0.8.20-dist/summernote-bs4.js"></script>

    <link rel="stylesheet" href="../summernote-0.8.20-dist/summernote.css" />
    <script src="../summernote-0.8.20-dist/summernote.js"></script>

    <link rel="stylesheet" href="../summernote-0.8.20-dist/summernote-lite.css" />
    <script src="../summernote-0.8.20-dist/summernote-lite.js"></script>

    <script src="../summernote-0.8.20-dist/lang/summernote-es-ES.js"></script>
</head>

<body>

<?php include 'header.php'; ?>
<div class="container-fluid">

    <div class="row">
        <div class="col-md-3 d-flex">
            <?php include 'sidebar.php'; ?>
        </div>

        <div class="col-md-8 mt-5">

            <div class="row mt-4">
                <div class="col-md-10">
                    <?php
                    // Pagination configuration
                    $items_per_page = 10;
                    $current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
                    if ($current_page < 1) $current_page = 1;

                    $offset = ($current_page - 1) * $items_per_page;

                    $sql = "SELECT * FROM suggestions ORDER BY id DESC LIMIT $offset, $items_per_page";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        $a = ($current_page - 1) * $items_per_page + 1;
                        ?>
                        <div class="table-responsive">
                            <table class="table border border-4">
                                <h4>نگاه کلی :</h4>
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">ردیف</th>
                                        <th scope="col" class="text-center">متن پیام</th>
                                        <th scope="col" class="text-center">نوع</th>
                                        <th scope="col" class="text-center">عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <th scope="row" class="text-center"><?= $a ?></th>
                                            <td class="text-center">
                                                <a style="text-decoration: none;" href="javascript:void(0);" onclick='showFullText(<?= json_encode($row['text'], JSON_UNESCAPED_UNICODE) ?>)'>
                                                    <?= mb_strimwidth($row['text'], 0, 50, '...') ?>
                                                </a>
                                            </td>
                                            <td class="text-center"><?= htmlspecialchars($row['type']) ?></td>
                                            <td class="text-center">
                                                <form method="POST" style="display:inline;" onsubmit="return confirm('آیا از حذف این پیشنهاد مطمئن هستید؟');">
                                                    <input type="hidden" name="suggestion_id" value="<?= $row['id'] ?>">
                                                    <button type="submit" name="delete_suggestion" class="btn btn-danger btn-sm">
                                                        حذف
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php $a++; } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php

                        // Pagination links
                        $sql = "SELECT COUNT(*) AS total FROM suggestions";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        $total_items = $row['total'];
                        $total_pages = ceil($total_items / $items_per_page);
                        ?>
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                                    <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </nav>
                        <?php
                    } else {
                        echo "<p>No records found.</p>";
                    }
                    ?>

                    <!-- Hidden Textarea for Full Text -->
                    <div class="col-md-10 mt-3 mb-3" id="full-text-container" style="display: none;">
                        <textarea class="form-control" id="full-text" rows="5"></textarea>
                    </div>

                </div>
            </div>

            <script>
                function showFullText(fullText) {
                    document.getElementById('full-text-container').style.display = 'block';
                    document.getElementById('full-text').value = fullText;
                }
            </script>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.nav-link').click(function() {
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
        });
    });
</script>

<script>
    function toggleCheckbox(checkedId, uncheckedId) {
        var checkedBox = document.getElementById(checkedId);
        var uncheckedBox = document.getElementById(uncheckedId);
        if (checkedBox.checked) {
            uncheckedBox.checked = false;
        }
    }
</script>

<script>
    $('.summernote').summernote({
        hint: {
            mentions: ['jayden','sam','alvin','david'],
            match: /\B@(\w*)$/,
            search: function (keyword, callback) {
                callback($.grep(this.mentions, function (item) {
                    return item.indexOf(keyword) == 0;
                }));
            },
            content: function (item) {
                return '@' + item;
            }
        }
    });
</script>

</body>

</html>