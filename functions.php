<?php
/**
 * Bibledoc Modern Theme Functions
 *
 * @package Bibledoc_Modern
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Theme Setup
 */
function bibledoc_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 1200, 630, true );

    // Register navigation menus
    register_nav_menus( array(
        'primary' => esc_html__( 'Primary Menu', 'bibledoc-modern' ),
        'footer'  => esc_html__( 'Footer Menu', 'bibledoc-modern' ),
    ) );

    // Switch default core markup to output valid HTML5
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Add theme support for selective refresh for widgets
    add_theme_support( 'customize-selective-refresh-widgets' );

    // Add support for editor styles
    add_theme_support( 'editor-styles' );

    // Add support for responsive embeds
    add_theme_support( 'responsive-embeds' );
}
add_action( 'after_setup_theme', 'bibledoc_setup' );

/**
 * Set the content width
 */
function bibledoc_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'bibledoc_content_width', 1200 );
}
add_action( 'after_setup_theme', 'bibledoc_content_width', 0 );

/**
 * Register widget areas
 */
function bibledoc_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'bibledoc-modern' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Add widgets here.', 'bibledoc-modern' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer', 'bibledoc-modern' ),
        'id'            => 'footer-1',
        'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'bibledoc-modern' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'bibledoc_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function bibledoc_scripts() {
    // Main stylesheet
    wp_enqueue_style( 'bibledoc-style', get_stylesheet_uri(), array(), '1.0.0' );

    // Custom JavaScript
    wp_enqueue_script( 'bibledoc-script', get_template_directory_uri() . '/js/script.js', array(), '1.0.0', true );

    // Localize script for AJAX
    wp_localize_script( 'bibledoc-script', 'bibledocAjax', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'bibledoc-nonce' )
    ) );

    // Comment reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'bibledoc_scripts' );

/**
 * Calculate reading time
 */
function bibledoc_reading_time() {
    $content = get_post_field( 'post_content', get_the_ID() );
    $word_count = str_word_count( strip_tags( $content ) );
    $reading_time = ceil( $word_count / 200 );
    
    return $reading_time;
}

/**
 * Get post views count
 */
function bibledoc_get_post_views( $post_id ) {
    $count_key = 'post_views_count';
    $count = get_post_meta( $post_id, $count_key, true );
    
    if ( $count == '' ) {
        delete_post_meta( $post_id, $count_key );
        add_post_meta( $post_id, $count_key, '0' );
        return 0;
    }
    
    return $count;
}

/**
 * Set post views count
 */
function bibledoc_set_post_views( $post_id ) {
    $count_key = 'post_views_count';
    $count = get_post_meta( $post_id, $count_key, true );
    
    if ( $count == '' ) {
        $count = 0;
        delete_post_meta( $post_id, $count_key );
        add_post_meta( $post_id, $count_key, '0' );
    } else {
        $count++;
        update_post_meta( $post_id, $count_key, $count );
    }
}

/**
 * Track post views on single posts
 */
function bibledoc_track_post_views( $post_id ) {
    if ( ! is_single() ) return;
    if ( empty( $post_id ) ) {
        global $post;
        $post_id = $post->ID;
    }
    bibledoc_set_post_views( $post_id );
}
add_action( 'wp_head', 'bibledoc_track_post_views' );

/**
 * Custom excerpt length
 */
function bibledoc_excerpt_length( $length ) {
    return 30;
}
add_filter( 'excerpt_length', 'bibledoc_excerpt_length', 999 );

/**
 * Custom excerpt more
 */
function bibledoc_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'bibledoc_excerpt_more' );

/**
 * Add social share buttons
 */
function bibledoc_social_share() {
    $post_url = urlencode( get_permalink() );
    $post_title = urlencode( get_the_title() );
    
    $twitter_url = 'https://twitter.com/intent/tweet?text=' . $post_title . '&url=' . $post_url;
    $facebook_url = 'https://www.facebook.com/sharer/sharer.php?u=' . $post_url;
    $linkedin_url = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $post_url . '&title=' . $post_title;
    
    echo '<div class="social-share">';
    echo '<a href="' . esc_url( $twitter_url ) . '" target="_blank" rel="noopener" aria-label="Share on Twitter">𝕏</a>';
    echo '<a href="' . esc_url( $facebook_url ) . '" target="_blank" rel="noopener" aria-label="Share on Facebook">f</a>';
    echo '<a href="' . esc_url( $linkedin_url ) . '" target="_blank" rel="noopener" aria-label="Share on LinkedIn">in</a>';
    echo '</div>';
}

/**
 * Custom breadcrumb function
 */
