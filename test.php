<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_VERSION', '3.4.4' );
define( 'EHP_THEME_SLUG', 'hello-elementor' );

define( 'HELLO_THEME_PATH', get_template_directory() );
define( 'HELLO_THEME_URL', get_template_directory_uri() );
define( 'HELLO_THEME_ASSETS_PATH', HELLO_THEME_PATH . '/assets/' );
define( 'HELLO_THEME_ASSETS_URL', HELLO_THEME_URL . '/assets/' );
define( 'HELLO_THEME_SCRIPTS_PATH', HELLO_THEME_ASSETS_PATH . 'js/' );
define( 'HELLO_THEME_SCRIPTS_URL', HELLO_THEME_ASSETS_URL . 'js/' );
define( 'HELLO_THEME_STYLE_PATH', HELLO_THEME_ASSETS_PATH . 'css/' );
define( 'HELLO_THEME_STYLE_URL', HELLO_THEME_ASSETS_URL . 'css/' );
define( 'HELLO_THEME_IMAGES_PATH', HELLO_THEME_ASSETS_PATH . 'images/' );
define( 'HELLO_THEME_IMAGES_URL', HELLO_THEME_ASSETS_URL . 'images/' );

if ( ! isset( $content_width ) ) {
	$content_width = 800; // Pixels.
}

if ( ! function_exists( 'hello_elementor_setup' ) ) {
	/**
	 * Set up theme support.
	 *
	 * @return void
	 */
	function hello_elementor_setup() {
		if ( is_admin() ) {
			hello_maybe_update_theme_version_in_db();
		}

		if ( apply_filters( 'hello_elementor_register_menus', true ) ) {
			register_nav_menus( [ 'menu-1' => esc_html__( 'Header', 'hello-elementor' ) ] );
			register_nav_menus( [ 'menu-2' => esc_html__( 'Footer', 'hello-elementor' ) ] );
		}

		if ( apply_filters( 'hello_elementor_post_type_support', true ) ) {
			add_post_type_support( 'page', 'excerpt' );
		}

		if ( apply_filters( 'hello_elementor_add_theme_support', true ) ) {
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'title-tag' );
			add_theme_support(
				'html5',
				[
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
					'script',
					'style',
					'navigation-widgets',
				]
			);
			add_theme_support(
				'custom-logo',
				[
					'height'      => 100,
					'width'       => 350,
					'flex-height' => true,
					'flex-width'  => true,
				]
			);
			add_theme_support( 'align-wide' );
			add_theme_support( 'responsive-embeds' );

			/*
			 * Editor Styles
			 */
			add_theme_support( 'editor-styles' );
			add_editor_style( 'editor-styles.css' );

			/*
			 * WooCommerce.
			 */
			if ( apply_filters( 'hello_elementor_add_woocommerce_support', true ) ) {
				// WooCommerce in general.
				add_theme_support( 'woocommerce' );
				// Enabling WooCommerce product gallery features (are off by default since WC 3.0.0).
				// zoom.
				add_theme_support( 'wc-product-gallery-zoom' );
				// lightbox.
				add_theme_support( 'wc-product-gallery-lightbox' );
				// swipe.
				add_theme_support( 'wc-product-gallery-slider' );
			}
		}
	}
}
add_action( 'after_setup_theme', 'hello_elementor_setup' );

function hello_maybe_update_theme_version_in_db() {
	$theme_version_option_name = 'hello_theme_version';
	// The theme version saved in the database.
	$hello_theme_db_version = get_option( $theme_version_option_name );

	// If the 'hello_theme_version' option does not exist in the DB, or the version needs to be updated, do the update.
	if ( ! $hello_theme_db_version || version_compare( $hello_theme_db_version, HELLO_ELEMENTOR_VERSION, '<' ) ) {
		update_option( $theme_version_option_name, HELLO_ELEMENTOR_VERSION );
	}
}

if ( ! function_exists( 'hello_elementor_display_header_footer' ) ) {
	/**
	 * Check whether to display header footer.
	 *
	 * @return bool
	 */
	function hello_elementor_display_header_footer() {
		$hello_elementor_header_footer = true;

		return apply_filters( 'hello_elementor_header_footer', $hello_elementor_header_footer );
	}
}

