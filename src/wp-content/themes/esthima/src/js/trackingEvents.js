export class TrackingEvents {

    constructor() {
        this.init()
    }

    init() {
        this.pageType = jQuery('title').text()
        this.bodyEl = jQuery('body')
     
        this.assocNameByURI = {
            'Page Prestation': 'nos-prestations',
            'Page Prestation - Incinération': 'incineration',
            'Page Tarif': 'tarifs',
            'Page Prise en charge':'comment-proceder',
            'Page Urgence décés':'urgence-deces',
            'Page Hommage':'temoignages',
        }

        this.assocNameByClassBody = {
            'home':'Homepage',
            'page-template-mon-compte':'Compte',
            'archive':'Page Liste',
            'single-product':'Page Produit',
            'page-template-contact':'Page contact',
            'page-template-store-locator':'Page Store Location',
            'page-template-shop-hp':'Boutique',
            'page-template-presse':'Espace Presse',
            'page-template-rdv':'Prise de RDV',
            // '':'Formulaire Contrat Obséques',
        }
      

        for (let [ka, va] of Object.entries(this.assocNameByURI)) {
            if (window.location.href.indexOf(va) !== -1) {
                this.pageType = ka
            }
        }

        for (let [k, v] of Object.entries(this.assocNameByClassBody)) {
            if (this.bodyEl.hasClass(k)) {
                this.pageType = v
            }
        }
    }
    
    listen() {
        this.pushEventsNavigationHeader()
        this.pushEventsNavigationFooter()
        this.pushEventsNewsletter()
        this.pushEventsVideo()
        this.pushEventsHomepage()
        this.pushEventsAccount()
        this.pushEventsPageListe()
        this.pushEventsPageProduit()
        this.pushEventsPagePrestation()
        this.pushEventsPageTarif()
        this.pushEventsPagePriseEnCharge()
        this.pushEventsPageUrgenceDeces()
        this.pushEventsPageHommage()
        this.pushEventsContact()
        this.pushEventsStoreLocation()
        this.pushEventsBoutique()
        this.pushEventsEspacePress()
    }

    pushEventsNavigationHeader() {

        // Clic sur le menu flottant
        jQuery('.header__pink .header__pink__item').on('click', (e) => {
            let eventLabel = jQuery(e.currentTarget).text().replace(/(\n|\t|\r)/gm, "")
            window.dataLayer.push({
                'event': 'clickMenu',
                'eventCategory': this.pageType,
                'eventAction': 'Clic Menu',
                'eventLabel': eventLabel
            });
        })
        
        // Clic sur les libéllés du menu Niveau 1
        jQuery('.header__menu .header__menu__main #menu-header-main > li > a').on('click', (e) => {
            let eventLabel = jQuery(e.currentTarget).text().replace(/(\n|\t|\r)/gm, "")
            window.dataLayer.push({
                'event': 'clickMenuLvl1',
                'eventCategory': this.pageType,
                'eventAction': 'Menu Level 1',
                'eventLabel': eventLabel
            });
        })

        // Clic sur les libéllés du menu Niveau 2
        jQuery('.header__menu .header__menu__main #menu-header-main > li > ul > li > a').on('click', (e) => {
            let eventLabel = jQuery(e.currentTarget).text().replace(/(\n|\t|\r)/gm, "")
            window.dataLayer.push({
                'event': 'clickMenuLvl2',
                'eventCategory': this.pageType,
                'eventAction': 'Menu Level 2',
                'eventLabel': eventLabel
            });
        })
        
        // Validation recherche Header (entrée) ou clique produit proposé - pas de liste donc au change
        jQuery('.search-field').on('change', (e) => {
            let eventLabel = jQuery(e.currentTarget).val()
            window.dataLayer.push({
                'event': 'clickHeaderSearch',
                'eventCategory': this.pageType,
                'eventAction': 'Header - Recherche',
                'eventLabel': eventLabel
            });
        })
       
        // Clic appel
        jQuery('.search-field').on('click', (e) => {
            window.dataLayer.push({
                'event': 'clickHeaderTel',
                'eventCategory': this.pageType,
                'eventAction': 'Header - Tel',
                'eventLabel': ''
            });
        })
       
        // Clic sur le fil d'Ariane
        jQuery('.yoast-breadcrumbs a').on('click', (e) => {
            let eventLabel = jQuery(e.currentTarget).text()
            window.dataLayer.push({
                'event': 'clickBreadcrumb',
                'eventCategory': this.pageType,
                'eventAction': 'Breadcrumb',
                'eventLabel': eventLabel
            });
        })

    }


    pushEventsNavigationFooter() {

        // Clic Newsletter - Footer
        jQuery('.newsletterForm input[type=submit]').on('click', (e) => {
            window.dataLayer.push({
                'event': 'clickFooterNewsletter',
                'eventCategory': this.pageType,
                'eventAction': 'Footer',
                'eventLabel': 'Newsletter'
            });
        })
        
        // Clic CTA - Footer
        jQuery('#menu-footer-main ul > li > a, #menu-footer-second ul > li > a').on('click', (e) => {
            let eventLabel = jQuery(e.currentTarget).text().replace(/(\n|\t|\r)/gm, "")
            window.dataLayer.push({
                'event': 'clickFooter',
                'eventCategory': this.pageType,
                'eventAction': 'Footer',
                'eventLabel': eventLabel
            });
        })

    }

    pushEventsNewsletter() {

        // Clic validation Newsletter
        jQuery('.newsletter__form form').on('submit', (e) => {
            window.dataLayer.push({
                'event': 'clickSendNewsletter',
                'eventCategory': this.pageType,
                'eventAction': 'Envoyer',
                'eventLabel': ''
            });
        })
    }
    
    pushEventsVideo() {

        // Chaque intéraction avec une vidéo
        // jQuery('.newsletter__form form').on('submit', (e) => {
        //     window.dataLayer.push({
        //         'event': 'clickSendNewsletter',
        //         'eventCategory': this.pageType,
        //         'eventAction': 'Envoyer',
        //         'eventLabel': ''
        //     });
        // })

        
    }

    pushEventsHomepage() {
    
        // Clic sur un block
        jQuery('.hp__tet__btns a').last().on('click', (e) => {
            let eventLabel = jQuery(e.currentTarget).text().replace(/(\n|\t|\r)/gm, "")
            window.dataLayer.push({
                'event': 'clickHpCta',
                'eventCategory': this.pageType,
                'eventAction': 'Clic CTA',
                'eventLabel': eventLabel
            });
        })

        // jQuery('.hp__tet__btns a').last().on('click', (e) => {
        //     let eventLabel = jQuery(e.currentTarget).text().replace(/(\n|\t|\r)/gm, "")
        //     window.dataLayer.push({
        //         'event': 'clickHpBlock',
        //         'eventCategory': this.pageType,
        //         'eventAction': 'Clic CTA',
        //         'eventLabel': eventLabel
        //     });
        // })
        
    }

    pushEventsAccount() {

        // Clic connexion compte (eventLabel form pas en ajax donc difficile d avoir l etat)
        jQuery('.woocommerce-form-login').on('submit', (e) => {
            window.dataLayer.push({
                'event': 'clickAccountConnexion',
                'eventCategory': this.pageType,
                'eventAction': 'Connexion',
                'eventLabel': 'Success'
            });
        })
    }


    pushEventsPageListe() {

        // Clic sur les catégories de liste
        jQuery('.yith-wcan-filter.filter-tax.checkbox-design').on('click', (e) => {
            window.dataLayer.push({
                'event': 'clickListCategory',
                'eventCategory': this.pageType,
                'eventAction': 'Catégorie',
                'eventLabel': 'contenance'
            });
        })
        
        jQuery('.yith-wcan-filter.filter-tax.color-design').on('click', (e) => {
            window.dataLayer.push({
                'event': 'clickListCategory',
                'eventCategory': this.pageType,
                'eventAction': 'Catégorie',
                'eventLabel': 'couleur'
            });
        })
        
        jQuery('.yith-wcan-filter.filter-price-slider').on('click', (e) => {
            window.dataLayer.push({
                'event': 'clickListCategory',
                'eventCategory': this.pageType,
                'eventAction': 'Catégorie',
                'eventLabel': 'price'
            });
        })


        // Clic Filtre
        jQuery('.yith-wcan-filter.filter-tax.checkbox-design .filter-items input[type=checkbox]').on('change', (e) => {
            let eventLabel = jQuery(e.currentTarget).val()
            window.dataLayer.push({
                'event': 'clickFilter',
                'eventCategory': this.pageType,
                'eventAction': 'Clic Filtre contenance',
                'eventLabel': eventLabel
            });
        })
        jQuery('.yith-wcan-filter.filter-tax.color-design .filter-items input[type=checkbox]').on('change', (e) => {
            let eventLabel = jQuery(e.currentTarget).val()
            window.dataLayer.push({
                'event': 'clickFilter',
                'eventCategory': this.pageType,
                'eventAction': 'Clic Filtre couleur',
                'eventLabel': eventLabel
            });
        })
        jQuery('.yith-wcan-filter.filter-price-slider .price-slider-ui').on('change', (e) => {
            let eventLabel = jQuery(e.currentTarget).val()
            window.dataLayer.push({
                'event': 'clickFilter',
                'eventCategory': this.pageType,
                'eventAction': 'Clic Filtre price',
                'eventLabel': eventLabel
            });
        })


        // Clic filtre menu
        jQuery('.shop__cats .cat-item a').on('click', (e) => {
            let eventLabel = jQuery(e.currentTarget).text().replace(/(\n|\t|\r)/gm, "")
            window.dataLayer.push({
                'event': 'clickFilter',
                'eventCategory': this.pageType,
                'eventAction': 'Clic Filtre',
                'eventLabel': eventLabel
            });
        })

        // Clic tri
        jQuery('select[name=orderby]').on('change', (e) => {
            let eventLabel = jQuery(e.currentTarget).val()
            window.dataLayer.push({
                'event': 'clickSort',
                'eventCategory': this.pageType,
                'eventAction': 'Trier par',
                'eventLabel': eventLabel
            });
        })
    }


    pushEventsPageProduit() {
        // Clic sur une caractéristique du produit
        jQuery('table.variations select').on('change', (e) => {
            let eventLabel = jQuery(e.currentTarget).val()
            let id = jQuery(e.currentTarget).attr('id')
            let eventAction = "Caractéristique - " + jQuery('label[for=' + id + ']').text().replace(/(\n|\t|\r)/gm, "")
            window.dataLayer.push({
                'event': 'clickProduitCarac',
                'eventCategory': this.pageType,
                'eventAction': eventAction,
                'eventLabel': eventLabel
            });
        })
      
    }


    pushEventsPagePrestation() {

        if (this.pageType.indexOf('prestations') !== -1) {
            // Clic sur une des prestations
            jQuery('.pricing-table.pricing-table--services .pricing-plan').on('click', (e) => {
                let eventAction = jQuery(e.currentTarget).find('.pricing-plan__head').text().replace(/(\n|\t|\r)/gm, "").trim().replace(/\s+/g, ' ')
                window.dataLayer.push({
                    'event': 'clickPrestationCta',
                    'eventCategory': this.pageType,
                    'eventAction': eventAction,
                    'eventLabel': ''
                });
            })

            // Clic sur l'un des CTA
            // jQuery(".wp-block-button a:contains('Demander un devis')").on('click', (e) => {
            jQuery(".wp-block-button a").on('click', (e) => {
                let eventLabel = jQuery(e.currentTarget).text().replace(/(\n|\t|\r)/gm, "").trim().replace(/\s+/g, ' ')
                window.dataLayer.push({
                    'event': 'clickPrestationCta',
                    'eventCategory': this.pageType,
                    'eventAction': 'Clic CTA',
                    'eventLabel': eventLabel
                });
            })
        }
    }

    pushEventsPageTarif() {
        // Clic sur l'un des CTA
        jQuery(".pricing-table .pricing-plan").on('click', (e) => {
            let btnDevisExist = jQuery(e.currentTarget).find("a:contains('Demander un devis')")
            if (btnDevisExist.length > 0) {
                let eventAction = jQuery(e.currentTarget).find('.pricing-plan__head').text().replace(/(\n|\t|\r)/gm, "").trim().replace(/\s+/g, ' ')
                window.dataLayer.push({
                    'event': 'clickTarifDevis',
                    'eventCategory': this.pageType,
                    'eventAction': 'Demande devis',
                    'eventLabel': eventAction
                });
            }
        })
    }

    pushEventsPagePriseEnCharge() {
        // Clic sur un CTA de la page Prise en charge
        if (this.pageType == "Page Prise en charge") {
            // jQuery(".wp-block-button a:contains('Prendre rendez-vous')").on('click', (e) => {
            jQuery(".wp-block-button a").on('click', (e) => {
                let eventAction = jQuery(e.currentTarget).text().replace(/(\n|\t|\r)/gm, "").trim().replace(/\s+/g, ' ')
                window.dataLayer.push({
                    'event': 'clickChargeCTA',
                    'eventCategory': this.pageType,
                    'eventAction': eventAction,
                    'eventLabel': ''
                });
            })
        }

    }
    
    pushEventsPageUrgenceDeces() {
        // Clic sur un CTA de la page Prise en charge
        if (this.pageType == "Page Urgence décés") {
            // jQuery(".wp-block-button a:contains('être rappelé')").on('click', (e) => {
            jQuery(".wp-block-button a").on('click', (e) => {
                let eventLabel = jQuery(e.currentTarget).text().replace(/(\n|\t|\r)/gm, "").trim().replace(/\s+/g, ' ')
                window.dataLayer.push({
                    'event': 'clickUrgenceCta',
                    'eventCategory': this.pageType,
                    'eventAction': 'Clic CTA',
                    'eventLabel': eventLabel
                });
            })
        }
    }


    pushEventsPageHommage() {
        // Clic sur un CTA de la page Hommage
        if (this.pageType == "Page Hommage") {
            jQuery(".wp-block-button a").on('click', (e) => {
                let eventLabel = jQuery(e.currentTarget).text().replace(/(\n|\t|\r)/gm, "").trim().replace(/\s+/g, ' ')
                window.dataLayer.push({
                    'event': 'clickHommageCta',
                    'eventCategory': this.pageType,
                    'eventAction': 'Clic CTA',
                    'eventLabel': eventLabel
                });
            })
        }
    }

    pushEventsContact() {
        // Clic envoyer
        if (this.pageType == "Page contact") {
            jQuery("form").on('submit', (e) => {
                let eventLabel = jQuery('select[name=input_14] option:selected').text().replace(/(\n|\t|\r)/gm, "").trim().replace(/\s+/g, ' ')
                window.dataLayer.push({
                    'event': 'clickSendContact',
                    'eventCategory': this.pageType,
                    'eventAction': 'Envoyer',
                    'eventLabel': eventLabel
                });
            })
        }
    }


    pushEventsStoreLocation() {

        var refreshIdStoreLoc = setInterval(() => {
            if (jQuery("#wpsl-stores .storeloc__map__store").length > 0) {
                 // Clic cta Store loc
                jQuery("#wpsl-stores .storeloc__map__store a").on('click', (e) => {
                    let eventLabel = jQuery(e.currentTarget).text().replace(/(\n|\t|\r)/gm, "").trim().replace(/\s+/g, ' ')
                    let eventAction = jQuery(e.currentTarget).parents('.storeloc__map__store__infos').find('.storeloc__map__store__infos__title').text().replace(/(\n|\t|\r)/gm, "").trim().replace(/\s+/g, ' ')
                    window.dataLayer.push({
                        'event': 'clickCtaStoreLoc',
                        'eventCategory': this.pageType,
                        'eventAction': eventAction,
                        'eventLabel': eventLabel
                    });
                })
              clearInterval(refreshIdStoreLoc);
            }
          }, 2000);
       
    }

    pushEventsBoutique() {
        if (this.pageType == "Boutique") {
            jQuery(".shop__blocks__item .btn").on('click', (e) => {
                let eventAction = jQuery(e.currentTarget).text().replace(/(\n|\t|\r)/gm, "").trim().replace(/\s+/g, ' ')
                let eventLabel = jQuery(e.currentTarget).parents('.shop__blocks__item').find('.shop__blocks__item__texts h2').text().replace(/(\n|\t|\r)/gm, "").trim().replace(/\s+/g, ' ')
                window.dataLayer.push({
                    'event': 'clickDecouvrirCollection',
                    'eventCategory': this.pageType,
                    'eventAction': 'Clic - ' + eventAction,
                    'eventLabel': eventLabel
                });
            })
        }
    }

    pushEventsEspacePress() {
        jQuery(".presse__links .presse__links__item").on('click', (e) => {
            let eventLabel = jQuery(e.currentTarget).find('.presse__links__item__text').text().replace(/(\n|\t|\r)/gm, "").trim().replace(/\s+/g, ' ')
            window.dataLayer.push({
                'event': 'clickCtaPresse',
                'eventCategory': this.pageType,
                'eventAction': 'Clic CTA',
                'eventLabel': eventLabel
            });
        })
    }
     
}