function bibledoc_breadcrumb() {
    if ( is_front_page() ) {
        return;
    }
    
    echo '<div class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">';
    echo '<a href="' . esc_url( home_url( '/' ) ) . '" itemprop="item"><span itemprop="name">Home</span></a>';
    
    if ( is_category() || is_single() ) {
        echo '<span class="separator">/</span>';
        $categories = get_the_category();
        if ( ! empty( $categories ) ) {
            $category = $categories[0];
            echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $category->name ) . '</span></a>';
        }
        
        if ( is_single() ) {
            echo '<span class="separator">/</span>';
            echo '<span itemprop="name">' . get_the_title() . '</span>';
        }
    } elseif ( is_page() ) {
        echo '<span class="separator">/</span>';
        echo '<span itemprop="name">' . get_the_title() . '</span>';
    } elseif ( is_search() ) {
        echo '<span class="separator">/</span>';
        echo '<span itemprop="name">Search Results for: ' . get_search_query() . '</span>';
    } elseif ( is_archive() ) {
        echo '<span class="separator">/</span>';
        echo '<span itemprop="name">' . get_the_archive_title() . '</span>';
    }
    
    echo '</div>';
}

/**
 * Add custom query vars for filtering
 */
function bibledoc_query_vars( $vars ) {
    $vars[] = 'post_sort';
    $vars[] = 'post_category';
    return $vars;
}
add_filter( 'query_vars', 'bibledoc_query_vars' );

/**
 * Modify main query for sorting and filtering
 */
function bibledoc_pre_get_posts( $query ) {
    if ( ! is_admin() && $query->is_main_query() && is_home() ) {
        // Handle sorting
        $sort = get_query_var( 'post_sort' );
        
        switch ( $sort ) {
            case 'popular':
                $query->set( 'meta_key', 'post_views_count' );
                $query->set( 'orderby', 'meta_value_num' );
                $query->set( 'order', 'DESC' );
                break;
            case 'oldest':
                $query->set( 'order', 'ASC' );
                break;
            default:
                $query->set( 'order', 'DESC' );
        }
        
        // Handle category filtering
        $category = get_query_var( 'post_category' );
        if ( $category && $category != 'all' ) {
            $query->set( 'cat', $category );
        }
    }
}
add_action( 'pre_get_posts', 'bibledoc_pre_get_posts' );

/**
 * Add featured posts column in admin
 */
function bibledoc_posts_columns( $columns ) {
    $columns['views'] = 'Views';
    return $columns;
}
add_filter( 'manage_posts_columns', 'bibledoc_posts_columns' );

function bibledoc_posts_custom_column( $column, $post_id ) {
    if ( $column === 'views' ) {
        echo bibledoc_get_post_views( $post_id );
    }
}
add_action( 'manage_posts_custom_column', 'bibledoc_posts_custom_column', 10, 2 );

/**
 * Make views column sortable
 */
function bibledoc_posts_sortable_columns( $columns ) {
    $columns['views'] = 'views';
    return $columns;
}
add_filter( 'manage_edit-post_sortable_columns', 'bibledoc_posts_sortable_columns' );

/**
 * Customize login page
 */
function bibledoc_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/logo.png);
            height: 80px;
            width: 320px;
            background-size: contain;
            background-repeat: no-repeat;
            padding-bottom: 30px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'bibledoc_login_logo' );

/**
 * Change login logo URL
 */
function bibledoc_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'bibledoc_login_logo_url' );

/**
 * Add theme customizer options
 */
function bibledoc_customize_register( $wp_customize ) {
    // Add section for hero
    $wp_customize->add_section( 'bibledoc_hero', array(
        'title'    => __( 'Hero Section', 'bibledoc-modern' ),
        'priority' => 30,
    ) );

    // Hero title
    $wp_customize->add_setting( 'hero_title', array(
        'default'           => 'Looking for answers?',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'hero_title', array(
        'label'   => __( 'Hero Title', 'bibledoc-modern' ),
        'section' => 'bibledoc_hero',
        'type'    => 'text',
    ) );

    // Hero subtitle
    $wp_customize->add_setting( 'hero_subtitle', array(
        'default'           => 'I help friends to understand their Bibles!',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'hero_subtitle', array(
        'label'   => __( 'Hero Subtitle', 'bibledoc-modern' ),
        'section' => 'bibledoc_hero',
        'type'    => 'text',
    ) );

    // Hero image
    $wp_customize->add_setting( 'hero_image', array(
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'hero_image', array(
        'label'   => __( 'Hero Image', 'bibledoc-modern' ),
        'section' => 'bibledoc_hero',
    ) ) );

    // Support button URL
    $wp_customize->add_setting( 'support_url', array(
        'default'           => '#support',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( 'support_url', array(
        'label'   => __( 'Support Button URL', 'bibledoc-modern' ),
        'section' => 'bibledoc_hero',
        'type'    => 'url',
    ) );
}
add_action( 'customize_register', 'bibledoc_customize_register' );

/**
 * Add async/defer to scripts
 */
function bibledoc_script_loader_tag( $tag, $handle ) {
    if ( 'bibledoc-script' === $handle ) {
        return str_replace( ' src', ' defer src', $tag );
    }
    return $tag;
}
add_filter( 'script_loader_tag', 'bibledoc_script_loader_tag', 10, 2 );
/**
 * Enqueue Google Fonts
 */
function bibledoc_fonts() {
    wp_enqueue_style( 'bibledoc-google-fonts', 'https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap', array(), null );
}
add_action( 'wp_enqueue_scripts', 'bibledoc_fonts' );
