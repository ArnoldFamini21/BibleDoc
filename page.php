<?php
/**
 * The template for displaying all pages
 *
 * @package Bibledoc_Modern
 */

get_header();
?>

<main id="primary" class="site-main">

    <?php
    while ( have_posts() ) :
        the_post();
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'single-page' ); ?>>
            
            <div class="content-section">
                <div class="post-container">
                    <div class="post-content-area">

                        <header class="entry-header">
                            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="post-thumbnail">
                                    <?php the_post_thumbnail( 'large' ); ?>
                                </div>
                            <?php endif; ?>
                        </header>

                        <div class="entry-content">
                            <?php
                            the_content();

                            wp_link_pages( array(
                                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'bibledoc-modern' ),
                                'after'  => '</div>',
                            ) );
                            ?>
                        </div>

                        <?php
                        // Comments
                        if ( comments_open() || get_comments_number() ) :
                            comments_template();
                        endif;
                        ?>

                    </div>

                    <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
                        <aside class="sidebar">
                            <?php dynamic_sidebar( 'sidebar-1' ); ?>
                        </aside>
                    <?php endif; ?>

                </div>
            </div>

        </article>

    <?php endwhile; ?>

</main>

<?php
get_footer();
