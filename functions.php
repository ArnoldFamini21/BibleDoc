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
    // Main stylesheet - use filemtime for cache busting
    wp_enqueue_style( 'bibledoc-style', get_stylesheet_uri(), array(), filemtime( get_template_directory() . '/style.css' ) );

    // Custom JavaScript - use filemtime for cache busting
    wp_enqueue_script( 'bibledoc-script', get_template_directory_uri() . '/script.js', array(), filemtime( get_template_directory() . '/script.js' ), true );

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
    return 25; // 25 words for consistency
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
 * Override site name to BibleDoc.org
 */
function bibledoc_override_bloginfo( $output, $show ) {
    if ( $show === 'name' ) {
        return 'BibleDoc.org';
    }
    return $output;
}
add_filter( 'bloginfo', 'bibledoc_override_bloginfo', 10, 2 );
add_filter( 'bloginfo_url', 'bibledoc_override_bloginfo', 10, 2 );
add_filter( 'option_blogname', function( $blogname ) {
    return 'BibleDoc.org';
}, 10, 1 );

/**
 * Default navigation menu fallback
 */
function bibledoc_default_menu() {
    $menu_items = array(
        'Topics'        => home_url( '/topics/' ),
        'About'         => home_url( '/about/' ),
        'Contact'       => home_url( '/contact/' ),
        'Eugene\'s Blog' => home_url( '/eugenes-blog/' ),
    );

    echo '<ul class="primary-menu">';
    foreach ( $menu_items as $title => $url ) {
        echo '<li><a href="' . esc_url( $url ) . '">' . esc_html( $title ) . '</a></li>';
    }
    echo '</ul>';
}

/**
 * Create default primary menu on theme activation
 */
function bibledoc_create_default_menu() {
    // Check if menu already exists
    $menu_name = 'Primary Menu';
    $menu_exists = wp_get_nav_menu_object( $menu_name );

    if ( ! $menu_exists ) {
        // Create the menu
        $menu_id = wp_create_nav_menu( $menu_name );

        // Menu items to add
        $menu_items = array(
            array( 'title' => 'Topics', 'url' => home_url( '/topics/' ) ),
            array( 'title' => 'About', 'url' => home_url( '/about/' ) ),
            array( 'title' => 'Contact', 'url' => home_url( '/contact/' ) ),
            array( 'title' => 'Eugene\'s Blog', 'url' => home_url( '/eugenes-blog/' ) ),
        );

        // Add menu items
        foreach ( $menu_items as $index => $item ) {
            wp_update_nav_menu_item( $menu_id, 0, array(
                'menu-item-title'    => $item['title'],
                'menu-item-url'      => $item['url'],
                'menu-item-status'   => 'publish',
                'menu-item-position' => $index + 1,
                'menu-item-type'     => 'custom',
            ) );
        }

        // Assign menu to primary location
        $locations = get_theme_mod( 'nav_menu_locations' );
        $locations['primary'] = $menu_id;
        set_theme_mod( 'nav_menu_locations', $locations );
    }
}
add_action( 'after_switch_theme', 'bibledoc_create_default_menu' );

/**
 * WebP Support with Fallbacks
 */
function bibledoc_add_webp_support( $image, $attachment_id, $size ) {
    $uploads = wp_upload_dir();
    $image_path = str_replace( $uploads['baseurl'], $uploads['basedir'], $image[0] );

    if ( file_exists( $image_path ) ) {
        $webp_path = preg_replace( '/\.(jpe?g|png)$/i', '.webp', $image_path );
        $webp_url = preg_replace( '/\.(jpe?g|png)$/i', '.webp', $image[0] );

        if ( file_exists( $webp_path ) ) {
            return array( $webp_url, $image[1], $image[2], $image[3] );
        }
    }

    return $image;
}

/**
 * Add responsive image srcset support
 */
function bibledoc_responsive_image( $attachment_id, $size = 'full', $class = '' ) {
    $image = wp_get_attachment_image_src( $attachment_id, $size );
    $image_srcset = wp_get_attachment_image_srcset( $attachment_id, $size );
    $image_sizes = wp_get_attachment_image_sizes( $attachment_id, $size );
    $alt_text = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );

    if ( $image ) {
        echo '<img src="' . esc_url( $image[0] ) . '" ' .
             'srcset="' . esc_attr( $image_srcset ) . '" ' .
             'sizes="' . esc_attr( $image_sizes ) . '" ' .
             'alt="' . esc_attr( $alt_text ) . '" ' .
             'class="' . esc_attr( $class ) . '" ' .
             'loading="lazy">';
    }
}

/**
 * Get related posts
 */
