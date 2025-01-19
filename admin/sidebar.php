<style>
    /* Base styles for the sidebar */
    .sidebar {
        margin: 0;
        padding: 0;
        width: 220px;
        background-color: #f8f9fa;
        position: fixed;
        height: 100%;
        overflow: auto;
        right: 0;
        box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        transition: width 0.3s ease; /* Smooth transition for width change */
    }

    /* Sidebar heading */
    .sidebar h5 {
        padding: 16px;
        font-size: 18px;
        background-color: #343a40;
        color: white;
        text-align: center;
        margin: 0;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    /* Sidebar links */
    .sidebar a {
        display: flex;
        align-items: center;
        color: #343a40;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 15px;
        transition: background-color 0.3s ease, color 0.3s ease; /* Smooth hover transition */
    }

    /* Active link styling */
    .sidebar a.active {
        background-color: #007bff;
        color: white;
    }

    /* Hover effect */
    .sidebar a:hover:not(.active) {
        background-color: #007bff;
        color: white;
    }

    /* Icons next to links */
    .sidebar a img {
        margin-right: 10px;
    }

    /* Dropdown container styles */
    .dropdown-container {
        display: none;
        padding-left: 24px;
        background-color: #f1f1f1;
    }

    .dropdown-container.show {
        display: block;
    }

    /* Dropdown button */
    .dropdown-btn {
        cursor: pointer;
        display: flex;
        align-items: center;
        padding: 14px 16px;
        font-size: 15px;
        color: #343a40;
        background-color: transparent;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .dropdown-btn:hover {
        background-color: #007bff;
        color: white;
    }

    /* Body styles */
    body {
        margin: 0;
        font-family: "Lato", sans-serif;
        background-color: #f8f9fa;
    }

    /* Content styles */
    div.content {
        margin-left: 220px;
        padding: 16px;
        height: 1000px;
        background-color: #ffffff;
        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1); /* Content area shadow */
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
            padding: 10px 10px;
        }

        .sidebar h5 {
            text-align: left;
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

        .sidebar img {
            display: none; /* Hide images on small screens */
        }
    }
</style>

<div class="sidebar">
    <h5 class="p-4 shadow"><?= $_SESSION['all_data']['name'] ." ". $_SESSION['all_data']['family']?></h5>
    <a href="index" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'index') echo 'active'; ?>">
        <img src="../images/home.png" height="20px" width="20px">
        صفحه اول
    </a>


    <!-- for dropdown : -->
    <a href="javascript:void(0);" class="dropdown-btn">
        <img src="../images/flash.png" height="20px" width="20px">
        افزودن نمونه کار جدید
    </a>
    <div class="dropdown-container">
        <a href="new_pic" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'new_pic') echo 'active'; ?>">
            <img src="../images/portofilo.png" height="20px" width="20px">
            گالری عکس
        </a>
        <a href="new_video" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'new_video') echo 'active'; ?>">
            <img src="../images/portofilo.png" height="20px" width="20px">
            ویدیوی جدید
        </a>
    </div>

    <a href="new_article" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'new_article') echo 'active'; ?>">
        <img src="../images/add-article.jpg" height="20px" width="20px">
        افزودن مقاله جدید
    </a>
    <a href="new_course" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'new_course') echo 'active'; ?>">
        <img src="../images/add-article.jpg" height="20px" width="20px">
        افزودن دوره جدید
    </a>
    <!-- <a href="new_work" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'new_work') echo 'active'; ?>">
        <img src="../images/add-article.jpg" height="20px" width="20px">
        افزودن نمونه کار جدید
    </a> -->
    <a href="new_radio" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'new_radio') echo 'active'; ?>">
        <img src="../images/radio.jpg" height="20px" width="20px">
        افزودن رادیوی جدید
    </a>
    <a href="new_speaker" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'new_speaker') echo 'active'; ?>">
        <img src="../images/speaker.png" height="20px" width="20px">
        افزودن گوینده جدید
    </a>


    

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
