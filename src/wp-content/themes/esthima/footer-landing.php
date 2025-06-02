<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

	<?php /* FOOTER */ ?>
	<footer class="footer footer__landing">

		<div class="footer__bottom">
			<div class="containerCustom2">
				<div class="footer__bottom__container">
					<?php wp_nav_menu(['menu'=>'Footer - bottom', 'container_class'=>'footer__bottom__menu']); ?>
					<div class="footer__bottom__copyrights">Esthima©<?php echo date('Y'); ?> - Tous droits réservés</div>
				</div>
			</div>
		</div>

	</footer>

	<!-- Début de la liste OneTrust de cookies -->
	<div id="ot-sdk-cookie-policy"></div>
	<!-- Fin de la liste OneTrust de cookies -->

	<?php /* SWIPER - JS */ ?>
	<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
	<?php wp_footer(); ?>

</body>
</html>