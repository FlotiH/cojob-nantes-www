import { Controller } from '@hotwired/stimulus';
import EmblaCarousel from 'embla-carousel';
import Autoplay from 'embla-carousel-autoplay';

const BREAKPOINTS = [
    { query: '(min-width: 1024px)', slidesToScroll: 6 },
    { query: '(min-width: 640px)', slidesToScroll: 3 },
    { query: '(min-width: 0px)', slidesToScroll: 1 },
];

export default class extends Controller {
    static targets = ['viewport'];
    static values = {
        autoplayDelay: { type: Number, default: 5000 },
    };

    connect() {
        this.userStopped = false;

        this.autoplay = Autoplay({ delay: this.autoplayDelayValue, stopOnInteraction: false, playOnInit: false });

        this.embla = EmblaCarousel(
            this.viewportTarget,
            { loop: true, align: 'start', containScroll: 'trimSnaps', slidesToScroll: this.currentSlidesToScroll() },
            [this.autoplay]
        );

        this.mediaQueries = BREAKPOINTS.map(bp => window.matchMedia(bp.query));
        this.handleBreakpointChange = () => this.applyBreakpoint();
        this.mediaQueries.forEach(mq => mq.addEventListener('change', this.handleBreakpointChange));

        this.embla.on('pointerDown', () => { this.userStopped = true; });

        this.observeVisibility();
    }

    disconnect() {
        this.observer?.disconnect();
        this.mediaQueries?.forEach(mq => mq.removeEventListener('change', this.handleBreakpointChange));
        this.embla?.destroy();
    }

    observeVisibility() {
        this.observer = new IntersectionObserver(
            ([entry]) => {
                if (this.userStopped) return;

                if (entry.isIntersecting) {
                    this.autoplay.play();
                } else {
                    this.autoplay.stop();
                }
            },
            { threshold: 0.4 } // at least 40 % of the carousel visible
        );

        this.observer.observe(this.element);
    }

    currentSlidesToScroll() {
        const match = BREAKPOINTS.find(bp => window.matchMedia(bp.query).matches);
        return match ? match.slidesToScroll : 1;
    }

    applyBreakpoint() {
        const newValue = this.currentSlidesToScroll();

        this.embla.reInit({ loop: true, align: 'start', containScroll: 'trimSnaps', slidesToScroll: newValue });
    }

    next() {
        this.userStopped = true;
        this.autoplay.stop();
        this.embla.scrollNext();
    }

    prev() {
        this.userStopped = true;
        this.autoplay.stop();
        this.embla.scrollPrev();
    }
}