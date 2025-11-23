<?php
/**
 * Bibledoc Modern Theme Functions
 *
 * @package Bibledoc_Modern
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function bibledoc_setup() {
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 1200, 630, true );

    register_nav_menus( array(
        'primary' => esc_html__( 'Primary Menu', 'bibledoc-modern' ),
        'footer'  => esc_html__( 'Footer Menu', 'bibledoc-modern' ),
    ) );

    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'editor-styles' );
    add_theme_support( 'responsive-embeds' );
}
add_action( 'after_setup_theme', 'bibledoc_setup' );

function bibledoc_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'bibledoc_content_width', 1200 );
}
add_action( 'after_setup_theme', 'bibledoc_content_width', 0 );

function bibledoc_widgets_init() {
    register_sidebar( array(
        'name' => esc_html__( 'Sidebar', 'bibledoc-modern' ),
        'id' => 'sidebar-1',
        'description' => esc_html__( 'Add widgets here.', 'bibledoc-modern' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ) );
    register_sidebar( array(
        'name' => esc_html__( 'Footer', 'bibledoc-modern' ),
        'id' => 'footer-1',
        'description' => esc_html__( 'Add widgets here to appear in your footer.', 'bibledoc-modern' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ) );
}
add_action( 'widgets_init', 'bibledoc_widgets_init' );

/**
 * Enqueue scripts and styles
 * VERSION 1.0.20 - FIX RESPONSIVE CONFLICT
 */
function bibledoc_scripts() {
    wp_enqueue_style( 'bibledoc-style', get_stylesheet_uri(), array(), '1.0.20' ); 
    wp_enqueue_script( 'bibledoc-script', get_template_directory_uri() . '/js/script.js', array(), '1.0.0', true );
    wp_localize_script( 'bibledoc-script', 'bibledocAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce( 'bibledoc-nonce' ) ) );
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'bibledoc_scripts' );

function bibledoc_fonts() {
    wp_enqueue_style( 'bibledoc-google-fonts', 'https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700&family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,400&display=swap', array(), null );
}
add_action( 'wp_enqueue_scripts', 'bibledoc_fonts' );

function bibledoc_reading_time() {
    $content = get_post_field( 'post_content', get_the_ID() );
    $word_count = str_word_count( strip_tags( $content ) );
    return ceil( $word_count / 200 );
}

function bibledoc_get_post_views( $post_id ) {
    $count_key = 'post_views_count';
    $count = get_post_meta( $post_id, $count_key, true );
    return ($count == '') ? '0' : $count;
}

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

function bibledoc_track_post_views( $post_id ) {
    if ( ! is_single() ) return;
    if ( empty( $post_id ) ) {
        global $post;
        $post_id = $post->ID;
    }
    bibledoc_set_post_views( $post_id );
}
add_action( 'wp_head', 'bibledoc_track_post_views' );

function bibledoc_excerpt_length( $length ) { return 20; }
add_filter( 'excerpt_length', 'bibledoc_excerpt_length', 999 );

function bibledoc_excerpt_more( $more ) { return '...'; }
add_filter( 'excerpt_more', 'bibledoc_excerpt_more' );

function bibledoc_social_share() {
    $post_url = urlencode( get_permalink() );
    $post_title = urlencode( get_the_title() );
    echo '<div class="social-share">';
    echo '<a href="https://twitter.com/intent/tweet?text=' . $post_title . '&url=' . $post_url . '" target="_blank">𝕏</a>';
    echo '<a href="https://www.facebook.com/sharer/sharer.php?u=' . $post_url . '" target="_blank">f</a>';
    echo '</div>';
}

function bibledoc_breadcrumb() {
    if ( is_front_page() ) return;
    echo '<div class="breadcrumb">';
    echo '<a href="' . esc_url( home_url( '/' ) ) . '">Home</a>';
    if ( is_category() || is_single() ) {
        echo '<span class="separator">/</span>';
        $categories = get_the_category();
        if ( ! empty( $categories ) ) echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
        if ( is_single() ) echo '<span class="separator">/</span><span>' . get_the_title() . '</span>';
    } elseif ( is_page() ) {
        echo '<span class="separator">/</span><span>' . get_the_title() . '</span>';
    }
    echo '</div>';
}

function bibledoc_customize_register( $wp_customize ) {
    $wp_customize->add_section( 'bibledoc_hero', array( 'title' => __( 'Hero Section', 'bibledoc-modern' ), 'priority' => 30 ) );
    
    $wp_customize->add_setting( 'hero_title', array( 'default' => 'Looking for answers?', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'hero_title', array( 'label' => __( 'Hero Title', 'bibledoc-modern' ), 'section' => 'bibledoc_hero', 'type' => 'text' ) );

    $wp_customize->add_setting( 'hero_subtitle', array( 'default' => 'I help friends to understand their Bibles!', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'hero_subtitle', array( 'label' => __( 'Hero Subtitle', 'bibledoc-modern' ), 'section' => 'bibledoc_hero', 'type' => 'text' ) );

    $wp_customize->add_setting( 'hero_bg_image', array( 'default' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?q=80&w=2000&auto=format', 'sanitize_callback' => 'esc_url_raw' ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'hero_bg_image', array( 'label' => __( 'Background Image (Dark)', 'bibledoc-modern' ), 'section' => 'bibledoc_hero' ) ) );

    $wp_customize->add_setting( 'hero_image', array( 'default' => 'https://png.pngtree.com/png-vector/20230928/ourmid/pngtree-man-in-suit-png-image_10149892.png', 'sanitize_callback' => 'esc_url_raw' ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'hero_image', array( 'label' => __( 'Person Image (Right Side)', 'bibledoc-modern' ), 'section' => 'bibledoc_hero' ) ) );

    $wp_customize->add_setting( 'support_url', array( 'default' => '#support', 'sanitize_callback' => 'esc_url_raw' ) );
    $wp_customize->add_control( 'support_url', array( 'label' => __( 'Support Button URL', 'bibledoc-modern' ), 'section' => 'bibledoc_hero', 'type' => 'url' ) );
}
add_action( 'customize_register', 'bibledoc_customize_register' );

function bibledoc_script_loader_tag( $tag, $handle ) {
    if ( 'bibledoc-script' === $handle ) return str_replace( ' src', ' defer src', $tag );
    return $tag;
}
add_filter( 'script_loader_tag', 'bibledoc_script_loader_tag', 10, 2 );
