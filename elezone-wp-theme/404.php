<?php
/**
 * 404 template.
 *
 * @package Elezone
 */

get_header();
?>
<main class="container py-5 text-center">
	<div class="row justify-content-center">
		<div class="col-lg-6">
			<h1 class="display-1 IRANSans_Bold text-bro">404</h1>
			<p class="mb-4">صفحه‌ای که به دنبال آن بودید پیدا نشد.</p>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-brow radius20 IRANSans_Medium">بازگشت به صفحه اصلی</a>
			<div class="mt-4 mx-auto" style="max-width:420px"><?php get_search_form(); ?></div>
		</div>
	</div>
</main>
<?php
get_footer();
