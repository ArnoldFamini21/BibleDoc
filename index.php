<?php
/**
 * The main template file
 */

get_header();
?>

<main id="primary" class="site-main">
    
    <?php if ( have_posts() ) : ?>

        <div class="content-section">
            <div class="section-header">
                <h2 class="section-title-red">
                    <?php
                    if ( is_archive() ) :
                        the_archive_title();
                    elseif ( is_search() ) :
                        printf( esc_html__( 'Search Results for: %s', 'bibledoc-modern' ), get_search_query() );
                    else :
                        esc_html_e( 'Latest work', 'bibledoc-modern' );
                    endif;
                    ?>
                </h2>
            </div>

            <div class="posts-list-grid">
                <?php
                while ( have_posts() ) :
                    the_post();
                    ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'list-item' ); ?>>
                        <h3 class="list-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <div class="list-meta">
                            <span class="view-count"><?php echo bibledoc_get_post_views( get_the_ID() ); ?> VIEWS</span>
                        </div>
                    </article>

                <?php endwhile; ?>
            </div>

            <?php
            the_posts_pagination( array(
                'prev_text' => __( '← Previous', 'bibledoc-modern' ),
                'next_text' => __( 'Next →', 'bibledoc-modern' ),
                'class'     => 'pagination',
            ) );
            ?>
        </div>

    <?php else : ?>
        <div class="content-section">
            <p><?php esc_html_e( 'Nothing found.', 'bibledoc-modern' ); ?></p>
        </div>
    <?php endif; ?>

    <?php if ( is_front_page() ) : ?>
        <div class="content-section">
            <div class="section-header">
                <h2 class="section-title-red">Articles</h2>
            </div>
            <div class="posts-list-grid">
               <?php 
               $args = array( 'posts_per_page' => 6, 'orderby' => 'rand' );
               $random_query = new WP_Query( $args );
               while ( $random_query->have_posts() ) : $random_query->the_post(); ?>
                    <article class="list-item">
                        <h3 class="list-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <div class="list-meta"><span class="view-count"><?php echo bibledoc_get_post_views( get_the_ID() ); ?> VIEWS</span></div>
                    </article>
               <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </div>
    <?php endif; ?>

</main>

<?php
get_footer();
