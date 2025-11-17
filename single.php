<?php
/**
 * The template for displaying single posts
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

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post' ); ?>>
            
            <div class="content-section">
                <div class="post-container">
                    <div class="post-content-area">

                        <header class="entry-header">
                            <?php
                            $categories = get_the_category();
                            if ( ! empty( $categories ) ) :
                                ?>
                                <div class="post-categories">
                                    <?php foreach ( $categories as $category ) : ?>
                                        <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" class="post-category">
                                            <?php echo esc_html( $category->name ); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

                            <div class="post-meta">
                                <span class="post-author">
                                    <span aria-hidden="true">👤</span>
                                    <?php
                                    printf(
                                        /* translators: %s: Author name */
                                        esc_html__( 'By %s', 'bibledoc-modern' ),
                                        '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>'
                                    );
                                    ?>
                                </span>

                                <span class="post-date">
                                    <span aria-hidden="true">📅</span>
                                    <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                                        <?php echo esc_html( get_the_date() ); ?>
                                    </time>
                                </span>

                                <span class="post-reading-time">
                                    <span aria-hidden="true">⏱</span>
                                    <?php echo esc_html( bibledoc_reading_time() ); ?> min read
                                </span>

                                <span class="post-views">
                                    <span aria-hidden="true">👁</span>
                                    <?php echo esc_html( number_format( bibledoc_get_post_views( get_the_ID() ) ) ); ?> views
                                </span>
                            </div>

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

                        <footer class="entry-footer">
                            <?php
                            $tags_list = get_the_tag_list( '', ' ' );
                            if ( $tags_list ) :
                                ?>
                                <div class="post-tags">
                                    <span class="tags-label"><?php esc_html_e( 'Tags:', 'bibledoc-modern' ); ?></span>
                                    <?php echo $tags_list; ?>
                                </div>
                            <?php endif; ?>

                            <?php bibledoc_social_sharing(); ?>
                        </footer>

                        <?php
                        // Author bio
                        if ( is_single() && get_the_author_meta( 'description' ) ) :
                            ?>
                            <div class="author-bio">
                                <div class="author-avatar">
                                    <?php echo get_avatar( get_the_author_meta( 'ID' ), 80 ); ?>
                                </div>
                                <div class="author-info">
                                    <h3 class="author-name">
                                        <?php
                                        printf(
                                            /* translators: %s: Author name */
                                            esc_html__( 'About %s', 'bibledoc-modern' ),
                                            esc_html( get_the_author() )
                                        );
                                        ?>
                                    </h3>
                                    <p class="author-description"><?php echo wp_kses_post( get_the_author_meta( 'description' ) ); ?></p>
                                    <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="author-link">
                                        <?php esc_html_e( 'View all posts →', 'bibledoc-modern' ); ?>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php
                        // Post navigation
                        the_post_navigation( array(
                            'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'bibledoc-modern' ) . '</span> <span class="nav-title">%title</span>',
                            'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'bibledoc-modern' ) . '</span> <span class="nav-title">%title</span>',
                        ) );
                        ?>

                        <?php
                        // Related posts
                        $related_posts = new WP_Query( array(
                            'category__in'   => wp_get_post_categories( get_the_ID() ),
                            'post__not_in'   => array( get_the_ID() ),
                            'posts_per_page' => 3,
                            'orderby'        => 'rand',
                        ) );

                        if ( $related_posts->have_posts() ) :
                            ?>
                            <div class="related-posts">
                                <h3 class="related-title"><?php esc_html_e( 'You might also like', 'bibledoc-modern' ); ?></h3>
                                <div class="posts-grid">
                                    <?php
                                    while ( $related_posts->have_posts() ) :
                                        $related_posts->the_post();
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

                                                <h4 class="card-title">
                                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                </h4>

                                                <div class="card-views">
                                                    <span aria-hidden="true">👁</span>
                                                    <span class="view-count"><?php echo esc_html( number_format( bibledoc_get_post_views( get_the_ID() ) ) ); ?></span> views
                                                </div>
                                            </div>
                                        </article>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                            <?php
                            wp_reset_postdata();
                        endif;
                        ?>

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
