const currentLang = document.documentElement.lang;

// src: https://stackoverflow.com/a/28002292
const getScript = (source, callback) => {
    var script = document.createElement('script');
    var prior = document.getElementsByTagName('script')[0];
    script.async = 1;

    script.onload = script.onreadystatechange = (_, isAbort) => {
        if (isAbort || !script.readyState || /loaded|complete/.test(script.readyState)) {
            script.onload = script.onreadystatechange = null;
            script = undefined;
            if (!isAbort) if (callback) callback();
        }
    };

    script.src = source;
    prior.parentNode.insertBefore(script, prior);
};

getScript("/vendor/tarteaucitron/lang/tarteaucitron." + currentLang + ".js");

tarteaucitron.init({
    "privacyUrl": document.getElementById('privacy-link')?.getAttribute('href'),
    "hashtag": "#tarteaucitron",
    "cookieName": "tarteaucitron",
    "orientation": "bottom",
    "showAlertSmall": false,
    "cookieslist": false,
    "showIcon": false,
    "iconPosition": "BottomLeft",
    "adblocker": false,
    "DenyAllCta": true,
    "AcceptAllCta": true,
    "highPrivacy": true,
    "handleBrowserDNTRequest": false,
    "removeCredit": true,
    "moreInfoLink": true,
    "useExternalCss": true,
    "useExternalJs": true,
    "readmoreLink": document.getElementById('privacy-link')?.getAttribute('href'),
    "mandatory": true,
});

if(window.googletagmanagerId) {
    tarteaucitron.user.googletagmanagerId = window.googletagmanagerId;
    (tarteaucitron.job = tarteaucitron.job || []).push('googletagmanager');
}

if(window.gajsUa) {
    tarteaucitron.user.gajsUa = window.gajsUa;
    tarteaucitron.user.gajsMore = function () { /* add here your optionnal _ga.push() */ };
    (tarteaucitron.job = tarteaucitron.job || []).push('gajs');
}

if(window.gtagUa) {
    tarteaucitron.user.gtagUa = window.gtagUa;
    tarteaucitron.user.gtagMore = function () { /* add here your optionnal gtag() */
    };
    (tarteaucitron.job = tarteaucitron.job || []).push('gtag');
}

if(window.facebookpixelId) {
    tarteaucitron.user.facebookpixelId = window.facebookpixelId;
    tarteaucitron.user.facebookpixelMore = function () { /* add here your optionnal facebook pixel function */ };
    (tarteaucitron.job = tarteaucitron.job || []).push('facebookpixel');
}
