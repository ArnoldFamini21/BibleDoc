<?php
/**
 * The main template file
 *
 * @package Bibledoc_Modern
 */

get_header();
?>

<main id="primary" class="site-main">
    
    <?php if ( have_posts() ) : ?>

        <div class="content-section">
            <div class="section-header">
                <div>
                    <h2 class="section-title">
                        <?php
                        if ( is_home() && ! is_front_page() ) :
                            single_post_title();
                        elseif ( is_archive() ) :
                            the_archive_title();
                        elseif ( is_search() ) :
                            printf( esc_html__( 'Search Results for: %s', 'bibledoc-modern' ), '<span>' . get_search_query() . '</span>' );
                        else :
                            esc_html_e( 'Latest Posts', 'bibledoc-modern' );
                        endif;
                        ?>
                    </h2>
                    <?php
                    if ( is_archive() ) {
                        the_archive_description( '<div class="archive-description">', '</div>' );
                    }
                    ?>
                </div>

                <div class="filter-controls">
                    <!-- Category Filter -->
                    <select class="filter-select" aria-label="<?php esc_attr_e( 'Filter by category', 'bibledoc-modern' ); ?>">
                        <option value="all"><?php esc_html_e( 'All Categories', 'bibledoc-modern' ); ?></option>
                        <?php
                        $categories = get_categories();
                        $current_category = get_query_var( 'post_category' );
                        foreach ( $categories as $category ) {
                            printf(
                                '<option value="%s"%s>%s</option>',
                                esc_attr( $category->term_id ),
                                selected( $current_category, $category->term_id, false ),
                                esc_html( $category->name )
                            );
                        }
                        ?>
                    </select>

                    <!-- Sort Options -->
                    <select class="sort-select" aria-label="<?php esc_attr_e( 'Sort posts', 'bibledoc-modern' ); ?>">
                        <?php
                        $current_sort = get_query_var( 'post_sort' );
                        ?>
                        <option value="newest" <?php selected( $current_sort, 'newest' ); ?>><?php esc_html_e( 'Newest First', 'bibledoc-modern' ); ?></option>
                        <option value="oldest" <?php selected( $current_sort, 'oldest' ); ?>><?php esc_html_e( 'Oldest First', 'bibledoc-modern' ); ?></option>
                        <option value="popular" <?php selected( $current_sort, 'popular' ); ?>><?php esc_html_e( 'Most Popular', 'bibledoc-modern' ); ?></option>
                    </select>

                    <!-- View Toggle -->
                    <div class="view-toggle">
                        <button class="view-grid active" aria-label="<?php esc_attr_e( 'Grid view', 'bibledoc-modern' ); ?>">⊞</button>
                        <button class="view-list" aria-label="<?php esc_attr_e( 'List view', 'bibledoc-modern' ); ?>">☰</button>
                    </div>
                </div>
            </div>

            <!-- Posts Grid -->
            <div class="posts-grid">
                <?php
                while ( have_posts() ) :
                    the_post();
                    ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'card' ); ?>>
                        <div class="card-content">
                            
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="post-thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail( 'medium' ); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <!-- Post Meta -->
                            <div class="post-meta">
                                <?php
                                $categories = get_the_category();
                                if ( ! empty( $categories ) ) {
                                    echo '<span class="post-category">' . esc_html( $categories[0]->name ) . '</span>';
                                }
                                ?>
                                
                                <span class="post-date">
                                    <span aria-hidden="true">📅</span>
                                    <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                                        <?php echo esc_html( get_the_date() ); ?>
                                    </time>
                                </span>

                                <span class="post-author">
                                    <span aria-hidden="true">👤</span>
                                    <?php the_author(); ?>
                                </span>

                                <span class="post-reading-time">
                                    <span aria-hidden="true">⏱</span>
                                    <?php echo esc_html( bibledoc_reading_time() ); ?> min read
                                </span>
                            </div>

                            <!-- Post Title -->
                            <h3 class="card-title">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h3>

                            <!-- Post Excerpt -->
                            <div class="card-excerpt">
                                <?php the_excerpt(); ?>
                            </div>

                            <!-- Card Footer -->
                            <div class="card-footer">
                                <div class="card-views">
                                    <span aria-hidden="true">👁</span>
                                    <span class="view-count"><?php echo esc_html( number_format( bibledoc_get_post_views( get_the_ID() ) ) ); ?></span> 
                                    <?php esc_html_e( 'views', 'bibledoc-modern' ); ?>
                                </div>

                                <!-- Social Share -->
                                <?php bibledoc_social_share(); ?>
                            </div>

                        </div>
                    </article>

                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <?php
            the_posts_pagination( array(
                'mid_size'  => 2,
                'prev_text' => __( '← Previous', 'bibledoc-modern' ),
                'next_text' => __( 'Next →', 'bibledoc-modern' ),
                'class'     => 'pagination',
            ) );
            ?>

        </div>

    <?php else : ?>

        <div class="content-section">
            <div class="no-results">
                <h2><?php esc_html_e( 'Nothing Found', 'bibledoc-modern' ); ?></h2>
                <p><?php esc_html_e( 'It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'bibledoc-modern' ); ?></p>
                <?php get_search_form(); ?>
            </div>
        </div>

    <?php endif; ?>

    <?php if ( is_front_page() ) : ?>
        <!-- Popular Categories Section -->
        <div class="content-section">
            <div class="section-header">
                <h2 class="section-title"><?php esc_html_e( 'Popular Categories', 'bibledoc-modern' ); ?></h2>
            </div>

            <div class="category-grid">
                <?php
                $categories = get_categories( array(
                    'orderby' => 'count',
                    'order'   => 'DESC',
                    'number'  => 6,
                ) );

                foreach ( $categories as $category ) :
                    $recent_posts = new WP_Query( array(
                        'cat'            => $category->term_id,
                        'posts_per_page' => 5,
                    ) );
                    ?>

                    <div class="category-card">
                        <h3 class="category-title">
                            <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>">
                                <?php echo esc_html( $category->name ); ?>
                            </a>
                        </h3>

                        <?php if ( $recent_posts->have_posts() ) : ?>
                            <ul class="category-items">
                                <?php while ( $recent_posts->have_posts() ) : $recent_posts->the_post(); ?>
                                    <li class="category-item">
                                        <a href="<?php the_permalink(); ?>">
                                            <span><?php the_title(); ?></span>
                                            <span class="item-views">
                                                <?php echo esc_html( number_format( bibledoc_get_post_views( get_the_ID() ) ) ); ?> views
                                            </span>
                                        </a>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                            <?php wp_reset_postdata(); ?>
                        <?php endif; ?>
                    </div>

                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

</main>

<?php
get_footer();
