<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

	<div class="main-content">
		<div class="shop__bottom">
			<?php $vignettes = get_field('footer_shop_vignettes', 'option'); ?>
			<?php if(!is_null($vignettes) && !empty($vignettes) && is_array($vignettes)) : ?>
				<div class="shop__bottom__flex">
					<?php foreach($vignettes as $v) : ?>
						<div class="shop__bottom__flex__item">
							<div class="shop__bottom__flex__item__picto">
								<img src="<?php echo str_replace('"', '\"', $v['picto']); ?>" alt="<?php echo str_replace('"', '\"', $v['text']); ?>">
							</div>
							<div class="shop__bottom__flex__item__text">
								<?php echo $v['text']; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<h2><?php echo get_field('footer_shop_title', 'option'); ?></h2>
			<?php get_template_part('template-parts/phone-number'); ?>
		</div>
	</div>

	<?php /* FOOTER */ ?>
	<footer class="footer">
		<?php $footerReassurance = get_field('footer_reassurance', 'option'); ?>
		<?php if(!is_front_page() && !is_null($footerReassurance) && !empty($footerReassurance) && is_array($footerReassurance)) : ?>
			<div class="footer__pink__container">
				<div class="containerCustom2">
					<div class="footer__pink">
						<?php foreach($footerReassurance as $r) : ?>
							<div class="footer__pink__item">
								<div class="footer__pink__item__picto">
									<img src="<?php echo str_replace('"', '\"', $r['picto']); ?>" alt="<?php echo str_replace('"', '\"', $r['text']); ?>">
								</div>
								<div class="footer__pink__item__text">
									<?php echo str_replace('"', '\"', $r['text']); ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
		<div class="containerCustom2">
			<div class="footer__top <?php echo (is_front_page()) ? 'footer__top-hp' : ''; ?>">
				<div class="footer__top__left">
					<div class="footer__top__left__title">
						<?php echo get_field('footer_news_title', 'option'); ?>
					</div>
					<div class="footer__top__left__text">
						<?php echo get_field('footer_news_text', 'option'); ?>
					</div>
					<div class="footer__top__left__form">
						<div>
							<input type="email" placeholder="Votre adresse email">
							<input type="submit">
						</div>
						<div class="footer__top__left__form__check">
							<input type="checkbox" id="newsletterconsent" name="newsletterconsent">
							<label for="newsletterconsent">J’accepte de m’inscrire à la newsletter et je reconnais avoir pris connaissance de la politique de confidentialité d’Esthima.</label>
						</div>
					</div>
					<div class="footer__top__left__flex">
						<div class="footer__top__left__flex__item footer__top__left__flex__item-1">
							<?php
								$rs = get_field('global_social', 'option');
								if(!is_null($rs) && !empty($rs) && is_array($rs)) :
							?>
							<div class="footer__top__left__title">
								Suivez-nous
							</div>
							<div class="footer__top__left__social">
								<?php foreach($rs as $s) : ?>
									<a href="<?php echo $s['link']; ?>" target="_blank" class="footer__top__left__social__link footer__top__left__social__link-<?php echo $s['reseau']; ?>"></a>
								<?php endforeach; ?>
							</div>
							<?php endif; ?>
						</div>
						<div class="footer__top__left__flex__item footer__top__left__flex__item-2">
							<?php get_template_part('template-parts/phone-number'); ?>
						</div>
					</div>
				</div>
				<div class="footer__top__right">
					<?php wp_nav_menu(['menu'=>'Footer - main', 'container_class'=>'footer__top__right__menu footer__top__right__menu-1']); ?>
					<?php wp_nav_menu(['menu'=>'Footer - second', 'container_class'=>'footer__top__right__menu footer__top__right__menu-2']); ?>
				</div>
			</div>
		</div>
		<div class="footer__bottom">
			<div class="containerCustom2">
				<div class="footer__bottom__container">
					<?php wp_nav_menu(['menu'=>'Footer - bottom', 'container_class'=>'footer__bottom__menu']); ?>
					<div class="footer__bottom__copyrights"><?php echo get_field('footer_copyrights', 'option'); ?></div>
				</div>
			</div>
		</div>
	</footer>

	<?php /* SWIPER - JS */ ?>
	<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
	<?php wp_footer(); ?>

</body>
</html>
