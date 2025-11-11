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

/**
 * SEO: Add Open Graph and Twitter Card meta tags
 */
function zk_futuristic_add_meta_tags() {
    if (is_singular()) {
        global $post;

        // Get post/page data
        $title = get_the_title();
        $description = get_the_excerpt() ? get_the_excerpt() : get_bloginfo('description');
        $url = get_permalink();
        $image = has_post_thumbnail() ? get_the_post_thumbnail_url($post->ID, 'full') : get_template_directory_uri() . '/screenshot.png';
        $site_name = get_bloginfo('name');

        // Open Graph meta tags
        echo '<meta property="og:type" content="' . (is_front_page() ? 'website' : 'article') . '" />' . "\n";
        echo '<meta property="og:title" content="' . esc_attr($title) . '" />' . "\n";
        echo '<meta property="og:description" content="' . esc_attr(wp_trim_words($description, 30)) . '" />' . "\n";
        echo '<meta property="og:url" content="' . esc_url($url) . '" />' . "\n";
        echo '<meta property="og:site_name" content="' . esc_attr($site_name) . '" />' . "\n";
        echo '<meta property="og:image" content="' . esc_url($image) . '" />' . "\n";

        // Twitter Card meta tags
        echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
        echo '<meta name="twitter:title" content="' . esc_attr($title) . '" />' . "\n";
        echo '<meta name="twitter:description" content="' . esc_attr(wp_trim_words($description, 30)) . '" />' . "\n";
        echo '<meta name="twitter:image" content="' . esc_url($image) . '" />' . "\n";

        // Article specific tags
        if (is_single()) {
            echo '<meta property="article:published_time" content="' . esc_attr(get_the_date('c')) . '" />' . "\n";
            echo '<meta property="article:modified_time" content="' . esc_attr(get_the_modified_date('c')) . '" />' . "\n";
            echo '<meta property="article:author" content="' . esc_attr(get_the_author()) . '" />' . "\n";
        }
    } else {
        // Homepage or archive
        $title = get_bloginfo('name');
        $description = get_bloginfo('description');
        $url = home_url('/');
        $image = get_template_directory_uri() . '/screenshot.png';

        echo '<meta property="og:type" content="website" />' . "\n";
        echo '<meta property="og:title" content="' . esc_attr($title) . '" />' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($description) . '" />' . "\n";
        echo '<meta property="og:url" content="' . esc_url($url) . '" />' . "\n";
        echo '<meta property="og:image" content="' . esc_url($image) . '" />' . "\n";

        echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
        echo '<meta name="twitter:title" content="' . esc_attr($title) . '" />' . "\n";
        echo '<meta name="twitter:description" content="' . esc_attr($description) . '" />' . "\n";
        echo '<meta name="twitter:image" content="' . esc_url($image) . '" />' . "\n";
    }

    // Additional SEO meta tags
    echo '<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />' . "\n";
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0" />' . "\n";
    echo '<link rel="canonical" href="' . esc_url(get_permalink()) . '" />' . "\n";
}
add_action('wp_head', 'zk_futuristic_add_meta_tags', 1);

/**
 * SEO: Add JSON-LD Schema.org structured data
 */
function zk_futuristic_add_schema_markup() {
    if (is_front_page() || is_home()) {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => 'Zechariah Kasina',
            'jobTitle' => 'Senior DevOps Engineer',
            'worksFor' => array(
                '@type' => 'Organization',
                'name' => 'Amazon Web Services (AWS)'
            ),
            'url' => home_url('/'),
            'sameAs' => array(
                'https://www.linkedin.com/in/zechariahkasina/',
                'https://github.com/zechariahkasina',
                'https://x.com/zechariahkasina',
                'https://community.aws/@zechariah'
            ),
            'alumniOf' => array(
                '@type' => 'EducationalOrganization',
                'name' => 'SRKR Engineering College'
            ),
            'knowsAbout' => array(
                'AWS', 'DevOps', 'Cloud Computing', 'Serverless', 'AI/ML',
                'Docker', 'Kubernetes', 'Python', 'TypeScript', 'Infrastructure as Code'
            ),
            'address' => array(
                '@type' => 'PostalAddress',
                'addressLocality' => 'Lake Oswego',
                'addressRegion' => 'OR',
                'addressCountry' => 'USA'
            )
        );

        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>' . "\n";

        // Website schema
        $website_schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => get_bloginfo('name'),
            'description' => get_bloginfo('description'),
            'url' => home_url('/'),
            'potentialAction' => array(
                '@type' => 'SearchAction',
                'target' => home_url('/?s={search_term_string}'),
                'query-input' => 'required name=search_term_string'
            )
        );

        echo '<script type="application/ld+json">' . wp_json_encode($website_schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>' . "\n";
    }

    if (is_single() && 'post' === get_post_type()) {
        global $post;

        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => get_the_title(),
            'description' => get_the_excerpt(),
            'author' => array(
                '@type' => 'Person',
                'name' => get_the_author()
            ),
            'datePublished' => get_the_date('c'),
            'dateModified' => get_the_modified_date('c'),
            'publisher' => array(
                '@type' => 'Person',
                'name' => get_bloginfo('name')
            ),
            'mainEntityOfPage' => array(
                '@type' => 'WebPage',
                '@id' => get_permalink()
            )
        );

        if (has_post_thumbnail()) {
            $schema['image'] = array(
                '@type' => 'ImageObject',
                'url' => get_the_post_thumbnail_url($post->ID, 'full')
            );
        }

        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>' . "\n";
    }
}
add_action('wp_head', 'zk_futuristic_add_schema_markup', 2);

