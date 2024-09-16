
<style>
    /* Base styles for the sidebar */
    .sidebar {
        margin: 0;
        padding: 0;
        width: 200px;
        background-color: #f1f1f1;
        position: fixed;
        height: 100%;
        overflow: auto;
        right: 0;
    }

    .sidebar a {
        display: block;
        color: black;
        padding: 16px;
        text-decoration: none;
    }

    .sidebar a.active {
        background-color: #1681f7;
        color: white;
    }

    .sidebar a:hover:not(.active) {
        background-color: #555;
        color: white;
    }

    /* Dropdown container styles */
    .dropdown-container {
        display: none;
        padding-left: 8px;
    }

    .dropdown-container.show {
        display: block;
    }

    .dropdown-btn {
        cursor: pointer;
    }

    /* Body styles */
    body {
        margin: 0;
        font-family: "Lato", sans-serif;
    }

    /* Content styles */
    div.content {
        margin-left: 200px;
        padding: 1px 16px;
        height: 1000px;
    }

    /* Mobile styles */
    @media screen and (max-width: 700px) {
        .sidebar {
            width: 100%;
            height: auto;
            position: relative;
        }

        .sidebar a {
            float: left;
        }

        div.content {
            margin-left: 0;
        }
    }

    @media screen and (max-width: 400px) {
        .sidebar a {
            text-align: center;
            float: none;
        }
    }

</style>

<div class="sidebar">
    <h5 class="p-4 shadow"><?= $_SESSION['all_data']['name']?></h5>
    <a href="index" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'index') echo 'active'; ?>">
        <img src="../images/home.png" height="20px" width="20px">
        صفحه اول
    </a>
    <a href="new_article" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'new_article') echo 'active'; ?>">
        <img src="../images/add-article.jpg" height="20px" width="20px">
        افزودن مقاله جدید
    </a>
    <a href="new_course" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'new_course') echo 'active'; ?>">
        <img src="../images/add-article.jpg" height="20px" width="20px">
        افزودن دوره جدید
    </a>
    <a href="new_work" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'new_work') echo 'active'; ?>">
        <img src="../images/add-article.jpg" height="20px" width="20px">
        افزودن نمونه کار جدید
    </a>
    <a href="new_radio" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'new_radio') echo 'active'; ?>">
        <img src="../images/radio.jpg" height="20px" width="20px">
        افزودن رادیوی جدید
    </a>
    <a href="new_speaker" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'new_speaker') echo 'active'; ?>">
        <img src="../images/speaker.png" height="20px" width="20px">
        افزودن گوینده جدید
    </a>

    <!-- for dropdown :
    <a href="javascript:void(0);" class="nav-link dropdown-btn">
        <img src="../images/flash.png" height="20px" width="20px">
            سفارش تبلیغات 
    </a>
    <div class="dropdown-container">
        <a href="new_motiongraphic" class="nav-link<?php if (basename($_SERVER['REQUEST_URI']) === 'new_motiongraphic') echo 'active'; ?>">
            <img src="../images/add-article.jpg" height="20px" width="20px">
            موشن گرافیک
        </a>
        <a href="clips" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'clips') echo 'active'; ?>">
            <img src="../images/add-article.jpg" height="20px" width="20px">
            کلیپ
        </a>
    </div> -->

    <a href="new_user" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'new_user') echo 'active'; ?>">
        <img src="../images/add-user.jpg" height="20px" width="20px">
        مدیریت یوزر ها
    </a>
    <a href="suggests" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'suggests') echo 'active'; ?>">
        <img src="../images/suggests.png" height="20px" width="20px">
        انتقادات و پیشنهادات
    </a>
    <a href="registered" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'registered') echo 'active'; ?>">
        <img src="../images/registered.png" height="20px" width="20px">
        اطلاعات ثبت نامی ها
    </a>
    <a href="sounds" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'sounds') echo 'active'; ?>">
        <img src="../images/sounds.jpg" height="20px" width="20px">
        صداهای ارسالی
    </a>

 
    
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var dropdownButtons = document.querySelectorAll('.dropdown-btn');

        dropdownButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var dropdownContent = this.nextElementSibling;

                // Toggle the 'show' class
                if (dropdownContent.classList.contains('show')) {
                    dropdownContent.classList.remove('show');
                } else {
                    // Hide all other dropdowns
                    document.querySelectorAll('.dropdown-container.show').forEach(function(openDropdown) {
                        openDropdown.classList.remove('show');
                    });
                    dropdownContent.classList.add('show');
                }
            });
        });
    });
</script>

