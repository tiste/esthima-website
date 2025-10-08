document.addEventListener('DOMContentLoaded', function() {
    const contactSubmitBtn = document.querySelector('.contact__submit');
    if (contactSubmitBtn) {
        contactSubmitBtn.addEventListener('click', function(e) {
            // Envoyer l'événement au dataLayer
            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push({
                'event': 'clickSendContact',
                'eventCategory': 'Page contact',
                'eventAction': 'Envoyer',
                'eventLabel': 'Crémation'
            });
            // console.log('Contact form tracking sent to dataLayer');
        });
    }
});