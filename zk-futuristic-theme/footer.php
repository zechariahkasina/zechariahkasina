<?php
/**
 * The footer for the ZK Futuristic theme
 *
 * @package ZK_Futuristic_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

    </div><!-- #content -->

    <?php if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3')) : ?>
        <div class="footer-widgets">
            <div class="container">
                <div class="footer-widget-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; padding: 4rem 0;">
                    <?php if (is_active_sidebar('footer-1')) : ?>
                        <div class="footer-widget-area">
                            <?php dynamic_sidebar('footer-1'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (is_active_sidebar('footer-2')) : ?>
                        <div class="footer-widget-area">
                            <?php dynamic_sidebar('footer-2'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (is_active_sidebar('footer-3')) : ?>
                        <div class="footer-widget-area">
                            <?php dynamic_sidebar('footer-3'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <footer id="colophon" class="site-footer">
        <div class="container">
            <p>
                <?php
                printf(
                    esc_html__('Designed & Built with %s by %s', 'zk-futuristic'),
                    '<span class="footer-heart">&hearts;</span>',
                    '<a href="' . esc_url(home_url('/')) . '">' . esc_html(get_bloginfo('name')) . '</a>'
                );
                ?>
                <br>
                &copy; <?php echo date('Y'); ?> <?php esc_html_e('All rights reserved.', 'zk-futuristic'); ?>
            </p>

            <?php
            if (has_nav_menu('footer')) {
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'menu_id'        => 'footer-menu',
                    'menu_class'     => 'footer-menu',
                    'container'      => 'nav',
                    'container_class' => 'footer-navigation',
                    'depth'          => 1,
                ));
            }
            ?>
        </div>
    </footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
