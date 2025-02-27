<?php
/**
 * Custom search form
 *
 * @package Atrawi
 * @since 1.0.0
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label class="screen-reader-text"><?php _e('Search for:', 'atrawi'); ?></label>
    <div class="flex relative">
        <input type="search" class="search-field border border-gray-300 px-4 py-2 rounded-md w-full" 
               placeholder="<?php echo esc_attr_x('Search &hellip;', 'placeholder', 'atrawi'); ?>" 
               value="<?php echo get_search_query(); ?>" name="s" />
        <button type="submit" class="search-submit absolute right-0 top-0 h-full px-4 bg-gray-800 text-white rounded-r-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <span class="screen-reader-text"><?php echo _x('Search', 'submit button', 'atrawi'); ?></span>
        </button>
    </div>
</form>