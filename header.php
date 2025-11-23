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
    
    <div class="hero-wrapper" style="background-image: url('<?php echo esc_url($bg_image); ?>'); background-size: 100% auto; background-position: center top; background-repeat: no-repeat; background-color: #1a1d21; position: relative; height: 550px; overflow: hidden; display: flex; align-items: center;">
        <div class="hero-overlay" style="position: absolute; top:0; left:0; right:0; bottom:0; background: linear-gradient(90deg, rgba(10,10,20,0.9) 0%, rgba(10,10,20,0.7) 50%, rgba(10,10,20,0.3) 100%); z-index: 1;"></div>
        
        <div class="hero-grid" style="max-width: 1200px; width: 100%; margin: 0 auto; padding: 0 2rem; position: relative; z-index: 10; height: 100%; display: flex;">
            
            <div class="hero-col-text" style="flex: 1; display: flex; flex-direction: column; justify-content: center; padding-bottom: 50px; z-index: 20;">
                <h1 class="hero-title" style="font-family: 'Outfit', sans-serif; font-size: 4rem; color: #ffffff !important; line-height: 1.1; margin-bottom: 1rem; font-weight: 700; text-shadow: 0 2px 10px rgba(0,0,0,0.5);"><?php echo esc_html( get_theme_mod( 'hero_title', 'Looking for answers?' ) ); ?></h1>
                <p class="hero-description" style="font-family: 'Georgia', serif; font-style: italic; color: #eeeeee !important; font-size: 1.5rem; margin-bottom: 2.5rem; font-weight: 300;"><?php echo esc_html( get_theme_mod( 'hero_subtitle', 'I help friends to understand their Bibles!' ) ); ?></p>
                
                <div class="hero-search" style="max-width: 500px;">
                    <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="position: relative;">
                        <input type="search" class="search-field" placeholder="Search entire website..." value="<?php echo get_search_query(); ?>" name="s" style="width: 100%; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); padding: 1rem 1.5rem; color: #fff; border-radius: 4px;" />
                    </form>
                </div>
            </div>

            <div class="hero-col-image" style="position: absolute; bottom: 0; right: 0; z-index: 5;">
                <?php
                $hero_person = get_theme_mod( 'hero_image', 'https://png.pngtree.com/png-vector/20230928/ourmid/pngtree-man-in-suit-png-image_10149892.png' );
                if ( $hero_person ) : ?>
                    <img src="<?php echo esc_url( $hero_person ); ?>" alt="Person" style="display: block; max-height: 450px; height: auto; width: auto; filter: drop-shadow(-10px 0 20px rgba(0,0,0,0.5));">
                <?php endif; ?>
            </div>

        </div>
    </div>
<?php else : ?>
    <?php bibledoc_breadcrumb(); ?>
<?php endif; ?>
