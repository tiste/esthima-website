export class TrackingDataLayer {

    constructor() {
        this.init()
    }

    init() {
        window.dataLayer = window.dataLayer || [];

        this.env = ''
        this.contentTypePageName = "other-page"
        this.bodyEl = jQuery('body')
        this.assocName = {
            'home': 'home-page',
            'search': 'search-results-page',
            'error404': 'error-page',
            'page-template-mon-compte': 'account-login',
            'page-template-shop-hp': 'product-list-page',
            'tax-product_cat': 'product-list-page',
            'single-product': 'tax-product_cat',
            // 'page-template-creation-compte': 'account-creation',
        }
    

        if (window.location.hostname.indexOf('local') !== -1) {
            this.env = 'development'
        } else if (window.location.hostname.indexOf('preprod') !== -1) {
            this.env = 'testing'
        } else {
            this.env = 'production'
        }


        for (let [k, v] of Object.entries(this.assocName)) {
            if (this.bodyEl.hasClass(k)) {
                this.contentTypePageName = v
            }
        }
    }

    push() {
        window.dataLayer.push({
            'page':{
                'content_type': this.contentTypePageName,
                'language':'FR',
                'pays':'FR',
                'error':'',
                'URL': window.location.href,
                'content_environment': this.env
            }
        });
    
        if (window.wpUserData.id !== undefined) {
            window.dataLayer.push({
                'user':{
                  'id': window.wpUserData.id,
                  'email': window.wpUserData.email_hash,
                  'ageRange': '',
                  'userType': '',
                  'loginStatus': 'Logged'
                }
            });
        }
    }
}