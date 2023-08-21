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


var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
}

/* HOMEPAGE SEARCHBOX : AFFICHAGE DU RAYON DE LOCALISATION (Anne)*/

var	rangeslider = document.getElementById("locationBar");
var result = document.getElementById("locationValue");
	
function setValue(){
	if (rangeslider) {
		let 
		newValue = Number( (rangeslider.value - rangeslider.min) * 100 / (rangeslider.max - rangeslider.min) ),
		newPosition = 10 - (newValue * 0.2);
		result.innerHTML = '<span>' + rangeslider.value + ' km</span>';
		result.style.left = "calc(" + newValue + " + " + newPosition + "px)";
	}
};
document.addEventListener("DOMContentLoaded", setValue);
if (rangeslider) {
	rangeslider.addEventListener("input", setValue);
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

function randomIntFromInterval(min, max) { // min and max included 
	return Math.floor(Math.random() * (max - min + 1) + min)
}


(function (window, $) {
	/* mon compte mobile : changement titre au clic sur onglet */
	$('.account__menu--desktop button').on('click', function(){
		$('.account__menu--desktop').css('order', '0');
		$(this).parent('.account__menu--desktop').css('order', '-1');
		$('#accountTab1TitleMobile').html($(this).html());
	})

	/* CHANGER D'ENTITE : toggleEntiteModal (Thibaut) */
	$('.toggleInvoiceModal').click(function (e) {
		e.preventDefault();
		$('.invoice-modal.modal').toggleClass('is-visible');
		showOverlay();
	});

	/* BOUTON VOIR SON RESEAU : openModalNetwork (Thibaut) */
	$(".openModalNetwork").click(function (e) {
		e.preventDefault();
		$(".reseau-modal.modal").addClass('is-visible');
		showOverlay();
	});

	/* SEARCH FILTERS SELECT2 (Thibaut) */
	if ($('.js-select2').hasClass("select2-hidden-accessible")) {
		$(".js-select2").select2({
			closeOnSelect : false,
			placeholder : "Placeholder",
			allowHtml: true,
			allowClear: true,
			tags: true
		});
	}

	/* AFFINER MA RECHERCHE : toggleFilters (Thibaut) */
	$('.toggleFilters').click(function (e) {
		e.preventDefault();
		$('.mob-filters.offcanvas').toggleClass('is-visible');
		$('body').toggleClass('no-scroll');
	});

	/* CHANGER D'ENTITE : toggleEntiteModal (Thibaut) */
	$('.toggleEntiteModal').click(function (e) {
		e.preventDefault();
		$('.entite-modal.modal').toggleClass('is-visible');
		showOverlay();
	});

	/* FICHE DETAIL : toggleThemes (Thibaut) */
	$('.toggleSpectacleType').click(function (e) {
		e.preventDefault();
		$('.spectaclestype-dropdown.dropdown').toggleClass('is-visible');
	});
	$('.toggleConfiguration').click(function (e) {
		e.preventDefault();
		$('.configuration-dropdown.dropdown').toggleClass('is-visible');
	});

	// $(document).mouseup(function(e) {
	// 	var container = $('.themes-dropdown, .toggleThemes');
	// 	if (!container.is(e.target) && container.has(e.target).length === 0) 
	// 		container.removeClass('is-visible');
	// });

	/* BOUTON MON COMPTE : toggleAccountNav (Thibaut) */
	$('.toggleAccountNav').click(function (e) {
		e.preventDefault();
		$('.account-nav.dropdown').toggleClass('is-visible');
	});
	$(document).mouseup(function(e) {
		var container = $('.account-nav, .toggleAccountNav');
		if (!container.is(e.target) && container.has(e.target).length === 0) 
			container.removeClass('is-visible');
	});


	/* FULLSCREEN MODAL (Thibaut) */
	// $('.header__nav a').click(function (e) {
	// 	e.preventDefault();
	// 	$('.network-popin.fs-modal').addClass('is-visible');
	// });

	/* MON COMPTE - NON CONNECTÉ */
	$('.menuBlocked').click(function (e) {
		e.preventDefault();
		$('.network-popin.fs-modal').addClass('is-visible');
	});


	$(document).on('keyup', function(e) {
		if (e.key == "Escape") {
			$('.overlay, .offcanvas, .fs-modal, .modal, .account-nav, .dropdown').removeClass('is-visible');
			$('body').removeClass('no-scroll');
		}
	});

	
	$('.closeModal').click(function (e) {
		e.preventDefault();
		$('.fs-modal').removeClass('is-visible');
	});
	

		// $('.toggleOffcanvas').click(function (e) {
		// 	e.preventDefault();
		// 	$(".offcanvas").toggleClass('active');
		// 	$('html, body').toggleClass('no-scroll');
		// });

	function showOverlay() {
		$(".overlay").addClass('is-visible');
		$('body').addClass('no-scroll');
	}
	function hideOverlay() {
		$(".overlay").removeClass('is-visible');
		setTimeout(function() {
			$('body').removeClass('no-scroll');
		}, 300);
	}
	
	function showOffCanvas() {
		$(".offcanvas").addClass('is-visible');
	}
	function hideOffCanvas() {
		$(".offcanvas").removeClass('is-visible');
	}

	function hideModal() {
		$(".modal").removeClass('is-visible');
	}

	function showHeroSide() {
		$('.hero__side').clone(true,true).addClass("is-fixed").insertAfter('.hero__side');
		window.setTimeout(function(){
			$('.hero__side.is-fixed').addClass("is-visible");
		}, 100);
	}
	function hideHeroSide() {
		$('.hero__side.is-fixed').removeClass("is-visible");
		window.setTimeout(function(){
			$('.hero__side.is-fixed').remove();
		}, 200);
	}

	$(".toggleNotifications").click(function (e) {
		e.preventDefault();
		showOffCanvas();
		showOverlay();
	});

	$(".toggleNotificationsOff").click(function(e) {
		e.preventDefault();
		hideOffCanvas();
		hideOverlay();
	})

	$(".overlay").click(function (e) {
		e.preventDefault();
		hideOverlay();
		hideOffCanvas();
		hideModal();
		hideHeroSide();
	});

	$('.btn-close-modal').on('click', function(e){
		e.preventDefault();
		hideModal();
		hideOverlay();
	});

	/* sticky action button click event */
	$(".sticky-action").click(function (e) {
		e.preventDefault();
		showHeroSide();
		showOverlay();
	});

	$( ".closeHeroSide" ).click(function(e) {
		e.preventDefault();
		hideOverlay();
		hideHeroSide();
	});

	$(".popInTarifs").click(function(e) {
		e.preventDefault();
		$('.popin-tarifs.fs-modal').addClass('is-visible');
	});

	/* NAV MOB */
	$(".toggleMobileNav").click(function(){
		$('.header__nav__mob.dropdown').toggleClass('is-visible');		
	})


	$(document).ready(function(){
		/* update read/unread notifs */
		$(document).on('click', '.notifications__items li.unread a', function(e){
			e.preventDefault();
			let urlRedirectAfterUpdate = $(this).attr('href');
			let idNotif = $(this).parent('li').attr('data-id');
			let request = $.ajax({
				url: "/wp-json/sc/v1/update-notif",
				type: "POST",
				data: {
					idNotif: idNotif,
				}
			})
			request.done(function(rep){
				window.location.href = document.location.origin + urlRedirectAfterUpdate
			})
		})

		$(document).on('click', '.notifications__items li.unread .check-read', function(e){
			e.preventDefault();
			let idNotif = $(this).parent('li').attr('data-id');
			let request = $.ajax({
				url: "/wp-json/sc/v1/update-notif",
				type: "POST",
				data: {
					idNotif: idNotif,
				}
			})
			request.done((rep)=>{
				$(this).parent('li').removeClass('unread');
				$(this).remove();
				if($('li.unread').length < 1){					
					let urlImgNotifs = $('.header__account__notifs').attr('src');
					urlImgNotifs = urlImgNotifs.replace('sceco_notifheader', 'sceco_notifheader_empty');
					$('.header__account__notifs').attr('src', urlImgNotifs);
				}
			})
		})

		/* BLOG ARTICLE -> CHANGER L'ICONE DE PARTAGE */
		$('.fa-linkedin').removeClass('fa-linkedin').addClass('fa-linkedin-in');
		$('.fa-facebook').removeClass('fa-facebook').addClass('fa-facebook-f');

		/* CONTACT FORM (ELEMENTOR) : CACHER LE PREMIER SELECT (Anne) */
		// $('#form-field-field_38c6c8a').find('option:first').addClass('first-hidden')
		$('#form-field-field_38c6c8a').find('option:first').hide(),
		$('#form-field-field_aa319ac').find('option:first').hide();

		/* HOME : OUVERTURE DES TABS (Anne) */
		$('.searchbloc li a:not(:first)').addClass('inactive'); // force the other element (not first) to be inactive
		$('.searchbox').hide();
		$('.searchbox:first').show(); // force the first element to show
		$('.searchbloc li a').click(function () {
			var t = $(this).attr('id');
			if ($(this).hasClass('inactive')) {
				$('.searchbloc li a').addClass('inactive');
				$(this).removeClass('inactive');

				$('.searchbox').hide();
				$('#' + t + 'C').fadeIn('fast'); //-> Fade, a voir si on le garde
			}
		});

		/* MON COMPTE : AFFICHAGE DYNAMIQUE DES TABS (Anne) */
		$('.account__menu button:not(:first)').addClass('inactive');
		$('.account__content').hide();
		$('.account__title').hide();
		$('.account__title--mobile').hide();
		$('.account__content:first').show();
		$('.account__title:first').show();
		$('.account__title--mobile:first').show();
		if (window.matchMedia('(max-width: 1024px)').matches) {
			// console.log("let's goooo")
			$('.account__title:first').hide();
		}
		$('.account__menu button').click(function () {
			var tab = $(this).attr('id');
			if ($(this).hasClass('inactive')) {
				$('.account__menu button').addClass('inactive');
				$(this).removeClass('inactive');

				$('.account__content').hide();
				$('.account__title').hide();
				$('#' + tab + 'Content').fadeIn('fast');
				$('#' + tab + 'Title').fadeIn('fast');
			}
		});
		$('#tabMobile button').click(function () {
			var tab = $(this).attr('id');
			if ($(this).hasClass('inactive')) {
				$('.account__menu button').addClass('inactive');
				$(this).removeClass('inactive');

				$('.account__content').hide();
				$('.account__title').hide();
				$('#' + tab + 'Content').fadeIn('fast');
				$('#' + tab + 'Title').fadeIn('fast');
			}
		})

		/* projet : gallerie clic sur image */
		$('body').on('click', '.grid-photos__pic', function(){
			let newModal = `
				<div class="modal-gallery__container">
					<div class="modal-gallery" data-index="`+$(this).attr('data-index')+`">
						<div class="modal-gallery__close"></div>
						<div class="modal-gallery__prev"></div>
						<div class="modal-gallery__next"></div>
						<img src="`+$(this).attr('data-image-url')+`" class="modal-gallery__pic">
					</div>
				</div>
			`;
			$('body').prepend(newModal);
		})
		$('body').on('click', '.modal-gallery__close', function(){
			$('.modal-gallery__container').remove();
		})
		$('body').on('click', '.modal-gallery__prev', function(){
			let newIndex = Number($(this).parent().attr('data-index')) - 1;
			if($(this).parent().attr('data-index')==0){
				newIndex = $('.grid-photos__pic-pic').length - 1;
			}
			$('.modal-gallery__pic').attr('src', $('.grid-photos__pic-pic:nth-child('+(newIndex+1)+') img').attr('src'));
			$('.modal-gallery').attr('data-index', newIndex);
		})
		$('body').on('click', '.modal-gallery__next', function(){
			let newIndex = Number($(this).parent().attr('data-index')) + 1;
			if(newIndex==$('.grid-photos__pic-pic').length){
				newIndex = 0;
			}
			$('.modal-gallery__pic').attr('src', $('.grid-photos__pic-pic:nth-child('+(newIndex+1)+') img').attr('src'));
			$('.modal-gallery').attr('data-index', newIndex);
		})
	});

	$(".wpcf7-select option:first").prop('disabled', true);

	/* 
	*
	* SLIDERS
	*
	*/

	
	/* HOME : CAROUSEL TEMOIGNAGES (Anne) */
	$(".testimonials").slick({
		dots: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		infinite: true,
		adaptiveHeight: true,
		arrows: false,
		lazyLoad: "ondemand",
		mobileFirst: true,
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					dots : false,
					arrows: true,
					prevArrow: ".testimonials-blocks__nav--prev",
					nextArrow:".testimonials-blocks__nav--next",
				}
			},
			{
				breakpoint: 1280,
				settings: {
					centerPadding: "150px",
					centerMode: true,
					slidesToShow: 1,
					slidesToScroll: 1,
					dots : false,
					arrows: true,
					prevArrow: ".testimonials-blocks__nav--prev",
					nextArrow:".testimonials-blocks__nav--next",
				}
			},
			{
				breakpoint: 1366,
				settings: {
					centerPadding: "150px",
					centerMode: true,
					slidesToShow: 1,
					slidesToScroll: 1,
					dots : false,
					arrows: true,
					prevArrow: ".testimonials-blocks__nav--prev",
					nextArrow:".testimonials-blocks__nav--next",
				}
			},
			{
				breakpoint: 1540,
				settings: {
					centerPadding: "250px",
					centerMode: true,
					slidesToShow: 1,
					slidesToScroll: 1,
					dots : false,
					arrows: true,
					prevArrow: ".testimonials-blocks__nav--prev",
					nextArrow:".testimonials-blocks__nav--next",
				}
			},
		]
	});

	$(".slider-blog").slick({
		dots : true,
		slideToShow: 1,
	});

	$(".entite__projets--prev").slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: true,
		prevArrow: ".navPrevHistoriqueCreation",
		nextArrow: ".navNextHistoriqueCreation",
		mobileFirst: true,
		responsive: [
			{
				breakpoint: 767,
				settings: {
					slidesToShow: 2,
				}
			},
		]
	})

	$(".entite__projets--next").slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: true,
		prevArrow: ".navPrevProchainesCreations",
		nextArrow: ".navNextProchainesCreations",
		mobileFirst: true,
		responsive: [
			{
				breakpoint: 767,
				settings: {
					slidesToShow: 2,
				}
			},
		]
	})

	if(window.innerWidth > 767 || $('.entite__projets--now .card').length > 1){
		$(".entite__projets--now").slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: true,
			prevArrow: ".navPrevNowCreation",
			nextArrow: ".navNextNowCreation",
			mobileFirst: true,
			responsive: [
				{
					breakpoint: 767,
					settings: {
						slidesToShow: 2,
						gap: 20
					}
				},
			]
		})
	}else{
		$('.navNextNowCreation').css('display', 'none');
		$('.navPrevNowCreation').css('display', 'none');
	}



	/* HOMEPAGE SEARCHBOX -> RECHERCHE (Anne) */
	$('.submitFilters').on('click', function () {
		filterList();
	});

	/* HOMEPAGE SEARCHBOX -> TOGGLE FILTRES (Anne) */
	$('.searchDropDown').click(function (e) {
		var button = $('.searchDropDown');
		var dropdown = $('.searchDropDown').next();

		if ($(this).hasClass("is-active")) {
			$(this).removeClass('is-active').next().slideUp(150);
		}
		else {
			button.removeClass('is-active');
			dropdown.slideUp(150);
			$(this).addClass('is-active').next().slideDown(150);
		}
	});
	$(document).click(function (e) {
		var target = e.target;
		var button = '.searchDropDown';
		var dropdown = '.searchDropDown + *';
		if (!$(target).is(button) && !$(target).parents().is(dropdown) && !$(target).parents().is(button)) {
			$(button).removeClass('is-active');
			$(dropdown).slideUp(150);
		}
	});

	/* MON COMPTE : AFFICHAGE DES TABS EN VMOBILE (Anne) */
	$('#filterPrincipal').click(function (e) {
		if ($('#tabMobile').hasClass("show")) {
			$('#tabMobile').removeClass("show");
			$('#filterPrincipal').removeClass("open");
		} else {
			$('#tabMobile').addClass("show");
			$('#filterPrincipal').addClass("open");
		}
	})


	// $('.ihc-form-create-edit').append('<a href="#" class="showPayment">Valider</a>')
	// $('.showPayment').on('click', function(e) {
	// 	e.preventDefault()
	// 	$('.iump-submit-form, #ihc_checkout_page_wrapp').show()
	// 	$('.iump-submit-form, #ihc_checkout_page_wrapp').show()
	// })

	if ( $('#createuser').length > 0 ) {
		let idUser = getCookie('sc_id_u')
		let rand = Date.now()
		
		if (idUser) {
			$('input[name^=user_login]').val(`ID ${idUser} fake ${rand}`)
			$('input[name^=user_email]').val(`${idUser}-${rand}@sc.com`)
			$('input[name^=pass1]').val(`${randomIntFromInterval(1000000,10700000)}`)
			$('input[name^=user_login]').prop('readonly', true)
			$('input[name^=user_email]').prop('readonly', true)
			$('input[name^=pass1]').prop('readonly', true)
		} 
		// else if (idUserUpdateAdd) {
		// 	$('input[name^=user_login]').val(`ID ${idUserUpdateAdd} fake ${rand}`)
		// 	$('input[name^=user_email]').val(`${idUserUpdateAdd}-${rand}@sc.com`)
		// 	$('input[name^=pass1]').val(`${randomIntFromInterval(1000000,10700000)}`)
		// }
	}

		/* TEST pill positionnement */
	// $(document).ready(function() {
	// 	if ($('.form-step__form').css('display') == 'none' ) {
	// 		$('.number-pill').addClass('number-pill--closed')
	// 	}
	// })


	if ( $('.page-template-liste-reseaux .page-numbers').length > 0) {
		$('.page-numbers.next').hide()
		$('.page-numbers.prev').hide()
		$('.page-template-liste-reseaux .page-numbers').on('click', function (e) {
			e.preventDefault()
			let nbPerPage = 9
			// let pages = ($(this).hasClass('next')) ? parseInt($('.page-numbers.current').html()) : parseInt($(this).html())
			let pages = parseInt($(this).html())
			let pageStart = ((pages-1) * nbPerPage)+1 
			let pageEnd = pageStart + nbPerPage
			if(pages != '…') {
				$('.itemPage').hide()

				$('.page-numbers').removeClass('current')
				// if($(this).hasClass('next')) {
				// 	$(".page-numbers").filter(function() {
				// 		return parseInt($(this).text()) === pages+1
				// 	}).addClass('current')
				// } else {
					$(this).addClass('current')
				// }
				for (let index = (pageStart - 1); index < (pageEnd - 1); index++) {
					$('.itemPage[data-item="' + index + '"').show()
				}
			}
			
		})
	}

	if ( $('.page-template-liste-scenes .page-numbers').length > 0) {
		$('.page-numbers.next').hide()
		$('.page-numbers.prev').hide()
		$('.page-template-liste-scenes .page-numbers').on('click', function (e) {
			e.preventDefault()
			let nbPerPage = 9
			// let pages = ($(this).hasClass('next')) ? parseInt($('.page-numbers.current').html()) : parseInt($(this).html())
			let pages = parseInt($(this).html())
			let pageStart = ((pages-1) * nbPerPage)+1 
			let pageEnd = pageStart + nbPerPage
			if(pages != '…') {
				$('.itemPage').hide()

				$('.page-numbers').removeClass('current')
				// if($(this).hasClass('next')) {
				// 	$(".page-numbers").filter(function() {
				// 		return parseInt($(this).text()) === pages+1
				// 	}).addClass('current')
				// } else {
					$(this).addClass('current')
				// }
				for (let index = (pageStart - 1); index < (pageEnd - 1); index++) {
					$('.itemPage[data-item="' + index + '"').show()
				}
			}
			
		})
	}

	if ( $('.page-template-liste-compagnies .page-numbers').length > 0) {
		$('.page-numbers.next').hide()
		$('.page-numbers.prev').hide()
		$('.page-template-liste-compagnies .page-numbers').on('click', function (e) {
			e.preventDefault()
			let nbPerPage = 9
			// let pages = ($(this).hasClass('next')) ? parseInt($('.page-numbers.current').html()) : parseInt($(this).html())
			let pages = parseInt($(this).html())
			let pageStart = ((pages-1) * nbPerPage)+1 
			let pageEnd = pageStart + nbPerPage
			if(pages != '…') {
				$('.itemPage').hide()

				$('.page-numbers').removeClass('current')
				// if($(this).hasClass('next')) {
				// 	$(".page-numbers").filter(function() {
				// 		return parseInt($(this).text()) === pages+1
				// 	}).addClass('current')
				// } else {
					$(this).addClass('current')
				// }
				for (let index = (pageStart - 1); index < (pageEnd - 1); index++) {
					$('.itemPage[data-item="' + index + '"').show()
				}
			}
			
		})
	}

	if ( $('.page-template-liste-projets .page-numbers').length > 0) {
		$('.page-numbers.next').hide()
		$('.page-numbers.prev').hide()
		$('.page-template-liste-projets .page-numbers').on('click', function (e) {
			e.preventDefault()
			let nbPerPage = 9
			// let pages = ($(this).hasClass('next')) ? parseInt($('.page-numbers.current').html()) : parseInt($(this).html())
			let pages = parseInt($(this).html())
			let pageStart = ((pages-1) * nbPerPage)+1 
			let pageEnd = pageStart + nbPerPage
			if(pages != '…') {
				$('.itemPage').hide()

				$('.page-numbers').removeClass('current')
				// if($(this).hasClass('next')) {
				// 	$(".page-numbers").filter(function() {
				// 		return parseInt($(this).text()) === pages+1
				// 	}).addClass('current')
				// } else {
					$(this).addClass('current')
				// }
				for (let index = (pageStart - 1); index < (pageEnd - 1); index++) {
					$('.itemPage[data-item="' + index + '"').show()
				}
			}
			
		})
	}

	function requestSoutien() {
		if ($(".btnSoutienProjetEntite").length > 0) {
			$(".btnSoutienProjetEntite").on('click', function(e){
				e.preventDefault()
				
				var idprojet = $(this).data('projet')

				$('.add-reseau-popin__title h3').html("Merci de patienter...");
				$('.overlay').addClass('is-visible');
				$('.add-reseau-popin').addClass('is-visible');

				let request = $.ajax({
					url: "/wp-json/sc/v1/add-soutien",
					type: "POST",
					data: {
						idprojet: idprojet,
					}
				})

				request.done(function(rep){
					let request = $.ajax({
						url: window.location.href,
						type: "GET"
					})
					request.done(function(p) {
						let listR = $(p).find('.cardAction').html()
						$('.cardAction').html(listR)
						eventReload()
						if (rep == 1) {
							// alert("Votre soutien a bien été enregistrée")
							location.reload();
						} else if (rep == "exist") {
							// alert("Votre soutien a déjà été enregistrée")
							$('.add-reseau-popin__title h3').html("Votre soutien a déjà été enregistré");
							setTimeout(function(){
								$('.overlay').removeClass('is-visible');
								$('.add-reseau-popin').removeClass('is-visible');
							}, 5000)
						} else {
							// alert("Une erreur est survenue lors de l'enregistrement, veuillez ressayer plus tard")
							$('.add-reseau-popin__title h3').html("Une erreur est survenue lors de l'enregistrement, veuillez ressayer plus tard");
							setTimeout(function(){
								$('.overlay').removeClass('is-visible');
								$('.add-reseau-popin').removeClass('is-visible');
							}, 5000)
						}
					})
				})

			})
		}
	}

	function requestRecommandation() {
		if ($('form[name^=formRecommandationProjetEntite]').length > 0) {
			$("form[name^=formRecommandationProjetEntite]").on('submit', function(e){
				e.preventDefault()
				let texte = $('textarea[name^="recommandation-text"]').val()
				let idprojet = $(this).data('projet')

				$('.add-reseau-popin__title h3').html("Merci de patienter...");
				$('.overlay').addClass('is-visible');
				$('.recommand-modal').removeClass('is-visible');
				$('.add-reseau-popin').addClass('is-visible');
				
				let request = $.ajax({
					url: "/wp-json/sc/v1/add-recommandation",
					type: "POST",
					data: {
						idprojet: idprojet,
						texte: texte
					}
				})
	
				request.done(function(rep){
						let request = $.ajax({
							url: window.location.href,
							type: "GET"
						})
						request.done(function(p) {
							let listR = $(p).find('.cardAction').html()
							$('.cardAction').html(listR)
							eventReload()
							if (rep == 1) {
								// alert("Votre recommandation a bien été enregistrée")
								location.reload();
							} else if (rep == "exist") {
								// alert("Votre recommandation a déjà été enregistrée")
								$('.add-reseau-popin__title h3').html("Votre recommandation a déjà été enregistrée");
								setTimeout(function(){
									$('.overlay').removeClass('is-visible');
									$('.add-reseau-popin').removeClass('is-visible');
								}, 5000)
							} else {
								// alert("Une erreur est survenue lors de l'enregistrement, veuillez ressayer plus tard")
								$('.add-reseau-popin__title h3').html("Une erreur est survenue lors de l'enregistrement, veuillez ressayer plus tard");
								setTimeout(function(){
									$('.overlay').removeClass('is-visible');
									$('.add-reseau-popin').removeClass('is-visible');
								}, 5000)
							}
					})
				})
			})
		}
	}
	

	function requestAddEntiteReseauFromProject() {
		
		if ($('.btnAddEntiteReseauFromProject').length > 0) {
			$('.btnAddEntiteReseauFromProject').on('click', function(e){
				e.preventDefault()
				let idprojet = $(this).data('projet')

				$('.add-reseau-popin__title h3').html("Merci de patienter...");
				$('.overlay').addClass('is-visible');
				$('.add-reseau-popin').addClass('is-visible');

				let request = $.ajax({
					url: "/wp-json/sc/v1/add-reseau-from-project",
					type: "POST",
					data: {
						idprojet: idprojet,
					}
				})

				request.done(function(rep){
						let request = $.ajax({
							url: window.location.href,
							type: "GET"
						})
						request.done(function(p) {
							let listR = $(p).find('.cardAction').html()
							$('.cardAction').html(listR)
							eventReload()
						if (rep == 1) {
							// alert("Votre demande a bien été enregistrée")
							$('.add-reseau-popin__title h3').html("Votre demande a bien été enregistrée");
						} else if (rep == "exist") {
							// alert("Votre demande a déjà été traité")
							$('.add-reseau-popin__title h3').html("Votre demande a déjà été traitée");
						} else {
							// alert("Une erreur est survenue lors de l'enregistrement, veuillez ressayer plus tard")
							$('.add-reseau-popin__title h3').html("Une erreur est survenue lors de l'enregistrement, veuillez ressayer plus tard");
						}
						setTimeout(function(){
							$('.overlay').removeClass('is-visible');
							$('.add-reseau-popin').removeClass('is-visible');
						}, 5000)
					})
				})
			})
		}
	}


