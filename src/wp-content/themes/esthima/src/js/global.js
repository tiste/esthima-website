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
			$(this).parents('li.menu-item-has-children').find('ul.sub-menu').css({
				'height': '0',
				'padding': '0 0 0 50px'
			})
			$(this).parents('li.menu-item-has-children').removeClass('menu-item-has-children-open');
		}else{
			let newHeight = $(this).parents('li.menu-item-has-children').find('ul.sub-menu').prop('scrollHeight') + 23;
			$(this).parents('li.menu-item-has-children').find('ul.sub-menu').css({
				'height': newHeight+'px',
				'padding': '23px 0 0 50px'
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

		var currentPageConseils = 1;

		/* hp - autoplay video tet (nécéssite une action de l'utilisateur sur la page) */
		if($('.hp__tet__video').length){
			window.addEventListener("click", () => {
				$('.hp__tet__video video')[0].play()
			}, { once: true });
		}
		/* /hp - autoplay video tet */

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
		if($('.hp__guides__item-2').length && $('.hp__guides__item-3').length){
			let minHeightGuides = $('.hp__guides__item-2').outerHeight() + $('.hp__guides__item-3').outerHeight() + 94;
			let topGuide3 = $('.hp__guides__item-2').outerHeight() + 94;
			$('.hp__guides').css('min-height', minHeightGuides+'px');
			$('.hp__guides__item-3').css('top', topGuide3+'px');
		}else if($('.hp__guides__item-2').length){
			let minHeightGuides = 0;
			$('.hp__guides').css('min-height', minHeightGuides+'px');
		}
		/* /hp - taille min bloc guides */

		/* taille espaceur header */
		if($('.heightHeader').length){
			$('.heightHeader').css('height', $('header.header').outerHeight()+'px');
		}
		/* /taille espaceur header */

		/* guides - taille bloc de couleur */
		if($('.guide__tet .lightBG').length){
			let heightLightBG = $('.guide__tet__breadcrumbs').outerHeight() + $('.guide__tet__flex__texts').outerHeight() + 90;
			$('.guide__tet .lightBG').css('height', heightLightBG+'px');
		}
		/* /guides - taille bloc de couleur */

		var currentPageConseils = 1;
		/* archive guides - pagination precedent */
		$(document).on('click', '#pagination-prev:not(.inactive)', function(){
			if(currentPageConseils>1){
				currentPageConseils--;
				showGuides();
			}
		})
		/* /archive guides - pagination precedent */
		/* archive guides - pagination suivant */
		$(document).on('click', '#pagination-next:not(.inactive)', function(){
			if($('div[data-page="'+(currentPageConseils+1)+'"]').length){
				currentPageConseils++;
				showGuides();
			}
		})
		/* /archive guides - pagination suivant */
		/* archive guides - pagination nombre */
		$(document).on('click', '.guides__pagination div:not(.active)', function(){
			currentPageConseils = Number($(this).data('page'));
			showGuides();
		})
		/* /archive guides - pagination nombre */
		/* archive guides - change page */
		function showGuides(){
			$('.guides__posts__item:not([data-page="'+currentPageConseils+'"])').css({
				'display': 'none',
				'transform': 'scale(0)'
			});
			$('.guides__posts__item[data-page="'+currentPageConseils+'"]').css({
				'display': 'flex',
				'transform': 'scale(1)'
			});
			if($('.guides__posts__item-7[data-page="'+currentPageConseils+'"]').length){
				$('.guides__posts__newsletter').css('grid-area', '6 / 2 / 7 / 3');
			}else if($('.guides__posts__item-6[data-page="'+currentPageConseils+'"]').length){
				$('.guides__posts__newsletter').css('grid-area', '5 / 2 / 6 / 3');
			}else if($('.guides__posts__item-5[data-page="'+currentPageConseils+'"]').length){
				$('.guides__posts__newsletter').css('grid-area', '5 / 1 / 6 / 2');
			}else if($('.guides__posts__item-4[data-page="'+currentPageConseils+'"]').length){
				$('.guides__posts__newsletter').css('grid-area', '3 / 2 / 4 / 3');
			}else if($('.guides__posts__item-3[data-page="'+currentPageConseils+'"]').length){
				$('.guides__posts__newsletter').css('grid-area', '3 / 2 / 4 / 3');
			}else if($('.guides__posts__item-2[data-page="'+currentPageConseils+'"]').length){
				$('.guides__posts__newsletter').css('grid-area', '3 / 1 / 4 / 2');
			}else if($('.guides__posts__item-1[data-page="'+currentPageConseils+'"]').length){
				$('.guides__posts__newsletter').css('grid-area', '2 / 2 / 3 / 3');
			}else if($('.guides__posts__item-0[data-page="'+currentPageConseils+'"]').length){
				$('.guides__posts__newsletter').css('grid-area', '1 / 2 / 2 / 3');
			}
			$('.guides__pagination div').removeClass('active');
			$('.guides__pagination div[data-page="'+currentPageConseils+'"]').addClass('active');
			if(currentPageConseils>1){
				$('#pagination-prev').removeClass('inactive');
			}else{
				$('#pagination-prev').addClass('inactive');
			}
			if($('div[data-page="'+(currentPageConseils+1)+'"]').length){
				$('#pagination-next').removeClass('inactive');
			}else{
				$('#pagination-next').addClass('inactive');
			}
		}
		/* /archive guides - change page */

		/* archive guides - taille bloc de couleur */
		if($('.guides__tet .lightBG').length){
			let heightLightBG = $('.guides__tet__breadcrumbs').outerHeight() + $('.guides__tet__texts').outerHeight() + 180;
			$('.guides__tet .lightBG').css('height', heightLightBG+'px');
		}
		/* /archive guides - taille bloc de couleur */

	});
	
})(window, jQuery);