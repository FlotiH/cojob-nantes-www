import { Controller } from '@hotwired/stimulus';
import EmblaCarousel from 'embla-carousel';
import AutoScroll from 'embla-carousel-auto-scroll';

export default class extends Controller {
    static targets = ['viewport'];
    static values = {
        speed: { type: Number, default: 1 },
    };

    connect() {
        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        this.autoScroll = AutoScroll({
            speed: this.speedValue,
            startDelay: 0,
            playOnInit: false,
            stopOnInteraction: false,
            stopOnMouseEnter: true, 
            stopOnFocusIn: true,
        });

        this.embla = EmblaCarousel(
            this.viewportTarget,
            { loop: true, align: 'start', dragFree: true },
            reduceMotion ? [] : [this.autoScroll]
        );

        if (!reduceMotion) {
            this.observeVisibility();
        }
    }

    disconnect() {
        this.observer?.disconnect();
        this.embla?.destroy();
    }

    observeVisibility() {
        this.observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) {
                    this.autoplay.play();
                } else {
                    this.autoplay.stop();
                }
            },
            { threshold: 0.2 } // at least 20 % of the carousel visible
        );

        this.observer.observe(this.element);
    }
}