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

		/* guides - taille bloc de couleur */
		if($('.guide__tet .lightBG').length){
			let heightLightBG = $('.guide__tet__breadcrumbs').outerHeight() + $('.guide__tet__flex__texts').outerHeight() + 90;
			$('.guide__tet .lightBG').css('height', heightLightBG+'px');
		}
		/* /guides - taille bloc de couleur */

		/* archive guides - taille bloc de couleur */
		if($('.guides__tet .lightBG').length){
			let heightLightBG = $('.guides__tet__breadcrumbs').outerHeight() + $('.guides__tet__texts').outerHeight() + 180;
			$('.guides__tet .lightBG').css('height', heightLightBG+'px');
		}
		/* /archive guides - taille bloc de couleur */

		/* store locator - recherche */
		if($('.storeloc__tet__form input[type="text"]').length && $('#wpsl-search-input').length){
			$('.storeloc__tet__form input[type="text"]').on('input', function(e){
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

		/* agence - slider */
		if($('.store__gallery__slider').length){
			const swiperHPShop = new Swiper('.store__gallery__slider', {
				spaceBetween: 20,
				slidesPerView: 1.42,
				navigation: {
					nextEl: '.store__gallery__slider__next',
					prevEl: '.store__gallery__slider__prev',
				}
			});
		}
		/* /agence - slider */

	});
	
})(window, jQuery);