function bibledoc_get_related_posts( $post_id, $number_posts = 3 ) {
    $post = get_post( $post_id );
    $categories = get_the_category( $post_id );

    if ( ! $categories ) {
        return array();
    }

    $category_ids = array();
    foreach ( $categories as $category ) {
        $category_ids[] = $category->term_id;
    }

    $args = array(
        'category__in'        => $category_ids,
        'post__not_in'        => array( $post_id ),
        'posts_per_page'      => $number_posts,
        'ignore_sticky_posts' => 1,
        'orderby'             => 'rand',
    );

    return new WP_Query( $args );
}

/**
 * Display related posts
 */
function bibledoc_display_related_posts() {
    $related_posts = bibledoc_get_related_posts( get_the_ID(), 3 );

    if ( ! $related_posts->have_posts() ) {
        return;
    }

    ?>
    <section class="related-posts">
        <h3 class="related-posts-title"><?php esc_html_e( 'You might also like', 'bibledoc-modern' ); ?></h3>
        <div class="related-posts-grid">
            <?php while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>
                <article class="related-post-card">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <a href="<?php the_permalink(); ?>" class="related-post-thumbnail">
                            <?php the_post_thumbnail( 'medium' ); ?>
                        </a>
                    <?php endif; ?>
                    <div class="related-post-content">
                        <h4 class="related-post-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h4>
                        <div class="related-post-meta">
                            <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                                <?php echo esc_html( get_the_date() ); ?>
                            </time>
                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
    </section>
    <?php

    wp_reset_postdata();
}

/**
 * Social sharing buttons
 */
function bibledoc_social_sharing() {
    $post_url = urlencode( get_permalink() );
    $post_title = urlencode( get_the_title() );

    ?>
    <div class="social-share">
        <h4 class="social-share-title"><?php esc_html_e( 'Share this article', 'bibledoc-modern' ); ?></h4>
        <div class="social-share-buttons">
            <a href="https://twitter.com/intent/tweet?text=<?php echo $post_title; ?>&url=<?php echo $post_url; ?>"
               target="_blank"
               rel="noopener noreferrer"
               class="share-btn share-twitter"
               aria-label="<?php esc_attr_e( 'Share on Twitter', 'bibledoc-modern' ); ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"></path>
                </svg>
                <span>Twitter</span>
            </a>

            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $post_url; ?>"
               target="_blank"
               rel="noopener noreferrer"
               class="share-btn share-facebook"
               aria-label="<?php esc_attr_e( 'Share on Facebook', 'bibledoc-modern' ); ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
                </svg>
                <span>Facebook</span>
            </a>

            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $post_url; ?>&title=<?php echo $post_title; ?>"
               target="_blank"
               rel="noopener noreferrer"
               class="share-btn share-linkedin"
               aria-label="<?php esc_attr_e( 'Share on LinkedIn', 'bibledoc-modern' ); ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"></path>
                    <circle cx="4" cy="4" r="2"></circle>
                </svg>
                <span>LinkedIn</span>
            </a>
        </div>
    </div>
    <?php
}

/**
 * Inline critical CSS for faster page loads
 */
function bibledoc_inline_critical_css() {
    ?>
    <style id="bibledoc-critical-css">
        /* Critical above-the-fold CSS */
        :root {
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --secondary: #dc2626;
            --dark: #111827;
            --dark-lighter: #1f2937;
            --gray: #374151;
            --gray-light: #6b7280;
            --gray-lighter: #9ca3af;
            --bg-light: #f9fafb;
            --white: #ffffff;
            --border: #e5e7eb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Inter', 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: var(--white);
            color: var(--dark);
            font-size: 18px;
            line-height: 1.7;
            font-weight: 400;
            letter-spacing: -0.01em;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .main-navigation {
            position: sticky;
            top: 0;
            background: var(--white);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .hero-section {
            padding: 4rem 2rem;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        }
    </style>
    <?php
}
add_action( 'wp_head', 'bibledoc_inline_critical_css', 1 );

/**
 * Defer non-critical CSS
 */
function bibledoc_defer_css( $html, $handle ) {
    if ( 'bibledoc-style' === $handle ) {
        $html = str_replace( "rel='stylesheet'", "rel='preload' as='style' onload=\"this.onload=null;this.rel='stylesheet'\"", $html );
        $html .= "<noscript><link rel='stylesheet' href='" . get_stylesheet_uri() . "'></noscript>";
    }
    return $html;
}

/**
 * Minify HTML output (optional - can be resource intensive)
 */
function bibledoc_minify_html( $buffer ) {
    // Only minify if not in debug mode
    if ( ! defined( 'WP_DEBUG' ) || ! WP_DEBUG ) {
        // Remove HTML comments (except IE conditionals)
        $buffer = preg_replace( '/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $buffer );

        // Remove whitespace
        $buffer = preg_replace( '/\s+/', ' ', $buffer );
        $buffer = preg_replace( '/>\s+</', '><', $buffer );
    }

    return $buffer;
}

/**
 * Preload key resources
 */
function bibledoc_preload_resources() {
    ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php
}
add_action( 'wp_head', 'bibledoc_preload_resources', 1 );
