export class TrackingEvents {

    constructor() {
        this.init()
    }

    init() {
        this.pageType = jQuery('title').text()
        this.bodyEl = jQuery('body')
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
        this.assocNameByURI = {
            'Page Prestation': 'nos-prestations',
            'Page Prestation - Incinération': 'incineration',
            'Page Tarif': 'tarifs',
            'Page Prise en charge':'comment-proceder',
            'Page Urgence décés':'urgence-deces',
            'Page Hommage':'temoignages',
        }

        for (let [ka, va] of Object.entries(this.assocNameByURI)) {
            if (window.location.href.indexOf(va)) {
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
                'event': 'clickHpBlock',
                'eventCategory': this.pageType,
                'eventAction': 'Clic CTA',
                'eventLabel': eventLabel
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
    }

     
}