/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */

// any CSS you import will output into a single css file (app.css in this case)
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import '@fortawesome/fontawesome-free/css/all.css';
import './styles/app.css';

// start the Stimulus application
//import './bootstrap.js';

document.addEventListener('DOMContentLoaded', function () {
    /** BACK TO TOP BUTTON + MENU BACKGROUND **/
    const backToTop = document.getElementById('back-to-top');
    const navbar = document.querySelector('.navbar.fixed-top');

    // Cacher le bouton au départ
    backToTop.style.display = 'none';

    window.addEventListener('scroll', function () {
        if (window.scrollY > 50) {
            backToTop.style.display = 'block';
            backToTop.style.opacity = '1';
            if (navbar) navbar.classList.add('background');
        } else {
            backToTop.style.display = 'none';
            backToTop.style.opacity = '0';
            if (navbar) navbar.classList.remove('background');
        }
    });

    // Scroll vers le haut au clic
    backToTop.addEventListener('click', function (e) {
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});
