// get device thanks to CSS
function getCurrentBreakpoint() {
	var device = window.getComputedStyle(document.body, ':after').getPropertyValue('content');

	if (device.indexOf('mobile') != -1)
		return 'mobile';
	if (device.indexOf('tablet') != -1)
		return 'tablet';
	if (device.indexOf('desktop') != -1)
		return 'desktop';
	return false;
}

// device detection
var isMobile = false;
if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0, 4))) {
	isMobile = true;
}

function getCookie(cName) {
	const name = cName + "=";
	const cDecoded = decodeURIComponent(document.cookie); //to be careful
	const cArr = cDecoded.split('; ');
	let res;
	cArr.forEach(val => {
	if (val.indexOf(name) === 0) res = val.substring(name.length);
	})
	return res
}


;(function (window, $) {

	/* menu - ouvre menu */
	$(document).on('click', '.header__pink__item-menu', function(){
		$('.header__menu').css('transform', 'translateX(0)');
	})
	/* /menu - ouvre menu */
	/* menu - ferme menu */
	$(document).on('click', '.header__menu__close', function(){
		$('.header__menu').css('transform', 'translateX(-100%)');
	})
	/* /menu - ferme menu */

	/* menu - ouvre/ferme sous-menu */
	$(document).on('click', '.header__menu__main > ul > li.menu-item-has-children > a', function(e){
		e.preventDefault();
		if($(this).parents('li.menu-item-has-children').hasClass('menu-item-has-children-open')){
			$(this).parents('li.menu-item-has-children').find('ul.sub-menu').removeClass('hasPadding');
			$(this).parents('li.menu-item-has-children').find('ul.sub-menu').css({
				'height': '0'
			})
			$(this).parents('li.menu-item-has-children').removeClass('menu-item-has-children-open');
		}else{
			let newHeight = $(this).parents('li.menu-item-has-children').find('ul.sub-menu').prop('scrollHeight') + 23;
			$(this).parents('li.menu-item-has-children').find('ul.sub-menu').addClass('hasPadding');
			$(this).parents('li.menu-item-has-children').find('ul.sub-menu').css({
				'height': newHeight+'px'
			})
			$(this).parents('li.menu-item-has-children').addClass('menu-item-has-children-open');
		}
	})
	/* /menu - ouvre/ferme sous-menu */

	$(document).ready(function(){

		var currentScrollPos = 0;
		var ticking = false;
		var lastScrollTop = 0;
		window.addEventListener('scroll', function(e) {
			currentScrollPos = window.scrollY;
			if (!ticking){
				window.requestAnimationFrame(function(){
					/* header - toggle transparence si besoin */
					if(currentScrollPos > 50 && $('.header-transparent').length){
						$('.header-transparent').removeClass('header-transparent-active');
					}else if($('.header-transparent').length){
						$('.header-transparent').addClass('header-transparent-active');
					}
					/* /header - toggle transparence si besoin */
					ticking = false;
				});
			}
			ticking = true;
		});
		/* /scroll */

	});

	$( window ).load(function() {

		/* produit - ajout barre scroll gallerie */
		if($('.woocommerce-product-gallery__wrapper').length && window.innerWidth>767){
			setTimeout(()=>{
				console.log('gallery', $('.woocommerce-product-gallery__wrapper__gallery').outerHeight())
				console.log('img', $('.woocommerce-product-gallery__wrapper__mainimg').outerHeight())
				if($('.woocommerce-product-gallery__wrapper__gallery').outerHeight() > $('.woocommerce-product-gallery__wrapper__mainimg').outerHeight()){
					$('.woocommerce-product-gallery__wrapper__gallery').addClass('woocommerce-product-gallery__wrapper__gallery-scroll');
					$('.woocommerce-product-gallery__wrapper__gallery').css('max-height', $('.woocommerce-product-gallery__wrapper__mainimg').outerHeight()+'px');
				}
			}, 100)
		}
		/* /produit - ajout barre scroll gallerie */
		

		/* panier - notes de commande */
		if($('.woocommerce-checkout #order_comments_field').length){
			$('.woocommerce-checkout #order_comments_field label').html("Numéro de convention");
			$('.woocommerce-checkout #order_comments_field #order_comments').attr('placeholder', "Si vous avez fait appel au service de crémation Esthima pour votre animal, merci de renseigner le numéro de convention");
		}
		/* /panier - notes de commande */

		/* taille espaceur header */
		if($('.heightHeader').length){
			$('.heightHeader').css('height', $('header.header').outerHeight()+'px');
		}
		/* /taille espaceur header */

		/* hp - ajout avis tetiere */
		if($('.hp__tet__reviews').length && $('.hp__reviews .rating__value').length){
			let linkToReviews = $('a.rating__details-link').attr('href');
			let htmlReviews = `
				<div class="skeepers_carousel_container">
					`+$('#nr-average-stars').html()+`
				</div>
				<div class="hp__tet__reviews__note">
					`+$('#nr-average').html()+`<span>/5</span>
				</div>
				<a href="`+linkToReviews+`" target="_blank" class="hp__tet__reviews__number">`+$('#nr-total-reviews').html()+` avis</a>
			`;
			$('.hp__tet__reviews').html(htmlReviews);
		}
		/* /hp - ajout avis tetiere */

		/* hp - taille min bloc guides */
		if($('.hp__guides__item-2').length && $('.hp__guides__item-3').length && window.innerWidth>=768){
			let minHeightGuides = $('.hp__guides__item-2').outerHeight() + $('.hp__guides__item-3').outerHeight() + 94;
			let topGuide3 = $('.hp__guides__item-2').outerHeight() + 94;
			$('.hp__guides').css('min-height', minHeightGuides+'px');
			$('.hp__guides__item-3').css('top', topGuide3+'px');
		}else if($('.hp__guides__item-2').length){
			let minHeightGuides = 0;
			$('.hp__guides').css('min-height', minHeightGuides+'px');
		}
		/* /hp - taille min bloc guides */

		/* hp - sliders mobile */
		if(window.innerWidth < 768){
			if($('.hp__services__serv').length){
				$('.hp__services__serv').addClass('swiper');
				$('.hp__services__serv__item').each(function(){
					$(this).addClass('swiper-slide');
				})
				let newHPServicesHTML = '<div class="swiper-wrapper">' + $('.hp__services__serv').html() + '</div><div class="swiper-button-prev hp__services__serv__prev"></div><div class="swiper-button-next hp__services__serv__next"></div>';
				$('.hp__services__serv').html(newHPServicesHTML);
				const swiperHPServices = new Swiper('.hp__services__serv', {
					spaceBetween: 10,
					slidesPerView: 1,
					navigation: {
						nextEl: '.hp__services__serv__next',
						prevEl: '.hp__services__serv__prev',
					}
				});
			}
			if($('.hp__services__vignettes').length){
				$('.hp__services__vignettes').addClass('swiper');
				$('.hp__services__vignettes__item').each(function(){
					$(this).addClass('swiper-slide');
				})
				let newHPServicesVignHTML = '<div class="swiper-wrapper">' + $('.hp__services__vignettes').html() + '</div>';
				$('.hp__services__vignettes').html(newHPServicesVignHTML);
				const swiperHPServicesVign = new Swiper('.hp__services__vignettes', {
					spaceBetween: 10,
					slidesPerView: 'auto'
				});
			}
			if($('.hp__conf__steps').length){
				$('.hp__conf__steps').addClass('swiper');
				$('.hp__conf__steps__item').each(function(){
					$(this).addClass('swiper-slide');
				})
				let newHPStepsHTML = '<div class="swiper-wrapper">' + $('.hp__conf__steps').html() + '</div><div class="swiper-button-prev hp__conf__steps__prev"></div><div class="swiper-button-next hp__conf__steps__next"></div>';
				$('.hp__conf__steps').html(newHPStepsHTML);
				const swiperHPSteps = new Swiper('.hp__conf__steps', {
					spaceBetween: 30,
					slidesPerView: 1,
					navigation: {
						nextEl: '.hp__conf__steps__next',
						prevEl: '.hp__conf__steps__prev',
					}
				});
			}
			if($('.hp__shop__cats').length){
				$('.hp__shop__cats').addClass('swiper');
				$('.hp__shop__cats__item').each(function(){
					$(this).addClass('swiper-slide');
				})
				let newHPShopHTML = '<div class="swiper-wrapper">' + $('.hp__shop__cats').html() + '</div>';
				$('.hp__shop__cats').html(newHPShopHTML);
				const swiperHPShop = new Swiper('.hp__shop__cats', {
					spaceBetween: 20,
					slidesPerView: 'auto'
				});
			}
		}
		/* /hp - sliders mobile */
		
		/* boutique - sliders mobile */
		if($('.shop__blocks__item__texts__products').length && window.innerWidth<768){
			$('.shop__blocks__item__texts__products').each(function(){
				$(this).addClass('swiper');
				$(this).find('.shop__blocks__item__texts__products__prod').each(function(){
					$(this).addClass('swiper-slide');
				})
				let newHPShopHTML = '<div class="swiper-wrapper">' + $(this).html() + '</div><div class="shop__blocks__item__texts__products__prev swiper-button-prev"></div><div class="shop__blocks__item__texts__products__next swiper-button-next"></div>';
				$(this).html(newHPShopHTML);
				new Swiper(this, {
					spaceBetween: 11,
					slidesPerView: 'auto',
					navigation: {
						nextEl: '.shop__blocks__item__texts__products__next',
						prevEl: '.shop__blocks__item__texts__products__prev',
					}
				});
			})
		}
		if($('.shop__solo__products').length && window.innerWidth<768){
			$('.shop__solo__products').each(function(){
				$(this).addClass('swiper');
				$(this).find('.shop__solo__products__item').each(function(){
					$(this).addClass('swiper-slide');
				})
				let newHPShopHTML = '<div class="swiper-wrapper">' + $(this).html() + '</div><div class="shop__solo__products__prev swiper-button-prev"></div><div class="shop__solo__products__next swiper-button-next"></div>';
				$(this).html(newHPShopHTML);
				new Swiper(this, {
					spaceBetween: 11,
					slidesPerView: 'auto',
					navigation: {
						nextEl: '.shop__solo__products__next',
						prevEl: '.shop__solo__products__prev',
					}
				});
			})
		}
		/* /boutique - sliders mobile */

		/* categorie - titre en 2 parties */
		if($('.cats .woocommerce-products-header h1').length){
			$('.cats .woocommerce-products-header h1').each(function(){
				let htmlTitle = $(this).html();
				let i = htmlTitle.indexOf(' ');
				let splits = [htmlTitle.slice(0,i), htmlTitle.slice(i+1)];
				if(splits.length>1){
					$(this).html(splits[0] + '<span>' + splits[1] + '</span>')
				}
			})
		}
		/* /categorie - titre en 2 parties */
		/* categorie - add wrap to img in loop */
		if($('.cats ul.products li.product.product .attachment-woocommerce_thumbnail').length){
			$('.cats ul.products li.product.product .attachment-woocommerce_thumbnail').each(function(){
				$(this).wrap('<div class="product__img"></div>')
			})
		}
		/* /categorie - add wrap to img in loop */

		/* produit - wrap gallery et desc */
		if($('.single-product .site-main .product .woocommerce-product-gallery').length && $('.single-product .site-main .product .summary').length){
			$('.single-product .site-main .product .woocommerce-product-gallery, .single-product .site-main .product .summary').wrapAll('<div class="product__tet"></div>');
		}
		/* /produit - wrap gallery et desc */
		/* produit - masquer prix quand variation */
		if($('.single-product .site-main .product.product-type-variable').length){
			$('.single-product .site-main .product .summary > .price').css('display', 'none');
		}
		/* /produit - masquer prix quand variation */
		/* produit - masquer bandeau descriptif si vide */
		if($('.woocommerce-Tabs-panel--reviews').length && !$('.woocommerce-Tabs-panel--description').length){
			$('.woocommerce-tabs').css('display', 'none');
		}
		/* /produit - masquer bandeau descriptif si vide */
		/* produit - gallerie */
		if($('.woocommerce-product-gallery__image').length){
			$('.woocommerce-product-gallery__image').eq(0).addClass('active');
		}
		$(document).on('click', '.woocommerce-product-gallery__image a', function(e){
			e.preventDefault();
			$('.woocommerce-product-gallery__wrapper__mainimg img').attr('src', $(this).attr('href'));
			$('.woocommerce-product-gallery__image').removeClass('active');
			$(this).parent('.woocommerce-product-gallery__image').addClass('active');
		})
		/* /produit - gallerie */
		/* produit - sliders mobile */
		if($('.upsells .products').length && window.innerWidth<768){
			$('.upsells .products').each(function(index){
				$(this).addClass('swiper');
				$(this).find('li.product').each(function(){
					$(this).addClass('swiper-slide');
				})
				let newHPShopHTML = '<div class="swiper-wrapper">' + $(this).html() + '</div><div class="products-'+index+'__prev products__prev swiper-button-prev"></div><div class="products-'+index+'__next products__next swiper-button-next"></div>';
				$(this).html(newHPShopHTML);
				new Swiper(this, {
					spaceBetween: 10,
					slidesPerView: 'auto',
					navigation: {
						nextEl: '.products-'+index+'__next',
						prevEl: '.products-'+index+'__prev',
					}
				});
			})
		}
		if($('.shop__solo__products').length && window.innerWidth<768){
			$('.shop__solo__products').each(function(){
				$(this).addClass('swiper');
				$(this).find('.shop__solo__products__item').each(function(){
					$(this).addClass('swiper-slide');
				})
				let newHPShopHTML = '<div class="swiper-wrapper">' + $(this).html() + '</div><div class="shop__solo__products__prev swiper-button-prev"></div><div class="shop__solo__products__next swiper-button-next"></div>';
				$(this).html(newHPShopHTML);
				new Swiper(this, {
					spaceBetween: 11,
					slidesPerView: 'auto',
					navigation: {
						nextEl: '.shop__solo__products__next',
						prevEl: '.shop__solo__products__prev',
					}
				});
			})
		}
		if($('.grid-souvenirs .products').length && window.innerWidth<768){
			$('.grid-souvenirs .products').each(function(index){
				$(this).addClass('swiper');
				$(this).find('li.product').each(function(){
					$(this).addClass('swiper-slide');
				})
				let newHPShopHTML = '<div class="swiper-wrapper">' + $(this).html() + '</div><div class="products-'+index+'__prev products__prev swiper-button-prev"></div><div class="products-'+index+'__next products__next swiper-button-next"></div>';
				$(this).html(newHPShopHTML);
				new Swiper(this, {
					spaceBetween: 10,
					slidesPerView: 'auto',
					navigation: {
						nextEl: '.products-'+index+'__next',
						prevEl: '.products-'+index+'__prev',
					}
				});
			})
		}
		/* /produit - sliders mobile */

		/* guides - taille bloc de couleur */
		if($('.guide__tet .lightBG').length){
			let heightLightBG = $('.guide__tet__breadcrumbs').outerHeight() + $('.guide__tet__flex__texts').outerHeight() + 90;
			$('.guide__tet .lightBG').css('height', heightLightBG+'px');
		}
		/* /guides - taille bloc de couleur */

		/* guides - select cats mob */
		$(document).on('change', '.guides__cats-mob', function(){
			window.location.href = $(this).val();
		})
		/* /guides - select cats mob */

		/* wishlist - couleur titre */
		if($('.wishlist__body .wishlist-title h2').length){
			$('.wishlist__body .wishlist-title h2').html('Ma liste de <span>souhaits</span>');
		}
		/* wishlist - couleur titre */

		/* archive guides - taille bloc de couleur */
		if($('.guides__tet .lightBG').length){
			let heightLightBG = $('.guides__tet__breadcrumbs').outerHeight() + $('.guides__tet__texts').outerHeight() + 180;
			$('.guides__tet .lightBG').css('height', heightLightBG+'px');
		}
		/* /archive guides - taille bloc de couleur */

		/* faq - ouvre faq */
		$(document).on('click', '.list-faq__item-closed', function(){
			$('.list-faq__item').addClass('list-faq__item-closed');
			$('.list-faq__item').removeClass('list-faq__item-open');
			$(this).addClass('list-faq__item-open');
			$(this).removeClass('list-faq__item-closed');
		})
		/* /faq - ouvre faq */

		/* faq - categories */
		$(document).on('click', '.cats-faq__cat', function(){
			if($(this).hasClass('cats-faq__cat-selected')){
				$(this).removeClass('cats-faq__cat-selected');
				$('.list-faq__item').removeClass('list-faq__item-hidden');
			}else{
				$('.cats-faq__cat').removeClass('cats-faq__cat-selected');
				$(this).addClass('cats-faq__cat-selected');
				var currentCat = $(this).data('slug');
				$('.list-faq__item').each(function(){
					if($(this).data('cats').includes('*'+currentCat+'*')){
						$(this).removeClass('list-faq__item-hidden');
					}else{
						$(this).addClass('list-faq__item-hidden');
					}
				})
			}
			openFirstFAQ();
		})
		$(document).on('change', '.cats-faq-mob', function(){
			if($(this).val()=='all'){
				$('.list-faq__item').removeClass('list-faq__item-hidden');
			}else{
				var currentCat = $(this).val();
				$('.list-faq__item').each(function(){
					if($(this).data('cats').includes('*'+currentCat+'*')){
						$(this).removeClass('list-faq__item-hidden');
					}else{
						$(this).addClass('list-faq__item-hidden');
					}
				})
			}
			openFirstFAQ();
		})
		function openFirstFAQ(){
			var isFirstOpen = false;
			$('.list-faq__item').each(function(){
				if(isFirstOpen || $(this).hasClass('list-faq__item-hidden')){
					$(this).removeClass('list-faq__item-open');
					$(this).addClass('list-faq__item-closed');
				}else{
					isFirstOpen = true;
					$(this).removeClass('list-faq__item-closed');
					$(this).addClass('list-faq__item-open');
				}
			})
		}
		/* /faq - categories */

		/* store locator - recherche */
		if($('.storeloc__tet__form input[type="text"]').length && $('#wpsl-search-input').length){
			$('.storeloc__tet__form input[type="text"]').on('input', function(){
				$('#wpsl-search-input').val($('.storeloc__tet__form input[type="text"]').val());
			})
			$('.storeloc__tet__form input[type="text"]').on('keyup', function (e) {
				if (e.key === 'Enter' || e.keyCode === 13) {
					$('#wpsl-search-btn').click();
				}
			});
			$('.storeloc__tet__form .btn').on('click', function () {
				$('#wpsl-search-btn').click();
			});
		}
		/* /store locator - recherche */

		/* espace recrutement - afficher form */
		$(document).on('click', '.jobs__self__btn', function(){
			$('.jobs__self__btn').toggleClass('jobs__self__btn-open');
			$('.jobs__self__form-container').toggleClass('jobs__self__form-container-open');
		})
		/* /espace recrutement - afficher form */

		/* agence - slider */
		if($('.store__gallery__slider').length){
			const swiperHPShop = new Swiper('.store__gallery__slider', {
				spaceBetween: 20,
				slidesPerView: 1,
				navigation: {
					nextEl: '.store__gallery__slider__next',
					prevEl: '.store__gallery__slider__prev',
				},
				breakpoints: {
					788: {
						slidesPerView: 1.42,
					}
				}
			});
		}
		/* /agence - slider */

		/* agence - ouvert/fermé */
		if($('.store__tet__status').length && window.todayDate && window.arrayDaysMap && window.arrayHours){
			var hoursToday = window.arrayHours[window.arrayDaysMap[window.todayDate.getDay()]];
			if(hoursToday.length<=0){
				$('.store__tet__status').addClass('store__tet__status-closed');
			}else{
				let isOpen = false;
				hoursToday.forEach((child) => {
					let heureArray = child.split(',');
					let debut = heureArray[0];
					let fin = heureArray[1];
					let heureDebut = Number(debut.split(':')[0]);
					let minuteDebut = Number(debut.split(':')[1]);
					let heureFin = Number(fin.split(':')[0]);
					let minuteFin = Number(fin.split(':')[1]);
					if(
						(
							heureDebut<window.todayDate.getHours() || 
							(heureDebut==window.todayDate.getHours() && minuteDebut<window.todayDate.getMinutes())
						) &&
						(
							window.todayDate.getHours()<heureFin ||
							(window.todayDate.getHours()==heureFin && window.todayDate.getMinutes()<minuteFin)
						)
					){
						isOpen = true;
					}
				});
				if(isOpen){
					$('.store__tet__status').addClass('store__tet__status-open');
				}else{
					$('.store__tet__status').addClass('store__tet__status-closed');
				}
			}
		}
		/* /agence - ouvert/fermé */

		/* agence - contact - positionnement labels */
		$('.has-label input').on('input', function(){
			if($(this).val()==null || $(this).val()==''){
				$(this).parents('.has-label').removeClass('has-label-written')
			}else{
				$(this).parents('.has-label').addClass('has-label-written')
			}
		})
		$('.has-label textarea').on('input', function(){
			if($(this).val()==null || $(this).val()==''){
				$(this).parents('.has-label').removeClass('has-label-written')
			}else{
				$(this).parents('.has-label').addClass('has-label-written')
			}
		})
		/* /agence - contact - positionnement labels */

		/* agence - contact - ouverture/fermeture mobile */
		$(document).on('click', '.store__infos__contact-cta', function(){
			$('.store__infos__contact').addClass('store__infos__contact-open');
		})
		$(document).on('click', '.store__infos__contact__close', function(){
			$('.store__infos__contact').removeClass('store__infos__contact-open');
		})
		/* /agence - contact - ouverture/fermeture mobile */

		/* agence - contact - drapeau tel */
		$(document).on('change', '.store__infos__contact .phone-country select', function(){
			$(this).attr('class', 'large gfield_select');
			$(this).addClass('pays-'+$(this).val());
		})
		/* /agence - contact - drapeau tel */

		/* contact - contact - ouverture/fermeture mobile */
		$(document).on('click', '.contact__tet__form-cta', function(){
			$('.contact__tet__form').addClass('contact__tet__form-open');
		})
		$(document).on('click', '.contact__tet__form__close', function(){
			$('.contact__tet__form').removeClass('contact__tet__form-open');
		})
		/* /contact - contact - ouverture/fermeture mobile */

		/* contact - contact - drapeau tel */
		$(document).on('change', '.contact__tet__form .phone-country select', function(){
			$(this).attr('class', 'large gfield_select');
			$(this).addClass('pays-'+$(this).val());
		})
		/* /contact - contact - drapeau tel */

		/* panier - plus/moins */
		$(document).on('click', '.product-quantity__minus', function(){
			let val = Number($(this).parent('.product-quantity').find('input[type=number]').val());
			let min = Number($(this).parent('.product-quantity').find('input[type=number]').attr('min'));
			if(val>min){
				$(this).parent('.product-quantity').find('input[type=number]').val(val-1);
				$(this).parent('.product-quantity').find('input[type=number]').change();
			}
		})
		$(document).on('click', '.product-quantity__plus', function(){
			let val = Number($(this).parent('.product-quantity').find('input[type=number]').val());
			let max = $(this).parent('.product-quantity').find('input[type=number]').attr('max');
			if(max=='' || val<Number(max)){
				$(this).parent('.product-quantity').find('input[type=number]').val(val+1);
				$(this).parent('.product-quantity').find('input[type=number]').change();
			}
		})
		/* /panier - plus/moins */

		/* newsletter - couleur titre */
		if($('.newsletter__container h1').length){
			let textH1 = $('.newsletter__container h1').text();
			let arrayText = textH1.split(' ');
			let newH1 = '';
			for(let i = 0; i<arrayText.length; i++){
				if((i+1)==arrayText.length){
					newH1 = newH1 + '<span>' + arrayText[i] + '</span>';
				}else{
					newH1 = newH1 + arrayText[i] + ' ';
				}
			}
			$('.newsletter__container h1').html(newH1);
		}
		/* /newsletter - couleur titre */
		/* newsletter - contact - positionnement labels */
		$(document).on('input', '.formText input', function(){
			if($(this).val()==null || $(this).val()==''){
				$(this).parents('.formText').removeClass('formText-written')
			}else{
				$(this).parents('.formText').addClass('formText-written')
			}
		})
		/* /newsletter - contact - positionnement labels */

		/* connexion/inscription - positionnement labels */
		$('.inscription__login .gfield--type-text input').on('input', function(){
			if($(this).val()==null || $(this).val()==''){
				$(this).parents('.gfield--type-text').removeClass('label-written')
			}else{
				$(this).parents('.gfield--type-text').addClass('label-written')
			}
		})
		$('.inscription__register .gform-grid-col input').on('input', function(){
			if($(this).val()==null || $(this).val()==''){
				$(this).parents('.gform-grid-col').removeClass('label-written')
			}else{
				$(this).parents('.gform-grid-col').addClass('label-written')
			}
		})
		/* /connexion/inscription - positionnement labels */

	});
	
})(window, jQuery);