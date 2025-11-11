<?php
/**
 * The header for the ZK Futuristic theme
 *
 * @package ZK_Futuristic_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Animated Gradient Background -->
<div class="gradient-bg"></div>

<!-- Particle Canvas -->
<canvas id="particles-canvas"></canvas>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'zk-futuristic'); ?></a>

    <!-- Navigation -->
    <nav id="site-navigation" class="main-navigation" role="navigation">
        <div class="nav-container">
            <?php
            // Display custom logo or site title
            if (has_custom_logo()) {
                the_custom_logo();
            } else {
                ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo" rel="home">
                    <?php
                    $site_title = get_bloginfo('name');
                    // Create an abbreviation from the site name
                    $words = explode(' ', $site_title);
                    if (count($words) >= 2) {
                        echo esc_html(strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1)));
                    } else {
                        echo esc_html(strtoupper(substr($site_title, 0, 2)));
                    }
                    ?>
                </a>
                <?php
            }
            ?>

            <div class="hamburger" onclick="toggleMenu()" aria-label="Toggle menu" role="button" tabindex="0">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_id'        => 'primary-menu',
                'menu_class'     => 'nav-menu',
                'container'      => false,
                'fallback_cb'    => 'zk_futuristic_fallback_menu',
                'walker'         => new ZK_Futuristic_Walker_Nav_Menu(),
            ));
            ?>
        </div>
    </nav><!-- #site-navigation -->

    <div id="content" class="site-content">

<?php
/**
 * Fallback menu if no menu is set
 */
function zk_futuristic_fallback_menu() {
    echo '<ul id="primary-menu" class="nav-menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'zk-futuristic') . '</a></li>';

    // List all pages
    $pages = get_pages(array('sort_column' => 'menu_order'));
    foreach ($pages as $page) {
        $current_class = (is_page($page->ID)) ? 'current_page_item' : '';
        echo '<li class="' . esc_attr($current_class) . '">';
        echo '<a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html($page->post_title) . '</a>';
        echo '</li>';
    }

    echo '</ul>';
}
?>
