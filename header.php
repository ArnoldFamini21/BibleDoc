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

<div class="reading-progress"></div>

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
                'fallback_cb'    => false,
            ) );
            ?>

            <button class="dark-mode-toggle" aria-label="<?php esc_attr_e( 'Toggle dark mode', 'bibledoc-modern' ); ?>">
                🌙
            </button>

            <?php
            $support_url = get_theme_mod( 'support_url', '#support' );
            ?>
            <a href="<?php echo esc_url( $support_url ); ?>" class="support-btn">
                <?php esc_html_e( 'Support', 'bibledoc-modern' ); ?>
            </a>

            <button class="mobile-menu-toggle" aria-label="<?php esc_attr_e( 'Toggle menu', 'bibledoc-modern' ); ?>" aria-expanded="false">
                ☰
            </button>
        </div>
    </div>
</nav>

<?php if ( is_front_page() ) : ?>
    <div class="hero-wrapper">
        <div class="hero-shape shape-1"></div>
        <div class="hero-shape shape-2"></div>

        <section class="hero-section">
            <div class="hero-content">
                <div class="hero-badge"><?php esc_html_e( 'Biblical Resources', 'bibledoc-modern' ); ?></div>
                <h1 class="hero-title"><?php echo esc_html( get_theme_mod( 'hero_title', 'Looking for answers?' ) ); ?></h1>
                <p class="hero-description"><?php echo esc_html( get_theme_mod( 'hero_subtitle', 'I help friends to understand their Bibles!' ) ); ?></p>
                
                <div class="search-container hero-search">
                    <?php get_search_form(); ?>
                </div>
                
                <div class="hero-tags">
                    <span>Popular:</span>
                    <a href="#prophecy">Prophecy</a>
                    <a href="#doctrine">Doctrine</a>
                    <a href="#lifestyle">Lifestyle</a>
                </div>
            </div>

            <div class="hero-image-container">
                <div class="hero-blob"></div>
                <?php
                $hero_image = get_theme_mod( 'hero_image' );
                if ( $hero_image ) :
                    ?>
                    <img src="<?php echo esc_url( $hero_image ); ?>" alt="<?php esc_attr_e( 'Hero Image', 'bibledoc-modern' ); ?>" class="hero-img-element">
                <?php else : ?>
                    <div class="hero-placeholder-graphic">
                        <div class="book-icon">📖</div>
                        <div class="graphic-circle"></div>
                        <div class="graphic-dots"></div>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>
<?php else : ?>
    <?php bibledoc_breadcrumb(); ?>
<?php endif; ?>
