<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Bibledoc_Modern
 */

get_header();
?>

<main id="primary" class="site-main error-404-page">
    <div class="error-404-container">
        <div class="error-404-content">
            <div class="error-404-number">404</div>
            <h1 class="error-404-title"><?php esc_html_e( 'Oops! Page Not Found', 'bibledoc-modern' ); ?></h1>
            <p class="error-404-message">
                <?php esc_html_e( 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'bibledoc-modern' ); ?>
            </p>

            <!-- Search Form -->
            <div class="error-404-search">
                <h2><?php esc_html_e( 'Try searching for what you need', 'bibledoc-modern' ); ?></h2>
                <?php get_search_form(); ?>
            </div>

            <!-- Quick Links -->
            <div class="error-404-links">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
                    <?php esc_html_e( 'Go to Homepage', 'bibledoc-modern' ); ?>
                </a>
                <a href="javascript:history.back()" class="btn btn-secondary">
                    <?php esc_html_e( 'Go Back', 'bibledoc-modern' ); ?>
                </a>
            </div>
        </div>

        <!-- Popular Posts -->
        <?php
        $popular_posts = new WP_Query( array(
            'posts_per_page'      => 6,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => 1,
            'orderby'             => 'comment_count',
            'order'               => 'DESC',
        ) );

        if ( $popular_posts->have_posts() ) :
            ?>
            <section class="error-404-popular">
                <h2><?php esc_html_e( 'Popular Articles', 'bibledoc-modern' ); ?></h2>
                <div class="posts-grid">
                    <?php while ( $popular_posts->have_posts() ) : $popular_posts->the_post(); ?>
                        <article class="post-card">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <a href="<?php the_permalink(); ?>" class="post-thumbnail">
                                    <?php the_post_thumbnail( 'medium' ); ?>
                                </a>
                            <?php endif; ?>

                            <div class="post-content">
                                <div class="post-meta">
                                    <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                                        <?php echo esc_html( get_the_date() ); ?>
                                    </time>
                                    <?php
                                    $categories = get_the_category();
                                    if ( $categories ) :
                                        ?>
                                        <span class="post-category">
                                            <?php echo esc_html( $categories[0]->name ); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <h3 class="post-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>

                                <div class="post-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>

                                <a href="<?php the_permalink(); ?>" class="read-more">
                                    <?php esc_html_e( 'Read More', 'bibledoc-modern' ); ?> →
                                </a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
            </section>
            <?php
            wp_reset_postdata();
        endif;
        ?>
    </div>
</main>

<?php
get_footer();
