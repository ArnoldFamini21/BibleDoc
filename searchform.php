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
        <svg aria-hidden="true" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
    </button>
</form>
