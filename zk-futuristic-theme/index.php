<?php
/**
 * The main template file (Blog Index)
 *
 * @package ZK_Futuristic_Theme
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">

        <?php if (have_posts()) : ?>

            <?php if (is_home() && !is_front_page()) : ?>
                <header class="page-header fade-in" style="text-align: center; margin-bottom: 4rem;">
                    <h1 class="page-title"><?php single_post_title(); ?></h1>
                </header>
            <?php endif; ?>

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2rem;">
                <?php
                while (have_posts()) :
                    the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('content-card fade-in'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('zk-featured-medium'); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <header class="entry-header">
                            <?php
                            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
                            ?>

                            <div class="entry-meta">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16" style="vertical-align: middle;">
                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                    </svg>
                                    <?php echo get_the_date(); ?>
                                </span>
                                <?php if (has_category()) : ?>
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16" style="vertical-align: middle;">
                                            <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3.797a1.5 1.5 0 0 1 1.06.44l.707.706H13.5A1.5 1.5 0 0 1 15 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-11A1.5 1.5 0 0 1 1 12.5v-10z"/>
                                        </svg>
                                        <?php the_category(', '); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </header><!-- .entry-header -->

                        <div class="entry-summary">
                            <?php the_excerpt(); ?>
                        </div><!-- .entry-summary -->

                        <footer class="entry-footer">
                            <a href="<?php the_permalink(); ?>" class="btn btn-primary" style="padding: 0.7rem 1.5rem; font-size: 0.9rem;">
                                <?php esc_html_e('Read More', 'zk-futuristic'); ?> &rarr;
                            </a>
                        </footer>
                    </article><!-- #post-<?php the_ID(); ?> -->
                    <?php
                endwhile;
                ?>
            </div>

            <?php
            zk_futuristic_pagination();

        else :
            ?>
            <div class="content-card fade-in" style="text-align: center; padding: 4rem;">
                <h2><?php esc_html_e('Nothing Found', 'zk-futuristic'); ?></h2>
                <p style="color: var(--text-muted); margin-top: 1rem; font-size: 1.1rem;">
                    <?php
                    if (is_home() && current_user_can('publish_posts')) :
                        printf(
                            '<p>' . wp_kses(
                                __('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'zk-futuristic'),
                                array(
                                    'a' => array(
                                        'href' => array(),
                                    ),
                                )
                            ) . '</p>',
                            esc_url(admin_url('post-new.php'))
                        );
                    else :
                        esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'zk-futuristic');
                    endif;
                    ?>
                </p>
                <?php get_search_form(); ?>
            </div>
            <?php
        endif;
        ?>

    </div>
</main><!-- #main -->

<?php
get_footer();
