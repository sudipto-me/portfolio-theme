jQuery(document).ready(function ($) {
    'use strict';

    //Open swtcher menu
    $('.style-switcher__control').on('click', function () {
        $('.style-switcher').toggleClass('style-switcher--active');
    });

    //Change monochrome.css to color.css
    $('.style-switcher__link--color').click(function () {
        var url = new URL( window.location.href);
        var href = url.href;
        if ( href.includes('?color=black')) {
            href = href.replace('?color=black', '');
        }
        var newhref = href + '?color=color';
        window.history.pushState( {path:newhref}, '', newhref);
    });

    //Change color.css to monochrome.css
    $('.style-switcher__link--mono').click(function () {
        var url = new URL( window.location.href );
        var href = url.href;
        if( href.includes('?color=color')) {
            href = href.replace('?color=color', '');
        }
        var newhref = href + '?color=black';
        window.history.pushState( {path:newhref}, '', newhref);
    });
});