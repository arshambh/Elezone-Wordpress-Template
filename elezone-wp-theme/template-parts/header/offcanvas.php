<?php
/**
 * Off-canvas mobile menu.
 *
 * WordPress automatically adds the `menu-item-has-children` class, which the
 * theme's Custom.js relies on to inject the explain-menu arrows.
 *
 * @package Elezone
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="off-canvas-wrap">
	<div class="close-off-canvas-wrap">
		<a href="#" id="of-close-off-canvas">
			<i class="fal fa-times"></i>
		</a>
	</div>
	<div class="off-canvas-inner">
		<div id="of-mobile-nav" class="mobile-menu-wrap">
			<?php if ( has_nav_menu( 'primary' ) ) : ?>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'mobile-menu',
					'depth'          => 0,
					'fallback_cb'    => false,
				) );
				?>
			<?php else : ?>
				<ul class="mobile-menu">
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">خانه</a></li>
				</ul>
			<?php endif; ?>
		</div>
	</div>
</div>
