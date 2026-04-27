/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';

const $ = require('jquery');
require('bootstrap');

$(document).ready(function () {

    /** BACK TO TOP BUTTON + MENU BACKGROUND**/
    const $backToTop = $('#back-to-top');
    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $backToTop.fadeIn();
            $('.navbar.fixed-top').addClass('background');
        } else {
            $backToTop.fadeOut();
            $('.navbar.fixed-top').removeClass('background');
        }
    });

    // scroll body to 0px on click
    $backToTop.click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });

    $backToTop.fadeOut();
});
