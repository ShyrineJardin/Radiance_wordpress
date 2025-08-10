function aiosGetParameterByName( name ) {
    var match = new RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
    return match ? decodeURIComponent(match[1]) : '';
}

function aiosGetDefaultTrackingData() {
    return {
        'event': 'form_submission',
        'gclid': aiosGetParameterByName('gclid'),
        'gbraid': aiosGetParameterByName('gbraid'),
        'wbraid': aiosGetParameterByName('wbraid'),
        'utm_source': aiosGetParameterByName('utm_source'),
        'utm_medium': aiosGetParameterByName('utm_medium'),
        'utm_campaign': aiosGetParameterByName('utm_campaign'),
        'utm_term': aiosGetParameterByName('utm_term'),
        'utm_content': aiosGetParameterByName('utm_content'),
    }
}

document.addEventListener('wpcf7mailsent', function(event) {
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({
        ...aiosGetDefaultTrackingData(),
        'event_from': 'AIOS Submission CF7',
        'form_id': event.detail.contactFormId,
        'form_title': event.target.getAttribute('aria-label') ? event.target.getAttribute('aria-label') : 'Unknown Form',
    });
});

document.addEventListener('ihfFormSubmission', function(event) {
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({
        ...aiosGetDefaultTrackingData(),
        'event_from': 'AIOS Submission IHF',
        'form_id': event.detail.formID ? event.detail.formID : 'Unknown Form ID',
        'form_title': event.detail.page_title ? event.detail.page_title : 'Unknown Form Title',
        'form_url': event.detail.page_url ? event.detail.page_url : 'Unknown Form URL',
    });
});