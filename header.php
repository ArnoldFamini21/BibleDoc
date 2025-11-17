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

<!-- Reading Progress Bar -->
<div class="reading-progress"></div>

<!-- Navigation -->
<nav class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'bibledoc-modern' ); ?>">
    <div class="nav-container">
        <div class="site-branding">
            <?php if ( has_custom_logo() ) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <h1 class="site-title">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                        <?php bloginfo( 'name' ); ?>
                    </a>
                </h1>
            <?php endif; ?>
        </div>

        <div class="nav-menu-wrapper">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'menu_class'     => 'primary-menu',
                'container'      => false,
                'fallback_cb'    => 'bibledoc_default_menu',
            ) );
            ?>

            <!-- Dark Mode Toggle -->
            <button class="dark-mode-toggle" aria-label="<?php esc_attr_e( 'Toggle dark mode', 'bibledoc-modern' ); ?>">
                🌙
            </button>

            <!-- Support Button -->
            <?php
            $support_url = get_theme_mod( 'support_url', '#support' );
            ?>
            <a href="<?php echo esc_url( $support_url ); ?>" class="support-btn">
                <?php esc_html_e( 'Support', 'bibledoc-modern' ); ?>
            </a>

            <!-- Mobile Menu Toggle -->
            <button class="mobile-menu-toggle" aria-label="<?php esc_attr_e( 'Toggle menu', 'bibledoc-modern' ); ?>" aria-expanded="false">
                ☰
            </button>
        </div>
    </div>
</nav>

<?php if ( is_front_page() ) : ?>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h1><?php echo esc_html( get_theme_mod( 'hero_title', 'Looking for answers?' ) ); ?></h1>
            <p><?php echo esc_html( get_theme_mod( 'hero_subtitle', 'I help friends to understand their Bibles!' ) ); ?></p>
            
            <div class="search-container">
                <?php get_search_form(); ?>
            </div>
        </div>

        <div class="hero-image">
            <?php
            $hero_image = get_theme_mod( 'hero_image' );
            if ( $hero_image ) :
                ?>
                <img src="<?php echo esc_url( $hero_image ); ?>" alt="<?php esc_attr_e( 'Hero Image', 'bibledoc-modern' ); ?>">
            <?php else : ?>
                <div style="width: 100%; height: 450px; background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 5rem; border: 1px solid #e5e7eb; position: relative;">
                    <span style="animation: bounce 2s ease-in-out infinite;">📖</span>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php else : ?>
    <!-- Breadcrumb -->
    <?php bibledoc_breadcrumb(); ?>
<?php endif; ?>
