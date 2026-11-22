<?php
/**
 * Header template.
 *
 * @package Elezone
 */

$logo_url      = elezone_get_logo_url( 'header' );
$logo_width    = (int) get_theme_mod( 'elezone_logo_width', 120 );
$logo_position = get_theme_mod( 'elezone_logo_position', 'start' );
$logo_img      = '<img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" style="width:' . $logo_width . 'px;height:auto;max-width:100%;" />';
?><!DOCTYPE html>
<html lang="<?php echo esc_attr( get_bloginfo( 'language' ) ); ?>" dir="rtl">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="main_wrap">
	<div class="of-site-mask"></div>

	<?php get_template_part( 'template-parts/header/offcanvas' ); ?>

	<header class="main_header wide_header">
		<div class="header_container">
			<div class="menu_wrapper menu_sticky">
				<div class="container p_relative bg-cudark radius15 py-2 shadow-sm mobnav">
					<div id="navigation" class="of-drop-down of-main-menu" role="navigation">
						<ul class="menu logo-pos-<?php echo esc_attr( $logo_position ); ?>">
							<li class="ml-3">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="current"><?php echo $logo_img; // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
							</li>
							<?php if ( has_nav_menu( 'primary' ) ) : ?>
								<?php
								wp_nav_menu( array(
									'theme_location' => 'primary',
									'container'      => false,
									'items_wrap'     => '%3$s',
									'walker'         => new Elezone_Mega_Menu_Walker(),
									'depth'          => 0,
									'fallback_cb'    => false,
								) );
								?>
							<?php endif; ?>
						</ul>
					</div>
					<div class="m_search align-self-center pt-md-1 pt-2"><i class="fal fa-search"></i></div>
					<div class="is-show mobile-nav-button">
						<?php echo $logo_img; // phpcs:ignore WordPress.Security.EscapeOutput ?>
						<a id="of-trigger" class="icon-wrap pr-3 pt-2" href="#"> <i class="fal fa-bars"></i></a>
					</div>
					<form class="search_wrap mt-lg-0" id="ajax-form-search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<input type="text" id="search-form-text" class="search-field" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" placeholder="کلید واژه مورد نظر ...">
						<button type="submit"><i class="fal fa-search"></i></button>
						<div id="ajax-search-result"></div>
					</form>
				</div>
			</div>
		</div>
	</header>

	<div class="clearfix"></div>

<?php
$is_wc_cart     = function_exists( 'is_cart' ) && is_cart();
$is_wc_checkout = function_exists( 'is_checkout' ) && is_checkout();

if ( ( $is_wc_cart || $is_wc_checkout ) && locate_template( 'template-parts/hero/banner.php' ) ) :
	$banner_key     = $is_wc_cart ? 'cart_page_banner' : 'checkout_page_banner';
	$banner_allowed = ! function_exists( 'elezone_is_section_visible' ) || elezone_is_section_visible( $banner_key );

	if ( $banner_allowed ) :
		$page_title = get_the_title();
		if ( ! $page_title ) {
			$page_title = $is_wc_cart ? __( 'سبد خرید', 'elezone' ) : __( 'تسویه حساب', 'elezone' );
		}

		$shop_id    = function_exists( 'wc_get_page_id' ) ? wc_get_page_id( 'shop' ) : 0;
		$shop_title = $shop_id > 0 ? get_the_title( $shop_id ) : __( 'فروشگاه', 'elezone' );
		$shop_url   = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );

		get_template_part(
			'template-parts/hero/banner',
			null,
			array(
				'title'  => $page_title,
				'crumbs' => array(
					array(
						'label' => __( 'صفحه اصلی', 'elezone' ),
						'text'  => __( 'صفحه اصلی', 'elezone' ),
						'url'   => home_url( '/' ),
						'link'  => home_url( '/' ),
					),
					array(
						'label' => $shop_title,
						'text'  => $shop_title,
						'url'   => $shop_url,
						'link'  => $shop_url,
					),
					array(
						'label' => $page_title,
						'text'  => $page_title,
						'url'   => '',
						'link'  => '',
					),
				),
			)
		);
	endif;
endif;
?>
