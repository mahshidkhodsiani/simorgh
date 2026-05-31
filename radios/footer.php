<style>
/* Footer */
.footer {
    background-color: #343a40;
    color: #ffffff;
    padding: 10px 0;
    font-size: 14px;
    position: relative;
    width: 100%;
}

.footer a {
    color: #ffffff;
    text-decoration: none;
}

.footer a:hover {
    color: #f8f9fa;
    text-decoration: underline;
}

.footer .list-inline-item {
    margin: 0 10px;
}

.footer p,
.footer ul {
    margin: 0;
}

.footer ul {
    padding: 0;
    list-style: none;
}

@media (max-width: 767.98px) {

    .footer .text-md-left,
    .footer .text-md-right {
        text-align: center !important;
    }
}

/* Remove specific margin/font size for .design-credit since it will be in footer-bottom */
/* .design-credit {
        margin-top: 15px;
        font-size: 13px;
        color: #bbb;
    } */

.design-credit a {
    color: #fff;
    font-weight: bold;
}

/* Style for footer-bottom to handle both texts */
.footer-bottom {
    padding-top: 15px;
    /* Add some padding above the bottom content */
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    /* Optional: a subtle line above it */
    margin-top: 20px;
    /* Space from the content above */
    display: flex;
    /* Use flexbox for alignment */
    flex-direction: column;
    /* Stack items vertically by default */
    align-items: center;
    /* Center items horizontally */
    text-align: center;
    /* Ensure text is centered for smaller screens */
}

/* Adjust layout for larger screens */
@media (min-width: 768px) {
    .footer-bottom {
        flex-direction: row;
        /* Arrange items in a row on larger screens */
        justify-content: space-between;
        /* Space out items */
    }
}
</style>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <ul class="simple-links">
                    <h5>لینک های مفید</h5>
                    <li><a href="../articles/contact">ارتباط با ما</a></li>
                    <li><a href="../articles/index">بهترین مقالات</a></li>
                    <li><a href="../articles/work_us">همکاری با ما</a></li>
                    <li><a href="../articles/suggestion">انتقاد و پیشنهاد به سیمرغ</a></li>

                </ul>
            </div>

            <div class="col-md-6 text-center">
                <a href="https://trustseal.enamad.ir/?id=514858&Code=XLHp9yPcQnRZL83Nfd3Kg9BbN4INSCXP" target="_blank">
                    <img src="https://trustseal.enamad.ir/logo.aspx?id=514858&Code=XLHp9yPcQnRZL83Nfd3Kg9BbN4INSCXP"
                        alt="Enamad" style="cursor: pointer; max-width: 120px;">
                </a>
                <video autoplay loop muted style="margin-top: 15px; max-width: 100%; border-radius: 10px;">
                    <source src="../images/sms.mp4" type="video/mp4">
                </video>
            </div>

            <div class="col-md-3">
                <div class="footer-location">
                    <h6>آدرس</h6>
                    <p>
                        تهران،
                        پل کریمخان ، میرزای شیرازی ، روبروی داروخانه ایثار پلاک ۶۸ واحد۳
                    </p>
                    <p>تلفن: 021-91300517</p>

                    <div class="ratio ratio-16x9">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3239.34702733371!2d51.415934!3d35.717683!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMzXCsDQzJzAzLjciTiA1McKwMjQnNTcuNCJF!5e0!3m2!1sen!2s!4v1747397440274!5m2!1sen!2s"
                            style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>تمامی حقوق این سایت متعلق به موسسه هفت هنر سیمرغ می‌باشد.</p>
            <p class="design-credit">
                طراحی و توسعه وب‌سایت توسط: <a href="http://moonshid.ir" target="_blank"
                    rel="noopener noreferrer">moonshid.ir</a>
            </p>
        </div>
    </div>
</footer>


<script src="../js/jquery-3.3.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/jquery.sticky.js"></script>
<script src="../js/main.js"></script>