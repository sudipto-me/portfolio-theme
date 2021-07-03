(function ($) {
    'use strict';
    $('.menu__mobile-button, .mobile-menu__close').click( function () {
        $('.mobile-menu').toggleClass('active');
    });

//Close mobile menu after click
    $('.mobile-menu__wrapper ul li a').on('click', function () {
        $('.mobile-menu').removeClass('active');
    });
})(window.jQuery);
