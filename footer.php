    <!-- Footer -->
    <footer class="site-footer">
        <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
            <div class="footer-widgets">
                <div class="footer-container">
                    <?php dynamic_sidebar( 'footer-1' ); ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="footer-content">
            <p>
                <?php
                printf(
                    /* translators: 1: Site name, 2: Current year */
                    esc_html__( 'Copyright © %1$s %2$s', 'bibledoc-modern' ),
                    esc_html( get_bloginfo( 'name' ) ),
                    date( 'Y' )
                );
                ?>
            </p>

            <?php
            if ( has_nav_menu( 'footer' ) ) {
                wp_nav_menu( array(
                    'theme_location' => 'footer',
                    'menu_class'     => 'footer-menu',
                    'container'      => 'nav',
                    'depth'          => 1,
                ) );
            }
            ?>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button class="back-to-top" aria-label="<?php esc_attr_e( 'Back to top', 'bibledoc-modern' ); ?>">
        ↑
    </button>

    <?php wp_footer(); ?>
</body>
</html>
