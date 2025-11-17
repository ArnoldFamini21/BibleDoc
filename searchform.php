<?php
/**
 * Custom search form
 *
 * @package Bibledoc_Modern
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label>
        <span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'bibledoc-modern' ); ?></span>
        <input type="search" 
               class="search-input" 
               placeholder="<?php echo esc_attr_x( 'Search entire website...', 'placeholder', 'bibledoc-modern' ); ?>" 
               value="<?php echo get_search_query(); ?>" 
               name="s" 
               required />
    </label>
    <button type="submit" class="search-submit">
        <span class="screen-reader-text"><?php esc_html_e( 'Search', 'bibledoc-modern' ); ?></span>
        <span aria-hidden="true">🔍</span>
    </button>
</form>
