<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Bibledoc_Modern
 */

get_header();
?>

<main id="primary" class="site-main">
    
    <div class="content-section">
        <div class="error-404 not-found">
            <header class="page-header">
                <h1 class="page-title"><?php esc_html_e( '404 - Page Not Found', 'bibledoc-modern' ); ?></h1>
            </header>

            <div class="page-content">
                <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try searching?', 'bibledoc-modern' ); ?></p>

                <div class="search-container">
                    <?php get_search_form(); ?>
                </div>

                <h2><?php esc_html_e( 'Popular Categories', 'bibledoc-modern' ); ?></h2>
                
                <div class="category-grid">
                    <?php
                    $categories = get_categories( array(
                        'orderby' => 'count',
                        'order'   => 'DESC',
                        'number'  => 6,
                    ) );

                    foreach ( $categories as $category ) :
                        ?>
                        <div class="category-card">
                            <h3 class="category-title">
                                <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>">
                                    <?php echo esc_html( $category->name ); ?>
                                </a>
                            </h3>
                            <p><?php echo esc_html( $category->description ); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>

                <h2><?php esc_html_e( 'Recent Posts', 'bibledoc-modern' ); ?></h2>
                
                <div class="posts-grid">
                    <?php
                    $recent_posts = new WP_Query( array(
                        'posts_per_page' => 6,
                        'post_status'    => 'publish',
                    ) );

                    if ( $recent_posts->have_posts() ) :
                        while ( $recent_posts->have_posts() ) :
                            $recent_posts->the_post();
                            ?>
                            <article class="card">
                                <div class="card-content">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <div class="post-thumbnail">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail( 'medium' ); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                    <h3 class="card-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>

                                    <div class="card-views">
                                        <span aria-hidden="true">👁</span>
                                        <span class="view-count"><?php echo esc_html( number_format( bibledoc_get_post_views( get_the_ID() ) ) ); ?></span> views
                                    </div>
                                </div>
                            </article>
                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>

</main>

<?php
get_footer();
