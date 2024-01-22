export class TrackingEvents {

    constructor() {
        this.init()
        this.listen()
    }

    init() {
        this.pageType = jQuery('title').text()
        this.bodyEl = jQuery('body')
     
        this.assocNameByURI = {
            'Page Prestation': 'nos-prestations',
            'Page Prestation - Incinération': 'incineration',
            'Page Tarif': 'tarifs',
            'Page Prise en charge':'comment-proceder',
            'Page Urgence décès':'urgence-deces',
            'Page Hommage':'temoignages',
            'Formulaire Contrat Obséques':'contrat-obseques',
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
        this.pushEventsPriseRDV()
        this.pushEventsCrematoriums()
        this.pushEventsContractObseque()
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
        jQuery('.phone-number__link').on('click', (e) => {
            window.dataLayer.push({
                'event': 'clickHeaderTel',
                'eventCategory': this.pageType,
                'eventAction': 'Header - Tel',
                'eventLabel': ''
            });
        })
       
        // Clic sur le fil d'Ariane
        jQuery('.yoast-breadcrumbs a, .woocommerce-breadcrumb a').on('click', (e) => {
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
        setTimeout(() => {
            jQuery('.newsletter__form form .formSubmit a').on('click', (e) => {
                window.dataLayer.push({
                    'event': 'clickSendNewsletter',
                    'eventCategory': this.pageType,
                    'eventAction': 'Envoyer',
                    'eventLabel': ''
                });
            })
        }, 2000)
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

        jQuery(".main > [class^='hp__']").on('click', (e) => {
            let eventLabelH1 = jQuery(e.currentTarget).find('h1').text().replace(/(\n|\t|\r)/gm, "")
            let eventLabelH2 = jQuery(e.currentTarget).find('h2').text().replace(/(\n|\t|\r)/gm, "")
            let eventLabelH3 = jQuery(e.currentTarget).find('h3').text().replace(/(\n|\t|\r)/gm, "")
            let eventLabel = []
            if (eventLabelH1.length > 0) {
                eventLabel.push(eventLabelH1)
            }
            if (eventLabelH2.length > 0) {
                eventLabel.push(eventLabelH2)
            }
            if (eventLabelH3.length > 0) {
                eventLabel.push(eventLabelH3)
            }
            window.dataLayer.push({
                'event': 'clickHpBlock',
                'eventCategory': this.pageType,
                'eventAction': 'Block',
                'eventLabel': eventLabel.join(' ')
            });
        })
        
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
        jQuery('.inscription__login form input[type=submit]').on('click', (e) => {
            window.dataLayer.push({
                'event': 'clickAccountConnexion',
                'eventCategory': this.pageType,
                'eventAction': 'Connexion',
                'eventLabel': 'Success'
            });
        })
        jQuery('.inscription__register form input[type=submit]').on('click', (e) => {
            window.dataLayer.push({
                'event': 'clickAccountInscription',
                'eventCategory': this.pageType,
                'eventAction': 'Inscription',
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
        // jQuery('.shop__cats .cat-item a').on('click', (e) => {
        //     let eventLabel = jQuery(e.currentTarget).text().replace(/(\n|\t|\r)/gm, "")
        //     window.dataLayer.push({
        //         'event': 'clickFilter',
        //         'eventCategory': this.pageType,
        //         'eventAction': 'Clic Filtre',
        //         'eventLabel': eventLabel
        //     });
        // })
        jQuery('.shop__cats .cat-item a').on('click', (e) => {
            let eventLabel = jQuery(e.currentTarget).text().replace(/(\n|\t|\r)/gm, "")
            window.dataLayer.push({
                'event': 'clickListCategory',
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
   
        if (this.pageType.toLowerCase().indexOf('prestation') !== -1) {
            // Clic sur une des prestations
            jQuery('.pricing-table.pricing-table--services > .pricing-plan').on('click', (e) => {
                let eventAction = jQuery(e.currentTarget).find('.pricing-plan__head').text().replace(/(\n|\t|\r)/gm, "").trim().replace(/\s+/g, ' ')
                window.dataLayer.push({
                    'event': 'clickPrestationCta',
                    'eventCategory': this.pageType,
                    'eventAction': eventAction,
                    'eventLabel': eventAction
                });
                return
            })

            // Clic sur l'un des CTA
            // jQuery(".wp-block-button a:contains('Demander un devis')").on('click', (e) => {
            // jQuery(".wp-block-button a").on('click', (e) => {
            jQuery('.pricing-table.pricing-table--services .pricing-plan a').on('click', (e) => {
                let eventLabel = jQuery(e.currentTarget).find('.pricing-plan__head').text().replace(/(\n|\t|\r)/gm, "").trim().replace(/\s+/g, ' ')
                window.dataLayer.push({
                    'event': 'clickPrestationCta',
                    'eventCategory': this.pageType + ' - ' + eventLabel,
                    'eventAction': 'Clic CTA',
                    'eventLabel': eventLabel
                });
                e.stopImmediatePropagation()
                return
            })
        }

        // if (this.pageType.toLowerCase().indexOf('incineration') !== -1) {
            if (jQuery('.wp-block-buttons')) {
                jQuery('.wp-block-buttons .wp-block-button a').on('click', (e) => {
                    let eventLabel = jQuery(e.currentTarget).text().replace(/(\n|\t|\r)/gm, "").trim().replace(/\s+/g, ' ')

                    if (eventLabel.indexOf('nos tarifs') !== -1) {
                        window.dataLayer.push({
                            'event': 'clickPrestationCta',
                            'eventCategory': this.pageType,
                            'eventAction': 'Clic CTA',
                            'eventLabel': eventLabel
                        });
                    } else if (eventLabel.indexOf('offre pers') !== -1) {
                        window.dataLayer.push({
                            'event': 'clickPrestationCta',
                            'eventCategory': this.pageType,
                            'eventAction': 'Clic CTA',
                            'eventLabel': eventLabel
                        });
                    } else if (eventLabel.indexOf('rends hommage') !== -1) {
                        window.dataLayer.push({
                            'event': 'clickPrestationCta',
                            'eventCategory': this.pageType,
                            'eventAction': 'Clic CTA',
                            'eventLabel': eventLabel
                        });
                    }
                })
            }
        // }
    }

    pushEventsPageTarif() {
        if (this.pageType == "Page Tarifs") {
            // Clic sur l'un des CTA
            jQuery(".pricing-table > .pricing-plan").on('click', (e) => {
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
            jQuery(".pricing-table > .pricing-plan").on('click', (e) => {
                let eventAction = jQuery(e.currentTarget).find('.pricing-plan__head').text().replace(/(\n|\t|\r)/gm, "").trim().replace(/\s+/g, ' ')
                window.dataLayer.push({
                    'event': 'clickTarifDevis',
                    'eventCategory': this.pageType,
                    'eventAction': 'Demande devis',
                    'eventLabel': eventAction
                });
            })
            jQuery(".pricing-table > .pricing-plan a").on('click', (e) => {
                let eventAction = jQuery(e.currentTarget).find('.pricing-plan__head').text().replace(/(\n|\t|\r)/gm, "").trim().replace(/\s+/g, ' ')
                window.dataLayer.push({
                    'event': 'clickCtaTarif',
                    'eventCategory': this.pageType,
                    'eventAction': 'Clic CTA',
                    'eventLabel': eventAction
                });
            })
        }
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
        if (this.pageType == "Page Urgence décès") {
           
            // jQuery(".wp-block-button a:contains('être rappelé')").on('click', (e) => {
            jQuery(".rappel").on('submit', (e) => {
                window.dataLayer.push({
                    'event': 'clickUrgenceCta',
                    'eventCategory': this.pageType,
                    'eventAction': 'Clic CTA',
                    'eventLabel': "Etre rappelé"
                });
            })

            jQuery(".gk-bloc-urgence a.wp-block-button__link").on('click', (e) => {
                window.dataLayer.push({
                    'event': 'clickUrgenceCta',
                    'eventCategory': this.pageType,
                    'eventAction': 'Clic CTA',
                    'eventLabel': "Prendre rendez-vous"
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

    pushEventsCrematoriums() {

        if (jQuery(".single .store__tet__btns .store__tet__btns__call").length > 0) {
            jQuery(".single .store__tet__btns .store__tet__btns__call").on('click', (e) => {
                let eventLabel = jQuery(e.currentTarget).text().replace(/(\n|\t|\r)/gm, "").trim().replace(/\s+/g, ' ')
                window.dataLayer.push({
                    'event': 'clickCtaStoreLoc',
                    'eventCategory': this.pageType,
                    'eventAction': 'Clic - ' + eventLabel,
                    'eventLabel': eventLabel
                });
            })
        }
        
        if (jQuery(".single .store__tet__btns .store__tet__btns__rdv").length > 0) {
            jQuery(".single .store__tet__btns .store__tet__btns__rdv").on('click', (e) => {
                let eventLabel = jQuery(e.currentTarget).text().replace(/(\n|\t|\r)/gm, "").trim().replace(/\s+/g, ' ')
                window.dataLayer.push({
                    'event': 'clickCtaStoreLoc',
                    'eventCategory': this.pageType,
                    'eventAction': 'Clic - ' + eventLabel,
                    'eventLabel': eventLabel
                });
            })
        }
        
        if (jQuery(".single .store__tet__btns .btn.btn--arrow").length > 0) {
            jQuery(".single .store__tet__btns .btn.btn--arrow").on('click', (e) => {
                let eventLabel = jQuery(e.currentTarget).text().replace(/(\n|\t|\r)/gm, "").trim().replace(/\s+/g, ' ')
                window.dataLayer.push({
                    'event': 'clickCtaStoreLoc',
                    'eventCategory': this.pageType,
                    'eventAction': 'Clic - ' + eventLabel,
                    'eventLabel': eventLabel
                });
            })
        }

        if (jQuery(".single-wpsl_stores #gform_1").length > 0) {
            jQuery(".single-wpsl_stores #gform_1").on('submit', (e) => {
                let eventLabel = jQuery('select[name=input_14] option:selected').text().replace(/(\n|\t|\r)/gm, "").trim().replace(/\s+/g, ' ')
                window.dataLayer.push({
                    'event': 'clickSendContact',
                    'eventCategory': this.pageType,
                    'eventAction': 'Envoyer',
                    'eventLabel': eventLabel
                });
                if (jQuery(".single-wpsl_stores #gform_1").length > 0) {
                    setTimeout(() => {

                        jQuery(".single-wpsl_stores #gform_1").on('submit', (e) => {
                            let eventLabel = jQuery('select[name=input_14] option:selected').text().replace(/(\n|\t|\r)/gm, "").trim().replace(/\s+/g, ' ')
                            window.dataLayer.push({
                                'event': 'clickSendContact',
                                'eventCategory': this.pageType,
                                'eventAction': 'Envoyer',
                                'eventLabel': eventLabel
                            });
                        })
                    }, 5000)
                }
            })
        }
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
   
    pushEventsPriseRDV() {
        if (this.pageType == "Prise de RDV") {
            var startPriseRDV = () => {
                window.dataLayer.push({
                    'event': 'clickPriseRdv',
                    'eventCategory': this.pageType,
                    'eventAction': 'Start',
                    'eventLabel': ''
                });
                let stepN = jQuery("#main-view form .nav-item.active")
                let stepN1 = stepN.find('.step-1')
                let stepN2 = stepN.find('.step-2')
                let stepN3 = stepN.find('.step-3')
                let stepN4 = stepN.find('.step-4')
                stepN = '1'

                if (stepN1.length > 0) {
                    stepN = '1'
                } else if (stepN2.length > 0) {
                    stepN = '2'
                } else if (stepN3.length > 0) {
                    stepN = '3'
                } else if (stepN4.length > 0) {
                    stepN = '4'
                }
                window.dataLayer.push({
                    'event': 'clickPriseRdv',
                    'eventCategory': this.pageType,
                    'eventAction': `Step ${stepN}`,
                    'eventLabel': ''
                });
            }

            var stepChangeAndFinal = () => {
                let stepN = jQuery("#main-view form .nav-item.active")
                let stepN1 = stepN.find('.step-1')
                let stepN2 = stepN.find('.step-2')
                let stepN3 = stepN.find('.step-3')
                let stepN4 = stepN.find('.step-4')
                if (stepN1.length > 0) {
                    stepN = '1'
                } else if (stepN2.length > 0) {
                    stepN = '2'
                } else if (stepN3.length > 0) {
                    stepN = '3'
                } else if (stepN4.length > 0) {
                    stepN = '4'
                }
              
                window.dataLayer.push({
                    'event': 'clickPriseRdv',
                    'eventCategory': this.pageType,
                    'eventAction': `Step ${stepN}`,
                    'eventLabel': ''
                });
                if (stepN == '3') {
                    alert('submit')
                    window.dataLayer.push({
                        'event': 'clickPriseRdv',
                        'eventCategory': this.pageType,
                        'eventAction': 'Final Step',
                        'eventLabel': 'Submit'
                    });
                }
            }
            setInterval(() => {

                jQuery('._3DNWQGIj8wqfDSxytYq0Cx button').each(function() {
                    jQuery(this).unbind('click', startPriseRDV)
                    jQuery(this).bind('click', startPriseRDV)
                })
                jQuery('button[aria-label=Suite]').unbind('click', stepChangeAndFinal)
                jQuery('button[aria-label=Suite]').bind('click', stepChangeAndFinal)
            }, 1000)

        }
    }

    pushEventsContractObseque() {

        if (this.pageType == "Formulaire Contrat Obséques") {
            setTimeout(() => {
                if (jQuery(".rappel.rappel--obseques").length > 0) {
                    jQuery(".rappel.rappel--obseques").on('submit', (e) => {
                        window.dataLayer.push({
                            'event': 'submitContratObsq',
                            'eventCategory': 'Formulaire Contrat Obséques',
                            'eventAction': 'Submit',
                            'eventLabel': ''
                        });
                    })
                }
            }, 4000)
        }


    }
     
}