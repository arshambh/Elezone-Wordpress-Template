<?php
/**
 * Search form (matches the header search markup).
 *
 * @package Elezone
 */
?>
<form role="search" class="search_wrap active mt-lg-0" id="ajax-form-search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="text" id="search-form-text" class="search-field" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" placeholder="کلید واژه مورد نظر ...">
	<button type="submit"><i class="fal fa-search"></i></button>
	<div id="ajax-search-result"></div>
</form>
