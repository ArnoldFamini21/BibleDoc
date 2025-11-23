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

<div id="header-search-bar" class="header-search-bar">
    <div class="search-bar-container">
        <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <input type="search" class="search-field" placeholder="Search website..." value="" name="s" />
            <button type="submit" class="search-submit">Search</button>
        </form>
        <button class="search-close" aria-label="Close search">×</button>
    </div>
</div>

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
            
            <div class="header-actions">
                <button class="header-search-toggle" aria-label="Open search">
                    <span class="search-icon">🔍</span>
                </button>
                
                <a href="<?php echo esc_url( get_theme_mod( 'support_url', '#support' ) ); ?>" class="support-btn desktop-only">
                    <?php esc_html_e( 'Support', 'bibledoc-modern' ); ?>
                </a>

                <button class="mobile-menu-toggle" aria-label="Open menu">
                    <span class="menu-icon">☰</span>
                </button>
            </div>
        </div>
    </div>
</nav>

<?php if ( is_front_page() ) : ?>
    <?php 
    $bg_image = get_theme_mod('hero_bg_image', 'https://images.unsplash.com/photo-1455390582262-044cdead277a?q=80&w=2000&auto=format');
    ?>
    
    <div class="hero-wrapper" style="background-image: url('<?php echo esc_url($bg_image); ?>');">
        <div class="hero-overlay"></div>
        
        <div class="hero-grid">
            <div class="hero-col-text">
                <h1 class="hero-title" style="font-family: 'Outfit', sans-serif; color: #ffffff !important; line-height: 1.1; font-weight: 700; text-shadow: 0 2px 10px rgba(0,0,0,0.5);"><?php echo esc_html( get_theme_mod( 'hero_title', 'Looking for answers?' ) ); ?></h1>
                <p class="hero-description" style="font-family: 'Georgia', serif; font-style: italic; color: #eeeeee !important; font-weight: 300;"><?php echo esc_html( get_theme_mod( 'hero_subtitle', 'I help friends to understand their Bibles!' ) ); ?></p>
            </div>

            <div class="hero-col-image">
                <?php
                $hero_person = get_theme_mod( 'hero_image', 'https://png.pngtree.com/png-vector/20230928/ourmid/pngtree-man-in-suit-png-image_10149892.png' );
                if ( $hero_person ) : ?>
                    <img src="<?php echo esc_url( $hero_person ); ?>" alt="Person" style="filter: drop-shadow(-10px 0 20px rgba(0,0,0,0.5));">
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php else : ?>
    <?php bibledoc_breadcrumb(); ?>
<?php endif; ?>