if ( ! function_exists( 'hello_elementor_scripts_styles' ) ) {
	/**
	 * Theme Scripts & Styles.
	 *
	 * @return void
	 */
	function hello_elementor_scripts_styles() {
		if ( apply_filters( 'hello_elementor_enqueue_style', true ) ) {
			wp_enqueue_style(
				'hello-elementor',
				HELLO_THEME_STYLE_URL . 'reset.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if ( apply_filters( 'hello_elementor_enqueue_theme_style', true ) ) {
			wp_enqueue_style(
				'hello-elementor-theme-style',
				HELLO_THEME_STYLE_URL . 'theme.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if ( hello_elementor_display_header_footer() ) {
			wp_enqueue_style(
				'hello-elementor-header-footer',
				HELLO_THEME_STYLE_URL . 'header-footer.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_scripts_styles' );

if ( ! function_exists( 'hello_elementor_register_elementor_locations' ) ) {
	/**
	 * Register Elementor Locations.
	 *
	 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
	 *
	 * @return void
	 */
	function hello_elementor_register_elementor_locations( $elementor_theme_manager ) {
		if ( apply_filters( 'hello_elementor_register_elementor_locations', true ) ) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}
add_action( 'elementor/theme/register_locations', 'hello_elementor_register_elementor_locations' );

if ( ! function_exists( 'hello_elementor_content_width' ) ) {
	/**
	 * Set default content width.
	 *
	 * @return void
	 */
	function hello_elementor_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'hello_elementor_content_width', 800 );
	}
}
add_action( 'after_setup_theme', 'hello_elementor_content_width', 0 );

if ( ! function_exists( 'hello_elementor_add_description_meta_tag' ) ) {
	/**
	 * Add description meta tag with excerpt text.
	 *
	 * @return void
	 */
	function hello_elementor_add_description_meta_tag() {
		if ( ! apply_filters( 'hello_elementor_description_meta_tag', true ) ) {
			return;
		}

		if ( ! is_singular() ) {
			return;
		}

		$post = get_queried_object();
		if ( empty( $post->post_excerpt ) ) {
			return;
		}

		echo '<meta name="description" content="' . esc_attr( wp_strip_all_tags( $post->post_excerpt ) ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'hello_elementor_add_description_meta_tag' );

// Settings page
require get_template_directory() . '/includes/settings-functions.php';

// Header & footer styling option, inside Elementor
require get_template_directory() . '/includes/elementor-functions.php';

if ( ! function_exists( 'hello_elementor_customizer' ) ) {
	// Customizer controls
	function hello_elementor_customizer() {
		if ( ! is_customize_preview() ) {
			return;
		}

		if ( ! hello_elementor_display_header_footer() ) {
			return;
		}

		require get_template_directory() . '/includes/customizer-functions.php';
	}
}
add_action( 'init', 'hello_elementor_customizer' );

if ( ! function_exists( 'hello_elementor_check_hide_title' ) ) {
	/**
	 * Check whether to display the page title.
	 *
	 * @param bool $val default value.
	 *
	 * @return bool
	 */
	function hello_elementor_check_hide_title( $val ) {
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			$current_doc = Elementor\Plugin::instance()->documents->get( get_the_ID() );
			if ( $current_doc && 'yes' === $current_doc->get_settings( 'hide_title' ) ) {
				$val = false;
			}
		}
		return $val;
	}
}
add_filter( 'hello_elementor_page_title', 'hello_elementor_check_hide_title' );

/**
 * BC:
 * In v2.7.0 the theme removed the `hello_elementor_body_open()` from `header.php` replacing it with `wp_body_open()`.
 * The following code prevents fatal errors in child themes that still use this function.
 */
if ( ! function_exists( 'hello_elementor_body_open' ) ) {
	function hello_elementor_body_open() {
		wp_body_open();
	}
}

require HELLO_THEME_PATH . '/theme.php';

HelloTheme\Theme::instance();








// مهشید
function show_recent_posts_box($atts)
{
    // استخراج پارامترهای شورتکد
    $atts = shortcode_atts(array(
        'number' => 3,
    ), $atts);

    // شروع بافر خروجی
    ob_start();

    // کوئری وردپرس برای دریافت پست‌ها
    $query = new WP_Query(array(
        'posts_per_page' => $atts['number'],
        'post_status' => 'publish',
        'ignore_sticky_posts' => true
    ));

    if ($query->have_posts()) {
        // استایل‌های CSS
?>
        <style>
            .recent-posts-container {
                display: flex;
                flex-wrap: wrap;
                gap: 30px;
                justify-content: center;
                margin: 40px 0;
            }

            .recent-post-card {
                width: calc(33.333% - 20px);
                min-width: 280px;
                background: #fff;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
                transition: all 0.3s ease;
                position: relative;
            }

            .recent-post-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
            }

            .post-thumbnail {
                width: 100%;
                height: 200px;
                object-fit: cover;
                display: block;
            }

            .post-content {
                padding: 20px;
            }

            .post-title {
                margin: 0 0 15px 0;
                font-size: 1.2em;
                line-height: 1.4;
            }

            .post-title a {
                color: #333;
                text-decoration: none;
                transition: color 0.3s ease;
            }

            .post-title a:hover {
                color: #4e6bff;
            }

            .post-excerpt {
                color: #666;
                font-size: 0.9em;
                margin-bottom: 20px;
                line-height: 1.6;
            }

            .read-more-btn {
                display: inline-block;
                padding: 8px 20px;
                background: #4e6bff;
                color: white;
                text-decoration: none;
                border-radius: 30px;
                font-size: 0.9em;
                transition: all 0.3s ease;
            }

            .read-more-btn:hover {
                background: #3a56d4;
                transform: translateY(-2px);
            }

            @media (max-width: 992px) {
                .recent-post-card {
                    width: calc(50% - 15px);
                }
            }

            @media (max-width: 768px) {
                .recent-post-card {
                    width: 100%;
                }
            }
        </style>

        <div class="recent-posts-container">
            <?php

            while ($query->have_posts()) {
                $query->the_post();
            ?>
                <div class="recent-post-card">
                    <a href="<?php the_permalink(); ?>">
                        <?php if (has_post_thumbnail()) {
                            the_post_thumbnail('medium_large', array('class' => 'post-thumbnail'));
                        } else {
                            echo '<img src="' . get_template_directory_uri() . '/assets/images/default-thumbnail.jpg" class="post-thumbnail" alt="' . get_the_title() . '">';
                        }
                        ?>
                    </a>
                    <div class="post-content">
                        <h3 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <div class="post-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></div>
                        <a href="<?php the_permalink(); ?>" class="read-more-btn">خواندن بیشتر</a>
                    </div>
                </div>
    <?php
            }

            echo '</div>';
        } else {
            echo '<p>هیچ پستی یافت نشد.</p>';
        }

        wp_reset_postdata();

        return ob_get_clean();
    }
    add_shortcode('recent_posts', 'show_recent_posts_box');





add_action('woocommerce_before_cart', 'custom_cart_payment_notice');
function custom_cart_payment_notice() {
    echo '<div style="padding:15px; background:#fff8e1; border:1px solid #fbc02d; border-radius:8px; margin-bottom:20px; font-family:Tahoma;">
        <strong>روش پرداخت کارت به کارت</strong><br>
        💳 شماره کارت: <strong>6037-6975-6574-3298</strong><br>
        به نام: <strong>مهشید خودسیانی</strong><br>
        📩 لطفاً فیش واریزی را به شماره <strong>09130109552</strong> ارسال کنید.
    </div>';
}





/**
 * حذف کامل چک باکس "حمل و نقل به یک آدرس متفاوت؟" در صفحه تسویه حساب
 * ووکامرس را مجبور می‌کند که از آدرس صورتحساب برای حمل و نقل استفاده کند.
 */
add_filter( 'woocommerce_cart_needs_shipping_address', '__return_false' );









add_filter('woocommerce_checkout_fields', 'customize_checkout_fields_update');

function customize_checkout_fields_update($fields)
{

    // ۱. اجباری کردن فیلد تلفن و تغییر برچسب آدرس

    // فیلد تلفن (billing_phone) را اجباری (Required) می‌کند
    $fields['billing']['billing_phone']['required'] = true;

    // **تغییر برچسب فیلد آدرس اصلی (billing_address_1) به "آدرس کامل"**
    $fields['billing']['billing_address_1']['label'] = 'آدرس کامل';
    // تغییر برچسب فیلد استان/ایالت
    $fields['billing']['billing_state']['label'] = 'شهر ';

    // ۲. حذف فیلدهای اضافی

    // حذف فیلد آدرس ایمیل (billing_email)
    unset($fields['billing']['billing_email']);
    // حذف فیلد کشور
    unset($fields['billing']['billing_country']);

    // **حذف فیلد آپارتمان/واحد (billing_address_2)**
    unset($fields['billing']['billing_address_2']);

    // حذف فیلد شهر (billing_city) - **توجه:** چون شما فیلد billing_state را نگه داشته‌اید،
    // حذف billing_city ممکن است در برخی ساختارها باعث مشکل شود. اگر قصد استفاده از آن را ندارید، حذفش کنید.
    unset($fields['billing']['billing_city']);

    // حذف نام شرکت (اختیاری)
    // unset($fields['billing']['billing_company']);

    return $fields;
}


// --- کد جدید برای محدود کردن فیلد استان/ایالت (billing_state) ---
/**
 * محدود کردن گزینه‌های فیلد استان/ایالت (billing_state) به اصفهان
 * در صورت فعال بودن فیلد billing_country.
 */
add_filter('woocommerce_states', 'limit_woocommerce_states_to_esfahan');

function limit_woocommerce_states_to_esfahan($states)
{
    // کد استان اصفهان در ووکامرس ایران ESF است
    $esfahan_code = 'ESF';
    $esfahan_name = 'اصفهان';

    // ابتدا بررسی می‌کنیم که کشور ایران (IR) وجود داشته باشد
    if (isset($states['IR'])) {
        // یک آرایه جدید حاوی فقط اصفهان ایجاد می‌کنیم
        $limited_states = array(
            $esfahan_code => $esfahan_name
        );

        // لیست استان‌های ایران را به این آرایه محدود شده تغییر می‌دهیم
        $states['IR'] = $limited_states;
    }

    return $states;
}

