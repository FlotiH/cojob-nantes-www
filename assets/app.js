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

    /** SMOOTH SCROLL ON ANCHORS **/
    /*$('a[href*="#"]').click(function (event) {
        if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
            let target = $(this.hash);
            if (target.length) {
                event.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 800, function () {
                    // Callback after animation : Must change focus
                    let $target = $(target);
                    $target.focus();
                    if ($target.is(":focus")) {
                        return false;
                    } else {
                        $target.attr('tabindex', '-1');
                        $target.focus();
                    }
                });
            }
        }
    });*/

    /** PICTURES ON EVENT **/
    if ($('#js-swiper-pictures').length > 0) {
        var galleryThumbs = new Swiper('.gallery-thumbs', {
            spaceBetween: 10,
            slidesPerView: 4,
            loop: true,
            freeMode: true,
            loopedSlides: 5, //looped slides should be the same
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
        });

        new Swiper('#js-swiper-pictures', {
            spaceBetween: 10,
            loop:true,
            loopedSlides: 5, //looped slides should be the same
            autoHeight: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            thumbs: {
                swiper: galleryThumbs,
            },
        });

        $('#js-swiper-pictures').magnificPopup({
            delegate: 'a',
            type: 'image',
            gallery: {
                enabled: true
            }
        });
    }

});
