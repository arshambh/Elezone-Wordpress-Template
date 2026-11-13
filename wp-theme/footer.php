<?php
/**
 * Footer template.
 *
 * @package ArshamDecor
 */

$footer_logo_url   = arsham_get_logo_url( 'footer' );
$footer_logo_width = (int) get_theme_mod( 'arsham_logo_width_footer', 150 );
$logo_html         = '<img src="' . esc_url( $footer_logo_url ) . '" class="img-fluid mb-4" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" style="width:' . $footer_logo_width . 'px;height:auto;max-width:100%;" />';
?>
	<footer class="mt-5 pt-5 pb-2">
		<div class="container py-4">
			<div class="row">
				<div class="col-xl-4 col-md-6 mb-3">
					<div class="pr-xl-4 mb-2 text-right address">
						<?php echo $logo_html; // phpcs:ignore WordPress.Security.EscapeOutput ?>
						<p class="mb-3"><i class="fal fa-map-marker-alt ml-2"></i><?php echo esc_html( arsham_get_option( 'address' ) ); ?></p>
						<p class="mb-3"><i class="fal fa-mobile ml-2"></i>شماره همراه : <?php echo esc_html( arsham_get_option( 'mobile' ) ); ?></p>
						<p class="mb-3"><i class="fal fa-phone ml-2"></i>شماره تماس : <?php echo esc_html( arsham_get_option( 'phone' ) ); ?></p>
						<p class="mb-3"><i class="fal fa-envelope ml-2"></i><?php echo esc_html( arsham_get_option( 'email' ) ); ?></p>
					</div>
				</div>
				<div class="col-xl-2 col-md-6 mb-3">
					<h3>دموهای اصلی</h3>
					<?php if ( has_nav_menu( 'footer-demos' ) ) : ?>
						<?php
						wp_nav_menu( array(
							'theme_location' => 'footer-demos',
							'container'      => false,
							'menu_class'     => '',
							'walker'         => new Arsham_Footer_Menu_Walker(),
							'depth'          => 1,
							'fallback_cb'    => false,
						) );
						?>
					<?php else : ?>
						<ul>
							<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><i class="fal fa-angle-left ml-2"></i>صفحه اصلی</a></li>
						</ul>
					<?php endif; ?>
				</div>
				<div class="col-xl-2 col-md-6 mb-3">
					<h3>لینک های سریع </h3>
					<?php if ( has_nav_menu( 'footer-quick' ) ) : ?>
						<?php
						wp_nav_menu( array(
							'theme_location' => 'footer-quick',
							'container'      => false,
							'menu_class'     => '',
							'walker'         => new Arsham_Footer_Menu_Walker(),
							'depth'          => 1,
							'fallback_cb'    => false,
						) );
						?>
					<?php endif; ?>
				</div>
				<div class="col-xl-4 col-md-6 mb-3">
					<h3>عضویت در خبرنامه</h3>
					<p>ثبت نام کنید و آخرین نکات را از طریق ایمیل دریافت کنید ، جهت ثبت نام فقط کافی ست که آدرس ایمیل را در کادر زیر وارد نمایید</p>
					<form class="newsletter p_relative mt-3" method="post" action="#">
						<input type="email" name="arsham_newsletter_email" placeholder="آدرس ایمیل" required>
						<button class="submit_btn" type="submit"><i class="fab fa-telegram-plane"></i></button>
					</form>
					<ul class="fo_social mt-3 float-right">
						<li class="round-btn btn-whatsapp"><span>شبکه های اجتماعی :</span></li>
						<li class="round-btn btn-whatsapp"><a href="<?php echo esc_url( arsham_get_option( 'social_whatsapp' ) ); ?>" aria-label="WhatsApp"><i class="fab fa-whatsapp m-1 fa-2x" aria-hidden="true"></i></a></li>
						<li class="round-btn btn-telegram"><a href="<?php echo esc_url( arsham_get_option( 'social_telegram' ) ); ?>" aria-label="Telegram"><i class="fab fa-telegram-plane m-1 fa-2x" aria-hidden="true"></i></a></li>
						<li class="round-btn btn-instagram"><a href="<?php echo esc_url( arsham_get_option( 'social_instagram' ) ); ?>" aria-label="Instagram"><i class="fab fa-instagram m-1 fa-2x" aria-hidden="true"></i></a></li>
						<li class="round-btn btn-facebook"><a href="<?php echo esc_url( arsham_get_option( 'social_facebook' ) ); ?>" aria-label="Facebook"><i class="fab fa-facebook-f m-1 fa-2x"></i></a></li>
					</ul>
				</div>
			</div>

			<div class="row pt-3">
				<div class="container-fluid">
					<div class="copyright">© کلیه حقوق این قالب برای طراح محفوظ می باشد</div>
				</div>
			</div>
		</div>
	</footer>
</div><!-- .main_wrap -->
<?php wp_footer(); ?>
</body>
</html>