function requestAddEntiteReseauFromEntite() {
		
	if ($('.btnAddEntiteReseauFromEntite').length > 0) {
		$('.btnAddEntiteReseauFromEntite').on('click', function(e){
			e.preventDefault()
			let identite = $(this).data('entite')

			$('.add-reseau-popin__title h3').html("Merci de patienter...");
			$('.overlay').addClass('is-visible');
			$('.add-reseau-popin').addClass('is-visible');

			let request = $.ajax({
				url: "/wp-json/sc/v1/add-reseau-from-entite",
				type: "POST",
				data: {
					identite: identite
				}
			})

			request.done(function(rep){
					let request = $.ajax({
						url: window.location.href,
						type: "GET"
					})
					request.done(function(p) {
						let listR = $(p).find('.cardAction').html()
						$('.cardAction').html(listR)
						eventReload()
					if (rep == 1) {
						// alert("Votre demande a bien été enregistrée")
						$('.add-reseau-popin__title h3').html("Votre demande a bien été enregistrée");
					} else if (rep == "exist") {
						// alert("Votre demande a déjà été traité")
						$('.add-reseau-popin__title h3').html("Votre demande a déjà été traitée");
					} else {
						// alert("Une erreur est survenue lors de l'enregistrement, veuillez ressayer plus tard")
						$('.add-reseau-popin__title h3').html("Une erreur est survenue lors de l'enregistrement, veuillez ressayer plus tard");
					}
					setTimeout(function(){
						window.location.reload();
					}, 5000)
				})
			})
		})
	}
}


	function requestFriendAcceptClick() {
		if ($('.requestFriendAccept').length > 0) {
			$('.requestFriendAccept').on('click', function(e) {
				e.preventDefault()
				let identite = $(this).data('entite')

				$('.add-reseau-popin__title h3').html("Merci de patienter...");
				$('.overlay').addClass('is-visible');
				$('.add-reseau-popin').addClass('is-visible');
	
				let request = $.ajax({
					url: "/wp-json/sc/v1/add-friend-reseau-entite",
					type: "POST",
					data: {
						identite: identite
					}
				})
	
				request.done(function(rep){
					let request = $.ajax({
						url: "/mon-compte",
						type: "GET"
					})
					request.done(function(p) {
						let listR = $(p).find('#accountTab3Content').html()
						$('#accountTab3Content').html(listR)
						eventReload()
						if (rep == 1) {
							// alert("Votre demande a bien été enregistrée")
							$('.add-reseau-popin__title h3').html("Votre demande a bien été enregistrée");
						} else if (rep == "exist") {
							// alert("Votre demande a déjà été traité")
							$('.add-reseau-popin__title h3').html("Votre demande a déjà été traitée");
						} else {
							// alert("Une erreur est survenue lors de l'enregistrement, veuillez ressayer plus tard")
							$('.add-reseau-popin__title h3').html("Une erreur est survenue lors de l'enregistrement, veuillez ressayer plus tard");
						}
						setTimeout(function(){
							$('.overlay').removeClass('is-visible');
							$('.add-reseau-popin').removeClass('is-visible');
						}, 5000)
					})
	
				})
	
			})
		}
	}
	
	function requestFriendDelete() {
		if ($('.requestFriendDelete').length > 0) {
			$('.requestFriendDelete').on('click', function(e) {
				e.preventDefault()
				let identite = $(this).data('entite')

				$('.add-reseau-popin__title h3').html("Merci de patienter...");
				$('.overlay').addClass('is-visible');
				$('.add-reseau-popin').addClass('is-visible');
	
				let request = $.ajax({
					url: "/wp-json/sc/v1/delete-friend-reseau-entite",
					type: "POST",
					data: {
						identite: identite
					}
				})
	
				request.done(function(rep){
					let request = $.ajax({
						url: "/mon-compte",
						type: "GET"
					})
					request.done(function(p) {
						let listR = $(p).find('#accountTab3Content').html()
						$('#accountTab3Content').html(listR)
						eventReload()
						if (rep == 1) {
							// alert("Votre demande a bien été enregistrée")
							$('.add-reseau-popin__title h3').html("Votre demande a bien été enregistrée");
						} else if (rep == "exist") {
							// alert("Votre demande a déjà été traité")
							$('.add-reseau-popin__title h3').html("Votre demande a déjà été traitée");
						} else {
							// alert("Une erreur est survenue lors de l'enregistrement, veuillez ressayer plus tard")
							$('.add-reseau-popin__title h3').html("Une erreur est survenue lors de l'enregistrement, veuillez ressayer plus tard");
						}
						setTimeout(function(){
							$('.overlay').removeClass('is-visible');
							$('.add-reseau-popin').removeClass('is-visible');
						}, 5000)
					})
				})
	
			})
		}
	}

	function requestRecommandationDelete() {
		if ($('.requestRecommandationDelete').length > 0) {
			$('.requestRecommandationDelete').on('click', function(e) {
				e.preventDefault()
				let identite = $(this).data('entite')

				$('.add-reseau-popin__title h3').html("Merci de patienter...");
				$('.overlay').addClass('is-visible');
				$('.add-reseau-popin').addClass('is-visible');
	
				let request = $.ajax({
					url: "/wp-json/sc/v1/delete-recommandation-entite",
					type: "POST",
					data: {
						identite: identite
					}
				})
	
				request.done(function(rep){
					let request = $.ajax({
						url: "/mon-compte",
						type: "GET"
					})
					request.done(function(p) {
						let listR = $(p).find('#accountTab7Content').html()
						$('#accountTab7Content').html(listR)
						eventReload()
						if (rep == 1) {
							// alert("Votre demande a bien été enregistrée")
							$('.add-reseau-popin__title h3').html("Votre demande a bien été enregistrée");
						} else if (rep == "exist") {
							// alert("Votre demande a déjà été traité")
							$('.add-reseau-popin__title h3').html("Votre demande a déjà été traitée");
						} else {
							// alert("Une erreur est survenue lors de l'enregistrement, veuillez ressayer plus tard")
							$('.add-reseau-popin__title h3').html("Une erreur est survenue lors de l'enregistrement, veuillez ressayer plus tard");
						}
						setTimeout(function(){
							$('.overlay').removeClass('is-visible');
							$('.add-reseau-popin').removeClass('is-visible');
						}, 5000)
					})
				})
	
			})
		}
	}

	if ($('.changeStatusProjectAccount').length > 0) {
		$('.changeStatusProjectAccount').on('click', function(e) {
			e.preventDefault()
			let idprojet = $(this).data('idprojet')
			let status = $(this).data('status')
			let that = this

			$('.add-reseau-popin__title h3').html("Merci de patienter...");
			$('.overlay').addClass('is-visible');
			$('.add-reseau-popin').addClass('is-visible');

			let request = $.ajax({
				url: "/wp-json/sc/v1/set-status-projet",
				type: "POST",
				data: {
					idprojet: idprojet,
					status: status
				}
			})

			request.done(function(rep){
				if (rep == 1) {
					// alert("Votre demande a bien été enregistrée")
					$('.add-reseau-popin__title h3').html("Votre demande a bien été enregistrée");
					if (status == 'draft') {
						$(that).data('status', 'publish')
						$(that).html('Mettre en ligne')
						$(that).removeClass('btn--third-orange')
						$(that).addClass('btn--third-grey')
					} else {
						$(that).data('status', 'draft')
						$(that).html('Archiver')
						$(that).removeClass('btn--third-grey')
						$(that).addClass('btn--third-orange')
					}
				} else if (rep == "exist") {
					// alert("Votre demande a déjà été traité")
					$('.add-reseau-popin__title h3').html("Votre demande a déjà été traitée");
				} else {
					// alert("Une erreur est survenue lors de l'enregistrement, veuillez ressayer plus tard")
					$('.add-reseau-popin__title h3').html("Une erreur est survenue lors de l'enregistrement, veuillez ressayer plus tard");
				}
				setTimeout(function(){
					$('.overlay').removeClass('is-visible');
					$('.add-reseau-popin').removeClass('is-visible');
				}, 5000)
			})

			

		})
	}
	
	if ($('.deleteProjectAccount').length > 0) {
		$('.deleteProjectAccount').on('click', function(e) {
			e.preventDefault()
			let idprojet = $(this).data('idprojet')
			let titleProjet = $(this).parents('.card-horizontal').find('.card-horizontal__title').html().trim()
			let that = this

			let conf = confirm("Êtes-vous sur de vouloir supprimer ce projet ? " + '(' + titleProjet + ')')
			if (conf) {

				$('.add-reseau-popin__title h3').html("Merci de patienter...");
				$('.overlay').addClass('is-visible');
				$('.add-reseau-popin').addClass('is-visible');

				let request = $.ajax({
					url: "/wp-json/sc/v1/delete-projet",
					type: "POST",
					data: {
						idprojet: idprojet
					}
				})

				request.done(function(rep){
					if (rep == 1) {
						// alert("Votre demande a bien été enregistrée")
						$('.add-reseau-popin__title h3').html("Votre demande a bien été enregistrée");
						$(that).parents('.card-horizontal').remove()
					} else if (rep == "exist") {
						// alert("Votre demande a déjà été traité")
						$('.add-reseau-popin__title h3').html("Votre demande a déjà été traitée");
					} else {
						// alert("Une erreur est survenue lors de l'enregistrement, veuillez ressayer plus tard")
						$('.add-reseau-popin__title h3').html("Une erreur est survenue lors de l'enregistrement, veuillez ressayer plus tard");
					}
					setTimeout(function(){
						$('.overlay').removeClass('is-visible');
						$('.add-reseau-popin').removeClass('is-visible');
					}, 5000)
				})
			}

			

		})
	}

	if ($('.deleteAppelProjet').length > 0) {
		$('.deleteAppelProjet').on('click', function(e) {
			e.preventDefault()
			let idappelprojet = $(this).data('idappelprojet')
			let that = this

			let conf = confirm("Êtes-vous sur de vouloir supprimer cette recherche ? ")
			if (conf) {

				$('.add-reseau-popin__title h3').html("Merci de patienter...");
				$('.overlay').addClass('is-visible');
				$('.add-reseau-popin').addClass('is-visible');

				let request = $.ajax({
					url: "/wp-json/sc/v1/delete-appel-projet",
					type: "POST",
					data: {
						idappelprojet: idappelprojet
					}
				})

				request.done(function(rep){
					if (rep == 1) {
						// alert("Votre demande a bien été enregistrée")
						$('.add-reseau-popin__title h3').html("Votre demande a bien été enregistrée");
						$(that).parents('.card-horizontal').remove()
					} else if (rep == "exist") {
						// alert("Votre demande a déjà été traité")
						$('.add-reseau-popin__title h3').html("Votre demande a déjà été traitée");
					} else {
						// alert("Une erreur est survenue lors de l'enregistrement, veuillez ressayer plus tard")
						$('.add-reseau-popin__title h3').html("Une erreur est survenue lors de l'enregistrement, veuillez ressayer plus tard");
					}
					setTimeout(function(){
						$('.overlay').removeClass('is-visible');
						$('.add-reseau-popin').removeClass('is-visible');
					}, 5000)
				})
			}

			

		})
	}


	if ($('.btnDeleteSubscription').length > 0) {
		$('.btnDeleteSubscription').on('click', function(e) {
			e.preventDefault()
			let conf = confirm("Êtes-vous sur de vouloir résilier votre abonnement ? ")
			if (conf) {
				window.location = $(this).attr('href')
			}
		})
	}


	function eventReload() {
		requestAddEntiteReseauFromEntite()
		requestAddEntiteReseauFromProject()
		requestSoutien()
		requestRecommandation()
		requestRecommandationDelete()
		requestFriendAcceptClick()
		requestFriendDelete()
	}
	

	eventReload()


	$( window ).load(function() {
		/* payment : ajout recap */
		if($('#ihc-checout-page-purchase-subscription-details-section').length && $('.payment-block').length){
			$('.payment-block').prepend($('#ihc-checout-page-purchase-subscription-details-section').html());
			$('.ihc-product-trial-fee-label').html("Paiement initial");
			$('tr:not(.ihc-then-payment-wrapper) td .ihc-product-price span:first-child').html("Gratuit");
			$('.ihc-product-price-detail').html("pendant 90 jours");
			$('.ihc-then-payment-wrapper').find('.ihc-product-main-fee-label').html("Puis");
			$('.ihc-then-payment-wrapper').find('.ihc-product-price-detail').html("chaque année");
		}

		/* toggle menu mon compte mobile */
		if($('.account__menu--desktop').length && window.innerWidth < 1024){
			$('.account__menu--desktop button.inactive').addClass('button-hidden');
		}
		$('.account__menu--desktop button').on('click', function(){
			$('.account__menu--desktop button.inactive').toggleClass('button-hidden');
		})

		/* open filtres mobile liste reseaux/projets */
		$('body').on('click', '.top-filters__title-mobile__open', function(){
			$('.top-filters').css('left', '0');
		})

		/* close filtres mobile liste reseaux/projets */
		$('body').on('click', '.top-filters__title-mobile__close', function(){
			$('.top-filters').css('left', '100%');
		})		

		/* ajout " ..." à la description dans les cards trop longues */
		if($('.card__text-4').length){
			$('.card__text-4').each(function(){
				if( Math.round($(this).prop("scrollHeight")) > (Math.round($(this).height()) + 1) ){
					$(this).addClass('card__text-4-ellipsis');
				}
			})
		}
	});
	
	if ($('.payment-block').length > 0) {
		//init payment method
		let p = $('.tab__payment-registers__option.active-tab')
		if (p.length > 0) {
			let paymentMethod = p.data('payment')
			$('input[name^=ihc_payment_gateway]').val(paymentMethod)
			$('input[name^=payment_selected]').val(paymentMethod)
		}

		//checbox active submit
		$('input[name^=acceptCGV]').on('change', function(e) {
			e.preventDefault()
			let acceptCGVIsChecked = $(this).is(':checked')
			let parent = $(this).parents('.tab__payment-bodies__body')
			if (parent.length > 0) {
				let submitBtn = parent.find('input[type^="submit"]')
				let acceptCollectData = parent.find('input[name^=acceptCollectData]')
				let acceptCollectDataIsChecked = acceptCollectData.is(':checked')
				if (acceptCGVIsChecked && acceptCollectDataIsChecked) {
					submitBtn.prop('disabled', false);
				} else {
					submitBtn.prop('disabled', true);
				}
			}
		})
		$('input[name^=acceptCollectData]').on('change', function(e) {
			e.preventDefault()
			let acceptCollectDataIsChecked = $(this).is(':checked')
			let parent = $(this).parents('.tab__payment-bodies__body')
			if (parent.length > 0) {
				let submitBtn = parent.find('input[type^="submit"]')
				let acceptCGV = parent.find('input[name^=acceptCGV]')
				let acceptCGVIsChecked = acceptCGV.is(':checked')
				if (acceptCGVIsChecked && acceptCollectDataIsChecked) {
					submitBtn.prop('disabled', false);
				} else {
					submitBtn.prop('disabled', true);
				}
			}
		})

		// Array.from(document.querySelectorAll('.tabs__payments')).forEach((tab_container, TabID) => {
		// 	const registers = tab_container.querySelector('.tab__payment-registers');
		// 	const bodies = tab_container.querySelector('.tab__payment-bodies');
	
		// 	Array.from(registers.children).forEach((el, i) => {
		// 		el.setAttribute('aria-controls', `${TabID}_${i}`)
		// 		bodies.children[i]?.setAttribute('id', `${TabID}_${i}`)
	
		// 		el.addEventListener('click', (ev) => {
		// 			let activeRegister = registers.querySelector('.active-tab');
		// 			activeRegister.classList.remove('active-tab')
		// 			activeRegister = el;
		// 			activeRegister.classList.add('active-tab')
		// 			let payment = $(activeRegister).data('payment')
		// 			$('input[name^=ihc_payment_gateway]').val(payment)
		// 			$('input[name^=payment_selected]').val(payment)
		// 			changeBody(registers, bodies, activeRegister)
		// 		})
		// 	})
		// })
	
	
		// function changeBody(registers, bodies, activeRegister) {
		// 	Array.from(registers.children).forEach((el, i) => {
		// 		if (bodies.children[i]) {
		// 			bodies.children[i].style.display = el == activeRegister ? 'block' : 'none'
		// 		}
		// 		el.setAttribute('aria-expanded', el == activeRegister ? 'true' : 'false')
		// 	})
		// }


		$('.tab__payment-bodies__tab-mobile').on('click', function(){
			$('.tab__payment-bodies__body').css('display', 'none');
			$('.tab__payment-registers__option').removeClass('active-tab');
			$('.tab__payment-bodies__tab-mobile').removeClass('active-tab');
			$('.tab__payment-bodies__body-'+$(this).attr('data-id')).css('display', 'block');
			$(this).addClass('active-tab');
			$('.tab__payment-registers__option[data-id='+$(this).attr('data-id')+']').addClass('active-tab');
			$('input[name^=ihc_payment_gateway]').val($(this).attr('data-payment'));
			$('input[name^=payment_selected]').val($(this).attr('data-payment'));
		})


		$('.tab__payment-registers__option').on('click', function(){
			$('.tab__payment-bodies__body').css('display', 'none');
			$('.tab__payment-registers__option').removeClass('active-tab');
			$('.tab__payment-bodies__tab-mobile').removeClass('active-tab');
			$('.tab__payment-bodies__body-'+$(this).attr('data-id')).css('display', 'block');
			$(this).addClass('active-tab');
			$('.tab__payment-bodies__tab-mobile[data-id='+$(this).attr('data-id')+']').addClass('active-tab');
			$('input[name^=ihc_payment_gateway]').val($(this).attr('data-payment'));
			$('input[name^=payment_selected]').val($(this).attr('data-payment'));
		})



	}
})(window, jQuery);