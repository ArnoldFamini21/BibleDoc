<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'bibledoc-modern' ); ?></a>

<nav class="main-navigation" role="navigation">
    <div class="nav-container">
        <div class="site-branding">
            <h1 class="site-title">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <?php bloginfo( 'name' ); ?>
                </a>
            </h1>
        </div>

        <div class="nav-menu-wrapper">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'menu_class'     => 'primary-menu',
                'container'      => false,
                'fallback_cb'    => false,
            ) );
            ?>
            <a href="<?php echo esc_url( get_theme_mod( 'support_url', '#support' ) ); ?>" class="support-btn">
                <?php esc_html_e( 'Support', 'bibledoc-modern' ); ?>
            </a>
        </div>
    </div>
</nav>

<?php if ( is_front_page() ) : ?>
    <?php 
    $bg_image = get_theme_mod('hero_bg_image', 'https://images.unsplash.com/photo-1455390582262-044cdead277a?q=80&w=2000&auto=format&fit=crop');
    ?>
    
    <div class="hero-wrapper" style="background-image: url('<?php echo esc_url($bg_image); ?>');">
        <div class="hero-overlay"></div>
        
        <div class="hero-container">
            
            <div class="hero-col-text">
                <h1 class="hero-title"><?php echo esc_html( get_theme_mod( 'hero_title', 'Looking for answers?' ) ); ?></h1>
                <p class="hero-description"><?php echo esc_html( get_theme_mod( 'hero_subtitle', 'I help friends to understand their Bibles!' ) ); ?></p>
                
                <div class="hero-search">
                    <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <input type="search" class="search-field" placeholder="Search entire website..." value="<?php echo get_search_query(); ?>" name="s" />
                    </form>
                </div>
            </div>

            <div class="hero-col-image">
                <?php
                $hero_person = get_theme_mod( 'hero_image', 'https://png.pngtree.com/png-vector/20230928/ourmid/pngtree-man-in-suit-png-image_10149892.png' );
                if ( $hero_person ) : ?>
                    <img src="<?php echo esc_url( $hero_person ); ?>" alt="Person">
                <?php endif; ?>
            </div>

        </div>
    </div>
<?php else : ?>
    <?php bibledoc_breadcrumb(); ?>
<?php endif; ?>