/**
 * SEO: Generate XML Sitemap
 */
function zk_futuristic_generate_sitemap() {
    if (isset($_GET['sitemap']) && $_GET['sitemap'] === 'xml') {
        header('Content-Type: application/xml; charset=utf-8');

        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Homepage
        echo '<url>' . "\n";
        echo '<loc>' . esc_url(home_url('/')) . '</loc>' . "\n";
        echo '<lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
        echo '<changefreq>weekly</changefreq>' . "\n";
        echo '<priority>1.0</priority>' . "\n";
        echo '</url>' . "\n";

        // Pages
        $pages = get_pages();
        foreach ($pages as $page) {
            echo '<url>' . "\n";
            echo '<loc>' . esc_url(get_permalink($page->ID)) . '</loc>' . "\n";
            echo '<lastmod>' . date('Y-m-d', strtotime($page->post_modified)) . '</lastmod>' . "\n";
            echo '<changefreq>monthly</changefreq>' . "\n";
            echo '<priority>0.8</priority>' . "\n";
            echo '</url>' . "\n";
        }

        // Posts
        $posts = get_posts(array('numberposts' => -1));
        foreach ($posts as $post) {
            echo '<url>' . "\n";
            echo '<loc>' . esc_url(get_permalink($post->ID)) . '</loc>' . "\n";
            echo '<lastmod>' . date('Y-m-d', strtotime($post->post_modified)) . '</lastmod>' . "\n";
            echo '<changefreq>monthly</changefreq>' . "\n";
            echo '<priority>0.6</priority>' . "\n";
            echo '</url>' . "\n";
        }

        echo '</urlset>';
        exit;
    }
}
add_action('init', 'zk_futuristic_generate_sitemap');

/**
 * SEO: Add meta description from excerpt or custom field
 */
function zk_futuristic_meta_description() {
    if (is_singular()) {
        global $post;
        $description = '';

        // Try custom field first
        if (get_post_meta($post->ID, '_meta_description', true)) {
            $description = get_post_meta($post->ID, '_meta_description', true);
        } elseif ($post->post_excerpt) {
            $description = $post->post_excerpt;
        } else {
            $description = wp_trim_words($post->post_content, 30, '...');
        }

        echo '<meta name="description" content="' . esc_attr(strip_tags($description)) . '" />' . "\n";
    } elseif (is_home() || is_front_page()) {
        echo '<meta name="description" content="' . esc_attr(get_bloginfo('description')) . '" />' . "\n";
    } elseif (is_category()) {
        echo '<meta name="description" content="' . esc_attr(strip_tags(category_description())) . '" />' . "\n";
    }
}
add_action('wp_head', 'zk_futuristic_meta_description', 0);

/**
 * Performance: Defer JavaScript loading
 */
function zk_futuristic_defer_scripts($tag, $handle) {
    if (is_admin()) {
        return $tag;
    }

    $defer_scripts = array('zk-futuristic-animations');

    if (in_array($handle, $defer_scripts)) {
        return str_replace(' src', ' defer src', $tag);
    }

    return $tag;
}
add_filter('script_loader_tag', 'zk_futuristic_defer_scripts', 10, 2);

/**
 * Accessibility: Add skip link target
 */
function zk_futuristic_skip_link_focus_fix() {
    ?>
    <script>
    /(trident|msie)/i.test(navigator.userAgent) && document.getElementById && window.addEventListener && window.addEventListener("hashchange", function() {
        var t, e = location.hash.substring(1);
        /^[A-z0-9_-]+$/.test(e) && (t = document.getElementById(e)) && (/^(?:a|select|input|button|textarea)$/i.test(t.tagName) || (t.tabIndex = -1), t.focus())
    }, !1);
    </script>
    <?php
}
add_action('wp_print_footer_scripts', 'zk_futuristic_skip_link_focus_fix');
