<?php
/**
 * ZK Futuristic Theme Functions
 *
 * @package ZK_Futuristic_Theme
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Theme Setup
 */
function zk_futuristic_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(1200, 675, true);

    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'zk-futuristic'),
        'footer'  => esc_html__('Footer Menu', 'zk-futuristic'),
    ));

    // Switch default core markup to output valid HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Add theme support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for core custom logo
    add_theme_support('custom-logo', array(
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ));

    // Add support for custom background
    add_theme_support('custom-background', array(
        'default-color' => '0a0a0f',
    ));

    // Add support for editor styles
    add_theme_support('editor-styles');
    add_editor_style('style.css');

    // Add support for wide and full alignment
    add_theme_support('align-wide');

    // Add support for responsive embeds
    add_theme_support('responsive-embeds');
}
add_action('after_setup_theme', 'zk_futuristic_setup');

/**
 * Set the content width in pixels
 */
function zk_futuristic_content_width() {
    $GLOBALS['content_width'] = apply_filters('zk_futuristic_content_width', 1200);
}
add_action('after_setup_theme', 'zk_futuristic_content_width', 0);

/**
 * Enqueue scripts and styles
 */
function zk_futuristic_scripts() {
    // Enqueue Google Fonts
    wp_enqueue_style('zk-futuristic-fonts', 'https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap', array(), null);

    // Enqueue main stylesheet
    wp_enqueue_style('zk-futuristic-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version'));

    // Enqueue main JavaScript file
    wp_enqueue_script('zk-futuristic-animations', get_template_directory_uri() . '/js/animations.js', array(), wp_get_theme()->get('Version'), true);

    // Enqueue comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'zk_futuristic_scripts');

/**
 * Register widget areas
 */
function zk_futuristic_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'zk-futuristic'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'zk-futuristic'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area 1', 'zk-futuristic'),
        'id'            => 'footer-1',
        'description'   => esc_html__('Add footer widgets here.', 'zk-futuristic'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area 2', 'zk-futuristic'),
        'id'            => 'footer-2',
        'description'   => esc_html__('Add footer widgets here.', 'zk-futuristic'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area 3', 'zk-futuristic'),
        'id'            => 'footer-3',
        'description'   => esc_html__('Add footer widgets here.', 'zk-futuristic'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'zk_futuristic_widgets_init');

/**
 * Custom excerpt length
 */
function zk_futuristic_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'zk_futuristic_excerpt_length');

/**
 * Custom excerpt more
 */
function zk_futuristic_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'zk_futuristic_excerpt_more');

/**
 * Add custom classes to body
 */
function zk_futuristic_body_classes($classes) {
    // Adds a class of hfeed to non-singular pages
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}
add_filter('body_class', 'zk_futuristic_body_classes');

/**
 * Add a pingback url auto-discovery header for single posts
 */
function zk_futuristic_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('wp_head', 'zk_futuristic_pingback_header');

/**
 * Custom navigation walker for primary menu
 */
class ZK_Futuristic_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= '<li' . $id . $class_names . '>';

        $atts = array();
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel']    = !empty($item->xfn) ? $item->xfn : '';
        $atts['href']   = !empty($item->url) ? $item->url : '';

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters('the_title', $item->title, $item->ID);
        $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

/**
 * Pagination
 */
function zk_futuristic_pagination() {
    if ($GLOBALS['wp_query']->max_num_pages <= 1) {
        return;
    }

    $args = array(
        'mid_size'  => 2,
        'prev_text' => __('&larr; Previous', 'zk-futuristic'),
        'next_text' => __('Next &rarr;', 'zk-futuristic'),
    );

    $links = paginate_links($args);

    if ($links) {
        echo '<nav class="pagination" role="navigation">';
        echo $links;
        echo '</nav>';
    }
}

/**
 * Display posted on meta information
 */
function zk_futuristic_posted_on() {
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
    if (get_the_time('U') !== get_the_modified_time('U')) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
    }

    $time_string = sprintf($time_string,
        esc_attr(get_the_date(DATE_W3C)),
        esc_html(get_the_date()),
        esc_attr(get_the_modified_date(DATE_W3C)),
        esc_html(get_the_modified_date())
    );

    $posted_on = sprintf(
        esc_html_x('Posted on %s', 'post date', 'zk-futuristic'),
        '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
    );

    echo '<span class="posted-on">' . $posted_on . '</span>';
}

/**
 * Display posted by meta information
 */
function zk_futuristic_posted_by() {
    $byline = sprintf(
        esc_html_x('by %s', 'post author', 'zk-futuristic'),
        '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
    );

    echo '<span class="byline"> ' . $byline . '</span>';
}

/**
 * Display post categories
 */
function zk_futuristic_categories() {
    $categories_list = get_the_category_list(esc_html__(', ', 'zk-futuristic'));
    if ($categories_list) {
        printf('<span class="cat-links">' . esc_html__('Posted in %1$s', 'zk-futuristic') . '</span>', $categories_list);
    }
}

/**
 * Display post tags
 */
function zk_futuristic_tags() {
    $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'zk-futuristic'));
    if ($tags_list) {
        printf('<span class="tags-links">' . esc_html__('Tagged %1$s', 'zk-futuristic') . '</span>', $tags_list);
    }
}

/**
 * Add custom image sizes
 */
function zk_futuristic_image_sizes() {
    add_image_size('zk-featured-large', 1200, 675, true);
    add_image_size('zk-featured-medium', 800, 450, true);
    add_image_size('zk-thumbnail', 400, 300, true);
}
add_action('after_setup_theme', 'zk_futuristic_image_sizes');
