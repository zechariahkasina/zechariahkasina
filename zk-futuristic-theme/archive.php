<?php
/**
 * The template for displaying archive pages
 *
 * @package ZK_Futuristic_Theme
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">

        <?php if (have_posts()) : ?>

            <header class="page-header fade-in" style="text-align: center; margin-bottom: 4rem;">
                <?php
                the_archive_title('<h1 class="page-title">', '</h1>');
                the_archive_description('<div class="archive-description" style="color: var(--text-muted); font-size: 1.2rem; margin-top: 1rem;">', '</div>');
                ?>
            </header><!-- .page-header -->

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
                            if (is_singular()) :
                                the_title('<h1 class="entry-title">', '</h1>');
                            else :
                                the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
                            endif;
                            ?>

                            <div class="entry-meta">
                                <span><?php echo get_the_date(); ?></span>
                                <?php if (has_category()) : ?>
                                    <span><?php the_category(', '); ?></span>
                                <?php endif; ?>
                            </div>
                        </header><!-- .entry-header -->

                        <div class="entry-summary">
                            <?php the_excerpt(); ?>
                        </div><!-- .entry-summary -->

                        <footer class="entry-footer">
                            <a href="<?php the_permalink(); ?>" class="btn btn-primary" style="padding: 0.7rem 1.5rem; font-size: 0.9rem;">
                                <?php esc_html_e('Read More', 'zk-futuristic'); ?>
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
                <p style="color: var(--text-muted); margin-top: 1rem;">
                    <?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'zk-futuristic'); ?>
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
